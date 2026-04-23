<?php
$sqrt2_ratio = 1.4141;
$grid_container = 1440;
$twelve_columns = $grid_container;
$eight_columns = ($grid_container / 12) * 8;
$six_columns = ($grid_container / 12) * 6;
$four_columns = ($grid_container / 12) * 4;
$three_columns = ($grid_container / 12) * 3;
$two_columns = ($grid_container / 12) * 2;
// 16:9 Landscape - height = width * (9/16)
$twelve_columns_landscape_height = round($twelve_columns * (9 / 16));
$six_columns_landscape_height = round($six_columns * (9 / 16));
$three_columns_landscape_height = round($three_columns * (9 / 16));
$two_columns_landscape_height = round($two_columns * (9 / 16));
// 9:16 Portrait - height = width * (16/9)
$twelve_columns_portrait_height = round($twelve_columns * (16 / 9));
$six_columns_portrait_height = round($six_columns * (16 / 9));
$three_columns_portrait_height = round($three_columns * (16 / 9));
$two_columns_portrait_height = round($two_columns * (16 / 9));

/* Image Size Crop for foundation */
/* 16:9 Landscape Crop */
add_image_size('six-columns-landscape', $six_columns, $six_columns_landscape_height, true);
add_image_size('three-columns-landscape', $three_columns, $three_columns_landscape_height, true);
/* 9:16 Portrait Crop */
add_image_size('six-columns-portrait', $six_columns, $six_columns_portrait_height, true);
add_image_size('three-columns-portrait', $three_columns, $three_columns_portrait_height, true);