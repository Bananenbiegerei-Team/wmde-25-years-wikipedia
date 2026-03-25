<?php
add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
	$toolbars['bb-block-paragraph'] = [];
	$toolbars['bb-block-paragraph'][1] = ['bold', 'underline', 'bullist', 'numlist', 'link', 'unlink', 'removeformat'];
	return $toolbars;
});