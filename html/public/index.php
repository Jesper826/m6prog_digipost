<?php
 
 
$request_url = explode('/',$_SERVER['REQUEST_URI']);

$controllers = ['bericht', 'user', 'userhasbericht', 'berichtenbox'];
foreach($controllers as $i => $page)
{
    if($request_url[1] == $page)
    {
        include_once("../source/controllers/$page.php");
        exit;
    }
}
 
 
http_response_code(404);
exit;