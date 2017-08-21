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
        self::check_logged_in_as_meklari();
        View::make('tuote/add.html', array('id' => $id));
    }
    
    public static function store($id){
        self::check_logged_in_as_meklari();
        $params = $_POST;
        $attributes = array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'kauppa_alkaa' => $params['alkaa'],
            'kauppa_loppuu' => $params['loppuu'],
            'minimihinta' => $params['minimihinta'],
            'linkki_kuvaan' => $params['linkki']
        );
        
        $tuote = new Tuote($attributes);
                
        $errors = $tuote->errors();
        
        if (count($errors) == 0) {
            $tuote->save($id);
            
            Redirect::to('/tuoteluokka/'. $id);
        } else {
            View::make('tuote/add.html', array('id' => $id, 'errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function edit($id) {
        self::check_logged_in_as_meklari();
        $tuote = Tuote::findOne($id);
        View::make('tuote/edit.html', array('attributes' => $tuote));
    }
    
    public static function update($id) {
        self::check_logged_in_as_meklari();
        $params = $_POST;
        
        $attributes = array(
            'tuote_id' => $id,
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'kauppa_alkaa' => $params['alkaa'],
            'kauppa_loppuu' => $params['loppuu'],
            'minimihinta' => $params['minimihinta'],
            'linkki_kuvaan' => $params['linkki']
        );
        
        $tuote = new Tuote($attributes);
        $errors = $tuote->errors();
        
        if (count($errors) > 0) {
            View::make('tuote/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $tuote->update();
            
            Redirect::to('/tuote/' . $tuote->tuote_id, array('message' => 'Tuotteen tietoja muokattu onnistuneesti!'));
        }
        
    }
    
    public static function destroy($id) {
        self::check_logged_in_as_meklari();
        $tuote = new Tuote(array('tuote_id' => $id));
        $tuote->destroy();
        
        Redirect::to('/');        
    }

}
