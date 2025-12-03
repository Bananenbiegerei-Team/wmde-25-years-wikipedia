// GSAP Parallax effect for W25 Numbers block
document.addEventListener('DOMContentLoaded', function() {
	const container = document.querySelector('#numbers-parallax-container');

	if (container) {
		const numberItems = container.querySelectorAll('.number-item');

		// Detect if mobile (width < 768px - Tailwind md breakpoint)
		const isMobile = window.innerWidth < 768;

		// Calculate movement distance relative to viewport height
		// Mobile: less movement, Desktop: more movement
		const movementDistance = window.innerHeight * (isMobile ? 0.25 : 1.0);

		// Scale values based on device
		const startScale = isMobile ? 0.8 : 0.7; // Mobile starts slightly bigger
		const minEndScale = isMobile ? 1.0 : 1.3; // Mobile scales less
		const scaleRange = isMobile ? 0.2 : 0.3; // Mobile has smaller scale variation

		// Create parallax effect for each number item with random speed and scale
		numberItems.forEach((item) => {
			// Generate random speed between 0.3 and 1.2 for variety
			const randomSpeed = 0.3 + Math.random() * 1.2; // Random value between 0.3 - 1.2

			// Generate random end scale based on device
			const randomEndScale = minEndScale + Math.random() * scaleRange;

			// Create GSAP animation with ScrollTrigger - animate both position and scale on scroll
			gsap.fromTo(item,
				{
					// Start state: original position and smaller scale
					y: 0,
					scale: startScale
				},
				{
					// End state: move up and scale to random size
					y: () => -movementDistance * randomSpeed, // Move up based on random speed multiplier and viewport height
					scale: randomEndScale, // Animate to random scale
					ease: 'none',
					scrollTrigger: {
						trigger: container,
						start: '33% bottom',
						end: '66% top',
						scrub: true,
						markers: false
					}
				}
			);
		});
	}
});
