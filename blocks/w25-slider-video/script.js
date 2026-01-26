/**
 * W25 Video Swiper - Logic for Portrait Video Slider
 */
const initVideoSwiper = () => {
    const swiperBlocks = document.querySelectorAll('.w25-video-swiper');
    let activeVideo = null; // State tracker for the currently playing video

    swiperBlocks.forEach((block) => {
        const container = block.querySelector('.w25-video-swiper-container');
        if (!container) return;

        // 1. Swiper Initialization
        const swiper = new Swiper(container, {
            slidesPerView: 1.2,
            spaceBetween: 20,
            centeredSlides: false, // Slides will align to the left
            grabCursor: true,
            navigation: {
                nextEl: block.querySelector('.swiper-button-next'),
                prevEl: block.querySelector('.swiper-button-prev'),
            },
            pagination: {
                el: block.querySelector('.swiper-pagination'),
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2.2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                }
            },
            on: {
                slideChange: () => {
                    // Stop the video if the user swipes it out of focus
                    if (activeVideo) activeVideo.pause();
                }
            }
        });

        // 2. Video Player Logic
        const slides = block.querySelectorAll('.swiper-slide');

        slides.forEach((slide) => {
            const video = slide.querySelector('video');
            const playBtn = slide.querySelector('.play-button');
            const pauseBtn = slide.querySelector('.pause-button');

            if (!video || !playBtn || !pauseBtn) return;

            // UI Toggle Helper
            const updateUI = (isPlaying) => {
                if (isPlaying) {
                    playBtn.classList.add('hidden');
                    pauseBtn.classList.remove('hidden');
                } else {
                    playBtn.classList.remove('hidden');
                    pauseBtn.classList.add('hidden');
                }
            };

            // Play Click
            playBtn.addEventListener('click', () => {
                if (activeVideo && activeVideo !== video) {
                    activeVideo.pause();
                }
                video.play();
                activeVideo = video;
            });

            // Pause Click
            pauseBtn.addEventListener('click', () => {
                video.pause();
            });

            // Native Event Listeners (Keeps UI in sync regardless of how video is triggered)
            video.addEventListener('play', () => updateUI(true));
            video.addEventListener('pause', () => updateUI(false));
            video.addEventListener('ended', () => {
                updateUI(false);
                if (activeVideo === video) activeVideo = null;
            });

            // Toggle play/pause by clicking the video itself
            video.addEventListener('click', () => {
                if (!video.paused) {
                    video.pause();
                } else {
                    if (activeVideo && activeVideo !== video) activeVideo.pause();
                    video.play();
                    activeVideo = video;
                }
            });
        });
    });
};

document.addEventListener('DOMContentLoaded', initVideoSwiper);