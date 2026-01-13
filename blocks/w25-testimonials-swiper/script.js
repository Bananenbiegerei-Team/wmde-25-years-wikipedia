// Initialize Swiper for W25 Testimonials Swiper blocks
document.addEventListener('DOMContentLoaded', function() {
    const testimonialSwipers = document.querySelectorAll('.w25-testimonials-swiper-block .swiper');

    testimonialSwipers.forEach((swiperEl) => {
        const parentBlock = swiperEl.closest('.w25-testimonials-swiper-block');

        new window.Swiper(swiperEl, {
            modules: [window.Autoplay],
            speed: 1400,
            autoplay: {
                delay: 4000,
                disableOnInteraction: true,
            },
            grabCursor: true,
            // Settings for mobile
            centeredSlides: false,
            loop: false,
            rewind: true,
            slidesPerView: 1.1,
            // Responsive breakpoints
            breakpoints: {
                640: {
                    centeredSlides: true,
                    loop: true,
                    rewind: false,
                    slidesPerView: 1.6,
                },
                768: {
                    centeredSlides: true,
                    loop: true,
                    rewind: false,
                    slidesPerView: 2,
                },
                1024: {
                    loop: true,
                    rewind: false,
                    slidesPerView: 3,
                },
            },
            on: {
                // Show side fade when slides start moving (autoplay or by user)
                init: function() {
                    setTimeout(() => {
                        if (parentBlock) {
                            parentBlock.classList.add('started');
                        }
                    }, 4000); // Must be the same value as autoplay.delay
                },
                sliderFirstMove: function() {
                    if (parentBlock) {
                        parentBlock.classList.add('started');
                    }
                }
            }
        });
    });
});
