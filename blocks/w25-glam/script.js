// GSAP Scroll-triggered animation for W25 GLAM Presents block
// Each puzzle item animates from bottom of viewport to its final absolute position
// Items trigger sequentially as user scrolls through the container
document.addEventListener('DOMContentLoaded', function() {
	const container = document.querySelector('#glam-puzzles-container');

	if (container && typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
		gsap.registerPlugin(ScrollTrigger);

		const puzzleItems = container.querySelectorAll('.puzzle-item');

		// Detect if mobile (width < 768px - Tailwind md breakpoint)
		const isMobile = window.innerWidth < 768;

		// Distance from bottom - all items come from below the viewport
		const distance = isMobile ? '80vh' : '100vh';

		// Calculate the scroll range for triggering items
		const itemCount = puzzleItems.length;
		const scrollRange = 400; // Total scroll distance to spread all triggers across

		// Animate each puzzle item with individual scroll triggers
		puzzleItems.forEach((item, index) => {
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
						start: () => `top+=${triggerOffset}px center`, // Each item triggers at different scroll position when container hits center
						end: () => `top+=${triggerOffset + 300}px center`, // Animation completes over 300px of scroll
						scrub: 1, // Smooth scrubbing effect - animation tied to scroll
						markers: true, // Set to true for debugging
						toggleActions: 'play none none reverse'
					}
				}
			);
		});
	}
});
