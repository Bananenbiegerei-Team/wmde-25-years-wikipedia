//import * as TW from './tailwindhelpers';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

// Swiper core + modules
import Swiper from 'swiper';
import { Navigation, Pagination, EffectCoverflow, Autoplay, EffectFade } from 'swiper/modules';

// Make GSAP available globally
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// Make Swiper available globally for block scripts
window.Swiper = Swiper;
window.Navigation = Navigation;
window.Pagination = Pagination;
window.EffectCoverflow = EffectCoverflow;
window.Autoplay = Autoplay;
window.EffectFade = EffectFade;

// Swiper styles loaded via SCSS (src/scss/components/swiper.scss)

// load js from bb-blocks repository
import '../../bb-blocks/bb-block-gallery-swiper/script.js';

// load js from blocks repositoy
import '../../blocks/w25-hero-video/script.js';
import '../../blocks/w25-news/script.js';
import '../../blocks/w25-protect-knowledge/script.js';
import '../../blocks/w25-numbers/script.js';
import '../../blocks/w25-glam/script.js';
import '../../blocks/w25-testimonials-swiper/script.js';

// Init Alpine
window.Alpine = Alpine;
Alpine.plugin(focus);
Alpine.start();
