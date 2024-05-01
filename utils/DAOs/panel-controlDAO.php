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

    static function getConsultasMaterias(){    

      $db=new MysqliWrapper();
      $sql = "SELECT COUNT(*)as cantidad, m.nombre as nombre FROM materia m INNER JOIN materia_x_comision mc ON m.id = mc.materia_id INNER JOIN consultas c ON mc.id = c.materia_x_comision_id INNER JOIN instancias i ON c.id = i.consulta_id INNER JOIN suscripciones s ON i.id = s.instancia_id  GROUP BY m.nombre"; 
      if($resultado = $db->query($sql)){    
        $materias = $resultado->fetch_all(MYSQLI_ASSOC); 
        mysqli_free_result($resultado);
      }
      else throw new Exception("No es posible mostrar la cantidad de suscripciones a consulta por materias");     
      return $materias;
    }

    static function getConsultasMateriass($year){    

      $db=new MysqliWrapper();
      $sql = "SELECT COUNT(*)as cantidad, m.nombre as nombre FROM materia m INNER JOIN materia_x_comision mc ON m.id = mc.materia_id INNER JOIN consultas c ON mc.id = c.materia_x_comision_id INNER JOIN instancias i ON c.id = i.consulta_id INNER JOIN suscripciones s ON i.id = s.instancia_id  WHERE YEAR(s.fecha_hora) = ? GROUP BY m.nombre"; 
      if ($stmt = $db->prepared($sql, array($year))) {     
        $materias = $stmt->fetch_all(MYSQLI_ASSOC); 
        mysqli_free_result($stmt);
      }
      else throw new Exception("No es posible mostrar la cantidad de suscripciones a consulta por materias");     
      return $materias;
    }


    static function getConsultasComisiones(){    

      $db=new MysqliWrapper();
      $sql = "SELECT COUNT(*) as cantidad, com.numero as numero FROM comision com INNER JOIN materia_x_comision mc ON com.id = mc.materia_id INNER JOIN consultas c ON mc.id = c.materia_x_comision_id INNER JOIN instancias i ON c.id = i.consulta_id INNER JOIN suscripciones s ON i.id = s.instancia_id GROUP BY com.numero"; 
      if($resultado = $db->query($sql)){    
        $materias = $resultado->fetch_all(MYSQLI_ASSOC); 
        mysqli_free_result($resultado);
      }
      else throw new Exception("No es posible mostrar la cantidad de suscripciones a consulta por comisiones");     
      return $materias;
    }

    static function getConsultasComisioness($year){    

      $db=new MysqliWrapper();
      $sql = "SELECT COUNT(*) as cantidad, com.numero as numero FROM comision com INNER JOIN materia_x_comision mc ON com.id = mc.materia_id INNER JOIN consultas c ON mc.id = c.materia_x_comision_id INNER JOIN instancias i ON c.id = i.consulta_id INNER JOIN suscripciones s ON i.id = s.instancia_id WHERE YEAR(s.fecha_hora) = ? GROUP BY com.numero"; 
      if ($stmt = $db->prepared($sql, array($year))) {     
        $materias = $stmt->fetch_all(MYSQLI_ASSOC); 
        mysqli_free_result($stmt);
      }
      else throw new Exception("No es posible mostrar la cantidad de suscripciones a consulta por comisiones");     
      return $materias;
    }

    static function getEstadosConsultas(){    

      $db=new MysqliWrapper();
      $sql = "SELECT COUNT(*) as cantidad, ie.descripcion as descripcion FROM usuarios u INNER JOIN consultas c ON u.id = c.profesor_id inner join instancias i on c.id = i.consulta_id inner join instancias_estados ie on i.estado_id = ie.id group by ie.descripcion"; 
      if($resultado = $db->query($sql)){    
        $materias = $resultado->fetch_all(MYSQLI_ASSOC); 
        mysqli_free_result($resultado);
      }
      else throw new Exception("No es posible mostrar la cantidad de consultas por estado");     
      return $materias;
    }


    static function getConsultasPorMes(){    
      $db = new MysqliWrapper();
      $sql = "SET lc_time_names = 'es_ES';";
      $db->query($sql); // Configurar el idioma para los nombres de los meses en español

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
      return $consultas;
    }

    static function getConsultasPorMess($year){    
      $db = new MysqliWrapper();
      $sql = "SET lc_time_names = 'es_ES';";
      $db->query($sql); // Configurar el idioma para los nombres de los meses en español

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
      return $consultas;
    }
}
?>
