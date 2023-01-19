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

function searchCom($com, $offset=0, $limit=10){
   return search($com, $offset, $limit+1);
}

function selectComs($offset=0,$limit=10){
   return selectAll($offset,$limit+1);
}

?>