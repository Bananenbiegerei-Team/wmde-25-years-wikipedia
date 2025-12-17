<ul class="flex flex-col md:flex-row items-center md:space-x-2 space-y-3 md:space-y-0 mb-4 md:mb-0">
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
    <a class="w-full md:w-auto <?php echo esc_attr($btn_class); ?>" href="<?php echo esc_url( $link['url'] ); ?>"
        target="<?php echo esc_attr( $link['target'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a>
    <?php endif; ?>
    <?php endwhile; ?>
    <?php endif; ?>
</ul>