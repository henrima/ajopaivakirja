<?php

$routes->get('/', function() {
    KayttajaController::login();
});

$routes->get('/kayttajat', function() {
    KayttajaController::index();
});

$routes->get('/rekisteroidy', function() {
    KayttajaController::rekisteroidy();
});

$routes->post('/kayttaja', function(){
  	KayttajaController::tallenna();
});

$routes->get('/kayttaja/:username', function($username){
 	KayttajaController::nayta($username);
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

