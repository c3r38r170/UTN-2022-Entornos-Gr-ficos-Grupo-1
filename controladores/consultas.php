<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/consultaDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/instanciaDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/usuarioDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/subscriptionDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/usuario-tipos.php'));

session_start(['read_and_close'=>true]);

// * Uso general

// TODO default limit 11, ver si no afecta en ningun lado
function searchCon($cons, $offset=0, $limit=10){
    if (sessionEsProfesor()){
        $legajo = $_SESSION['legajo'];
        $user = UsuarioDAO::getUser($legajo);
        return ConsultaDAO::search($cons, $offset, $limit+1,$user['id']);
    }
    return ConsultaDAO::search($cons, $offset, $limit+1);
}

 function getInst($idCon){
    return InstanciaDAO::getInstance($idCon);
 }

 function getAll($offset=0, $limit=11){
    return ConsultaDAO::getAll($offset, $limit);
 }
 
// * Estudiante

 function getStudentCon($offset=0, $limit=10){
    $legajo = $_SESSION['legajo'];
    $user = UsuarioDAO::getUser($legajo);

    return InstanciaDAO::studentCon($user['id'],$offset=0, $limit=10); 
 }

 function getSubs($offset=0, $limit=10){
    extract($_REQUEST);    
    return SubscriptionDAO::selectSubscriber($id,$offset=0, $limit=10);
 }

 function unSubscribe(){
    extract($_REQUEST);    
    $legajo = $_SESSION['legajo'];    
    
    $user = UsuarioDAO::getUser($legajo);        
    $instance = InstanciaDAO::getInstance($id);

   
    $subscribers = SubscriptionDAO::getSubscribers($instance['id']);  

    SubscriptionDAO::deleteSubscription($user['id'],$instance['id']); 
        
    if($subscribers[0] == 1){
        InstanciaDAO::deleteInstance($instance['id']);                    
        ///TO DO: enviar mail al docente
    } 

    //Redireccionamos a la pagina anterior, ya se consultas.php o mis_consultas.php
    //strtok permite quitar el parametro search de la URL, de lo contrario no se muestra el mensaje success 
    $success = "Usted ya no se encuentra suscrito a la consulta";
    header('Location: ' . strtok($_SERVER['HTTP_REFERER'], '?')."?success=".urlencode(json_encode($success)));               
}

function subscribe(){

    extract($_REQUEST);    
    $legajo = $_SESSION['legajo'];    
    
    $user = UsuarioDAO::getUser($legajo);   

    $instance = InstanciaDAO::getInstance($id);

    if(empty($instance)){

        $instanceID = InstanciaDAO::createInstance($id);   
        
        SubscriptionDAO::addSubscriptor($user['id'],$instanceID);
        ///TO DO: enviar mail al estudiante y al docente

    }
    else if($instance['descripcion'] == 'Bloqueada por profesor'){
        return header("Location: ../consultas.php?error=No se pudo realizar la inscripción porque la consulta se encuentra bloqueada"); 
    }                           
    else if($instance['cupo'] != 0 && SubscriptionDAO::getSubscribers($instance['id'])[0] < $instance['cupo'])       
    SubscriptionDAO::addSubscriptor($user['id'],$instance['id']); 
        ///TO DO: enviar mail al estudiante
    else{
        return header("Location: ../consultas.php?error=La consulta ya no tiene cupos disponibles");          
    }
               
    $success = "Inscripcion realizada con exito";
    header("Location: ../consultas.php?success=".urlencode(json_encode($success)));                  
}

function isSubscribed($idConsult){
    
    $instance = InstanciaDAO::getInstance($idConsult);        
    if(empty($instance))
      return false;

    $legajo = $_SESSION['legajo'];        
    $user = UsuarioDAO::getUser($legajo);    
     
    $subscription = SubscriptionDAO::getSubscription($user['id'],$instance['id']);

    return !empty($subscription); 
}

// * Profesor

 function getTeacherCon($offset=0, $limit=10){
    $legajo = $_SESSION['legajo'];
    $user = UsuarioDAO::getUser($legajo);

    return InstanciaDAO::pendingTeacherCon($user['id'],$offset=0, $limit=10); 
 }

 function teacherConAssigned(){
    $legajo = $_SESSION['legajo'];
    $user = UsuarioDAO::getUser($legajo);
    
    return ConsultaDAO::teacherCon($user['id']);
 }
 

//  * Controlador por redirección 

if(isset($_POST['ins'])){ 
    subscribe();
 }

 if(isset($_POST['cancel'])){ 
    unsubscribe();
 }

 if(isset($_POST['confirm'])){ 
    // TODO ver si es profesor

    extract($_REQUEST);
    // * $confirm es la ID de la instancia; $id, de la consulta

    if(!(int)$confirm){
        // TODO Añadir robustez a cuando viene 0 pero la instancia existe... según la fecha... quizá esto mate el proposito de mandar la id
        $confirm=InstanciaDAO::createInstance($id);
    }

    InstanciaDAO::confirmCon($confirm);
    //TO DO: notificar a los estudiantes inscriptos

    // TODO volver a donde estaba
    header('Location: ../consultas.php'); 
 }

?>