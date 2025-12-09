import Plyr from 'plyr';
import 'plyr/dist/plyr.css';

function toggleBodyLock() {
    document.body.classList.toggle('overflow-hidden');
}

document.addEventListener('DOMContentLoaded', () => {

    const components = document.querySelectorAll('.w25-hero-video');
    const videoModal = document.querySelector('.video-hero-modal');
    const closeBtn = videoModal ? videoModal.querySelector('.close-button') : null;
    const backdrop = videoModal ? videoModal.querySelector('.backdrop') : null;

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

        const videoEl = videoModal.querySelector('.plyr');
        console.log(videoEl);
        if (!videoEl) return;

        const plyrInstance = new Plyr(videoEl);

        const playBtn = component.querySelector('.play-button');

        if (playBtn) {
            playBtn.addEventListener('click', (e) => {
                e.preventDefault();
                console.log(videoModal);
                if (videoModal) videoModal.classList.remove('hidden');

                videoEl.style.display = 'block';

                setTimeout(() => {
                    const playPromise = plyrInstance.play();
                    if (playPromise && typeof playPromise.then === 'function') {
                        playPromise.catch(() => {
                            // Autoplay might be blocked; user interaction already occurred so ignore errors.
                        });
                    }
                }, 1400);

                toggleBodyLock();
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (videoModal) videoModal.classList.add('hidden');
                
                plyrInstance.pause();
                videoEl.style.display = 'none';


                toggleBodyLock();
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', (e) => {
                e.preventDefault();
                if (videoModal) videoModal.classList.add('hidden');
                
                plyrInstance.pause();
                videoEl.style.display = 'none';


                toggleBodyLock();
            });
        }
    });

});