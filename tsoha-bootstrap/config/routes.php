<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/rekisteroidy', function() {
    HelloWorldController::rekisteroidy();
});

$routes->get('/kuluvakk', function() {
    HelloWorldController::kuluvakk();
});

$routes->get('/raportit', function() {
    HelloWorldController::raportit();
});

$routes->get('/ajoneuvot', function() {
    HelloWorldController::ajoneuvot();
});


$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});
