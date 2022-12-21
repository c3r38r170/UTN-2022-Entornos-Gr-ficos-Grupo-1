<?php

function generateBreadcrumbs(...$breadcrumbs){
	$ul='<ul class="breadcrumbs">';
	foreach($breadcrumbs as $bre) {
		$ui.='<li><a href="'.$breadcrumbs['link'].'">'.$breadcrumbs['text'].'</a></li>';
	}
	$ul.='</ul>';
	return $ul;
}

?>