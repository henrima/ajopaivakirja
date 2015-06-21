<?php

function check_logged_in(){
    BaseController::check_logged_in();
}

$routes->get('/', 'check_logged_in', function() {
    AjotapahtumaController::kuluvakk();
});

// KAYTTAJA :: LOGIN
$routes->get('/login', function() {
    KayttajaController::login();
});

$routes->post('/login', function() {
    KayttajaController::kasittele_login();
});

$routes->get('/logout', function() {
    KayttajaController::logout();
});


// KAYTTAJA :: LISTAUS, REKISTEROITYMINEN, KAYT. SIVU, TALENNa (UUSI)
$routes->get('/kayttajat', 'check_logged_in', function() {
    KayttajaController::index();
});

$routes->get('/rekisteroidy', function() {
    KayttajaController::rekisteroidy();
});

$routes->post('/kayttaja', function(){
  	KayttajaController::tallenna();
});

$routes->get('/kayttaja/:username', 'check_logged_in', function($username){
 	KayttajaController::nayta($username);
});


// KAYTTAJA :: MUOKKAA JA POISTA
$routes->get('/kayttaja/:username/muokkaa', 'check_logged_in', function($username){
	KayttajaController::muokkaa($username);
});

$routes->post('/kayttaja/:username/muokkaa', 'check_logged_in', function($username){
	KayttajaController::paivita($username);
});

$routes->post('/kayttaja/:username/poista', 'check_logged_in', function($username){
	KayttajaController::poista($username);
});


// AJOTAPAHTUMA :: LISTAA, TALLENNA, MUOKKAA
$routes->get('/kuluvakk', 'check_logged_in', function() {
    AjotapahtumaController::kuluvakk();
});

$routes->post('/kuluvakk', 'check_logged_in', function(){
    AjotapahtumaController::tallenna();
});

$routes->get('/ajotapahtuma/:id/muokkaa', 'check_logged_in', function($id){
    AjotapahtumaController::muokkaa($id);
});

$routes->post('/ajotapahtuma/:id/muokkaa', 'check_logged_in', function($id){
    AjotapahtumaController::paivita($id);
});

$routes->post('/ajotapahtuma/:id/poista', 'check_logged_in', function($id){
    AjotapahtumaController::poista($id);
});



// AJONEUVO :: LISTAA, MUOKKAA, POISTA
$routes->get('/ajoneuvot', 'check_logged_in', function() {
    AjoneuvoController::index();
});

$routes->post('/ajoneuvot', 'check_logged_in', function() {
    AjoneuvoController::tallenna();
});

$routes->get('/ajoneuvot/:id/muokkaa', 'check_logged_in', function($id){
    AjoneuvoController::muokkaa($id);
});

$routes->post('/ajoneuvot/:id/muokkaa', 'check_logged_in', function($id){
    AjoneuvoController::paivita($id);
});

$routes->post('/ajoneuvot/:id/poista', 'check_logged_in', function($id){
    AjoneuvoController::poista($id);
});





$routes->get('/raportit', 'check_logged_in', function() {
    HelloWorldController::raportit();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

