<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/consultaDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/instanciaDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/usuarioDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/subscriptionDAO.php'));
require_once(realpath(dirname(__FILE__) . '/../utils/usuario-tipos.php'));

session_start(['read_and_close'=>true]);

// * Uso general

// TODO ver si default limit 11 no afecta en ningun lado
function searchCon($consulta, $offset=0, $limit=10+1){
    if (sessionEsProfesor()){
        $legajo = $_SESSION['legajo'];
        $user = UsuarioDAO::getUser($legajo);
        return ConsultaDAO::search($consulta, $offset, $limit,$user['id']);
    }
    return ConsultaDAO::search($consulta, $offset, $limit);
}

 function getInst($idCon){
    return InstanciaDAO::getInstance($idCon);
 }

 function getAll($offset=0, $limit=10+1){
    $parametros=[$offset, $limit];
    if(sessionEsProfesor()){
        // TODO ¿el legajo no está en la session? podríamos considerarlo, ya que es un identificador y se usa a cada rato
        $parametros[]=$_SESSION['id'];
    }
    return ConsultaDAO::getAll(...$parametros);
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
    
    $instance = InstanciaDAO::getInstance($id);

   
    $subscribers = SubscriptionDAO::getSubscribers($instance['id']);  

    SubscriptionDAO::deleteSubscription($_SESSION['id'],$instance['id']); 
        
    // TODO && !editado, si tiene algún dato puesto por el profesor, alugo de los campos NULL como truthy
    if($subscribers[0] == 1){
        InstanciaDAO::deleteInstance($instance['id']);                    
        ///TO DO: enviar mail al docente
    } 

    //Redireccionamos a la pagina anterior, ya se consultas.php o mis_consultas.php
    //strtok permite quitar el parametro search de la URL, de lo contrario no se muestra el mensaje success 
    $success = "Usted ya no se encuentra suscrito a la consulta";
    // TODO urlencode(json_encode ?? verificar
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

if(isset($_POST['edit'])){

    if(!isset($_POST['id'])){
        header('Location: ../consultas.php?errores='.urlencode(json_encode(['Datos inválidos.'])));
        die;
    }
    try{
        if(!sessionEsProfesor() || ConsultaDAO::getById($_POST['consultaID'])['profesor_id'] != $_SESSION['id'])
            header('Location: ../consultas.php?errores='.urlencode(json_encode(['No tiene permisos para realizar esta acción.'])));
    }catch(Exception $e){
        header('Location: ../consultas.php?errores='.urlencode(json_encode(['Datos inválidos.'])));
        die;
    }

    
    $fechaConsulta=substr($_POST['fecha-hora'],0,10);
    $hora=substr($_POST['fecha-hora'],11,15);

    // ! Definición de $instanciaID
    if($instanciaID=(int)$_POST['id']){
        try{
            if (InstanciaDAO::getById($_POST['id'])['consulta_id'] != $_POST['consultaID']){
                // TODO mandar con los parámetros anteriores
                header('Location: ../consultas.php?errores='.urlencode(json_encode(['Datos inválidos.'])));
                die;
            }
        }catch(Exception $e){
            header('Location: ../consultas.php?errores='.urlencode(json_encode(['Datos inválidos.'])));
            die;
        }
        
    // TODO solo actualizar lo cambiado?

        $res=$db->prepared(
            "UPDATE `instancias` SET
                fecha_consulta=?
                ,hora_nueva=?
                ,aula_nueva=?
                ,enlace=?
                ,cupo=?
                ,motivo=?
            WHERE id=".$instanciaID
        ,[
            $fechaConsulta
            ,$hora
            ,$_POST['aula']
            ,trim($_POST['enlace'])?:NULL
            ,$_POST['cupo']
            ,trim($_POST['motivo'])?:NULL
        ]);
    }else{
        $res=$db->prepared(
            "INSERT INTO `instancias` (
                fecha
                ,fecha_consulta
                ,hora_nueva
                ,aula_nueva
                ,enlace
                ,cupo
                ,motivo
            ) VALUES (
                '".date('Y-m-d')."'
                ,?
                ,?
                ,?
                ,?
                ,".((int)$_POST['cupo'])."
                ,?
            )"
            ,[
                $fechaConsulta
                ,$hora
                ,$_POST['aula']
                ,trim($_POST['enlace'])?:NULL
                ,trim($_POST['motivo'])?:NULL
            ]
        );

    }
    
    // TODO DRY
    if($res){
        header('Location: ../consultas.php?success='.urlencode('Datos actualizados.'));
    }else{
        header('Location: ../consultas.php?errores='.urlencode(json_encode(['Datos inválidos.'])));
    }
    die;

}

?>