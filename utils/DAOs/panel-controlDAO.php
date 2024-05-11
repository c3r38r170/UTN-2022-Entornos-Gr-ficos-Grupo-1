<?php

require_once(dirname(__DIR__,1) . '/db.php');

class PanelDAO{
   static function countAlumnos(){    
      $db=new MysqliWrapper();
  
      $sql = "SELECT count(*) as total FROM usuarios where tipo_id = 1 and baja = 0"; 
      $rs_result = $db->query($sql);    
      $result = $rs_result->fetch_assoc(); 
      $total = $result['total']; 
      
      mysqli_free_result($rs_result);
          
      return $total; 
    }

    static function countDocentes(){    
      $db=new MysqliWrapper();
  
      $sql = "SELECT count(*) as total FROM usuarios where tipo_id = 2 and baja = 0"; 
      $rs_result = $db->query($sql);    
      $result = $rs_result->fetch_assoc(); 
      $total = $result['total']; 
      
      mysqli_free_result($rs_result);
          
      return $total; 
    }

    static function countConsultasPorAnio($year) {
      global $db;
      $query = "SELECT count(*) as total FROM suscripciones WHERE YEAR(fecha_hora) = ?";
      $result = $db->prepared($query, array($year));
      if ($result !== false) {
          $total = $result->fetch_assoc()['total'];
          $result->close(); 
          return $total;
      } else {
          return 0;
      }
    }

    static function getConsultasMaterias($year = null) {    

      $db = new MysqliWrapper();
      $sql = "SET lc_time_names = 'es_ES';";
      $db->query($sql); //config el idioma para los nombres de los meses en español
  
      if ($year !== null) {
          $sql = "SELECT COUNT(*) as cantidad, m.nombre as nombre 
                  FROM materia m 
                  INNER JOIN materia_x_comision mc ON m.id = mc.materia_id 
                  INNER JOIN consultas c ON mc.id = c.materia_x_comision_id 
                  INNER JOIN instancias i ON c.id = i.consulta_id 
                  INNER JOIN suscripciones s ON i.id = s.instancia_id  
                  WHERE YEAR(s.fecha_hora) = ? 
                  GROUP BY m.nombre";
          if ($stmt = $db->prepared($sql, array($year))) {     
              $materias = $stmt->fetch_all(MYSQLI_ASSOC); 
              mysqli_free_result($stmt);
          } else {
              throw new Exception("No es posible mostrar la cantidad de suscripciones a consulta por materias");     
          }
      } else {
          $sql = "SELECT COUNT(*) as cantidad, m.nombre as nombre 
                  FROM materia m 
                  INNER JOIN materia_x_comision mc ON m.id = mc.materia_id 
                  INNER JOIN consultas c ON mc.id = c.materia_x_comision_id 
                  INNER JOIN instancias i ON c.id = i.consulta_id 
                  INNER JOIN suscripciones s ON i.id = s.instancia_id  
                  GROUP BY m.nombre";
          if ($resultado = $db->query($sql)) {    
              $materias = $resultado->fetch_all(MYSQLI_ASSOC); 
              mysqli_free_result($resultado);
          } else {
              throw new Exception("No es posible mostrar la cantidad de suscripciones a consulta por materias");     
          }
      }
      return $materias;
    }
  
    static function getConsultasComisiones($year = null) {    

      $db = new MysqliWrapper();
      $sql = "SET lc_time_names = 'es_ES';";
      $db->query($sql); 
  
      if ($year !== null) {
          $sql = "SELECT COUNT(*) as cantidad, com.numero as numero 
                  FROM comision com 
                  INNER JOIN materia_x_comision mc ON com.id = mc.materia_id 
                  INNER JOIN consultas c ON mc.id = c.materia_x_comision_id 
                  INNER JOIN instancias i ON c.id = i.consulta_id 
                  INNER JOIN suscripciones s ON i.id = s.instancia_id 
                  WHERE YEAR(s.fecha_hora) = ? 
                  GROUP BY com.numero";
          if ($stmt = $db->prepared($sql, array($year))) {     
              $materias = $stmt->fetch_all(MYSQLI_ASSOC); 
              mysqli_free_result($stmt);
          } else {
              throw new Exception("No es posible mostrar la cantidad de suscripciones a consulta por comisiones");     
          }
      } else {
          $sql = "SELECT COUNT(*) as cantidad, com.numero as numero 
                  FROM comision com 
                  INNER JOIN materia_x_comision mc ON com.id = mc.materia_id 
                  INNER JOIN consultas c ON mc.id = c.materia_x_comision_id 
                  INNER JOIN instancias i ON c.id = i.consulta_id 
                  INNER JOIN suscripciones s ON i.id = s.instancia_id 
                  GROUP BY com.numero";
          if ($resultado = $db->query($sql)) {    
              $materias = $resultado->fetch_all(MYSQLI_ASSOC); 
              mysqli_free_result($resultado);
          } else {
              throw new Exception("No es posible mostrar la cantidad de suscripciones a consulta por comisiones");     
          }
      }
      return $materias;
    }
  
