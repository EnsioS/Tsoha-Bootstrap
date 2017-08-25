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

    public static function edit($id) {
        self::check_logged_in_as_meklari();
        $tuoteluokka = Tuoteluokka::findOne($id);
        View::make('/tuoteluokka/edit.html', array('attributes' => $tuoteluokka));
    }

    public static function update($id) {
        self::check_logged_in_as_meklari();
        $params = $_POST;

        $attributes = array(
            'tuoteluokka_id' => $id,
            'nimi' => $params['nimi']
        );

        $tuoteluokka = new Tuoteluokka($attributes);
        $errors = $tuoteluokka->errors();

        if (count($errors) > 0) {
            View::make('/tuoteluokka/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $tuoteluokka->update();

            Redirect::to('/tuoteluokat', array('message' => 'Tuoteluokka muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in_as_meklari();
        $tuoteluokka = Tuoteluokka::findOne($id);

        if ($tuoteluokka->tuotteita == 0) {
            $tuoteluokka->destroy();

            Redirect::to('/tuoteluokat', array('message' => 'Tuoteluokka on poistettu onnistuneesti'));
        } else {
            $errors = array('Tuoteluokkaa, jossa on tuotteita, ei voi poistaa');
            
            View::make('/tuoteluokat', array('errors' => $errors));
        }
    }

}
