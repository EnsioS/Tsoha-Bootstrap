<?php

class Tuote extends BaseModel {

    // Attribuutit
    public $tuote_id, $nimi, $kuvaus, $kauppa_alkaa, $kauppa_loppuu, $minimihinta, $linkki_kuvaan;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Tuote');
        $query->execute();
        $rows = $query->fetchAll();

        $tuotteet = array();

        foreach ($rows as $row) {
            $tuotteet[] = new Tuote(array(
                'tuote_id' => $row['tuote_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'kauppa_alkaa' => $row['kauppa_alkaa'],
                'kauppa_loppuu' => $row['kauppa_loppuu'],
                'minimihinta' => $row['minimihinta'],
                'linkki_kuvaan' => $row['linkki_kuvaan']
            ));
        }

        return $tuotteet;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tuote WHERE tuote_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tuote = new Tuote(array(
                'tuote_id' => $row['tuote_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'kauppa_alkaa' => $row['kauppa_alkaa'],
                'kauppa_loppuu' => $row['kauppa_loppuu'],
                'minimihinta' => $row['minimihinta'],
                'linkki_kuvaan' => $row['linkki_kuvaan']
            ));

            return $tuote;
        }

        return null;
    }

    public static function findByTuoteluokka($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tuote AS t LEFT JOIN Luokan_tuote as lt'
                . ' ON t.tuote_id = lt.tuote'
                . ' WHERE lt.tuoteluokka = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();

        $tuotteet = array();
      
        foreach ($rows as $row) {
            $tuotteet[] = new Tuote(array(
                'tuote_id' => $row['tuote_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'kauppa_alkaa' => $row['kauppa_alkaa'],
                'kauppa_loppuu' => $row['kauppa_loppuu'],
                'minimihinta' => $row['minimihinta'],
                'linkki_kuvaan' => $row['linkki_kuvaan']
            ));
        }
        
        return $tuotteet;
    }

}
