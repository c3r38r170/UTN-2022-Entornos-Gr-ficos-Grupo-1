<?php

if (file_exists('utils/db.php' ))
  require_once 'utils/db.php';
        
if (file_exists('../utils/db.php' ))
  require_once '../utils/db.php';



if(isset($_POST['btn_save']))
{      
   insertCom();
}
if(isset($_POST['delete'])){
   delete($_POST['id']);   
}
if(isset($_POST['btn_edit']))
{  
   editCom();
}


function insertCom(){    
    $db=new MysqliWrapper();
    session_start();           
    extract($_REQUEST);

    if(!ctype_alnum($name)){          
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

function selectAll(){    

    $db=new MysqliWrapper();

    $sql = "SELECT * FROM comision";      
    $rs_result = $db->query($sql);    
    $coms = $rs_result->fetch_all(MYSQLI_ASSOC);
    
    mysqli_free_result($rs_result);
        
    return $coms;
}

function delete($id){
   
   $db=new MysqliWrapper();
   
   $vSql = "DELETE FROM comision WHERE id=?";
   $db->prepared($vSql,[$id]);
   
   header('Location: ../comisiones.php');        
}

function editCom(){
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

function searchCom($com){
   $db=new MysqliWrapper();
   
   $vSql = "SELECT * FROM comision WHERE numero=?";
   $rs_result = $db->prepared($vSql,[$com]);

   $coms = $rs_result->fetch_all(MYSQLI_ASSOC);
    
   mysqli_free_result($rs_result);
        
   return $coms;
}

?>