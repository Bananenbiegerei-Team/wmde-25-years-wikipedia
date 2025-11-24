//import * as TW from './tailwindhelpers';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

// Swiper core + modules
import Swiper from 'swiper';
import { Navigation, Pagination, EffectCoverflow } from 'swiper/modules';

// Swiper styles loaded via SCSS (src/scss/components/swiper.scss)

// Init Alpine
window.Alpine = Alpine;
Alpine.plugin(focus);
Alpine.start();

// Initialize Swiper for W25 News block when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
	const newsSlider = document.querySelector('.w25-news .swiper');
	if (newsSlider) {
		const w25NewsSwiper = new Swiper('.w25-news .swiper', {
			modules: [Navigation, Pagination, EffectCoverflow],
			grabCursor: true,
			centeredSlides: true,
			slidesPerView: 1,
			spaceBetween: 0,
			loop: true,
			autoHeight: true,
			navigation: {
				nextEl: '.w25-news .swiper-button-next',
				prevEl: '.w25-news .swiper-button-prev',
			},
			pagination: {
				el: '.w25-news .swiper-pagination',
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
