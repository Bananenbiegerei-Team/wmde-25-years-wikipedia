<?php $header_color = get_field('header_color', 'options') ?: 'white';
$search = get_field('activate_topbar_search', 'options');
?>
<script>
const pw = 20; // pointer width
const pyoff = -19; // pointer v offset

// Prepare x-data for 'navMenu' component
document.addEventListener('alpine:init', () => {
    Alpine.data('navMenu', () => ({
        nav: WPNav,
        isOpen: new Array(WPNav.length).fill(false),
        idx: -1,
        items: null,
        itemIdx: -1,
        showPointer: false,
        isScrolled: false,
        init() {
            // Slide-in logo when sticky navbar
            window.addEventListener('scroll', () => {
                const scrollPosition = window.scrollY;
                const threshold = document.getElementById('titlebar_desktop')
                    .getBoundingClientRect().height;
                if (scrollPosition >= threshold) {
                    this.isScrolled = true;
                } else {
                    this.isScrolled = false;
                }
            });
            // Keyboard navigation (tab to switch domain, up/down to select sub items)
            document.getElementById('navmenu_desktop').addEventListener('keydown', e => {
                const keyUP = e.keyCode === 38;
                const keyDOWN = e.keyCode === 40;
                const keyTAB = (e.keyCode === 9) && !e.shiftKey;;
                const keySHIFT_TAB = (e.keyCode === 9) && e.shiftKey;
                const domainOpen = this.idx != -1;
                const firstDomain = this.idx == 0;
                const lastDomain = this.idx == (this.nav.length - 1);
                if (keyDOWN) {
                    e.preventDefault();
                    this.focusNextItem();
                    return false;
                }
                if (keyUP) {
                    e.preventDefault();
                    this.focusPrevItem();
                    return false;
                }
                if (keyTAB && domainOpen && !lastDomain) {
                    e.preventDefault();
                    const n = this.idx + 1;
                    this.openNav(n);
                    document.getElementById(`domain_${n}`).focus();
                    this.movePointer();
                    return false;
                }
                if (keySHIFT_TAB && domainOpen && !firstDomain) {
                    e.preventDefault();
                    const n = this.idx - 1;
                    this.openNav(n);
                    document.getElementById(`domain_${n}`).focus();
                    this.movePointer();
                    return false;
                }
                if (domainOpen && (keySHIFT_TAB && firstDomain) || (keyTAB && lastDomain)) {
                    this.closeNav();
                    return false;
                }
                // Prevent scrolling with arrow keys when a domain dropdown is open
                if ((keyUP || keyDOWN) && domainOpen) {
                    e.preventDefault();
                    return false;
                }
            });
        },
        openNav(n) {
            this.isOpen.fill(false);
            this.idx = n;
            this.itemIdx = -1;
            if ((this.nav[n].featured.length + this.nav[n].pages.length + this.nav[n].sections
                    .length) > 0) {
                this.isOpen[n] = true;
                this.items = document.querySelectorAll(`#menu_${n} li a`);
            }
        },
        closeNav() {
            this.isOpen.fill(false);
            this.idx = -1;
            this.itemIdx = -1;
            this.showPointer = false;
        },
        focusPrevItem() {
            if (this.itemIdx <= 0) {
                return;
            }
            this.itemIdx = this.itemIdx - 1;
            const item = this.items[this.itemIdx];
            item.focus();
        },
        focusNextItem() {
            if (this.itemIdx == this.items.length - 1) {
                return;
            }
            this.itemIdx = this.itemIdx + 1;
            const item = this.items[this.itemIdx];
            item.focus();
        },
        movePointer() {
            if (this.nav[this.idx].pages.length + this.nav[this.idx].sections.length == 0) {
                this.showPointer = false;
                return;
            }
            this.showPointer = true;
            let bx = document.getElementById('domain_' + this.idx).getBoundingClientRect()
                .left; // button x
            let bw = document.getElementById('domain_' + this.idx).offsetWidth; // button width
            let dxoff = this.getNavDropdownOffset(); // dropdown h offset
            // let pw = 32; // pointer width
            // let pyoff = -31; // pointer v offset
            let ddw = document.getElementById('menu_' + this.idx).offsetWidth;
            let voff = parseInt(window.getComputedStyle(document.querySelector(
                    '#navmenu_desktop .container')).getPropertyValue("margin-left").match(/\d+/)
                .pop());
            let ddx = Math.max(dxoff, bx + bw / 2 - ddw / 2) - voff;
            document.getElementById('menu_' + this.idx).style.left = ddx + 'px';
            document.getElementById('pointer').style.left = bx - dxoff + bw / 2 - pw / 2 + 'px';
            document.getElementById('pointer').style.top = pyoff + 'px';
        },
        getNavDropdownOffset() {
            let box = document.getElementById('navmenu_desktop_dropdown').getBoundingClientRect();
            let body = document.body;
            let docEl = document.documentElement;
            let scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;
            let clientLeft = docEl.clientLeft || body.clientLeft || 0;
            let left = box.left + scrollLeft - clientLeft;
            return Math.round(left);
        }
    }));
});
</script>

