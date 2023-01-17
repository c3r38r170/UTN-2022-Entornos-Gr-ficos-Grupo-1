<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/materiaDAO.php'));


if(!empty($_POST["btn_add"])){

  insertMateria();
}

if(!empty($_POST["btn_delete"])){
  $id = $_POST['id'];
  deleteMateria($id);   
}

if(!empty($_POST["btn_up"])){

  updateMateria();
}

function searchMaterias($nameMateria){
  return search($nameMateria);
}

function getAllMaterias(){
  return getAll();
}


?>




  
