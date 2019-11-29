<?php
if (Request::session()->has('myga'))
    $my_ga = Request::session()->get('myga');
else {
    $my_ga = uniqid();
    Request::session()->put('myga', $my_ga);
}

$gamp = GAMP::setClientId($my_ga)
    ->setDocumentPath(Request::path());
if(isset($_SERVER['REMOTE_ADDR'])) {
    $gamp->setIpOverride($_SERVER['REMOTE_ADDR']);
}
if(isset($_SERVER["HTTP_REFERER"])){
    $gamp->setDocumentReferrer($_SERVER["HTTP_REFERER"]);
}
$gamp->sendPageview();
