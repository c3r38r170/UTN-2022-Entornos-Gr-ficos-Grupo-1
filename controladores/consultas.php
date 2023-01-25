<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/consultaDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/instanciaDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/usuarioDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/subscriptionDAO.php'));


session_start(['read_and_close'=>true]);

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
    
    $user = UsuarioDAO::getUser($legajo);        
    $instance = getInstance($id);

   
    $subscribers = getSubscribers($instance['id']);  

    deleteSubscription($user['id'],$instance['id']); 
        
    if($subscribers[0] == 1){
        deleteInstance($instance['id']);                    
        ///TO DO: enviar mail al docente
    } 

    $success = "Usted ya no se encuentra suscrito a la consulta";
    header("Location: ../consultas.php?success=".urlencode(json_encode($success)));                  
}


function subscribe(){

    extract($_REQUEST);    
    $legajo = $_SESSION['legajo'];    
    
    $user = UsuarioDAO::getUser($legajo);   
     
    $instance = getInstance($id);

    if(empty($instance)){
        $instanceID = createInstance($id);   
        addSubscriptor($user['id'],$instanceID);
        ///TO DO: enviar mail al estudiante y al docente

    }else addSubscriptor($user['id'],$instance['id']); 
        ///TO DO: enviar mail al estudiante
           
    $success = "Inscripcion realizada con exito";
    header("Location: ../consultas.php?success=".urlencode(json_encode($success)));                  
}

function isSubscribed($idConsult){
    
    $instance = getInstance($idConsult);        
   
    $legajo = $_SESSION['legajo'];        
    $user = UsuarioDAO::getUser($legajo);    

    $subscription = getSubscription($user['id'],$instance['id']);

    return !empty($subscription); 
}

?>