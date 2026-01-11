import Plyr from 'plyr'
import 'plyr/dist/plyr.css'

function toggleBodyLock() {
    document.body.classList.toggle('overflow-hidden')
}

// helper: creates an infinite fade loop for a list of elements
function createPuzzleTimeline(puzzles, { t_fade = 1, pause = 2 } = {}) {
    if (!puzzles || puzzles.length < 2) return null

    gsap.set(puzzles, { opacity: 0 })
    gsap.set(puzzles[0], { opacity: 1 })

    const tl = gsap.timeline({ repeat: -1 })

    puzzles.forEach((current, i) => {
        const next = puzzles[(i + 1) % puzzles.length]

        tl.to(
            next,
            { opacity: 1, duration: t_fade },
            `+=${pause}`
        )

        tl.to(
            current,
            { opacity: 0, duration: t_fade },
            `+=${pause}`
        )
    })

    return tl
}

document.addEventListener('DOMContentLoaded', () => {
    const components = document.querySelectorAll('.w25-hero-video')
    const videoModal = document.querySelector('.video-hero-modal')
    const closeBtn = videoModal ? videoModal.querySelector('.close-button') : null
    const backdrop = videoModal ? videoModal.querySelector('.backdrop') : null

    // Match your breakpoint as needed
    const mm = gsap.matchMedia()

    components.forEach((component) => {
        // IMPORTANT: query INSIDE the component and split by desktop/mobile classes
        const desktopPuzzles = Array.from(component.querySelectorAll('.overlayPuzzle.desktop'))
        const mobilePuzzles = Array.from(component.querySelectorAll('.overlayPuzzle.mobile'))

        // Create timelines (we’ll pause one depending on viewport)
        const desktopTl = createPuzzleTimeline(desktopPuzzles)
        const mobileTl = createPuzzleTimeline(mobilePuzzles)

        // Only run the relevant one
        mm.add(
            {
                isDesktop: '(min-width: 1024px)',
                isMobile: '(max-width: 1023px)',
            },
            (ctx) => {
                const { isDesktop, isMobile } = ctx.conditions

                if (desktopTl) desktopTl.pause(0)
                if (mobileTl) mobileTl.pause(0)

                if (isDesktop) {
                    if (desktopTl) desktopTl.play(0)
                    if (mobileTl) mobileTl.pause(0)
                }

                if (isMobile) {
                    if (mobileTl) mobileTl.play(0)
                    if (desktopTl) desktopTl.pause(0)
                }

                // cleanup when media query changes
                return () => {
                    if (desktopTl) desktopTl.pause(0)
                    if (mobileTl) mobileTl.pause(0)
                }
            }
        )
    })

    components.forEach((component) => {
        // Initialize hero swiper if it exists
        const heroSwiper = component.querySelector('.hero-swiper')
        if (heroSwiper) {
            new window.Swiper('.hero-swiper', {
                effect: 'fade',
                fadeEffect: { crossFade: true },
                loop: true,
                autoplay: { delay: 3000, disableOnInteraction: false },
                speed: 2000,
                modules: [window.Autoplay, window.EffectFade],
            })
        }

        if (!videoModal) return
        const videoEl = videoModal.querySelector('.plyr')
        if (!videoEl) return

        const plyrInstance = new Plyr(videoEl, {
            captions: { active: true, update: true },
            controls: [
                'play-large',
                'play',
                'progress',
                'current-time',
                'mute',
                'volume',
                'captions',
                'fullscreen'
            ],
        })
        const playBtn = component.querySelector('.play-button')

        if (playBtn) {
            playBtn.addEventListener('click', (e) => {
                e.preventDefault()
                videoModal.classList.remove('hidden')

                videoEl.style.display = 'block'
                videoModal.style.top = window.scrollY + 'px'

                setTimeout(() => {
                    const playPromise = plyrInstance.play()
                    if (playPromise && typeof playPromise.then === 'function') {
                        playPromise.catch(() => { })
                    }
                }, 1400)

                toggleBodyLock()
            })
        }

        const close = (e) => {
            e?.preventDefault?.()
            videoModal.classList.add('hidden')
            plyrInstance.pause()
            videoEl.style.display = 'none'
            toggleBodyLock()
        }

        if (closeBtn) closeBtn.addEventListener('click', close)
        if (backdrop) backdrop.addEventListener('click', close)
    })
})
