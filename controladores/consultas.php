<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/consultaDAO.php'));

function searchCon($cons){
    return search($cons);
 }


?>