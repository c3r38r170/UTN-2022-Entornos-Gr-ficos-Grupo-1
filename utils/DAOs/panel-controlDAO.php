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

    static function countConsultas2024(){    
      $db=new MysqliWrapper();
  
      $sql = "SELECT count(*) as total FROM suscripciones where year(fecha_hora) = 2024"; 
      $rs_result = $db->query($sql);    
      $result = $rs_result->fetch_assoc(); 
      $total = $result['total']; 
      
      mysqli_free_result($rs_result);
          
      return $total; 
    }

    static function countConsultasPorAnio($year) {
      global $db;
  
      // Preparar la consulta parametrizada
      $query = "SELECT count(*) as total FROM suscripciones WHERE YEAR(fecha_hora) = ?";
      
      // Ejecutar la consulta preparada y pasar el año como dato
      $result = $db->prepared($query, array($year));
  
      // Verificar si se obtuvo un resultado válido
      if ($result !== false) {
          // Obtener el total de la consulta
          $total = $result->fetch_assoc()['total'];
          $result->close(); // Cerrar el resultado
          return $total;
      } else {
          // Manejar el error, por ejemplo, puedes retornar 0 o lanzar una excepción
          return 0;
      }
  }

  static function getConsultasMaterias(){    

    $db=new MysqliWrapper();
    $sql = "SELECT COUNT(*)as cantidad, m.nombre as nombre FROM materia m INNER JOIN materia_x_comision mc ON m.id = mc.materia_id INNER JOIN consultas c ON mc.id = c.materia_x_comision_id INNER JOIN instancias i ON c.id = i.consulta_id INNER JOIN suscripciones s ON i.id = s.instancia_id GROUP BY m.nombre"; 
    if($resultado = $db->query($sql)){    
      $materias = $resultado->fetch_all(MYSQLI_ASSOC); 
      mysqli_free_result($resultado);
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
}
?>
