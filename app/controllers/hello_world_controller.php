<?php

// Composer hoitaa luokkien automaattisen lataamisen
//require 'app/models/tuote.php'; 
class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('suunnitelmat/etusivu.html');
    }

    public static function tuoteluokat() {
        View::make('suunnitelmat/tuoteluokat.html');
    }

    public static function tuoteluokka() {
        View::make('suunnitelmat/tuoteluokka.html');
    }

    public static function tuote() {
        View::make('suunnitelmat/tuote.html');
    }
    
    public static function sandbox() {
        // Testaa koodiasi täällä
        $mokki = Tuote::findOne(1);
        $tuotteet = Tuote::findAll();
        $Asunnot = Tuote::findByTuoteluokka(1);
        
        Kint::dump($tuotteet);
        Kint::dump($mokki);
        Kint::dump($Asunnot);
        
    }
}
