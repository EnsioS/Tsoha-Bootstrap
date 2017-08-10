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
