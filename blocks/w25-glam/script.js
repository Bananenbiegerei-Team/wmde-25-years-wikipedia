// GSAP Scroll-triggered animation for W25 GLAM Presents block
// Each puzzle item animates from bottom of viewport to its final absolute position
// Items trigger sequentially as user scrolls through the container
document.addEventListener('DOMContentLoaded', function() {
	const container = document.querySelector('#glam-puzzles-container');
	const glamContainer = document.querySelector('.glam-container');

	// Calculate and set height of glam-container based on absolutely positioned puzzle items
	if (glamContainer && container) {
		const puzzleItems = container.querySelectorAll('.puzzle-item');

		// Function to calculate the maximum bottom position of all puzzle items
		function calculateContainerHeight() {
			let maxBottom = 0;

			puzzleItems.forEach((item) => {
				const relativeTop = item.offsetTop;
				const itemBottom = relativeTop + item.offsetHeight;

				if (itemBottom > maxBottom) {
					maxBottom = itemBottom;
				}
			});

			// Get computed padding-bottom to add to the calculated height
			const computedStyle = window.getComputedStyle(glamContainer);
			const paddingBottom = parseFloat(computedStyle.paddingBottom) || 0;

			// Set the height of glam-container (add padding to ensure it's respected)
			if (maxBottom > 0) {
				glamContainer.style.minHeight = (maxBottom + paddingBottom) + 'px';
			}
		}

		// Calculate height after images load
		if (puzzleItems.length > 0) {
			// Wait for images to load
			const images = Array.from(puzzleItems);
			Promise.all(images.map(img => {
				if (img.complete) return Promise.resolve();
				return new Promise(resolve => {
					img.addEventListener('load', resolve);
					img.addEventListener('error', resolve);
				});
			})).then(() => {
				calculateContainerHeight();
			});

			// Also recalculate on window resize
			window.addEventListener('resize', calculateContainerHeight);
		}
	}

	if (container && typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
		gsap.registerPlugin(ScrollTrigger);

		const puzzleItems = container.querySelectorAll('.puzzle-item');
		const stickyContent = document.querySelector('.glam-content-sticky');

		// Detect if mobile (width < 768px - Tailwind md breakpoint)
		const isMobile = window.innerWidth < 768;

		// Distance from bottom - all items come from below the viewport
		const distance = isMobile ? '80vh' : '100vh';

		// Calculate the scroll range for triggering items
		const itemCount = puzzleItems.length;
		const scrollRange = isMobile ? 50 : 800; // Total scroll distance to spread all triggers across (smaller on mobile)

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
						markers: false, // Set to true for debugging
						toggleActions: 'play none none reverse'
					}
				}
			);
		});

		// Create sticky effect for content using ScrollTrigger pin
		if (stickyContent && glamContainer) {
			ScrollTrigger.create({
				trigger: glamContainer,
				start: 'top top+=96', // Pin when container reaches 96px from top (6rem)
				end: 'bottom bottom',
				pin: stickyContent,
				pinSpacing: false,
				markers: false, // Set to false for production
				id: 'glam-sticky-pin' // Custom name for markers
			});
		}
	}
});
