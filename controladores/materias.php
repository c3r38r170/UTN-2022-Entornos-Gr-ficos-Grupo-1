<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/materiaDAO.php'));


if(!empty($_POST["btn_add"])){

  insertMateria();
}

if(!empty($_POST["btn_delete"])){  
  try{
      $id = $_POST['id'];
      deleteMateria($id);   
  }catch(Exception $e){      
      echo '<script type="text/javascript">alert("'.$e->getMessage().'");
            window.location.href="../materias.php";
            </script>';      
   }

}

if(!empty($_POST["btn_up"])){

  updateMateria();
}

function searchMaterias($nameMateria, $offset=0, $limit=10){
  return search($nameMateria, $offset, $limit);
}

function getAllMaterias(){
  return getAll();
}


?>




  
