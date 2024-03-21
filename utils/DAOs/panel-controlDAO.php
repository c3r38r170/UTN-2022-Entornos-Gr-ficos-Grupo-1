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
  
 }
?>