    static function getEstadosConsultas($year = null) {    

      $db = new MysqliWrapper();
      $sql = "SET lc_time_names = 'es_ES';";
      $db->query($sql); 
  
      if ($year !== null) {
          $sql = "SELECT COUNT(*) as cantidad, ie.descripcion as descripcion 
                  FROM usuarios u 
                  INNER JOIN consultas c ON u.id = c.profesor_id 
                  INNER JOIN instancias i ON c.id = i.consulta_id 
                  INNER JOIN instancias_estados ie ON i.estado_id = ie.id 
                  INNER JOIN suscripciones s ON i.id = s.instancia_id
                  WHERE YEAR(s.fecha_hora) = ?
                  GROUP BY ie.descripcion";
          if ($stmt = $db->prepared($sql, array($year))) {     
              $materias = $stmt->fetch_all(MYSQLI_ASSOC); 
              mysqli_free_result($stmt);
          } else {
              throw new Exception("No es posible mostrar la cantidad de consultas por estado");     
          }
      } else {
          $sql = "SELECT COUNT(*) as cantidad, ie.descripcion as descripcion 
                  FROM usuarios u 
                  INNER JOIN consultas c ON u.id = c.profesor_id 
                  INNER JOIN instancias i ON c.id = i.consulta_id 
                  INNER JOIN instancias_estados ie ON i.estado_id = ie.id 
                  INNER JOIN suscripciones s ON i.id = s.instancia_id
                  GROUP BY ie.descripcion";
          if ($resultado = $db->query($sql)) {    
              $materias = $resultado->fetch_all(MYSQLI_ASSOC); 
              mysqli_free_result($resultado);
          } else {
              throw new Exception("No es posible mostrar la cantidad de consultas por estado");     
          }
      }
      return $materias;
    }
  
    static function getConsultasPorMes($year = null) {
      $db = new MysqliWrapper();
      $sql = "SET lc_time_names = 'es_ES';";
      $db->query($sql); 
  
      if ($year !== null) {
          $sql = "SELECT COUNT(*) as cantidad, MONTHNAME(s.fecha_hora) as mes 
                  FROM consultas c 
                  INNER JOIN instancias i ON c.id = i.consulta_id 
                  INNER JOIN suscripciones s ON i.id = s.instancia_id
                  WHERE YEAR(s.fecha_hora) = ?
                  GROUP BY MONTH(s.fecha_hora)";
          if ($stmt = $db->prepared($sql, array($year))) {     
              $consultas = $stmt->fetch_all(MYSQLI_ASSOC); 
              mysqli_free_result($stmt);
          } else {
              throw new Exception("No es posible mostrar la cantidad de consultas por estado");
          }
      } else {
          $sql = "SELECT COUNT(*) as cantidad, MONTHNAME(c.fecha) as mes 
                  FROM consultas c 
                  INNER JOIN instancias i ON c.id = i.consulta_id 
                  INNER JOIN suscripciones s ON i.id = s.instancia_id 
                  GROUP BY MONTH(c.fecha)";
          if ($resultado = $db->query($sql)) {    
              $consultas = $resultado->fetch_all(MYSQLI_ASSOC); 
              mysqli_free_result($resultado);
          } else {
              throw new Exception("No es posible mostrar la cantidad de consultas por estado");
          }
      }
      return $consultas;
    }
  
