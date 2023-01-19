<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/comisionDAO.php'));


if(isset($_POST['btn_save']))
{      
   insertCom();
}
if(isset($_POST['delete'])){
   //delete($_POST['id']);   
   try{
      delete($_POST['id']);   
   }catch(Exception $e){      
      echo '<script type="text/javascript">alert("'.$e->getMessage().'");
            window.location.href="../comisiones.php";
            </script>';      
   }
}
if(isset($_POST['btn_edit']))
{  
   editCom();
}

function searchCom($com, $offset=0, $limit=10){
   return search($com, $offset, $limit);
}

function selectComs(){
   return selectAll();
}

?>