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

// Initialize Swiper for W25 News block with Coverflow effect
const w25NewsSwiper = new Swiper('.w25-news .swiper', {
	modules: [Navigation, Pagination, EffectCoverflow],
	grabCursor: true,
	centeredSlides: true,
	slidesPerView: '3',
	loop: true,
	navigation: {
		nextEl: '.w25-news .swiper-button-next',
		prevEl: '.w25-news .swiper-button-prev',
	},
	pagination: {
		el: '.w25-news .swiper-pagination',
		clickable: true,
	},
});
