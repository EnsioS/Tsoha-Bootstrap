<?php

class TuoteluokkaController extends BaseController {

    public static function index() {
        $tuoteluokat = Tuoteluokka::findAll();

        View::make('tuoteluokka/index.html', array('tuoteluokat' => $tuoteluokat));
    }

    public static function show($id) {
        $tuotteet = Tuote::findByTuoteluokka($id);
        $tuoteluokka = Tuoteluokka::findOne($id);

        View::make('tuote/index.html', array('tuotteet' => $tuotteet, 'tuoteluokka' => $tuoteluokka));
    }

    public static function store() {
        $params = $_POST;

        $tuoteluokka = new Tuoteluokka(array(
            'nimi' => $params['nimi']
        ));
        
        $tuoteluokka->save();
        
        Redirect::to('/tuoteluokat', array('message' => 'Tuoteluokka '. $params['nimi'] .' lisätty'));
    }

}
