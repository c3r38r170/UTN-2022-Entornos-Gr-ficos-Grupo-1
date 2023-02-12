<?php

require_once(dirname(__DIR__,1) . '\getDate.php');

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
  static function createInstance($id){    
      $db=new MysqliWrapper();
  
      $query = "SELECT dia_de_la_semana FROM consultas WHERE id=?";
      $rs_result = $db->prepared($query,[$id]);
      $day = mysqli_fetch_array($rs_result);
      $rs_result->free();    

    $rs_result=$db->query("SELECT dia_de_la_semana FROM consultas WHERE id=".$consultaId);
    $day=$rs_result->fetch_assoc();
  	$rs_result->free();    

    // TODO cupo y estado_id por default en la base de datos. que el cupo sea algo humano tipo 5-10
    $vSql = "INSERT INTO instancias (fecha_consulta, cupo, estado_id,consulta_id,fecha) VALUES (?,5,1,?)";
    
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
        INNER JOIN suscripciones s ON s.estudiante_id=? AND s.instancia_id=i.id        
    WHERE i.fecha_consulta>=CURDATE()
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

    $string = strtotime($instance['datetime']);
    $date = date('Y/m/d/', $string);
    $time = date('H:i:s A', $string);   
    $state = isset($instance['blocking']) ? 3 : 1; 

    $db=new MysqliWrapper();
    $sql = "UPDATE instancias SET
              motivo = IFNULL(?, motivo), 
              cupo = IFNULL(?, cupo), 
              hora_nueva = IFNULL(?,hora_nueva), 
              fecha_consulta = IFNULL(?,fecha_consulta), 
              aula_nueva = IFNULL(?, aula_nueva),                
              estado_id = IFNULL(?, estado_id)
            WHERE id = ?";
    
    $rs_result = $db->prepared($sql,[$instance['motivo'],$instance['cupo'],$time,$date,$instance['aula'],$state,$instance['idInstance']]);          
  }
}
?>