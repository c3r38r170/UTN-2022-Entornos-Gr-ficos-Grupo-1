<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/comisionDAO.php'));


if(isset($_POST['btn_save']))
{      
   ComisionDAO::insertCom();
}
if(isset($_POST['delete'])){
   //delete($_POST['id']);   
   try{
      ComisionDAO::delete($_POST['id']);   
   }catch(Exception $e){      
      echo '<script type="text/javascript">alert("'.$e->getMessage().'");
            window.location.href="../comisiones.php";
            </script>';      
   }
}
if(isset($_POST['btn_edit']))
{  
   ComisionDAO::editCom();
}

function searchCom($com, $offset=0, $limit=10){
   return ComisionDAO::search($com, $offset, $limit+1);
}

function selectComs($offset=0,$limit=10){
   return ComisionDAO::selectAll($offset,$limit+1);
}

?>