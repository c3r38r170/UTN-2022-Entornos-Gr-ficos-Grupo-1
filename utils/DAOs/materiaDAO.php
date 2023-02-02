<?php

require_once(dirname(__DIR__,1) . '\db.php');

class MateriaDAO{
  static function getAll(){    

    $db=new MysqliWrapper();
    $sql = "SELECT * FROM materia"; 
    if($resultado = $db->query($sql)){    
      $materias = $resultado->fetch_all(MYSQLI_ASSOC); 
      mysqli_free_result($resultado);
    }
    else throw new Exception("No es posible mostrar el listado de materias");     
    return $materias;
  }

  
  static function getOneMateria($id){

    $db=new MysqliWrapper();
    $sql = "SELECT * FROM materia WHERE id=?";
    if($resultado = $db->prepared($sql,[$id])){
      $materia = $resultado->fetch_array();
      mysqli_free_result($resultado);
    }
    else throw new Exception("No es posible obtener la materia");     
    return $materia;
  }


  static function insertMateria(){

    $db=new MysqliWrapper();
    $name = $_POST["name"];
    $cont = 0;

    if(!preg_match('/[^a-zA-Z0-9àâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñý’,. ]/', $name)){          
      $error = "El campo Nombre debe ser alfanumerico";
      header("Location: ../form_materias.php?error=".urlencode(json_encode($error)));
      $cont++;      
   }

    if($cont == 0){             
        $sql = "SELECT * FROM materia WHERE nombre=?";        
        if($resultado = $db->prepared($sql,[$name])){
          $materias_filas=mysqli_num_rows($resultado);
          if($materias_filas > 0){       
            $error = "Ya existe una materia con ese nombre!";
            header("Location: ../form_materias.php?error=".urlencode(json_encode($error)));
          }else{
            $vSql = "INSERT INTO materia (nombre) VALUES (?)";
            if($db->prepared($vSql,[$name])){
            $success = "Materia cargada con exito!";
            header("Location: ../form_materias.php?success=".urlencode(json_encode($success)));
            }else throw new Exception("No es posible cargar la materia"); 
          }          
        }else throw new Exception("No es posible cargar la materia"); 
      }
 }  



  static function deleteMateria($id){

    $db=new MysqliWrapper();
    $sql = "DELETE FROM materia WHERE id=?";          
    if($db->prepared($sql,[$id]))
      header('Location: ../materias.php');     
    else throw new Exception("No es posible realizar esta operacion"); 
  }
                 

  static function updateMateria(){

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
        if($resultado = $db->prepared($sql,[$name])){
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
        }else throw new Exception("No es posible actualizar la materia");        
    }
  }



  static function search($nameMateria, $offset=0, $limit=10){

    $db=new MysqliWrapper();
    $name = "%$nameMateria%"; 
    $sql = "SELECT * FROM materia WHERE nombre LIKE ? LIMIT $limit OFFSET $offset";
    
    if($resultado = $db->prepared($sql,[$name])){
      $materias = $resultado->fetch_all(MYSQLI_ASSOC);
      mysqli_free_result($resultado);    
    }else throw new Exception("No es posible buscar la materia");       
      return $materias;
  }
}

?>