<?php

require_once(dirname(__DIR__,1) . '\db.php');

class ComisionDAO{
   static function insertCom(){    
    $db=new MysqliWrapper();
    session_start();           
    extract($_REQUEST);

    if(!ctype_alnum(str_replace(' ','',$name))){          
       $error = "El campo Nombre debe ser alfanumerico";
       header("Location: ../form_comisiones.php?error=".urlencode(json_encode($error)));      
    }
    else{
      $vSql = "SELECT * FROM comision WHERE numero=?";
      $vResult = $db->prepared($vSql,[$name]);
      $registers=mysqli_num_rows($vResult);

      if($registers == 1){       
         $error = "Ya existe una comision con ese numero!";
         header("Location: ../form_comisiones.php?error=".urlencode(json_encode($error)));
      }else{
         $vSql = "INSERT INTO comision (numero) VALUES (?)";
         $db->prepared($vSql,[$name]);
         $success = "Comision cargada con exito!";
         mysqli_free_result($vResult);         
         header("Location: ../form_comisiones.php?success=".urlencode(json_encode($success)));         
         
      }
    }        
 }

   static function selectAll($offset,$limit){    

    $db=new MysqliWrapper();

    $sql = "SELECT * FROM comision LIMIT $limit OFFSET $offset";
    $rs_result = $db->query($sql);    
    $coms = $rs_result->fetch_all(MYSQLI_ASSOC);
    
    mysqli_free_result($rs_result);
        
    return $coms;
  }

 static function delete($id){
   
   $db=new MysqliWrapper();
   
   $vSql = "DELETE FROM comision WHERE id=?";
   if($db->prepared($vSql,[$id]))
      header('Location: ../comisiones.php');              
   else 
      throw new Exception("No es posible realizar esta operacion");            
 }

  static function editCom(){
   $db=new MysqliWrapper();
   session_start();           
   extract($_REQUEST);

   if(!ctype_alnum($name)){       
      $error = "El campo Nombre debe ser alfanumerico";
      header("Location: ../form_comisiones.php?id=".$id."&number=".$name."&error=".urlencode(json_encode($error)));              
   }
   else{
     $vSql = "SELECT * FROM comision WHERE numero=?";
     $vResult = $db->prepared($vSql,[$name]);
     $registers=mysqli_num_rows($vResult);

     if($registers == 1){       
        $error = "Ya existe una comision con ese numero!";
        header('Location: ../form_comisiones.php?id='.$id.'&number='.$name."&error=".urlencode(json_encode($error)));                     
     }else{
        $vSql = "UPDATE comision set numero=? WHERE id=?";
        $db->prepared($vSql,[$name,$id]);
        mysqli_free_result($vResult);
        header('Location: ../comisiones.php');        
     }
   } 
  }

  static function search($com, $offset=0, $limit=10){
   $db=new MysqliWrapper();
   
   $vSql = "SELECT * FROM comision WHERE numero=? LIMIT $limit OFFSET $offset";
   $rs_result = $db->prepared($vSql,[$com]);

   $coms = $rs_result->fetch_all(MYSQLI_ASSOC);
    
   mysqli_free_result($rs_result);
        
   return $coms;
  }
}
?>