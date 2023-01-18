<?php

require_once(dirname(__DIR__,1) . '\db.php');

function getAll(){    

    $db=new MysqliWrapper();

    $sql = "SELECT * FROM materia";      
    $resultado = $db->query($sql);    
    $materias = $resultado->fetch_all(MYSQLI_ASSOC);
    
    mysqli_free_result($resultado);
        
    return $materias;
  }

  
  function getOneMateria($id){
    $db=new MysqliWrapper();
   
    $sql = "SELECT * FROM materia WHERE id=?";
    $resultado = $db->prepared($sql,[$id]);
    $materia = $resultado->fetch_array();

    mysqli_free_result($resultado);
     
    return $materia;
  }
  

  function insertMateria(){

    $db=new MysqliWrapper();
    $name = $_POST["name"];
    $cont = 0;

    if(!ctype_alnum($name)){          
      $error = "El campo Nombre debe ser alfanumerico";
      header("Location: ../form_materias.php?error=".urlencode(json_encode($error)));
      $cont++;      
   }

    if($cont == 0){  
      $sql = "SELECT * FROM materia WHERE nombre=?";
      $resultado = $db->prepared($sql,[$name]);
      $materias_filas=mysqli_num_rows($resultado);

      if($materias_filas > 0){       
        $error = "Ya existe una materia con ese nombre!";
        header("Location: ../form_materias.php?error=".urlencode(json_encode($error)));
      }else{
        $vSql = "INSERT INTO materia (nombre) VALUES (?)";
        $db->prepared($vSql,[$name]);
        $success = "Materia cargada con exito!";
        header("Location: ../form_materias.php?success=".urlencode(json_encode($success)));
      }
    }
  }



  function deleteMateria($id){

    $db=new MysqliWrapper();
    $sql = "DELETE FROM materia WHERE id=?";      
    $db->prepared($sql,[$id]);

    header('Location: ../materias.php'); 

  }



  function updateMateria(){

    $db=new MysqliWrapper();
    $name = $_POST["name"];
    $id = $_POST["id"];
    $error = 0;

    if(!ctype_alnum($name)){
      $error = "El campo Nombre debe ser alfanumerico";
      header("Location: ../form_materias.php?id=".$id."&name=".$name."&error=".urlencode(json_encode($error))); 
    }
    

    if($error == 0){  
      $sql = "SELECT * FROM materia WHERE nombre=?";
      $resultado = $db->prepared($sql,[$name]);
      $materias_filas=mysqli_num_rows($resultado);

      if($materias_filas > 0){       
        $error = "Ya existe una materia con ese nombre!";
        header('Location: ../form_materias.php?id='.$id.'&name='.$name."&error=".urlencode(json_encode($error)));
         
      }else{
        $vSql = "UPDATE materia set nombre=? WHERE id=?";
        $db->prepared($vSql,[$name,$id]);
        $success = "Materia Modificada con exito!";
        header("Location: ../materias.php?success=".urlencode(json_encode($success))); 
      }
    }
  }



  function search($nameMateria){

    $db=new MysqliWrapper();
    $name = "%$nameMateria%"; 
    $sql = "SELECT * FROM materia WHERE nombre LIKE ?"; 
    $resultado = $db->prepared($sql,[$name]);
    $materias = $resultado->fetch_all(MYSQLI_ASSOC);
    mysqli_free_result($resultado);
          
    return $materias;

  }


?>