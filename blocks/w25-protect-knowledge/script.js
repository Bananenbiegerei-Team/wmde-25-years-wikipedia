// Initialize Swiper for W25 News block when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
	const newsSlider = document.querySelector('.w25-protect-knowledge .swiper');
	if (newsSlider) {
		const w25NewsSwiper = new Swiper('.w25-protect-knowledge .swiper', {
			modules: [Navigation, Pagination, EffectCoverflow],
			grabCursor: true,
			centeredSlides: true,
			slidesPerView: 1,
			spaceBetween: 0,
			loop: true,
			autoHeight: false,
			navigation: {
				nextEl: '.w25-protect-knowledge .swiper-button-next',
				prevEl: '.w25-protect-knowledge .swiper-button-prev',
			},
			pagination: {
				el: '.w25-protect-knowledge .swiper-pagination',
				clickable: true,
			},
			breakpoints: {
				// Mobile (default above: 1 slide)
				768: {
					// sm breakpoint
					slidesPerView: 2,
					spaceBetween: 0,
					autoHeight: false,
				},
				1024: {
					// lg breakpoint
					slidesPerView: 3,
					spaceBetween: 0,
					autoHeight: false,
				},
			},
		});
	}
});