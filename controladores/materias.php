<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/materiaDAO.php'));


if(!empty($_POST["btn_add"])){
  try{
    MateriaDAO::insertMateria();  
  }catch(Exception $e){          
    echo '<script type="text/javascript">alert("'.$e->getMessage().'");
          window.location.href="../materias.php";
          </script>';      
 }
}

if(!empty($_POST["btn_delete"])){    
  try{
      $id = $_POST['id'];
      MateriaDAO::deleteMateria($id);      
  }catch(Exception $e){    
      echo '<script type="text/javascript">alert("'.$e->getMessage().'");
            window.location.href="../materias.php";
            </script>';      
   }

}

if(!empty($_POST["btn_up"])){

  try{
    MateriaDAO::updateMateria();  
  }catch(Exception $e){      
    echo '<script type="text/javascript">alert("'.$e->getMessage().'");
          window.location.href="../materias.php";
          </script>';      
 }
}

function searchMaterias($nameMateria, $offset=0, $limit=10){
  try{
    return MateriaDAO::search($nameMateria, $offset, $limit);   
  }catch(Exception $e){      
    echo '<script type="text/javascript">alert("'.$e->getMessage().'");
          window.location.href="./materias.php";
          </script>';      
 }
}

function getAllMaterias(){
  try{
    return MateriaDAO::getAll();   
  }catch(Exception $e){   
    echo '<script type="text/javascript">alert("'.$e->getMessage().'");
          window.location.href="'.$_SERVER['HTTP_REFERER'].'";
          </script>';      
 }
}


?>




  
