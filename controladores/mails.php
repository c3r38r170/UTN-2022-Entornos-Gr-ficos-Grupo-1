<?php

    require_once(dirname(__DIR__,1) . '\utils\db.php');
    require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/consultaDAO.php'));
    require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/subscriptionDAO.php'));

    //para enviar el correo en "sobre nosotros"
    if(isset($_POST["btn_contact"])){

        //TODO crear un mail para que lleguen las consultas del apartado sobre nosotros
        $to = "frangiangiordano@gmail.com";
        $name = $_POST["name"];
        $description = $_POST["description"];
        $mail = $_POST["mail"];
        $subject = "Consulta UTN Frro";

        $sms = $description."\n Atentamente: ".$name."\n Correo Electronico: ".$mail;

        if(mail($to, $subject, $sms)){
            echo "<script>alert('Consulta enviada exitosamente')</script>";
        }
        else{
            echo "<script>alert('Error! La consulta no fue enviada')</script>";
        }
    }

    function notifyTeacher($instance, $neg=" "){   
        
        $to=getTeacherEmail($instance['id']);
        $con= ConsultaDAO::conInfo($instance['consulta_id']);
        
        $subject = "Consulta UTN Frro";
        $message = "Estimado docente, 
                    Le informamos que la consulta programada para la fecha ".$instance['fecha_consulta']. " correspondiente a la materia ".$con['nombre']." de la comisión ".$con['numero']. " ya".$neg."cuenta con alumnos inscriptos. De cambiar esta situación le notificaremos por este mismo medio.
                    
                    Muchas gracias";

        mail($to, $subject, $message);
    }

    function notifySubsStudent($instance,$user){
        $to=$user['legajo'];
        $con= ConsultaDAO::conInfo($instance['consulta_id']);
        $subject = "Consulta UTN Frro";

        $message="Le informamos que usted acaba de suscribirse a la consulta de la materia ".$con['nombre']." de la comisión ".$con['numero']. "programada para la fecha ".$instance['fecha_consulta']. ". Le recordamos que tiene hasta 24hs para dar de baja la suscripción.";

        mail($to, $subject, $message);
    }


    function notifyStudents($idInstance){
        $subs = SubscriptionDAO::selectAllSubscribers($idInstance);
        $to="";
        foreach ($subs as $row){
            $to.= $row["correo"].", ";            
        }
        $subject = "Consulta UTN Frro";
        $message="Le informamos que la consulta de la materia ".$con['nombre']." de la comisión ".$con['numero']. "programada para la fecha ".$instance['fecha_consulta']. "acaba de ser confirmada por el docente";
        
        mail($to, $subject, $message);        
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