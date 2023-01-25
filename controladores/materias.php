<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/materiaDAO.php'));


if(!empty($_POST["btn_add"])){
  try{
    insertMateria();  
  }catch(Exception $e){      
    echo '<script type="text/javascript">alert("'.$e->getMessage().'");
          window.location.href="../materias.php";
          </script>';      
 }
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

  try{
    updateMateria();  
  }catch(Exception $e){      
    echo '<script type="text/javascript">alert("'.$e->getMessage().'");
          window.location.href="../materias.php";
          </script>';      
 }
}

function searchMaterias($nameMateria, $offset=0, $limit=10){
  try{
    return search($nameMateria, $offset, $limit);   
  }catch(Exception $e){      
    echo '<script type="text/javascript">alert("'.$e->getMessage().'");
          window.location.href="./materias.php";
          </script>';      
 }
}

function getAllMaterias(){
  try{
    return getAll();   
  }catch(Exception $e){ 
    //TODO redireccionar al home del administrador en caso de que se de la ex en materias.php     
    echo '<script type="text/javascript">alert("'.$e->getMessage().'");
          window.location.href="./administador.php";
          </script>';      
 }
}


?>




  
