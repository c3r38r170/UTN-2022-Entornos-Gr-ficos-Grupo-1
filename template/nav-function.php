<?php
	function nav(...$items){
?>
<style>
	nav-container{
		width: 100%;
		display: flex;
		flex-shrink: 0;
		justify-content: flex-start;
		align-items: center;
	}
	nav-container > img{
		margin-left: 1em;
		max-width: 100%;
		height: auto;
		object-fit: contain;
	}
	nav-container > h2{
		margin-left: 1em;
	}
	nav-container > nav{
		background: rgb(37, 150, 226);
		color: #FFF;
		height: 45px;
		padding-left: 18px;
		border-radius: 10px;
		width: 100%;
	}
	nav-container > nav > input{
		display: none;
		margin: 0;
		padding: 0;
		height: 45px;
		width: 100%;
		opacity: 0;
		cursor: pointer;
	}
	nav-container > nav > label {
		display: none;
		line-height: 45px;
		text-align: center;
		position: absolute;
		left: 35px;
	}
	nav-container > nav ul {
		width: 100%;
	}
	nav-container > nav ul {
		float: left;
		display: inline;
		position: relative;
	}
	nav-container > nav ul, nav-container > nav li {
		margin: 0 auto;
		padding: 0;
		list-style: none;
	}
	nav-container > nav a, nav-container > nav input + span {
		display: block;
		line-height: 45px;
		padding: 0 14px;
		text-decoration: none;
		color: #FFFFFF;
		font-size: 16px;
	}
	nav-container > nav a:hover
		, nav-container > nav input + span:hover {
		color: #0099CC;
		background: #F2F2F2;
	}
	nav-container > nav input {
		display: none;
	}
	nav-container > nav input ~ ul{
		height: auto;
		overflow: hidden;
		width: 170px;
		background: #444444;
		position: absolute;
		z-index: 99;
		display: none;
	}
	nav-container > nav input ~ ul > li{
		display: block;
		width: 100%;
	}
	nav span::after {
		content: "\25BE";
		margin-left: 5px;
	}
	@media screen and (max-aspect-ratio: 13/9) {
		nav {position:relative}
		nav ul {background:#111;position:absolute;top:100%;right:0;left:0;z-index:3;height:auto;display:none}
		nav input ~ ul {width:100%;position:static;}
		nav input ~ ul a {padding-left:30px;}
		nav li {display:block;float:none;width:auto;}
		nav input, nav label {position:absolute;top:0;left:0;display:block}
		nav input {z-index:4}
		nav input:checked + label {color:white}
		nav input:checked + label:before {content:"\00d7"}
		nav input:checked ~ ul {display:block}
	}
</style>
<nav-container>
	<img src="../img/utn_icono 1.png" alt="">
	<h2>UTN Frro</h2>	
	<nav>
		<input type="checkbox"><label></label>
		<ul>
<?php

foreach ($items as $title => $content) {
	if(is_string($content)){
?>
			<li><a href="<?=$content?>"><?=$title?></li>	
<?php
	}else{
?>
			<li><input type="checkbox"><span><?=$title?></span>
				<ul>
<?php
		foreach ($content as $subIitle => $subContent) {
?>
					<li><a href="<?=$content?>"><?=$title?></li>
<?php
		}
?>	
				</ul>
			</li>
<?php
	}
}
?>
		</ul>
	</nav>
</nav-container>
<?php
	}
?>