<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/consultaDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/instanciaDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/usuarioDAO.php'));

session_start();

function searchCon($cons, $offset=0, $limit=10){
    return search($cons, $offset, $limit+1);
 }


 if(isset($_POST['ins'])){ 
    subscribe();
 }

 if(isset($_POST['cancel'])){ 
    unsubscribe();
 }

function unSubscribe(){
    extract($_REQUEST);    
    $legajo = $_SESSION['legajo'];    
    
    $user = getUser($legajo);        
    $instance = getInstance($id);

    deleteSubscription($user['id'],$instance['id']);     

    $success = "Usted ya no se encuentra suscrito a la consulta";
    header("Location: ../consultas.php?success=".urlencode(json_encode($success)));                  
}


function subscribe(){

    extract($_REQUEST);    
    $legajo = $_SESSION['legajo'];    
    
    $user = getUser($legajo);        
    $instance = getInstance($id);

    if(empty($instance)){
        createInstance($id);     
        addSubscriptor($user['id'],$instance['id']);
        ///TO DO: enviar mail al estudiante y al docente

    }                           
    else        
        addSubscriptor($user['id'],$instance['id']); 
        ///TO DO: enviar mail al estudiante
           
    $success = "Inscripcion realizada con exito";
    header("Location: ../consultas.php?success=".urlencode(json_encode($success)));                  
}

function isSubscribed($idConsult){
    
    $instance = getInstance($idConsult);        
    
    $legajo = $_SESSION['legajo'];        
    $user = getUser($legajo);    
    
    $subscription = getSubscription($user['id'],$instance['id']);

    if(empty($subscription))
     return false;
    return true; 
}

?>