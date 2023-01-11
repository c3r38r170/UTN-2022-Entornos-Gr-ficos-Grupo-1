<?php
require_once 'controladores/comisiones.php';
$coms = selectAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/formulario.css"/>
	<title>Document</title>	
    <!-- Los siguientes estilos son temporales para mejorar la visualización hasta que se definan los  definitivos -->
    <style>
        table caption {
            font-size: 1.5em;
            margin: .5em 0 .75em;
        }         
  
        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;    
            table-layout: fixed;
        }

        table tr {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: .35em;
        }

        table th,
        table td {
            padding: .625em;
            text-align: center;
        }

        table th {
            font-size: .85em;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

         .container{
            display:flex;
            justify-content:center;
            flex-direction:column;
            align-items:center;                            
         }
         form > button{
            background: none;
            border: none;
            cursor: pointer;
         }
         .buttons{
            display:flex;
         }   

         .btn{
            margin:1em;
            font-family:sans-serif;
            font-weight: 0;
            font-size: 14px;
            color: #fff;
            background-color: #2596e2;
            padding: 10px 30px;
            border: solid #2596e2 2px;
            box-shadow: rgb(0, 0, 0) 0px 0px 0px 0px;
            border-radius: 50px;
            transition : 1000ms;
            transform: translateY(0);            
            cursor: pointer;
        }
        .btn > a{            
            text-decoration: none;
            color:white;
        }
        .btn:hover > a{            
            color: #0066cc;
        }
        .btn:hover{
            transition : 1000ms;
            padding: 10px 50px;
            transform : translateY(-0px);
            background-color: #fff;            
            border: solid 2px #0066cc;
        }        
    </style>
</head>
<body>
<?php require_once 'template/header.php'; ?>
<?php
	require_once 'template/nav-function.php';
	nav([
		'Ingresar'=>'login.php'
		,'Registrarse'=>'registro.php'
		,'Consultas'=>'http://'
		,'Gestionar'=>[
			'Usuarios'=>'usuarios.php'
			,'Comisiones'=>'comisiones.php'
		]
		,'Sobre Nosotros'=>'contacto.php'
	]);
?>
<div class="container">
<table>
    <caption>Listado de comisiones</caption>
    <thead>
        <tr>
            <td><b>Id</b></td>
            <td><b>Numero</b></td>
            <td><b>Modificar</b></td>
        </tr>
    </thead>    
    <tbody>
        <?php foreach ($coms as $row) { ?> 
            <tr>
                <td data-label="Id"><?php echo ($row['id']); ?></td>
                <td data-label="Nombre"><?php echo ($row['numero']); ?></td>
                <td data-label="Modificar"> <div class="buttons">
                    <form action="form_comisiones.php" method="get">
                        <!-- Los .svg son temporales hasta que se definan los iconos de edicion -->
                        <button type="submit"><svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M13.94 5 19 10.06 9.062 20a2.25 2.25 0 0 1-.999.58l-5.116 1.395a.75.75 0 0 1-.92-.921l1.395-5.116a2.25 2.25 0 0 1 .58-.999L13.938 5Zm7.09-2.03a3.578 3.578 0 0 1 0 5.06l-.97.97L15 3.94l.97-.97a3.578 3.578 0 0 1 5.06 0Z" fill="green"/></svg></button>  
                        <input type="hidden" value="<?=$row['id']?>" name="id">
                        <input type="hidden" value="<?=$row['numero']?>" name="number">
                    </form>
                    <form action="controladores/comisiones.php" method="post">
                        <button type="submit"><svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.5 6a1 1 0 0 1-.883.993L20.5 7h-.845l-1.231 12.52A2.75 2.75 0 0 1 15.687 22H8.313a2.75 2.75 0 0 1-2.737-2.48L4.345 7H3.5a1 1 0 0 1 0-2h5a3.5 3.5 0 1 1 7 0h5a1 1 0 0 1 1 1Zm-7.25 3.25a.75.75 0 0 0-.743.648L13.5 10v7l.007.102a.75.75 0 0 0 1.486 0L15 17v-7l-.007-.102a.75.75 0 0 0-.743-.648Zm-4.5 0a.75.75 0 0 0-.743.648L9 10v7l.007.102a.75.75 0 0 0 1.486 0L10.5 17v-7l-.007-.102a.75.75 0 0 0-.743-.648ZM12 3.5A1.5 1.5 0 0 0 10.5 5h3A1.5 1.5 0 0 0 12 3.5Z" fill="red"/></svg></button>  
                        <input type="hidden" value="<?=$row['id']?>" name="id">
                        <input type="hidden" value=" " name="delete">
                    </form>
                </td>    
            </tr>
<?php } ?>
    </tbody>
</table>
<button class="btn"><a href="form_comisiones.php">Cargar Comision</a></button>
</div>
<script src="https://kit.fontawesome.com/f452b46f6c.js" crossorigin="anonymous"></script>
<?php //require_once 'template/footer.php'; ?>
</body>
</html>