<style>
	footer {
		position: absolute;
		bottom: 0;
		width: 100%;
	}

	footer > div{
		position: relative;
		height: 350px; overflow: hidden;
	}

	footer > div > a{
		display: inline-block;
		border-radius: 7px;
		border: none;
		background: #fff;
		color: black;
		font-family: inherit;
		text-align: center;
		font-size: 17px;
		width: 10em;
		padding: 1em;
		transition: all 0.4s;
		cursor: pointer;
		margin-left: 5%;
		margin-top: 250px;
		position: absolute;
		text-decoration: none;
	}
	
	footer > div > div {
		max-width: 400px;
		justify-content: space-around;
		display: block;
		margin-left: 80%;
		margin-top: 250px;
		position: absolute;
	}

	footer > div > div a {
		text-decoration: none;
		font-size: 15px;
		width: 40px;
		height: 40px;
		line-height: 40px !important;
		text-align: center;
		background: #fff;
		color: black;
		border-radius: 50%;
		box-shadow: 2px 2px 5px rgba(0, 0, 0, .5);
		transition: all .4s ease-in-out;
	}

	footer > div svg{
		height: 100%; width: 100%; margin-top: 50px
	}

	
	@media screen and (max-aspect-ratio: 13/9) { /* Pantalla vertical */
		footer > div > a {
			margin-top: 275px;
		}
		footer > div > div {
			margin-left: 70%;
		}
	}
</style>
<footer>
	<div>
		<a href="contact_us.php" tabindex="6">Sobre Nosotros</a>
		<div>
			<a href="#" class="fab fa-instagram"></a>
			<a href="#" class="fab fa-facebook"></a>
			<a href="#" class="fab fa-youtube"></a>
			<a href="#" class="fab fa-twitter"></a>
		</div>
		<svg viewBox="0 0 500 150" preserveAspectRatio="none">
			<path d="M0.00,49.99 C150.00,150.00 349.20,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #087cf4"></path>
		</svg>
	</div>
</footer>