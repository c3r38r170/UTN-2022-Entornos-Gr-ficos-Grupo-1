<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/consultaDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/instanciaDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/usuarioDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/subscriptionDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/usuario-tipos.php'));

session_start(['read_and_close'=>true]);


function searchCon($cons, $offset=0, $limit=10){
    if (sessionEsProfesor()){
        $legajo = $_SESSION['legajo'];
        $user = UsuarioDAO::getUser($legajo);
        return search($cons, $offset, $limit+1,$user['id']);
    }
    return search($cons, $offset, $limit+1);
 }

 function getInst($idCon){
    return getInstance($idCon);
 }

 function getStudentCon($offset=0, $limit=10){
    $legajo = $_SESSION['legajo'];
    $user = UsuarioDAO::getUser($legajo);

    return studentCon($user['id'],$offset=0, $limit=10); 
 }

 function getTeacherCon($offset=0, $limit=10){
    $legajo = $_SESSION['legajo'];
    $user = UsuarioDAO::getUser($legajo);

    return pendingTeacherCon($user['id'],$offset=0, $limit=10); 
 }

 function teacherConAssigned(){
    $legajo = $_SESSION['legajo'];
    $user = UsuarioDAO::getUser($legajo);
    
    return teacherCon($user['id']);
 }

 if(isset($_POST['ins'])){ 
    subscribe();
 }

 if(isset($_POST['cancel'])){ 
    unsubscribe();
 }

 if(isset($_POST['confirm'])){ 
    confirm();
 }

 
 function getSubs($offset=0, $limit=10){
    extract($_REQUEST);    
    return selectSubscriber($id,$offset=0, $limit=10);
 }

 function confirm(){
    extract($_REQUEST);    

    $instance = getInstance($id);
    confirmCon($instance['id']);
    //TO DO: notificar a los estudiantes inscriptos

    header('Location: ../consultas.php');        
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

    //Redireccionamos a la pagina anterior, ya se consultas.php o mis_consultas.php
    //strtok permite quitar el parametro search de la URL, de lo contrario no se muestra el mensaje success 
    $success = "Usted ya no se encuentra suscrito a la consulta";
    header('Location: ' . strtok($_SERVER['HTTP_REFERER'], '?')."?success=".urlencode(json_encode($success)));               
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

    }
    else if($instance['descripcion'] == 'Bloqueada por profesor'){
        return header("Location: ../consultas.php?error=No se pudo realizar la inscripción porque la consulta se encuentra bloqueada"); 
    }                           
    else if($instance['cupo'] != 0 && getSubscribers($instance['id'])[0] < $instance['cupo'])       
        addSubscriptor($user['id'],$instance['id']); 
        ///TO DO: enviar mail al estudiante
    else{
        return header("Location: ../consultas.php?error=La consulta ya no tiene cupos disponibles");          
    }
               
    $success = "Inscripcion realizada con exito";
    header("Location: ../consultas.php?success=".urlencode(json_encode($success)));                  
}

function isSubscribed($idConsult){
    
    $instance = getInstance($idConsult);        
    if(empty($instance))
      return false;

    $legajo = $_SESSION['legajo'];        
    $user = UsuarioDAO::getUser($legajo);    
     
    $subscription = getSubscription($user['id'],$instance['id']);

    return !empty($subscription); 
}

?>