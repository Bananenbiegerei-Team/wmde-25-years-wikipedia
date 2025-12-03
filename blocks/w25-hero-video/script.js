import { speed } from 'jquery';
import Plyr from 'plyr';
import 'plyr/dist/plyr.css';

document.addEventListener('DOMContentLoaded', () => {

    const components = document.querySelectorAll('.w25-hero-video');

    console.log('Hallo')

    components.forEach( ( component ) => {

        // Initialize hero swiper if it exists
        const heroSwiper = component.querySelector('.hero-swiper');
        if (heroSwiper) {
            new window.Swiper('.hero-swiper', {
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                speed: 2000,
                modules: [window.Autoplay, window.EffectFade],
            });
        }

        const videoEl = component.querySelector('.plyr');
        if (!videoEl) return;

        const plyrInstance = new Plyr(videoEl);

        const playBtn = component.querySelector('.play-button');
        const overlay = component.querySelector('.video-overlay');
        const container = component.querySelector('.video-container');

        if (playBtn) {
            playBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (overlay) overlay.style.display = 'none';
                if (container) container.style.display = 'block';

                videoEl.style.display = 'block';

                const playPromise = plyrInstance.play();
                if (playPromise && typeof playPromise.then === 'function') {
                    playPromise.catch(() => {
                        // Autoplay might be blocked; user interaction already occurred so ignore errors.
                    });
                }
            });
        }
    });

});