<?php

require_once(__DIR__ . "/htmlPage.php");

function PageGet($url)
{
    $page = __DIR__ . "/../pages/$url.php";
    if (file_exists($page)) {
        return htmlPage($url, include_once($page));
    } else {
        $page404 = __DIR__ . "../pages/404.php";
        if (file_exists($page404)) return htmlPage('404', include_once($page404));
        else return htmlPage('404', "<h1>404</h1>");
    }
}

echo PageGet(REQUEST_URL);
