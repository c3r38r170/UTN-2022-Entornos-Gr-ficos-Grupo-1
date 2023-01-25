<?php

require_once 'utils/db.php';

class UsuarioDAO{
    static function getUser($leg){
    
        $db=new MysqliWrapper();
        $sql = "SELECT * FROM usuarios where legajo= ? AND `baja`<>1";
        $result = $db->prepared($sql,[$leg]);
        $user = $result->fetch_assoc();
        $result->free();
        
        return $user;
    }
    
    static function getUserByID($id){
    
        $db=new MysqliWrapper();
        $sql = "SELECT * FROM usuarios where id= ? AND `baja`<>1";
        $result = $db->prepared($sql,[$id]);
        $user = $result->fetch_assoc();
        $result->free();
        
        return $user;
    }

    static function search($text, $offset=0, $limit=11){
        $db=new MysqliWrapper();
        $wildcardedText="%$text%";
        $sql = "SELECT * FROM usuarios where (legajo LIKE ? OR nombre_completo LIKE ?) AND `baja`<>1 LIMIT $limit OFFSET $offset";
        $result = $db->prepared($sql,[$wildcardedText,$wildcardedText]);
        $users = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
        
        return $users;
    }

    
    static function selectAll($offset=0,$limit=11){    

        $db=new MysqliWrapper();

        $sql = "SELECT * FROM usuarios WHERE `baja`<>1 LIMIT $limit OFFSET $offset";
        $rs_result = $db->query($sql);    
        $coms = $rs_result->fetch_all(MYSQLI_ASSOC);
        
        mysqli_free_result($rs_result);
            
        return $coms;
    }
}

?>