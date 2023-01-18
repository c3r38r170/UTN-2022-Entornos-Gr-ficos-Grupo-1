<?php


if(!is_uploaded_file($_FILES['file']['tmp_name']))   
    header("Location: ../horarios.php?error=".urlencode(json_encode("Nos has seleccionado ningún archivo!")));
else{

    require_once '../libs/SimpleXLSX.php';
    require_once '../utils/cargaHorarios.php';

    if($excel=Shuchkin\SimpleXLSX::parse($_FILES['file']['tmp_name'],false) ){
        $rows=$excel->rows();
        return uploadFile($rows);
    }	    
    else header("Location: ../horarios.php?error=".urlencode(json_encode("Formato np compatible!")));    
}