<!-- Container for the whole desktop nav menu -->
<div x-data="navMenu" @mouseleave="closeNav()" class="sticky top-0 z-40 hidden md:block nohover:hidden">
<header aria-hidden="true" id="navmenu_desktop"
    class="border-b border-neutral-light bg-<?= $header_color; ?> py-1">

    <!-- Top bar with logo, domains, and search -->
    <div class="container relative z-10 overflow-hidden">

        <!-- Logo -->
        <div class="absolute overflow-hidden left-5 top-2" type="logo">
            <div class="transition-all duration-500 ease-in-out -translate-x-10 opacity-0"
                x-bind:class="{ 'opacity-0 -translate-x-10': !isScrolled, 'opacity-100 translate-x-0': isScrolled }">
                <a tabindex="-1" href="<?php echo get_home_url(); ?>">
                    <img class="mini-logo" style="max-height: 33px" src="<?= get_stylesheet_directory_uri() ?>/img/wikimedia-logo-mini.svg" alt="Wikimedia Logo">
                </a>
            </div>
        </div>

        <!-- Domains & search -->
        <div class="flex items-center justify-between">

            <!-- Domains -->
            <div class="flex flex-none py-1 ml-10 space-x-1 transition-all duration-500 ease-in-out -translate-x-12 navmenu"
                x-bind:class="{ '-translate-x-12': !isScrolled, 'translate-x-10': isScrolled }">
                <!-- Domain items -->
                <nav id="navmenu_desktop_domains">
                    <template x-for="(domain,i) in nav">
                        <a class="btn btn-menu" @focus="openNav(i); movePointer()"
                            @mouseenter="openNav(i); movePointer()" x-bind:id="'domain_' + i"
                            x-bind:class="{'current': pageID == domain.ID || domain.children.includes(pageID) }"
                            x-bind:href="domain.url" x-html="domain.title"></a>
                    </template>
                </nav>
            </div>

            <!-- Search -->
            <?php if ($search): ?>
            <div class="flex items-center justify-end flex-1 h-full gap-5 pl-12" x-data="{ open: false }">
                <?php get_template_part('template-parts/header-top/desktop/search-slide-out'); ?>
                <?php get_template_part('template-parts/header-top/desktop/search-modal'); ?>
            </div>
            <?php endif; ?>

            <!-- Subnav -->
            <?php if (has_nav_menu('nav-right-level-2')) : ?>
            <div class="flex-none">
                <?php get_template_part('template-parts/header-top/menu-top-right-2'); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Submenus items go below the navigation bar -->
    <div id="navmenu_desktop_dropdown" class="container relative block">

        <!-- Pointer to domain button -->
        <div class="absolute z-20 pointer-events-none" id="pointer" x-show="showPointer">
            <div class="object-cover w-full h-full drop-shadow-xs text-neutral-light" aria-hidden="true">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 8L0 20H20L10 8Z" fill="white" />
                    <path d="M0 20L10 8L20 20" stroke="currentColor" />
                </svg>
            </div>
        </div>

        <!-- For each domain... -->
        <template x-for="(domain,i) in nav">
            <div show="isOpen[i]" x-bind:id="'menu_'+ i"
                class="absolute inset-x-0 z-10 p-2 overflow-hidden transform bg-white border border-neutral-light max-h-screen-80 rounded-xl shadow-navbar"
                x-bind:class="{ 'max-w-6xl': domain.featured.length > 0, 'max-w-md': domain.featured.length == 0, 'visible': isOpen[i], 'invisible': !isOpen[i] }">

                <!-- If there are featured pages: 2 columns with featured pages + pages -->
                <div class="relative grid mx-auto"
                    x-bind:class="{ 'grid-cols-2' : domain.featured.length > 0, 'grid-cols-1': domain.featured.length == 0}">

                    <!-- Featured pages -->
                    <template x-if="domain.featured.length > 0">
                        <nav class="pr-5 mr-5 border-r border-neutral-light">
                            <ul class="flex flex-col overflow-auto max-h-screen-80">
                                <template x-for="page in domain.featured">
                                    <li class="p-1" x-bind:class="{'current': pageID == page.ID }">
                                        <a x-bind:href="page.url"
                                            class="flex items-center h-12 gap-5 p-1 p-4 transition hover:bg-neutral rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-0">
                                            <div class="">
                                                <img class="w-10 h-auto p-1"
                                                    x-bind:src="page.logo || page.thumbnail || defaultIcon" />
                                            </div>
                                            <div class="">
                                                <h4 class="m-0 text-base" x-html="page.title"></h4>
                                            </div>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </nav>
                    </template>

                    <!-- Pages & sections -->
                    <nav class="grid overflow-auto max-h-screen-80"
                        x-bind:class="{ 'grid-cols-2' : domain.pages.length > 0 && domain.sections.length > 0 || domain.sections.length > 1 }">

                        <!-- Pages -->
                        <template x-if="domain.pages.length > 0">
                            <ul class="items-stretch py-1 justify-items-stretch dropdown">
                                <template x-for="page in domain.pages">
                                    <li class="p-1 transition bg-white rounded-md"
                                        x-bind:class="{'current': pageID == page.ID }">
                                        <a tabindex="-1" x-bind:href="page.url"
                                            class="font-normal btn btn-menu btn-expanded" x-html="page.title"></a>
                                    </li>
                                </template>
                            </ul>
                        </template>

                        <!-- Sections -->
                        <template x-for="section in domain.sections">
                            <ul class="items-stretch justify-items-stretch">
                                <li
                                    class="transition bg-white rounded-md btn btn-menu btn-expanded hover:text-black">
                                    <span class="p-1" x-text="section.title"></span>
                                </li>
                                <template x-for="page in section.pages">
                                    <li class="p-1 transition bg-white rounded-md"
                                        x-bind:class="{'current': pageID == page.ID }">
                                        <a tabindex="-1" x-bind:href="page.url"
                                            class="font-normal btn btn-menu btn-expanded" x-html="page.title"></a>
                                    </li>
                                </template>
                            </ul>
                        </template>

                    </nav>
                </div>
            </div>
        </template>
    </div>
</header>
</div>