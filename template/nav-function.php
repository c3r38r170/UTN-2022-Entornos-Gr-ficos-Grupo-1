<?php
	function nav($items){
?>
<style>
	nav-container{
		width: 100%;
		display: flex;
		flex-shrink: 0;
		justify-content: flex-start;
		align-items: center;
		padding: 0 1rem;
		box-sizing: border-box;
	}
	nav-container > img{
		max-width: 100%;
		height: auto;
		object-fit: contain;
	}
	nav-container > h2{
		margin-left: 1em;
	}
	nav{
		background: rgb(37, 150, 226);
		color: #FFF;
		height: 45px;
		padding-left: 18px;
		border-radius: 10px;
		width: 100%;
	}
	nav > input{
		display: none;
		margin: 0;
		padding: 0;
		height: 45px;
		width: 100%;
		opacity: 0;
		cursor: pointer;
	}
	nav > label {
		display: none;
		line-height: 45px;
		text-align: center;
		position: absolute;
		left: 35px;
	}
	nav > label::before {
		font-size: 1.6em;
		content: "\2261";
		margin-left: 20px;
	}
	nav ul {
		width: 100%;
	}
	nav li {
		float: left;
		display: inline;
		position: relative;
	}
	nav ul, nav li {
		margin: 0 auto;
		padding: 0;
		list-style: none;
	}
	nav a, nav input + span {
		display: block;
		line-height: 45px;
		padding: 0 14px;
		text-decoration: none;
		color: #FFFFFF;
		font-size: 16px;
	}
	nav a:hover
		, nav input + span:hover {
		color: #0099CC;
		background: #F2F2F2;
	}
	nav input {
		display: none;
	}
	nav li input ~ ul{
		height: auto;
		overflow: hidden;
		width: 170px;
		background: #444444;
		position: absolute;
		z-index: 99;
		display: none;
	}
	nav li input:checked ~ ul {
		display: block;
	}
	nav li input ~ ul > li{
		display: block;
		width: 100%;
	}
	nav span::after {
		content: "\25BE";
		margin-left: 5px;
	}
	@media screen and (min-aspect-ratio: 13/9) { /* Pantalla horaizontal */

	}
	@media screen and (max-aspect-ratio: 13/9) { /* Pantalla vertical */
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
	<img src="img/utn_icono 1.png" alt="">
	<h2>UTN Frro</h2>	
	<nav>
		<input type="checkbox"><label></label>
		<ul>
<?php

foreach ($items as $title => $content) {
	if(is_string($content)){
		echo "<li><a href=\"$content\">$title</a></li>";
	}else{
		echo"<li><input type=\"checkbox\"><span>$title</span>
				<ul>";
		foreach ($content as $subTitle => $subContent) {
					echo "<li><a href=\"$subContent\">$subTitle</a></li>";
		}
		echo"		</ul>
			</li>";
	}
}

?>
		</ul>
	</nav>
</nav-container>
<?php
	}
?>