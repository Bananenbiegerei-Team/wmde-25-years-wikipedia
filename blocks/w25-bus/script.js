// Simple fade-in/fade-out animation for bus images
document.addEventListener('DOMContentLoaded', () => {
	// Get all bus images
	const pieces = Array.from(document.querySelectorAll('#bus-container .puzzle-piece'));

	console.log('Bus animation: Found', pieces.length, 'images');

	// Check if GSAP is available
	if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
		console.error('Bus animation: GSAP or ScrollTrigger not loaded');
		// Fallback: show all images
		pieces.forEach(el => el.style.opacity = '1');
		return;
	}

	gsap.registerPlugin(ScrollTrigger);

	// Wait for images to load
	const loadPromises = pieces.map(img => {
		if (img.complete) {
			return Promise.resolve();
		} else {
			return new Promise(res => {
				img.addEventListener('load', res, { once: true });
				img.addEventListener('error', res, { once: true });
			});
		}
	});

	// Start animation once images are loaded
	Promise.all(loadPromises).then(() => {
		console.log('Bus animation: All images loaded, starting animation');

		// Create GSAP timeline that auto-plays once triggered
		const tl = gsap.timeline({
			scrollTrigger: {
				trigger: '#bus-container',
				start: '20% center',
				markers: false,
				once: true,
				onEnter: () => console.log('Bus animation: ScrollTrigger activated')
			}
		});

		// Show images one after another instantly
		pieces.forEach((el, i) => {
			const isLast = i === pieces.length - 1;

			// Show this image instantly
			tl.set(el, { opacity: 1 }, i * 0.3);

			// Hide it instantly (unless it's the last image)
			if (!isLast) {
				tl.set(el, { opacity: 0 }, (i * 0.3) + 0.3);
			}
		});

		console.log('Bus animation: Timeline created with', pieces.length, 'animations');
	});
});
