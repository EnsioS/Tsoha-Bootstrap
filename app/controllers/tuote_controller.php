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

}
