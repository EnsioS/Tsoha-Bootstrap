<?php

class TarjousController extends BaseController {

    public static function index($id) {
        $tarjoukset = Tarjous::findByHenkilotiodot($id);

        View::make('tarjous/index.html', array('tarjoukset' => $tarjoukset));
    }

    public static function form($id) {
        $tuote = Tuote::findOne($id);

        $timestamp_alkaa = tuote::timestamp_to_int_format($tuote->kauppa_alkaa);
        $timestamp_loppuu = tuote::timestamp_to_int_format($tuote->kauppa_loppuu);

        $user = self::get_user_logged_in();
        $henkilotiedot = null;
        if ($user != null) {
            $henkilotiedot = Henkilotiedot::findOne($user->henkilotiedot);
        }       
//        $attributes = array('henkilotiedot' => );

        View::make('tarjous/add.html', array('id' => $id, 'tuote' => $tuote, 'henkilotiedot' => $henkilotiedot));
    }

    public static function store($id) {
        $params = $_POST;
        $tuote = Tuote::findOne($id);
        
        // Lisätään Henkilötiedot tietokantatauluun rivi, jos sitä ei siellä vielä näillä henkilötiedoilla ole,
        // Koska Tarjous tiekantataulussa pakollinen viiteavain henkilötietoihin.
        if ($params['id'] == null || $params['id'] == '') {
            $attributes = array(
                'nimi' => $params['nimi'],
                'sahkoposti' => $params['sahkoposti'],
                'osoite' => $params['osoite']
            );

            $henkilotiedot = new Henkilotiedot($attributes);
            $errors = $henkilotiedot->errors();

            // Ilmoitetaan käyttäjälle, jos lomakkeeseen syötetyt henkilötiedot eivät kelpaa.
            if (count($errors) > 0) {       
                View::make('tarjous/add.html', array('errors' => $errors, 'id' => $id, 'tuote' => $tuote,'henkilotiedot' => $attributes));
            }

            $henkilo_id = $henkilotiedot->save();
        } else {
            $henkilo_id = User::find($params['id'])->henkilotiedot;
        }

        $attributes = array(
            'summa' => $params['summa'],
            'tuotteesta' => $id,
            'henkilotiedot' => $henkilo_id
        );

        $tarjous = new Tarjous($attributes);
        $errors = $tarjous->errors();

        if (count($errors) == 0) {
            $tarjous->save();

            Redirect::to('/tuote/' . $id);
        } else {
            View::make('tarjous/add.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

}
