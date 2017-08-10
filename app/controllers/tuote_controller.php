<?php

class TuoteController extends BaseController {

    public static function index() {
        $tuotteet = Tuote::findAll();

        View::make('tuote/index.html', array('tuotteet' => $tuotteet));
    }

    public static function show($id) {
        $tuote = Tuote::findOne($id);

        View::make('tuote/show.html', array('tuote' => $tuote));
    }

}
