<?php

    require_once(dirname(__DIR__,1) . '/utils/db.php');
    require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/consultaDAO.php'));
    require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/subscriptionDAO.php'));
    require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/instanciaDAO.php'));

    //para enviar el correo en "sobre nosotros"
    if(isset($_POST["btn_contact"])){

        $errores = [];

        $nombre=trim($_POST['name']);
        if(!preg_match('/^[a-zA-Z0-9áéíóúñÑ ]+$/u', $nombre))          
	        $errores[]= "El campo Nombre debe ser alfanumerico";            
        
        if(count($errores)){
            header("Location: ../contacto.php?errores=".urlencode(json_encode($errores)));
            exit;
        }

        //TODO crear un mail para que lleguen las consultas del apartado sobre nosotros
        $to = "entornosgraficos2023@gmail.com";
        $name = $_POST["name"];
        $description = $_POST["description"];
        $mail = $_POST["mail"];
        $subject = "Consulta UTN Frro";

        $sms = $description."\n Atentamente: ".$name."\n Correo Electronico: ".$mail;

        if(mail($to, $subject, $sms)){
            echo "<script>alert('Consulta enviada exitosamente');
                   window.location.href='../contacto.php';</script>";
        }
        else{
            echo "<script>alert('Error! La consulta no fue enviada, asegurese que la direccion de correo es correcta');
                   window.location.href='../contacto.php';</script>";
        }
    }

    function notifyTeacher($instanceID, $neg=" "){   
      
        $instance = InstanciaDAO::getById($instanceID);
        
        $to=getTeacherEmail($instance['id']);
        $con= ConsultaDAO::conInfo($instance['consulta_id']);
        $headers = 'From: entornosgraficos2023@gmail.com';
        
        $subject = "Consulta UTN Frro";
        $message = "Estimado docente, 
                    Le informamos que la consulta programada para la fecha ".$instance['fecha_consulta']. " correspondiente a la materia ".$con['nombre']." de la comisión ".$con['numero']. " ya".$neg."cuenta con alumnos inscriptos. De cambiar esta situación le notificaremos por este mismo medio.
                    
                    Muchas gracias";
        
        mail($to, $subject, $message, $headers);
    }

    function notifySubsStudent($instanceID,$user){

         
        $instance = InstanciaDAO::getById($instanceID);
        
        $to=$user['correo'];
        $con= ConsultaDAO::conInfo($instance['consulta_id']);
        $subject = "Consulta UTN Frro";
        $headers = 'From: entornosgraficos2023@gmail.com';

        $message="Le informamos que usted acaba de suscribirse a la consulta de la materia ".$con['nombre']." de la comisión ".$con['numero']. " programada para la fecha ".$instance['fecha_consulta']. ". Le recordamos que tiene hasta 24hs para dar de baja la suscripción.";
                
        mail($to, $subject, $message, $headers);
    }


    function notifyStudents($idInstance, $cupo){
        $subs = SubscriptionDAO::selectAllSubscribers($idInstance);
        $to="";
        foreach ($subs as $row){
            $to.= $row["correo"].", ";
        }
        $subject = "Consulta UTN Frro";
        $headers = 'From: entornosgraficos2023@gmail.com';

        $warning="";
        if(count($subs)>$cupo && $cupo!=0)
            $warning=" Sin embargo, tenga en cuenta que la cantidad actual de estudiantes inscriptos supera al cupo establecido por el docente, por lo que se recomienda cambiar de consulta, en caso de ser posible."; 

        $instance=InstanciaDAO::getById($idInstance);
        $con= ConsultaDAO::conInfo($instance['consulta_id']);
        $message="Le informamos que la consulta de la materia "
            .$con['nombre']
            ." de la comisión "
            .$con['numero']
            . " programada para la fecha "
            .$instance['fecha_consulta']
            . " acaba de ser confirmada por el docente."
            .$warning;
                
        mail($to, $subject, $message, $headers);        
    }

    function getTeacherEmail($idInstance){
        $db=new MysqliWrapper();
        $sql =
		"SELECT
		    u.correo
		FROM instancias i        
			INNER JOIN consultas c ON i.consulta_id = c.id			
			INNER JOIN usuarios u ON u.id=c.profesor_id
		WHERE i.id=?"; 
        $rs_result = $db->prepared($sql,[$idInstance]); 

        $email = $rs_result->fetch_assoc();      
        $rs_result->free();        
        return $email['correo'];
    }

?>