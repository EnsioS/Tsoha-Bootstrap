<?php

class TuoteluokkaController extends BaseController {

    public static function index() {
        $tuoteluokat = Tuoteluokka::findAll();
        $tuotteita = Tuote::count();

        View::make('tuoteluokka/index.html', array('tuoteluokat' => $tuoteluokat, 'tuotteita' => $tuotteita));
    }

    public static function show($id) {
        $tuotteet = Tuote::findByTuoteluokka($id);
        $tuoteluokka = Tuoteluokka::findOne($id);

        View::make('tuote/index.html', array('tuotteet' => $tuotteet, 'tuoteluokka' => $tuoteluokka));
    }

    public static function store() {
        $params = $_POST;
        $attributes = array(
            'nimi' => $params['nimi']
        );
        
        $tuoteluokka = new Tuoteluokka($attributes);

        $errors = $tuoteluokka->errors();

        if (count($errors) == 0) {
            $tuoteluokka->save();

            Redirect::to('/tuoteluokat', array('message' => 'Tuoteluokka ' . $params['nimi'] . ' lisätty'));
        } else {
            $tuoteluokat = Tuoteluokka::findAll();
            $tuotteita = Tuote::count();
            View::make('/tuoteluokka/index.html', array('errors' => $errors, 'attributes' => $attributes, 'tuoteluokat' => $tuoteluokat, 'tuotteita' => $tuotteita));
        }

    }

}
