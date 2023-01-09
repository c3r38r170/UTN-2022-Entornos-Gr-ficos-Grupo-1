<?php

include '../backend/consulta.php';

session_start();

//To reuse the form, in case of being a modification we bring the data and load it
if(isset($_SESSION['id'])){
   $user = consultarUsuario($_SESSION['id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/grid.css">        
    <link rel='stylesheet' href='../css/style.css'>
    
    <title>Registro</title>
    <link rel="stylesheet" href="/TP_Entornos/css/login.css">
</head>

<body>
<div class="container">
<?php require_once 'header.php'?>
  <?php require_once 'menu.php'?>
  <div class="cont">  
   <div class="containerr">      
      <div class="login-item">
        <?php
            if(isset($_SESSION['id'])){
              echo '<h1 class="title">Editar Usuario</h1>';         
            }else{
              echo '<h1 class="title">Registro de Usuario</h1>';    
            }
        ?>
         
        <form action="/TP_Entornos/backend/register.php" method="post" class="form form-login">
         <div class="form-field">                     
            <input type="text" name="nombre" class="form-input" placeholder="Nombre" value="<?= isset($_SESSION['id']) ? $user['nombre'] : ""?>" required>
          </div>
          <div class="form-field">            
            <input type="text" name="apellido" class="form-input" placeholder="Apellido" value="<?= isset($_SESSION['id']) ? $user['apellido'] : ""?>" required>
          </div>
          <div class="form-field">            
            <input type="email" name="email" class="form-input" placeholder="Correo" value="<?= isset($_SESSION['id']) ? $user['email'] : ""?>" required>
          </div>
          <div class="form-field">            
            <input id="login-username" type="text" name="legajo" class="form-input" placeholder="Legajo" value="<?= isset($_SESSION['id']) ? $user['legajo'] : ""?>" required>
          </div>
          <div class="form-field">            
            <input id="login-password" type="password" name="psw" class="form-input" placeholder="Contraseña" value="<?= isset($_SESSION['id']) ? $user['password'] : ""?>" required>
          </div>
          <div class="form-field">            
            <select class="select" name="role" id="" required>              
              <option selected disabled>Tipo de Usuario</option>
              <option value="0" <?= isset($_SESSION['id']) && ($user['rol']==0)  ? "selected" : ""?>>Admin</option>
              <option value="1" <?= isset($_SESSION['id']) && ($user['rol']==1)  ? "selected" : ""?>>Docente</option>
              <option value="2" <?= isset($_SESSION['id']) && ($user['rol']==2)  ? "selected" : ""?>>Alumno</option>
            </select>
          </div>          
          <div class="form-field">            
            <input type="submit" value="Registrar">
          </div>
        </form>
      </div>    
    </div> 
  </div>   
      <?php require_once 'footer.php'?>      
</div>      
</body>
</html>