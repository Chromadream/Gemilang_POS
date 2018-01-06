<?php

function selected($id,$cid)
{
    if ($id==$cid) {
        return "selected";
    } else {
        return null;
    }
    
}
?>