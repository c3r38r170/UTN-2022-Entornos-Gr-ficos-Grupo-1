<?php
include '../backend/consulta.php';
include '../backend/conection.inc';
include '../backend/pagination.php';

$limit = 1;  // Number of entries to show in a page.
    // Look for a GET variable page if not found default is 1.     
    //$pn es la pagina actual
if (isset($_GET["page"])) { 
  $pn  = $_GET["page"]; 
} 
else { 
  $pn=1; 
};  
  
$start_from = ($pn-1) * $limit;  
   
if (isset($_GET["search"])) {       
  $search = $_GET["search"]; 

  $sql = "SELECT * FROM usuarios WHERE CONCAT( nombre,  ' ', apellido ) LIKE  '%$search%' LIMIT $start_from, $limit";  
  $rs_result = mysqli_query($link,$sql);  
} 
else {    
 $sql = "SELECT * FROM usuarios LIMIT $start_from, $limit";  
 $rs_result = mysqli_query($link,$sql);  
};  

?>
<html>
<head>
<title> Listados Usuarios </title>
<link rel="stylesheet" href="../css/grid.css">        
<link rel='stylesheet' href='../css/style.css'>
<link rel='stylesheet' href='../css/table.css'>
<link rel='stylesheet' href='../css/login.css'>
<link rel='stylesheet' href='../css/searchBar.css'>
</head>

<body>
<div class="container">
<?php
include '../backend/conection.inc';

require_once 'header.php';
require_once 'menu.php';

//$vSql = "SELECT * FROM usuarios WHERE rol<>0";
$vSql = "SELECT * FROM usuarios";
$vResultado = mysqli_query($link, $vSql);
$total_registros=mysqli_num_rows($vResultado);
?>
<div class="content">

<div class="table">
<div class="wrap">   
    <form action="usuarios.php" method="GET">
      <div class="search">
      <input type="text" class="searchTerm" placeholder="Buscar por nombre y/o apellido" name="search">
      <button type="submit" class="searchButton">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10 2.5a7.5 7.5 0 0 1 5.964 12.048l4.743 4.745a1 1 0 0 1-1.32 1.497l-.094-.083-4.745-4.743A7.5 7.5 0 1 1 10 2.5Zm0 2a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11Z" fill="white"/></svg>
     </button>
     </div>
   </form>         
</div>

<table>
  <caption>Lista de usuarios</caption>
  <thead>
    <tr>
      <td><b>Id</b></td>
      <td><b>Nombre</b></td>
      <td><b>Apellido</b></td>
      <td><b>Legajo</b></td>
      <td><b>Email</b></td>
      <td><b>Rol</b></td>
      <td><b>Modificar</b></td>
    </tr>
  </thead>    
  <tbody>
<?php
while ($fila = mysqli_fetch_array($rs_result))
{
?>
    <tr>
      <td data-label="Id"><?php echo ($fila['id']); ?></td>
      <td data-label="Nombre"><?php echo ($fila['nombre']); ?></td>
      <td data-label="Apellido"><?php echo ($fila['apellido']); ?></td>
      <td data-label="Legajo"><?php echo ($fila['legajo']); ?></td>
      <td data-label="Email"><?php echo ($fila['email']); ?></td>
      <td data-label="Rol"><?php echo ((($fila['rol']==1) ? "Docente" : "Alumno")); ?></td>
      <td data-label="Modificar"> 
        <div class="buttons">
          <form action="modificacion.php" method="post">
             <button type="submit"><svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M13.94 5 19 10.06 9.062 20a2.25 2.25 0 0 1-.999.58l-5.116 1.395a.75.75 0 0 1-.92-.921l1.395-5.116a2.25 2.25 0 0 1 .58-.999L13.938 5Zm7.09-2.03a3.578 3.578 0 0 1 0 5.06l-.97.97L15 3.94l.97-.97a3.578 3.578 0 0 1 5.06 0Z" fill="#212121"/></svg></button>  
            <input type="hidden" value="<?=$fila['id']?>" name="id">
          </form>
          <form action="../backend/consulta.php" method="post">
            <button type="submit"><svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.5 6a1 1 0 0 1-.883.993L20.5 7h-.845l-1.231 12.52A2.75 2.75 0 0 1 15.687 22H8.313a2.75 2.75 0 0 1-2.737-2.48L4.345 7H3.5a1 1 0 0 1 0-2h5a3.5 3.5 0 1 1 7 0h5a1 1 0 0 1 1 1Zm-7.25 3.25a.75.75 0 0 0-.743.648L13.5 10v7l.007.102a.75.75 0 0 0 1.486 0L15 17v-7l-.007-.102a.75.75 0 0 0-.743-.648Zm-4.5 0a.75.75 0 0 0-.743.648L9 10v7l.007.102a.75.75 0 0 0 1.486 0L10.5 17v-7l-.007-.102a.75.75 0 0 0-.743-.648ZM12 3.5A1.5 1.5 0 0 0 10.5 5h3A1.5 1.5 0 0 0 12 3.5Z" fill="#212121"/></svg></button>  
            <input type="hidden" value="<?=$fila['id']?>" name="id">
            <input type="hidden" value=" " name="delete">
          </form>
        </div>
      </td>
    </tr>
<?php
}

?>
  </tbody>
</table>
<ul class="pagination">
      <?php 
      
      //If the user did any search
      if (isset($_GET["search"])){
        $sql = "SELECT COUNT(*) FROM usuarios WHERE CONCAT( nombre,  ' ', apellido ) LIKE  '%$search%'";  
      }else{
        $sql = "SELECT COUNT(*) FROM usuarios";  
      }
        
        $rs_result = mysqli_query($link,$sql);
        $row = mysqli_fetch_array($rs_result);
        $total_records = $row[0];

        // Number of pages required.
        $total_pages = ceil($total_records / $limit);  
        $pagLink = "";             
        
        // Number of pages showed.
        $showed = ($total_records < 2) ? $total_records : 2; //this validation is necessary because if the number of results is less than 2 then the pagination fails

        //Number of the first page to show
        if (isset($_GET["first"])) { 
          $fisrt  = $_GET["first"]; 
        } 
        else { 
          $fisrt=1; 
        };  
                
        echo generateLeftArrow($pn,$fisrt,(isset($_GET["search"])) ? $search : "");
        echo generatePages($pn,$fisrt,$showed,(isset($_GET["search"])) ? $search : "");
        echo generateRightArrow($pn,$fisrt+$showed,$showed,$fisrt,$total_pages,(isset($_GET["search"])) ? $search : "");                
      ?>
      </ul>
      <button id="registerUser">Registrar Usuario</button>
</div>        
</div>
<?php require_once 'footer.php'?>      
</div>
<div class="modal" style="display:none">
  <div class="cont">  
     <div class="containerr">      
        <div class="login-item">  
          <form action="/TP_Entornos/backend/register.php" method="post" class="form form-login">          
            <button id="closeModal" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" id="mdi-close" viewBox="2 1 20 20"><path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" /></svg>
                <span>Cerrar</span>         
            </button>            
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
</div>
<script src="../frontend/modalForm.js"></script>  
</body>
</html>