<?php

function NavGetURL(){
    $REQ_URL = str_replace(dirname($_SERVER['SCRIPT_NAME']), "", $_SERVER['REQUEST_URI']);
    $pos = strpos($REQ_URL, "?");
    if ($pos != false) {
        $REQ_URL = substr($REQ_URL, 0, $pos);
    }
    
    $REQ_URL = rtrim(ltrim($REQ_URL, "/"), "/");
    return $REQ_URL;
}

define('REQUEST_URL', NavGetURL());