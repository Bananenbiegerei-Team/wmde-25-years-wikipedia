<?php
$header_color = get_field('header_color', 'options') ?: 'white';
?>
<script>
// Prepare x-data for 'navMenuMobile' component
document.addEventListener('alpine:init', () => {
    Alpine.data('navMenuMobile', () => ({
        nav: WPNav,
        isOpen: new Array(WPNav.length).fill(false),
        timeOutFunctionId: 0,
        init() {
            // Keyboard navigation
            document.getElementById('navmenu_mobile').addEventListener('keydown', e => {
                const items = document.querySelectorAll('#navmenu_mobile a.btn');
                const keyTAB = (e.keyCode === 9) && !e.shiftKey;
                const isLastItem = e.target == items[items.length - 1];
                // Jump back to menu hamburger button after the last item
                if (isLastItem) {
                    e.preventDefault();
                    document.querySelector('[x-data="navMenuMobileToggle"] button').focus();
                    return false;
                }
            });
        },
        toggleNav(n) {
            var v = this.isOpen[n];
            this.isOpen.fill(false);
            this.isOpen[n] = !v;
        }
    }));
});
</script>

<!-- Container for the whole mobile nav menu -->
<header aria-hidden="true" id="navmenu_mobile" x-data="navMenuMobile"
    class="z-40 block bg-<?= $header_color; ?>-light fixed left-0 right-0 bottom-0 top-14 block md:hidden nohover:block overflow-scroll"
    x-show="$store.open_mobile_nav" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90">
   <div class="flex items-center justify-start flex-1 gap-2 p-3 bg-white" x-data="{ open: false }">
            <?php get_template_part('template-parts/header-top/cta'); ?>
    <?php /* <form class="flex w-full gap-5 form-sm" action="<?= bb_search_url() ?>" method="get">
        <input class="!mb-0" type="text" name="s" id="mobile-search" x-ref="searchInput"
            value="<?php the_search_query(); ?>" />
        <input type="submit" alt="Search" value="Suchen" class="" />
    </form> */ ?>
    </div>
    <?php if (has_nav_menu('nav-right-level-1')) : ?>
    <?php get_template_part('template-parts/header-top/menu-top-right-1'); ?>
    <?php endif; ?>

    <nav class="h-full bg-white border-b divide-y divide-primary-dark border-primary-dark">
        <template x-for="(domain,i) in nav">

            <div>

                <div class="relative flex flex-wrap items-center nav_item"
                    x-bind:class="{ 'border-transparent' : !isOpen[i], 'border-transparent' : isOpen[i] }">

                    <!-- Domain title -->
                    <div class="flex-1"
                        x-bind:class="{'current before:w-2 before:h-16 before:bg-primary-dark before:absolute h-16 before:-left-2 before:top-0': pageID == domain.ID }">
                        <a x-bind:href="domain.url" @focus="toggleNav(i)" class="btn btn-menu">
                            <span class="w-full" x-html="domain.title"></span>
                        </a>
                    </div>

                    <template x-if="domain.pages.length > 0 || domain.sections.length > 0">
                        <div tabindex='-1' @click="toggleNav(i)" class="flex-shrink mr-3"
                            x-bind:class="{ 'item_closed' : !isOpen[i], 'item_open' : isOpen[i] }">
                            <?= bb_icon('menu_open', 'cursor-pointer open') ?>
                            <?= bb_icon('menu_close', 'cursor-pointer close') ?>
                        </div>
                    </template>

                    <!-- Wrapper for domain items -->
                    <div class="basis-full" x-show="isOpen[i]" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90">

                        <!-- Pages -->
                        <template x-if="domain.pages.length > 0">
                            <ul class="">
                                <template x-for="page in domain.pages">
                                    <li class="pl-5" x-bind:class="{'current': pageID == page.ID }">
                                        <a x-bind:href="page.url" class="btn btn-menu">
                                            <span class="w-full" x-html="page.title"></span>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </template>

                        <!-- Sections -->
                        <div class="grid md:grid-cols-2">
                            <template x-for="(section,i) in domain.sections">
                                <ul class="px-2 py-4 border-0 border-t border-neutral-dark"
                                    x-bind:class="{ 'md:border-r': i % 2 === 0 }">
                                    <li class="pl-6">
                                        <span class="btn btn-menu"
                                            x-html="section.title"></span>
                                        <ul>
                                            <template x-for="page in section.pages">
                                                <li class="py-2" x-bind:class="{'current': pageID == page.ID }">
                                                    <a x-bind:href="page.url" x-html="page.title"
                                                        class="btn btn-menu"></a>
                                                </li>
                                            </template>
                                        </ul>
                                    </li>
                                </ul>
                            </template>
                        </div>

                    </div>
                </div>
            </div>
        </template>
    </nav>
    <!-- Subnav -->
    <?php if (has_nav_menu('nav-right-level-2')) : ?>
    <div class="flex-none">
        <?php get_template_part('template-parts/header-top/menu-top-right-2'); ?>
    </div>
    <?php endif; ?>
</header>