    static function getBloqueosPorDocentes($year, $docenteSeleccionado = null) {    
      $db = new MysqliWrapper();
      $docenteCondition = '';
      $params = array($year);
  
      if ($docenteSeleccionado !== null) {
          $docenteNames = is_array($docenteSeleccionado) ? "'" . implode("','", $docenteSeleccionado) . "'" : "'" . $docenteSeleccionado . "'";
          $docenteCondition = "AND u.nombre_completo IN ($docenteNames)";
      }
  
      $sql = "SELECT u.nombre_completo as 'profesor', i.motivo as 'motivo bloqueo', i.fecha_consulta as 'fecha consulta', 
              i.fecha as 'fecha bloqueo consulta', concat(ABS(DATEDIFF(i.fecha_consulta, i.fecha)), ' dias') AS 'dias transcurridos entre fechas' 
              FROM usuarios u 
              INNER JOIN usuarios_tipos ut ON u.tipo_id = ut.id 
              INNER JOIN consultas c ON u.id = c.profesor_id 
              INNER JOIN instancias i ON c.id = i.consulta_id 
              WHERE YEAR(i.fecha_consulta) = ? AND ut.id = 2 AND i.motivo IS NOT NULL 
              $docenteCondition 
              ORDER BY u.nombre_completo"; 
  
      if ($stmt = $db->prepared($sql, $params)) {     
          $resultados = $stmt->fetch_all(MYSQLI_ASSOC); 
          mysqli_free_result($stmt);
      } else {
          throw new Exception("No es posible obtener los bloqueos de consulta por docente");
      }
  
      return $resultados;
    }
  
    static function getBloquedasVsConfirmadas($year, $docenteSeleccionado = null) {    
      $db = new MysqliWrapper();
      $docenteCondition = '';
      $params = array($year);
  
      if ($docenteSeleccionado !== null) {
          $docenteNames = is_array($docenteSeleccionado) ? "'" . implode("','", $docenteSeleccionado) . "'" : "'" . $docenteSeleccionado . "'";
          $docenteCondition = "AND u.nombre_completo IN ($docenteNames)";
      }
  
      //tabla temporal
      $sql_temp_table = "CREATE TEMPORARY TABLE cantidad AS 
                          SELECT u.id, COUNT(*) AS cantidadConfirmadas 
                          FROM usuarios u 
                          INNER JOIN usuarios_tipos ut ON u.tipo_id = ut.id 
                          INNER JOIN consultas c ON u.id = c.profesor_id 
                          INNER JOIN instancias i ON c.id = i.consulta_id 
                          WHERE YEAR(i.fecha_consulta) = ? AND ut.id = 2 AND i.estado_id = 2 
                          GROUP BY u.id 
                          ORDER BY u.nombre_completo";
      $db->prepared($sql_temp_table, $params);
  
      //consulta
      $sql = "SELECT u.nombre_completo as 'profesor', can.cantidadConfirmadas as 'cantidad consultas confirmadas', 
              COUNT(*) as 'cantidad consultas bloqueadas', 
              CONCAT(ROUND(COUNT(*) * 100 / can.cantidadConfirmadas,0),' %') as ' porcentaje bloquedas sobre confirmadas' 
              FROM usuarios u 
              INNER JOIN usuarios_tipos ut ON u.tipo_id = ut.id 
              INNER JOIN consultas c ON u.id = c.profesor_id 
              INNER JOIN instancias i ON c.id = i.consulta_id 
              INNER JOIN cantidad can ON u.id = can.id 
              WHERE YEAR(i.fecha_consulta) = ? AND ut.id = 2 AND i.estado_id = 3 
              $docenteCondition 
              GROUP BY u.nombre_completo 
              ORDER BY u.nombre_completo"; 
  
      if ($stmt = $db->prepared($sql, $params)) {     
          $resultados = $stmt->fetch_all(MYSQLI_ASSOC); 
          mysqli_free_result($stmt);
      } else {
          throw new Exception("No es posible mostrar las consultas bloqueadas y confirmadas por docente");
      }
  
      return $resultados;
    }
  
    static function getVirtualesVsPresenciales($year, $docenteSeleccionado = null) {    
      $db = new MysqliWrapper();
      $docenteCondition = '';
      $params = array($year);
  
      if ($docenteSeleccionado !== null) {
          $docenteNames = is_array($docenteSeleccionado) ? "'" . implode("','", $docenteSeleccionado) . "'" : "'" . $docenteSeleccionado . "'";
          $docenteCondition = "AND u.nombre_completo IN ($docenteNames)";
      }
  
      //tabla temporal
      $sql_temp_table = "CREATE TEMPORARY TABLE cantidad 
                          SELECT u.id, COUNT(*) AS cantidadPresencial 
                          FROM usuarios u 
                          INNER JOIN usuarios_tipos ut ON u.tipo_id = ut.id 
                          INNER JOIN consultas c ON u.id = c.profesor_id 
                          INNER JOIN instancias i ON c.id = i.consulta_id 
                          WHERE YEAR(i.fecha_consulta) = ? AND ut.id = 2 AND i.estado_id = 2 AND i.enlace IS NULL 
                          GROUP BY u.id 
                          ORDER BY u.nombre_completo";
      $db->prepared($sql_temp_table, $params);
  
      //consulta
      $sql = "SELECT u.nombre_completo as 'profesor', COUNT(i.enlace) as 'cantidad virtuales', can.cantidadPresencial as 'cantidad presenciales' 
              FROM usuarios u 
              INNER JOIN usuarios_tipos ut ON u.tipo_id = ut.id 
              INNER JOIN consultas c ON u.id = c.profesor_id 
              INNER JOIN instancias i ON c.id = i.consulta_id 
              INNER JOIN cantidad can ON u.id = can.id 
              WHERE YEAR(i.fecha_consulta) = ? AND ut.id = 2 
              $docenteCondition 
              GROUP BY u.nombre_completo 
              ORDER BY u.nombre_completo"; 
  
      if ($stmt = $db->prepared($sql, $params)) {     
          $resultados = $stmt->fetch_all(MYSQLI_ASSOC); 
          mysqli_free_result($stmt);
      } else {
          throw new Exception("No es posible obtener las consultas presenciales y virtuales por profesor");
      }
  
      return $resultados;
    }
  
