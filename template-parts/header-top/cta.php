<ul class="flex items-center gap-2">
    <?php if ( have_rows( 'call_to_actions', 'option' ) ) : ?>
    <?php while ( have_rows( 'call_to_actions', 'option' ) ) : the_row(); ?>
    <?php
        $link = get_sub_field( 'link' );
        $link_color = get_sub_field( 'color' ) ?: 'primary';
        $link_variant = get_sub_field( 'variant' ) ?: 'default';

        // Build button class based on variant and color
        $btn_class = 'btn';

        // Add variant class
        if ($link_variant === 'outline') {
            $btn_class .= ' btn-outline';
        } elseif ($link_variant === 'ghost') {
            $btn_class .= ' btn-ghost';
        }

        // Always add color class (works with all variants)
        if ($link_color) {
            $btn_class .= ' btn-' . $link_color;
        }
    ?>
    <?php if ( $link ) : ?>
    <a class="!font-alt !font-medium !text-lg <?php echo esc_attr($btn_class); ?>" href="<?php echo esc_url( $link['url'] ); ?>"
        target="<?php echo esc_attr( $link['target'] ); ?>"
        onclick="window._paq && window._paq.push(['trackEvent','CTA','Klick','<?php echo esc_js( esc_html( $link['title'] ) ); ?>',1])"><?php echo esc_html( $link['title'] ); ?></a>
    <?php endif; ?>
    <?php endwhile; ?>
    <?php endif; ?>
</ul>