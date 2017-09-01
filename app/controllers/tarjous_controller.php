<?php

class TarjousController extends BaseController {

    public static function seurantalista() {
        parent::check_logged_in_as_meklari();

        $tarjoukset = Tarjous::findAll();

        View::make('tarjous/list.html', array('tarjoukset' => $tarjoukset));
    }

    public static function index($id) {
        parent::check_logged_in();

        $user = parent::get_user_logged_in();

        if ($user->henkilotiedot != $id) {
            View::make('user/login.html', array('demand_message' => 'Ei näytetä toisen käyttäjän tarjoussivua'));
        }

        $tarjoukset = Tarjous::findByHenkilotiedot($id);

        View::make('tarjous/index.html', array('tarjoukset' => $tarjoukset));
    }

    public static function show($id) {
        parent::check_logged_in_as_meklari();
        
        $tarjous = Tarjous::findOne($id);
        $tuote = Tuote::findOne($tarjous->tuotteesta);
        $henkilotiedot = Henkilotiedot::findOne($tarjous->henkilotiedot);

        View::make('tarjous/show.html', array('tarjous' => $tarjous, 'tuote' => $tuote, 'henkilotiedot' => $henkilotiedot));
    }

    public static function form($id) {
        $tuote = Tuote::findOne($id);

        $user = self::get_user_logged_in();
        $henkilotiedot = null;
        if ($user != null) {
            $henkilotiedot = Henkilotiedot::findOne($user->henkilotiedot);
        }

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
                View::make('tarjous/add.html', array('errors' => $errors, 'id' => $id, 'tuote' => $tuote, 'henkilotiedot' => $attributes));
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
            $henkilotiedot = Henkilotiedot::findOne($henkilo_id);
            View::make('tarjous/add.html', array('errors' => $errors, 'id' => $id, 'tuote' => $tuote, 'henkilotiedot' => $henkilotiedot, 'summa' => $params['summa']));
        }
    }

}
