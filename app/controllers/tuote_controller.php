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
    
    public static function form($id) {                
        View::make('tuote/add.html', array('id' => $id));
    }
    
    public static function store($id){
        $params = $_POST;
        
        $tuote = new Tuote(array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'kauppa_alkaa' => $params['alkaa'],
            'kauppa_loppuu' => $params['loppuu'],
            'minimihinta' => $params['minimihinta'],
            'linkki_kuvaan' => $params['linkki']
        ));
        
        $tuote->save($id);
        
        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        Redirect::to('/tuoteluokka/'. $id);
    }

}
