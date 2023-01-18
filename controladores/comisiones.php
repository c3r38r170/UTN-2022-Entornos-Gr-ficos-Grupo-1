<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/comisionDAO.php'));


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

function searchCom($com){
   return search($com);
}

function selectComs(){
   return selectAll();
}

?>