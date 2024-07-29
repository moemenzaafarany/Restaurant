<?php
function HtmlPage($url, $body)
{
    $style = __DIR__ . "/../styles/$url.css";
    $script = __DIR__ . "/../scripts/$url.js";
    $title = str_replace("/", " ", $url);


    if (file_exists($style)) {
        $styleLink = '<link rel="stylesheet" href="styles/' . $url . '.css" />';
    } else $styleLink = '';
    if (file_exists($script)) {
        $scriptSrc = '<script src="scripts/' . $url . '.js" ></script>';
    } else $scriptSrc = '';

    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <base href="" />
            <meta charset="UTF-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
            <title>{$title}</title>
            <link rel="icon" href="./imgs/WhatsApp Image 2022-11-30 at 9.52.27 AM.jpeg">
            {$styleLink}
            {$scriptSrc}
        </head>
        <body>
            {$body}
        </body>
    </html>
    HTML;
}
