<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/consultaDAO.php'));

function searchCon($cons, $offset=0, $limit=10){
    return search($cons, $offset, $limit);
 }


?>