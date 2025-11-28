import Plyr from 'plyr';
import 'plyr/dist/plyr.css';

document.addEventListener('DOMContentLoaded', () => {

    const components = document.querySelectorAll('.w25-hero-video');

    console.log('Hallo')

    components.forEach( ( component ) => {

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