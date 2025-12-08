// GSAP Scroll-triggered animation for W25 Numbers block
// Each number item animates from bottom of viewport to its final absolute position
// Items trigger sequentially as user scrolls through the container
document.addEventListener('DOMContentLoaded', function() {
	const container = document.querySelector('#numbers-parallax-container');

	if (container && typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
		gsap.registerPlugin(ScrollTrigger);

		const numberItems = container.querySelectorAll('.number-item');

		// Detect if mobile (width < 768px - Tailwind md breakpoint)
		const isMobile = window.innerWidth < 768;

		// Distance from bottom - all items come from below the viewport
		const distance = isMobile ? '80vh' : '100vh';

		// Calculate the scroll range for triggering items
		const itemCount = numberItems.length;
		const scrollRange = 400; // Total scroll distance to spread all triggers across

		// Animate each number item with individual scroll triggers
		numberItems.forEach((item, index) => {
			// Calculate trigger position for this item based on its index
			// Spread triggers evenly across the scroll range
			const triggerOffset = (index / (itemCount - 1)) * scrollRange;

			gsap.fromTo(item,
				{
					opacity: 0,
					y: distance
				},
				{
					y: 0,
					opacity: 1,
					ease: 'power2.out',
					scrollTrigger: {
						trigger: container,
						start: () => `top+=${triggerOffset}px center`, // Each item triggers at different scroll position
						end: () => `top+=${triggerOffset + 150}px center`, // Animation completes over 150px of scroll
						scrub: 1, // Smooth scrubbing effect - animation tied to scroll
						markers: false, // Set to true for debugging
						toggleActions: 'play none none reverse'
					}
				}
			);
		});
	}
});