    static function getCambiosConsultas($year, $docenteSeleccionado = null) {    
      $db = new MysqliWrapper();
      $docenteCondition = '';
      $params = array($year);
  
      if ($docenteSeleccionado !== null) {
          $docenteNames = is_array($docenteSeleccionado) ? "'" . implode("','", $docenteSeleccionado) . "'" : "'" . $docenteSeleccionado . "'";
          $docenteCondition = "AND u.nombre_completo IN ($docenteNames)";
      }
  
      $sql = "SELECT u.nombre_completo AS 'profesor', i.motivo AS 'motivo cambio consulta', c.dia_de_la_semana AS 'dia consulta', 
              CASE DAYOFWEEK(i.fecha_consulta) 
                  WHEN 1 THEN 'Domingo' WHEN 2 THEN 'Lunes' WHEN 3 THEN 'Martes' WHEN 4 THEN 'Miércoles' 
                  WHEN 5 THEN 'Jueves' WHEN 6 THEN 'Viernes' WHEN 7 THEN 'Sábado' 
              END AS 'nuevo dia de consulta', 
              c.hora_desde AS 'fecha inicio consulta', i.hora_nueva AS 'nueva fecha de inicio de consulta', 
              c.aula as 'aula consulta', i.aula_nueva as 'aula nueva', ie.descripcion AS 'estado consulta' 
              FROM usuarios u 
              INNER JOIN usuarios_tipos ut ON u.tipo_id = ut.id 
              INNER JOIN consultas c ON u.id = c.profesor_id 
              INNER JOIN instancias i ON c.id = i.consulta_id 
              INNER JOIN instancias_estados ie ON i.estado_id = ie.id 
              WHERE YEAR(i.fecha_consulta) = ? AND ut.id = 2 AND i.estado_id != 3 AND i.motivo IS NOT NULL $docenteCondition
              AND (c.hora_desde != i.hora_nueva OR c.aula != i.aula_nueva OR 
              c.dia_de_la_semana != CASE WHEN DAYNAME(i.fecha_consulta) = 'Monday' THEN 'Lunes' 
                                         WHEN DAYNAME(i.fecha_consulta) = 'Tuesday' THEN 'Martes' 
                                         WHEN DAYNAME(i.fecha_consulta) = 'Wednesday' THEN 'Miércoles' 
                                         WHEN DAYNAME(i.fecha_consulta) = 'Thursday' THEN 'Jueves' 
                                         WHEN DAYNAME(i.fecha_consulta) = 'Friday' THEN 'Viernes' 
                                         WHEN DAYNAME(i.fecha_consulta) = 'Saturday' THEN 'Sábado' 
                                         WHEN DAYNAME(i.fecha_consulta) = 'Sunday' THEN 'Domingo' 
                                    END) 
              ORDER BY u.nombre_completo, ie.descripcion";
  
      if ($stmt = $db->prepared($sql, $params)) {     
          $cambiosConsultas = $stmt->fetch_all(MYSQLI_ASSOC); 
          mysqli_free_result($stmt);
      } else {
          throw new Exception("No es posible mostrar los cambios de consulta por docente");
      }
  
      return $cambiosConsultas;
    }
  
