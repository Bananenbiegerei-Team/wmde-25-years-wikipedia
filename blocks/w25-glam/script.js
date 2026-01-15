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

		// Detect orientation mode (portrait vs landscape)
		// Portrait: height > width (phones, tablets held vertically)
		// Landscape: width > height (desktops, tablets held horizontally)
		const isPortrait = window.innerHeight > window.innerWidth;

		// Distance from bottom - all items come from below the viewport
		const distance = '100vh'; // Always start from full viewport height below

		// Calculate the scroll range for triggering items
		const itemCount = puzzleItems.length;
		// Scroll range as percentage of viewport height, converted to pixels
		// Portrait: tighter spacing (30vh) for vertical scrolling
		// Landscape: wider spacing (50vh) for horizontal viewing
		const scrollRangeVh = isPortrait ? 60 : 50;
		const scrollRange = (scrollRangeVh / 100) * window.innerHeight;

		// Animation duration (scroll distance for each item animation)
		// Portrait: faster animation (1vh) for quick reveals
		// Landscape: slower animation (10vh) for smoother transitions
		const animationDurationVh = isPortrait ? 30 : 10;
		const animationDuration = (animationDurationVh / 100) * window.innerHeight;

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
						start: () => `top+=${triggerOffset}px center`, // Each item triggers at staggered positions
						end: () => `top+=${triggerOffset + animationDuration}px center`, // Animation completes over duration distance
						scrub: 1, // Smooth scrubbing - animation tied directly to scroll position
						markers: false, // Set to true for debugging
						toggleActions: 'play none none reverse',
						id: `glam-puzzle-${index + 1}` // Custom name for debugging markers
					}
				}
			);
		});
	}
});
