<?php
$template_uri = get_template_directory_uri();
?>
<div class="relative bg-secondary-light" id="bus-container">
    <?php foreach (range(1, 18) as $busNumber):
        $busNumberPadded = str_pad($busNumber, 2, '0', STR_PAD_LEFT);
        $isFirst = ($busNumber === 1);
    ?>
        <img class="<?php echo $isFirst ? 'relative' : 'absolute top-0 left-0'; ?> w-screen h-auto puzzle-piece"
            src="<?php echo $template_uri; ?>/blocks/w25-bus/img/bus-<?php echo $busNumberPadded; ?>.png"
            alt="Bus image">
    <?php endforeach; ?>
</div>

<script>
  /**
   * Fisher-Yates shuffle algorithm
   * Randomly reorders the elements in an array
   * Example: [1,2,3,4,5] might become [3,1,5,2,4]
   */
  function shuffle(arr) {
    // Loop backwards through array starting from last element
    for (let i = arr.length - 1; i > 0; i--) {
      // Pick a random index from 0 to i
      const j = Math.floor(Math.random() * (i + 1));
      // Swap elements at positions i and j
      [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr;
  }

  // Wait for the DOM to be fully loaded before running animation
  document.addEventListener('DOMContentLoaded', () => {
    // Step 1: Get all bus images from the DOM
    // Array.from() converts NodeList to a regular JavaScript array
    const pieces = Array.from(document.querySelectorAll('#bus-container .puzzle-piece'));

    // Step 2: Create a shuffled copy of the images array
    // [...pieces] creates a copy so we don't modify the original
    // This randomizes which bus appears first, second, third, etc.
    const order = shuffle([...pieces]);

    // Step 3: Wait for all images to load before starting animation
    // This prevents animation from starting before images are ready
    const loadPromises = order.map(img => {
      // If image is already loaded (cached), resolve immediately
      if (img.complete) {
        return Promise.resolve();
      } else {
        // Otherwise, wait for the 'load' or 'error' event
        return new Promise(res => {
          img.addEventListener('load', res, { once: true });
          img.addEventListener('error', res, { once: true });
        });
      }
    });

    // Step 4: Once ALL images are loaded, start the GSAP animation with ScrollTrigger
    Promise.all(loadPromises).then(() => {
      // Create a GSAP timeline
      // duration: 0.025 = each fade takes 0.025 seconds (very quick)
      // ease: 'power2.out' = animation starts fast and slows down at end
      const tl = window.gsap.timeline({
        defaults: {
          duration: 0.025,
          ease: 'power2.out'
        },
        // ScrollTrigger configuration
        scrollTrigger: {
          trigger: '#bus-container',        // Element that triggers the animation
          start: 'top center',               // Start when top of element hits center of viewport
          markers: false,                     // Show visual markers for debugging
          once: true                         // Only trigger once (don't reverse on scroll back up)
        }
      });

      // Step 5: Add each bus image to the timeline in shuffled order
      order.forEach((el, i) => {
        // Calculate random delay between images
        // First image (i === 0): no delay (offset = 0)
        // Other images: 0.015s to 0.04s random delay after previous image
        const offset = i === 0 ? 0 : 0.015 + Math.random() * 0.025;

        // Animate this image's opacity from 0 to 1
        // += means "after the previous animation finishes, wait this offset, then start"
        tl.to(el, { opacity: 1 }, `+=${offset}`);
      });
    });
  });
</script>