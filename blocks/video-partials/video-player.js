/**
 * Shared Video Player - Plyr initialization
 *
 * Used by video-portrait-text and video-swiper blocks.
 * Expects elements with class .video-player-wrapper containing:
 * - .js-plyr-video (the video element)
 * - .play-button (the custom play button)
 */

const VideoPlayer = {
    players: [],
    scrollObserver: null,

    ensureObserver() {
        if (!this.scrollObserver) {
            this.scrollObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const player = entry.target.plyr;
                    if (!entry.isIntersecting && player && player.playing) {
                        player.pause();
                    }
                });
            }, { threshold: 0.1 });
        }
    },

    init() {
        this.ensureObserver();
        this.initAllPlayers();
    },

    initAllPlayers() {
        // Ensure observer exists (in case called before DOMContentLoaded)
        this.ensureObserver();

        const wrappers = document.querySelectorAll('.video-player-wrapper');

        wrappers.forEach((wrapper) => {
            // Skip if already initialized
            if (wrapper.dataset.plyrInitialized) return;

            const videoElement = wrapper.querySelector('.js-plyr-video');
            const playBtn = wrapper.querySelector('.play-button');
            const titleContainer = wrapper.querySelector('.video-title-container');

            if (!videoElement || !playBtn) return;

            const player = new Plyr(videoElement, {
                controls: ['progress', 'mute'],
                clickToPlay: true,
                hideControls: false,
                disableContextMenu: false,
                muted: false,
                volume: 1,
                settings: []
            });

            // Store reference on the element
            videoElement.plyr = player;
            wrapper.dataset.plyrInitialized = 'true';

            // Observe for viewport visibility
            this.scrollObserver.observe(videoElement);

            // Play button click handler
            playBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                player.play();
            });

            // Show/hide play button, title container, and controls based on player state
            player.on('play', () => {
                playBtn.classList.add('opacity-0', 'pointer-events-none');
                if (titleContainer) titleContainer.classList.add('opacity-0', 'pointer-events-none');
                wrapper.classList.add('is-playing');
            });

            player.on('pause', () => {
                playBtn.classList.remove('opacity-0', 'pointer-events-none');
                if (titleContainer) titleContainer.classList.remove('opacity-0', 'pointer-events-none');
                wrapper.classList.remove('is-playing');
            });

            player.on('ended', () => {
                playBtn.classList.remove('opacity-0', 'pointer-events-none');
                if (titleContainer) titleContainer.classList.remove('opacity-0', 'pointer-events-none');
                wrapper.classList.remove('is-playing');
            });

            this.players.push(player);
        });
    },

    // Pause all videos (useful for swipers/carousels)
    pauseAll() {
        this.players.forEach(player => {
            if (player.playing) {
                player.pause();
            }
        });
    }
};

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => VideoPlayer.init());

// Export for use by other scripts (e.g., swiper integration)
window.VideoPlayer = VideoPlayer;
