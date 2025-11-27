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
<div id="<?php echo esc_attr($id); ?>" class="overflow-hidden relative <?php echo esc_attr($className); ?>"
    x-data="puzzlePieces()">
    <img class="w-full" src="<?php echo get_template_directory_uri(); ?>/blocks/w25-bus/puzzle-transition-01.svg"
        alt="Puzzle Pattern">
    <div class="bg-secondary-light">
        <div class="container">
            <div class="max-w-5xl mb-8">
                <?php if ($headline): ?>
                <h2 class="mb-4 text-3xl lg:text-5xl">
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
            <div class="flex gap-8">
                <div class="basis-2/3">
                    <?php get_template_part('blocks/w25-bus/puzzle'); ?>
                </div>
                <div class="basis-1/3">
                    <?php get_template_part('blocks/w25-bus/dates'); ?>
                </div>
            </div>
        </div>
    </div>
    <img class="w-full" src="<?php echo get_template_directory_uri(); ?>/blocks/w25-bus/puzzle-transition-02.svg"
        alt="Puzzle Pattern">
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