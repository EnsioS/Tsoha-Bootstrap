<?php

$routes->get('/', function() {
HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
HelloWorldController::sandbox();
});

//$routes->get('/tuoteluokat', function() {
//HelloWorldController::tuoteluokat();
//});

//$routes->get('/tuoteluokka', function() {
//    HelloWorldController::tuoteluokka();
//});

$routes->get('/tuote', function() {
HelloWorldController::tuote();
});

// Listaa kaikki tuotteet
$routes->get('/tuotteet', function () {
TuoteController::index();
});

// Tuoteen sivu
$routes->get('/tuote/:id', function($id){
TuoteController::show($id);
});

// Tuotteen muokkauslomakkeen esittäminen
$routes->get('/tuote/:id/edit', function($id) {
    TuoteController::edit($id);
});
// Tuotteen muokkaaminen
$routes->post('/tuote/:id/edit', function($id) {
    TuoteController::update($id);
});

// Tuoteluokan lisäys
$routes->post('/tuoteluokat', function() {
    TuoteluokkaController::store();
});

// Sivu jolla listattuna tuoteluokat ja tuoteluokkien lisäysmahdollisuus
$routes->get('/tuoteluokat', function() {
    TuoteluokkaController::index();
});

// Tuoteluokan sivu, listaus tuoteluokkaan kuuluvista tuotteista 
$routes->get('/tuoteluokka/:id', function($id){
    TuoteluokkaController::show($id);
});

// Tuotteen lisääminen tuoteluokkaan
//   Tuotteen lisääminen tuoteluokkaan
$routes->post('/tuoteluokka/:id/lisaa/tuote', function($id){
    TuoteController::store($id);
});      
//   Lisäyssivun näyttäminen
$routes->get('/tuoteluokka/:id/lisaa/tuote', function($id){
    TuoteController::form($id);
});

// Kirjautuminen
//    Kirjautumislomakkeen esittäminen
$routes->get('/login', function(){
    UserController::login();
});

$routes->post('/login', function(){
    UserController::handle_login();
});
