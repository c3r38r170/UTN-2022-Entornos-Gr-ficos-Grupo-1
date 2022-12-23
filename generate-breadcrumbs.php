<?php

function generateBreadcrumbs(...$breadcrumbs){
	$ul='<ul class="breadcrumbs">';
	foreach($breadcrumbs as $bre) {
		$ui.='<li><a href="'.$bre['link'].'">'.$bre['text'].'</a></li>';
	}
	$ul.='</ul>';
	return $ul;
}

?>