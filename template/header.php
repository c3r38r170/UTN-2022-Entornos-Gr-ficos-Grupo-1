<?php
	session_start(['read_and_close'=>true]);
?><style>
	header { 
		width: 100%;
		padding: 1em 0;
		background-color: rgb(37, 150, 226);
		display: flex;
		justify-content:center;
	}
	header p{
		position: absolute;right: 1rem;
	}
	@media screen and (max-aspect-ratio: 13/9) { /* Pantalla vertical */
		header {
			display: none;
		}
	}
</style>
<header>
	<img src="img/utn1.png" alt="Imagen Encabezado">
	<p><?=isset($_SESSION['id'])?"Ingresó como: {$_SESSION['nombre_completo']}":''?></p>
</header>