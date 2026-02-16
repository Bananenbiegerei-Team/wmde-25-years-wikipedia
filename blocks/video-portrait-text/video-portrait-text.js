/**
 * Video Portrait Text Block - Script
 */
const initVideoPortraitBlocks = () => {
    const blocks = document.querySelectorAll('.video-portrait-text-block');

    // 1. Setup Intersection Observer to pause videos when they leave the screen
    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const player = entry.target.plyr;
            if (!entry.isIntersecting && player && player.playing) {
                player.pause();
            }
        });
    }, { threshold: 0.1 });

    blocks.forEach((block) => {
        const videoElement = block.querySelector('.js-plyr-video');
        const playBtn = block.querySelector('.play-button');

        if (!videoElement || !playBtn) return;

        const player = new Plyr(videoElement, {
            controls: ['progress'],
            clickToPlay: true, // Clicking the video area will toggle play/pause natively
            hideControls: false,
            disableContextMenu: false,
            settings: []
        });

        videoElement.plyr = player;
        scrollObserver.observe(videoElement);

        playBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            player.play();
        });

        player.on('play', () => {
            playBtn.classList.add('opacity-0', 'pointer-events-none');
        });

        player.on('pause', () => {
            playBtn.classList.remove('opacity-0', 'pointer-events-none');
        });

        player.on('ended', () => {
            playBtn.classList.remove('opacity-0', 'pointer-events-none');
        });
    });
}

// Initialize on standard page load
document.addEventListener('DOMContentLoaded', initVideoPortraitBlocks);