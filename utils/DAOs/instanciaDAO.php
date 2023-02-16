<?php

require_once(dirname(__DIR__,1) . '\getDate.php');
require_once(dirname(__DIR__,1) . '\db.php');


class InstanciaDAO{
  //Traemos solo aquellas instancias que correspondan a consultas vigentes
  static function getById(int $instanciaID){
    $db=new MysqliWrapper();
      
    $vSql = "SELECT 
                  i.`id`, 
                  i.fecha, 
                  i.motivo, 
                  i.hora_nueva, 
                  i.aula_nueva, 
                  i.cupo,
                  i.fecha_consulta,
                  i.estado_id,
                  i.consulta_id,
                  ie.descripcion AS estado,
                  IFNULL(SUM(sus.instancia_id),0) as suscritos
              FROM instancias i
                INNER JOIN `instancias_estados` ie
                  ON i.estado_id=ie.id
                LEFT JOIN suscripciones sus
                  ON i.id=sus.instancia_id
              WHERE i.id=$instanciaID";

    $rs_result = $db->query($vSql); 
    if($rs_result){
      $cons = $rs_result->fetch_assoc();
      
      $rs_result->free();
        
      return $cons;
    }else return null;
  }

  static function getInstance($consultaId){
    $db=new MysqliWrapper();
      
    // TODO Renombrar ie.descripcion a "estado" en todos lados
    $vSql = "SELECT 
                  i.id, 
                  i.fecha, 
                  i.motivo, 
                  i.hora_nueva, 
                  i.aula_nueva, 
                  i.cupo,
                  i.enlace,
                  i.consulta_id,
                  i.fecha_consulta,
                  i.estado_id,
                  ie.descripcion,
                  ie.descripcion AS estado,
                  IFNULL(SUM(sus.instancia_id),0) as suscritos
              FROM instancias i
                INNER JOIN `instancias_estados` ie
                  ON i.estado_id=ie.id
                LEFT JOIN suscripciones sus
                  ON i.id=sus.instancia_id
              WHERE i.consulta_id=? AND
              i.fecha_consulta>=CURDATE()";

    $rs_result = $db->prepared($vSql,[$consultaId]); 
    if($rs_result){
      $cons = $rs_result->fetch_assoc();
      
      $rs_result->free();
        
      return $cons;
    }else return null;
  }

  //Al momento de crear la instancia, guardamos la fecha en la que se va a llevar a cabo la consulta
  static function createInstance($consultaId){    
    $db=new MysqliWrapper();
  
    $rs_result=$db->query("SELECT dia_de_la_semana FROM consultas WHERE id=".$consultaId);
    $day=$rs_result->fetch_assoc();
  	$rs_result->free();    

    // TODO cupo y estado_id por default en la base de datos. que el cupo sea algo humano tipo 5-10
    $vSql = "INSERT INTO instancias (fecha_consulta, cupo, estado_id,consulta_id,fecha) VALUES (?,5,1,?,?)";
    
    date_default_timezone_set('America/Argentina/Buenos_Aires');    
    $db->prepared($vSql,[getWeekDate($day['dia_de_la_semana']),$consultaId,date('Y-m-d')]);
    return $db->insert_id();
  }

  static function deleteInstance($idInstance){
    $db=new MysqliWrapper();
    $vSql = "DELETE FROM instancias WHERE id=?";
    $db->prepared($vSql,[$idInstance]);
  }

  static function studentCon($id,$offset=0, $limit=10){
    $db=new MysqliWrapper();

    $sql =
    "SELECT
        c.id  
        , u.nombre_completo
        , mat.nombre AS nombre_materia
        , com.numero AS numero_comision
        , c.hora_desde
        , c.hora_hasta
        , c.dia_de_la_semana
        , c.aula
        , c.fecha
			  , c.enlace
    FROM consultas c
        INNER JOIN materia_x_comision mc ON mc.id=c.materia_x_comision_id
        INNER JOIN comision com ON com.id=mc.comision_id
        INNER JOIN materia mat ON mat.id=mc.materia_id
        INNER JOIN usuarios u ON u.id=c.profesor_id
        INNER JOIN instancias i ON i.consulta_id=c.id
        INNER JOIN suscripciones s ON s.estudiante_id=? AND s.instancia_id=i.id        
    WHERE i.fecha_consulta>=CURDATE()
    AND u.`baja`<>1
    LIMIT $limit OFFSET $offset";

    $rs_result = $db->prepared($sql,[$id]);
    $consult = $rs_result->fetch_all(MYSQLI_ASSOC);
	
    $rs_result->free();
      
    return $consult;
  }

