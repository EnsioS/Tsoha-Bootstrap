<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/tuoteluokat', function() {
    HelloWorldController::tuoteluokat();
});

$routes->get('/tuoteluokka', function() {
    HelloWorldController::tuoteluokka();
});

$routes->get('/tuote', function() {
    HelloWorldController::tuote();
});