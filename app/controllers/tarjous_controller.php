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

        View::make('tarjous/add.html', array('id' => $id, 'tuote' => $tuote));
    }

}
