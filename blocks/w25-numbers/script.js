// GSAP Parallax effect for W25 Numbers block
document.addEventListener('DOMContentLoaded', function() {
	const container = document.querySelector('#numbers-parallax-container');

	if (container) {
		const numberItems = container.querySelectorAll('.number-item');

		// Detect if mobile (width < 768px - Tailwind md breakpoint)
		const isMobile = window.innerWidth < 768;

		// Calculate movement distance relative to viewport height
		// Mobile: less movement, Desktop: more movement
		const movementDistance = window.innerHeight * (isMobile ? 0.25 : 0.8);

		// Scale values based on device
		// Ternary operator: condition ? valueIfTrue : valueIfFalse
		// Format: isMobile ? mobileValue : desktopValue

		// Starting scale at beginning of scroll animation
		// Mobile: 0.8 (90%), Desktop: 0.7 (70%)
		// Mobile starts slightly bigger to be more readable on smaller screens
		const startScale = isMobile ? 0.9 : 0.7;

		// Minimum end scale - the smallest possible size at end of animation
		// Mobile: 1.0 (100%), Desktop: 1.3 (120%)
		// Desktop scales more dramatically for stronger visual effect
		const minEndScale = isMobile ? 1.0 : 1.2;

		// Random scale variation range added to minEndScale
		// Mobile: 0.2 (results in 100%-120% final size), Desktop: 0.3 (results in 130%-160% final size)
		// Desktop has more variation for more dynamic effect
		const scaleRange = isMobile ? 0.2 : 0.3;

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
						start: '20% bottom',
						end: '80% top',
						scrub: true,
						markers: false
					}
				}
			);
		});
	}
});
