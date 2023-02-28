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
	header .parrafo{
		position: absolute;right: 1rem;margin-top: 45px;
	}

	header .parrafo p{
		margin: 0px;
		font-weight: bold;
		font-size:19px;
	}

	header span{
		color: #ffff;
	}

	header .user{
		position: absolute;right: 3rem; 
	}
	@media screen and (max-aspect-ratio: 13/9) { /* Pantalla vertical */
		header {
			display: none;
		}
	}
</style>
<header>
	<img src="img/utn1.png" alt="Imagen Encabezado">
	<?php
	if(isset($_SESSION['id'])){
	?>
	<div class="user">
	<img src="img/usuario.png" alt="Imagen Usuario">
	</div>
	<div class="parrafo">
		<p>Ingresó como: </p>
		<p> <span> <?php echo $_SESSION['nombre_completo'] ?> </span> </p>
	</div>
	<?php
	}
	?>

</header>