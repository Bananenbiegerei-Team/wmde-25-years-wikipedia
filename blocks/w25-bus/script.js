// GSAP Scroll-triggered animation for W25 Bus block
// Bus images animate from bottom of viewport to their final position
document.addEventListener('DOMContentLoaded', function() {
	const container = document.querySelector('#bus-container');

	if (container && typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
		gsap.registerPlugin(ScrollTrigger);

		const busItems = container.querySelectorAll('.bus-item');

		// Detect if mobile (width < 768px - Tailwind md breakpoint)
		const isMobile = window.innerWidth < 768;

		// Distance from bottom - all items come from below the viewport
		const distance = isMobile ? '80vh' : '100vh';

		// Calculate the scroll range for triggering items
		const itemCount = busItems.length;
		// Scroll range determines how much scrolling is needed to complete all animations
		// Lower values = animations finish sooner, higher values = animations spread over more scroll
		const scrollRange = isMobile ? 300 : 300;

		// Use a single timeline with staggered animations instead of individual ScrollTriggers
		// This is more performant than creating 27 separate ScrollTrigger instances
		const timeline = gsap.timeline({
			scrollTrigger: {
				trigger: container,
				start: 'top center',
				end: () => `+=${scrollRange}`,
				scrub: 1,
				markers: false
			}
		});

		// Add all animations to a single timeline with stagger
		busItems.forEach((item, index) => {
			const startProgress = index / itemCount;
			const endProgress = (index + 1) / itemCount;

			timeline.fromTo(item,
				{
					opacity: 0,
					y: distance
				},
				{
					y: 0,
					opacity: 1,
					ease: 'power2.out',
					duration: 1
				},
				startProgress
			);
		});
	}
});
