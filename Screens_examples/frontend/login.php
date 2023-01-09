<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/grid.css">        
    <link rel='stylesheet' href='../css/style.css'>
    <link rel="stylesheet" href="/TP_Entornos/css/login.css">
    <script src='../js/script.js'></script><body>
      </head>      
    <title>Document</title>    
</head>


<body>  
<div class="container">
  <?php require_once 'header.php'?>
   <?php require_once 'menu.php'?>
  <div class="cont">
    <div class="containerr">    
      <div class="login-item">
        <form action="/TP_Entornos/backend/loginn.php" method="post" class="form form-login">
          <div class="form-field">
            <label class="user" for="login-username"><span class="hidden">Username</span></label>
            <input id="login-username" type="text" name="legajo" class="form-input" placeholder="Legajo" required>
          </div>
          <div class="form-field">
            <label class="lock" for="login-password"><span class="hidden">Password</span></label>
            <input id="login-password" type="password" name="psw" class="form-input" placeholder="Contraseña" required>
          </div>
          <div class="form-field">
            <input type="submit" value="Ingresar">
          </div>
        </form>
      </div>
    </div>
    <br><br>    
  </div>  
  <?php require_once 'footer.php'?>
</div>
</body> 
</html>