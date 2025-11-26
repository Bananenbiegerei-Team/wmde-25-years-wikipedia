<?php
/**
 * W25 Bus Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-bus-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-bus';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
$headline = get_field('headline');
$text = get_field('text');
$cta = get_field('cta'); // Returns array with 'url', 'title', 'target'
$image = get_field('image'); // Returns array with 'url', 'alt', 'width', 'height', etc.

?>

<div id="<?php echo esc_attr($id); ?>"
    class="overflow-hidden relative bg-secondary-light <?php echo esc_attr($className); ?>" x-data="puzzlePieces()">
    <div class="container">
        <div class="max-w-xl mb-8">
            <?php if ($headline): ?>
            <h2 class="text-4xl">
                <?php echo esc_html($headline); ?>
            </h2>
            <?php endif; ?>

            <?php if ($text): ?>
            <div class="mb-4 text-xl font-headings">
                <?php echo nl2br(esc_html($text)); ?>
            </div>
            <?php endif; ?>

            <?php if ($cta): ?>
            <div class="w25-bus__cta">
                <a href="<?php echo esc_url($cta['url']); ?>" class="w25-bus__link"
                    <?php if ($cta['target']): ?>target="<?php echo esc_attr($cta['target']); ?>" <?php endif; ?>>
                    <?php echo esc_html($cta['title']); ?>
                </a>
            </div>
            <?php endif; ?>
            <button class="btn btn-outline btn-secondary" @click="resetAllPieces()">Puzzle neu laden
                <?= bb_icon('reload', 'icon-md') ?></button>
            <button class="btn btn-outline btn-secondary" @click="toggleSound()">
                <span class="flex items-center gap-2" x-show="!soundEnabled">Sound an
                    <?= bb_icon('speaker-off', 'icon-md') ?></span>
                <span class="flex items-center gap-2" x-show="soundEnabled">Sound aus
                    <?= bb_icon('speaker-on', 'icon-md') ?></span>
            </button>
        </div>
        <div class="max-w-5xl">
            <div class="overflow-hidden bg-no-repeat bg-cover rounded-lg aspect-h-9 aspect-w-16" style="background-image: url(<?php echo get_template_directory_uri(); ?>/blocks/w25-bus/street.png);">
                <div class="absolute inset-0 w-full h-full">
                    <div class="z-20 relative -translate-x-[2.5%] w-[105%] h-[109%] -translate-y-[9%]">
                        <template x-for="(row, rowIndex) in rows" :key="rowIndex">
                            <div class="flex" :style="`transform: translateY(calc(-${rowIndex} * 20.2%))`">
                                <template x-for="(piece, colIndex) in row" :key="colIndex">
                                    <img class="w-[12.3%] max-w-auto transition-opacity duration-300 h-auto"
                                        style="filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));"
                                        :class="{ 'opacity-0': piece.revealed, 'opacity-100': !piece.revealed }"
                                        :style="`transform: translateX(calc(-${colIndex} * 20.3%)) translateY(${colIndex % 2 === 1 ? '19.8%' : '0%'}) rotate(${colIndex % 2 === 1 ? -90 : 0}deg)`"
                                        @mouseenter="revealPiece(rowIndex, colIndex)"
                                        src="<?php echo get_template_directory_uri(); ?>/blocks/w25-bus/puzzle.svg"
                                        alt="Puzzle piece">
                                </template>
                            </div>
                        </template>
                    </div>
                    <img class="z-10 absolute w-[500px] h-auto bottom-[20px] transition-transform duration-[1000ms] ease-linear"
                        :style="`transform: translateX(${allPuzzlesRevealed ? '-300%' : '0%'}) translateY(${allPuzzlesRevealed ? '-20%' : '0%'}) scale(${allPuzzlesRevealed ? '2' : '1'}); right: -100px;`"
                        src="<?php echo get_template_directory_uri(); ?>/blocks/w25-bus/bus.png" alt="Wikipedia Bus">
                    <img class="z-10 absolute w-[100px] h-auto top-[20px] left-[20px]"
                        :class="allPuzzlesRevealed ? 'animate-bounce-in-down' : 'opacity-0'"
                        src="<?php echo get_template_directory_uri(); ?>/blocks/w25-bus/sign.svg" alt="Freuen uns">
                </div>
            </div>
        </div>
    </div>
    <script>
    function puzzlePieces() {
        return {
            audioContext: null,
            soundEnabled: false,
            rows: Array.from({
                    length: 6 // 6
                }, () =>
                Array.from({
                    length: 10 //10
                }, () => ({
                    revealed: false
                }))
            ),
            get allPuzzlesRevealed() {
                return this.rows.every(row => row.every(piece => piece.revealed));
            },
            toggleSound() {
                if (!this.audioContext) {
                    // Create AudioContext on first click
                    try {
                        this.audioContext = new(window.AudioContext || window.webkitAudioContext)();
                        this.soundEnabled = true;
                    } catch (e) {
                        console.error('AudioContext creation failed:', e);
                    }
                } else {
                    // Toggle sound on/off
                    this.soundEnabled = !this.soundEnabled;
                }
            },
            playBlopSound() {
                // Only play if sound is enabled
                if (!this.soundEnabled || !this.audioContext) {
                    return;
                }

                try {
                    // Create a simple blop sound using Web Audio API
                    const oscillator = this.audioContext.createOscillator();
                    const gainNode = this.audioContext.createGain();

                    oscillator.connect(gainNode);
                    gainNode.connect(this.audioContext.destination);

                    oscillator.frequency.value = 600;
                    oscillator.type = 'sine';

                    const now = this.audioContext.currentTime;
                    gainNode.gain.setValueAtTime(0.3, now);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, now + 0.1);

                    oscillator.start(now);
                    oscillator.stop(now + 0.1);
                } catch (e) {
                    console.error('Sound playback failed:', e);
                }
            },
            revealPiece(rowIndex, colIndex) {
                if (!this.rows[rowIndex][colIndex].revealed) {
                    this.rows[rowIndex][colIndex].revealed = true;
                    this.playBlopSound();
                }
            },
            resetAllPieces() {
                // Temporarily disable transition for instant reset
                const busElement = document.querySelector('img[alt="Wikipedia Bus"]');
                if (busElement) {
                    busElement.style.transition = 'none';
                }

                this.rows.forEach(row => {
                    row.forEach(piece => {
                        piece.revealed = false;
                    });
                });

                // Force reflow to apply the transition: none immediately
                if (busElement) {
                    busElement.offsetHeight; // Trigger reflow
                }

                // Re-enable transition on next frame
                requestAnimationFrame(() => {
                    if (busElement) {
                        busElement.style.transition = '';
                    }
                });
            }
        }
    }
    </script>
</div>