  static function pendingTeacherCon($id,$offset=0, $limit=10){
    $db=new MysqliWrapper();

    $sql =
    "SELECT
        c.id  
        , u.nombre_completo
        , mat.nombre
        , com.numero
        , c.hora_desde
        , c.hora_hasta
        , c.dia_de_la_semana
        , c.aula
        , c.fecha
		  	, c.enlace
    FROM consultas c
        INNER JOIN materia_x_comision mc ON mc.id=c.materia_x_comision_id
        INNER JOIN comision com ON com.id=mc.comision_id
        INNER JOIN materia mat ON mat.id=mc.materia_id
        INNER JOIN usuarios u ON u.id=c.profesor_id
        INNER JOIN instancias i ON i.consulta_id=c.id  
    WHERE i.fecha_consulta>=CURDATE() AND c.profesor_id=?
    AND u.`baja`<>1
    LIMIT $limit OFFSET $offset";

    $rs_result = $db->prepared($sql,[$id]);
    $consult = $rs_result->fetch_all(MYSQLI_ASSOC);
	
    $rs_result->free();
      
    return $consult;

  }

  static function confirmCon($idInstance){
    $db=new MysqliWrapper();

    $sql =
    "UPDATE instancias SET estado_id=2 WHERE ID=?";
    $db->prepared($sql,[$idInstance]);
    
  }

  static function updateInstance($instance){
    $db=new MysqliWrapper();
    if(!isset($instance['id'])){      
      return ['Datos inválidos.'];
    }
    try{
        if(!sessionEsProfesor() || ConsultaDAO::getById($instance['consultaID'])['profesor_id'] != $_SESSION['id'])
            return ['No tiene permisos para realizar esta acción.'];
    }catch(Exception $e){      
        return ['Datos inválidos.'];
        die;
    }

    
    $fechaConsulta=substr($instance['fecha-hora'],0,10);
    $hora=substr($instance['fecha-hora'],11,15);
    // TODO default in DB.
    $state = isset($instance['blocking']) ? 3 : 1;     
    /* Versión alternativa:
    $string = strtotime($instance['datetime']);
    $date = date('Y/m/d/', $string);
    $time = date('H:i:s A', $string);
    */

    // ! Definición de $instanciaID
    if($instanciaID=(int)$instance['id']){      
        try{
            if (InstanciaDAO::getById($instance['id'])['consulta_id'] != $instance['consultaID']){
                return ['Datos inválidos.'];
                die;
            }
        }catch(Exception $e){
            return ['Datos inválidos.'];
            die;
        }
        
        $res=$db->prepared(
            "UPDATE `instancias` SET
                fecha_consulta=IFNULL(?,fecha_consulta)
                ,hora_nueva=IFNULL(?,hora_nueva)
                ,aula_nueva=IFNULL(?, aula_nueva)
                ,enlace=IFNULL(?, enlace)
                ,cupo=IFNULL(?, cupo)
                ,motivo=IFNULL(?, motivo)
                ,estado_id = IFNULL(?, estado_id)
            WHERE id=".$instanciaID
        ,[
            $fechaConsulta
            ,$hora
            ,$instance['aula']
            ,trim($instance['enlace'])?:NULL
            ,$instance['cupo']
            ,trim($instance['motivo'])?:NULL
            ,$state
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
                ,estado_id
                ,consulta_id
            ) VALUES (
                '".date('Y-m-d')."'
                ,?
                ,?
                ,?
                ,?
                ,".((int)$instance['cupo'])."
                ,?
                ,?
                ,?
            )"
            ,[
                $fechaConsulta
                ,$hora
                ,$instance['aula']
                ,trim($instance['enlace'])?:NULL
                ,trim($instance['motivo'])?:NULL
                ,$state
                ,$instance['consultaID']
            ]
        );        
    }
    
    return $res? [] : ['Datos inválidos.'];

  }
}
?>