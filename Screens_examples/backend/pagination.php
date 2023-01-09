<?php


function generateLeftArrow($pn,$fisrt, $search=""){

    $pagLink = "";             

    if($search==""){
        $pagLink .= "<li ". (($pn==1) ? "style='pointer-events:none; opacity:0.3; '" : "") ."><a ".(($pn!=$fisrt) ? "href='usuarios.php?page=".($pn-1)."&first=".($pn-1)."'" : "href='usuarios.php?page=".($pn-1)."'")."'>
        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'><path d='M12.727 3.687a1 1 0 1 0-1.454-1.374l-8.5 9a1 1 0 0 0 0 1.374l8.5 9.001a1 1 0 1 0 1.454-1.373L4.875 12l7.852-8.313Z' fill='#03a9f4'/></svg>
        </a></li>";
    }else{
        $pagLink .= "<li ". (($pn==1) ? "style='pointer-events:none; opacity:0.3; '" : "") ."><a ".(($pn!=$fisrt) ? "href='usuarios.php?search=".$search."&page=".($pn-1)."&first=".($pn-1)."'" : "href='usuarios.php?search=".$search."&page=".($pn-1)."'")."'>
        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'><path d='M12.727 3.687a1 1 0 1 0-1.454-1.374l-8.5 9a1 1 0 0 0 0 1.374l8.5 9.001a1 1 0 1 0 1.454-1.373L4.875 12l7.852-8.313Z' fill='#03a9f4'/></svg>
        </a></li>";
    }

    

    return $pagLink;
}


function generateRightArrow($pn,$index,$showed,$fisrt,$total_pages, $search=""){

    $pagLink = "";
        

    if($search==""){
        $pagLink .= "<li ". (($pn==$total_pages) ? "style='pointer-events:none; opacity:0.3; '" : "") ."><a ".(($pn!=($fisrt+$showed-1)) ? "href='usuarios.php?page=".($pn+1)."'" : "href='usuarios.php?page=".($pn+1)."&first=".($index-1)."'")."'>
        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'><path d='M11.273 3.687a1 1 0 1 1 1.454-1.374l8.5 9a1 1 0 0 1 0 1.374l-8.5 9.001a1 1 0 1 1-1.454-1.373L19.125 12l-7.852-8.313Z' fill='#03a9f4'/></svg>
        </a></li>";
    }else{
        $pagLink .= "<li ". (($pn==$total_pages) ? "style='pointer-events:none; opacity:0.3; '" : "") ."><a ".(($pn!=($fisrt+$showed-1)) ? "href='usuarios.php?search=".$search."&page=".($pn+1)."'" : "href='usuarios.php?search=".$search."&page=".($pn+1)."&first=".($index-1)."'")."'>
        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'><path d='M11.273 3.687a1 1 0 1 1 1.454-1.374l8.5 9a1 1 0 0 1 0 1.374l-8.5 9.001a1 1 0 1 1-1.454-1.373L19.125 12l-7.852-8.313Z' fill='#03a9f4'/></svg>
        </a></li>";
    }
    

    return $pagLink;    
}


function generatePages($pn,$fisrt,$showed,$search=""){

    $pagLink = "";
    
    for ($i=$fisrt; $i<=($fisrt+$showed-1); $i++) {
        if ($i==$pn) {
            if($search==""){
                $pagLink .= "<li class='active'><a style='background-color: #03a9f4;
                color: white;' href='usuarios.php?page=".$i."'>".$i."</a></li>";
            }else{
                $pagLink .= "<li class='active'><a style='background-color: #03a9f4;
                color: white;' href='usuarios.php?search=".$search."&page=".$i."'>".$i."</a></li>";
            }            
        }            
        else  {
            if($search==""){
                $pagLink .= "<li class='active' ><a style='color: black;' href='usuarios.php?page=".$i."'>".$i."</a></li>";  
            }else{
                $pagLink .= "<li class='active' ><a style='color: black;' href='usuarios.php?search=".$search."&page=".$i."'>".$i."</a></li>";  
            }            
        }
      };  
      return $pagLink;
}        
    ?>