    static function getAlumnosSuscripciones($year, $alumnoSeleccionado = null) {    
      $db = new MysqliWrapper();
      $alumnoCondition = '';
      $params = array($year);
  
      if ($alumnoSeleccionado !== null) {
          $alumnoNames = is_array($alumnoSeleccionado) ? "'" . implode("','", $alumnoSeleccionado) . "'" : "'" . $alumnoSeleccionado . "'";
          $alumnoCondition = "AND u.nombre_completo IN ($alumnoNames)";
      }
  
      $sql = "SELECT u.nombre_completo AS 'alumno', s.fecha_hora 'fecha inscripcion', m.nombre AS 'materia', com.numero AS 'comision', prof.nombre_completo AS 'profesor' 
              FROM usuarios u 
              INNER JOIN usuarios_tipos ut ON u.tipo_id = ut.id 
              INNER JOIN suscripciones s ON u.id = s.estudiante_id 
              INNER JOIN instancias i ON i.id = s.instancia_id 
              INNER JOIN consultas c ON i.consulta_id = c.id 
              INNER JOIN usuarios prof ON c.profesor_id = prof.id 
              INNER JOIN materia_x_comision mc ON c.materia_x_comision_id = mc.id 
              INNER JOIN materia m ON mc.materia_id = m.id 
              INNER JOIN comision com ON mc.comision_id = com.id 
              WHERE year(s.fecha_hora) = ? $alumnoCondition 
              ORDER BY u.nombre_completo, s.fecha_hora";
  
      if ($stmt = $db->prepared($sql, $params)) {     
          $suscripciones = $stmt->fetch_all(MYSQLI_ASSOC); 
          mysqli_free_result($stmt);
      } else {
          throw new Exception("No es posible mostrar las suscripciones por alumno");     
      }
      
      return $suscripciones;
    }
  
    static function getAlumnosUltimasSuscripciones($year, $alumnoSeleccionado = null) {    
      $db = new MysqliWrapper();
      $alumnoCondition = '';
      $params = array($year);
  
      if ($alumnoSeleccionado !== null) {
          $alumnoNames = is_array($alumnoSeleccionado) ? "'" . implode("','", $alumnoSeleccionado) . "'" : "'" . $alumnoSeleccionado . "'";
          $alumnoCondition = "AND u.nombre_completo IN ($alumnoNames)";
      }
  
      $sql = "SELECT u.nombre_completo AS 'alumno', max(s.fecha_hora) 'ultima fecha inscripcion', m.nombre AS 'materia', com.numero AS 'comision', prof.nombre_completo AS 'profesor' 
              FROM usuarios u 
              INNER JOIN usuarios_tipos ut ON u.tipo_id = ut.id 
              INNER JOIN suscripciones s ON u.id = s.estudiante_id 
              INNER JOIN instancias i ON i.id = s.instancia_id 
              INNER JOIN consultas c ON i.consulta_id = c.id 
              INNER JOIN usuarios prof ON c.profesor_id = prof.id 
              INNER JOIN materia_x_comision mc ON c.materia_x_comision_id = mc.id 
              INNER JOIN materia m ON mc.materia_id = m.id 
              INNER JOIN comision com ON mc.comision_id = com.id 
              WHERE year(s.fecha_hora) = ? $alumnoCondition 
              GROUP BY u.nombre_completo, m.nombre, com.numero, prof.nombre_completo 
              ORDER BY u.nombre_completo, max(s.fecha_hora)";
  
      if ($stmt = $db->prepared($sql, $params)) {     
          $suscripciones = $stmt->fetch_all(MYSQLI_ASSOC); 
          mysqli_free_result($stmt);
      } else {
          throw new Exception("No es posible mostrar las últimas suscripciones por alumno");     
      }
      
      return $suscripciones;
    }

    static function getAllDocentes(){    

      $db=new MysqliWrapper();
      $sql = "SELECT u.nombre_completo 
              FROM usuarios u 
              INNER JOIN usuarios_tipos ut 
              ON u.tipo_id = ut.id 
              WHERE ut.id = 2 AND u.baja = 0"; 
      if($resultado = $db->query($sql)){    
        $docentes = $resultado->fetch_all(MYSQLI_ASSOC); 
        mysqli_free_result($resultado);
      }
      else throw new Exception("No es posible mostrar los docentes activos");     
      return $docentes;
    }

    static function getAllAlumnos(){    

      $db=new MysqliWrapper();
      $sql = "SELECT u.nombre_completo 
              FROM usuarios u 
              INNER JOIN usuarios_tipos ut 
              ON u.tipo_id = ut.id 
              WHERE ut.id = 1 AND u.baja = 0"; 
      if($resultado = $db->query($sql)){    
        $alumnos = $resultado->fetch_all(MYSQLI_ASSOC); 
        mysqli_free_result($resultado);
      }
      else throw new Exception("No es posible mostrar los alumnos activos");     
      return $alumnos;
    }
}
?>
