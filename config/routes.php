<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/tuote', function() {
    HelloWorldController::tuote();
});

// Listaa kaikki tuotteet
$routes->get('/tuotteet', function () {
    TuoteController::index();
});

// Tuoteen sivu
$routes->get('/tuote/:id', function($id) {
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
$routes->get('/tuoteluokka/:id', function($id) {
    TuoteluokkaController::show($id);
});

// Tuoteluokan muokkaussivu
$routes->get('/tuoteluokka/:id/edit', function($id) {
    TuoteluokkaController::edit($id);
});
// Tuoteluokan muokkaus
$routes->post('/tuoteluokka/:id/edit', function($id) {
    TuoteluokkaController::update($id);
});

// Tuoteluokan poisto
$routes->post('/tuoteluokka/:id/destroy', function($id) {
    TuoteluokkaController::destroy($id);
});

// Tuotteen lisääminen tuoteluokkaan
//   Tuotteen lisääminen tuoteluokkaan
$routes->post('/tuoteluokka/:id/lisaa/tuote', function($id) {
    TuoteController::store($id);
});
//   Lisäyssivun näyttäminen
$routes->get('/tuoteluokka/:id/lisaa/tuote', function($id) {
    TuoteController::form($id);
});

// Tuotteen poisto
$routes->post('/tuote/:id/destroy', function($id) {
    TuoteController::destroy($id);
});

// Kirjautuminen
//    Kirjautumislomakkeen esittäminen
$routes->get('/login', function() {
    UserController::login();
});
//    Sisään kirjautuminen
$routes->post('/login', function() {
    UserController::handle_login();
});
//    Ulos kirjautuminen
$routes->post('/logout', function() {
    UserController::logout();
});

// Asiakkaan tekemien tarjousten näyttäminen
$routes->get('/:id/tarjoukset', function($id) {
    TarjousController::index($id);
});

// Tarjouksen lisäyslomake
$routes->get('/tuote/:id/tarjous', function($id) {
    TarjousController::form($id);
});
// Tarjoaksen tekeminen
$routes->post('/tuote/:id/tarjous', function($id) {
    TarjousController::store($id);
});

// Seurantalista
$routes->get('/seurantalista', function() {
    TarjousController::seurantalista();
});

// Tarjouksen tarkastelusivu
$routes->get('/tarjous/:id', function($id) {
    TarjousController::show($id);
});
