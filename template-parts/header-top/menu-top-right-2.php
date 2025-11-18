<?php
bb_wp_nav_menu( array(
  'theme_location' => 'nav-right-level-2',
  'menu_id'        => 'nav-right-level-2',
  'menu_class'     => 'menu horizontal right', // Add the 'menu' class to the ul element
  'container'      => 'div',  // Wrap the menu in a div
  'container_class'=> 'nav-container', // Add a class to the container div
) );
?>