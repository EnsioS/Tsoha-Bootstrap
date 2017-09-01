<?php

class Tuote extends BaseModel {

    // Attribuutit
    public $tuote_id, $nimi, $kuvaus, $kauppa_alkaa, $kauppa_loppuu, $minimihinta, $max_tarjous, $linkki_kuvaan;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_kuvaus', 'validate_minimihinta', 'validate_kauppa_alkaa',
            'validate_kauppa_loppuu', 'validate_alkaa_before_loppuu', 'validate_alkaa_and_loppuu_after_now');
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT tu.nimi, tu.tuote_id, tu.minimihinta, MAX(ta.summa) AS max, tu.linkki_kuvaan FROM Tuote AS tu '
                . 'LEFT JOIN Tarjous AS ta ON ta.tuote = tu.tuote_id GROUP BY tu.tuote_id ORDER BY tu.tuote_id DESC');
        $query->execute();
        $rows = $query->fetchAll();

        $tuotteet = array();

        foreach ($rows as $row) {
            $tuotteet[] = new Tuote(array(
                'tuote_id' => $row['tuote_id'],
                'nimi' => $row['nimi'],
                'minimihinta' => $row['minimihinta'],
                'max_tarjous' => $row['max'],
                'linkki_kuvaan' => $row['linkki_kuvaan']
            ));
        }

        return $tuotteet;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT tuote_id, nimi, kuvaus, kauppa_alkaa, '
                . 'kauppa_loppuu, minimihinta, linkki_kuvaan, MAX(summa) AS max '
                . 'FROM Tuote LEFT JOIN Tarjous ON tuote = tuote_id WHERE tuote_id = :id '
                . 'GROUP BY tuote_id');
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
                'max_tarjous' => $row['max'],
                'linkki_kuvaan' => $row['linkki_kuvaan']
            ));

            return $tuote;
        }

        return null;
    }

    public static function findByTuoteluokka($id) {
        $query = DB::connection()->prepare('SELECT t.tuote_id, t.nimi, t.minimihinta, MAX(ta.summa) AS max,'
                . 't.linkki_kuvaan, t.kauppa_alkaa, t.kauppa_loppuu FROM Tuote AS t LEFT JOIN Luokan_tuote AS lt'
                . ' ON t.tuote_id = lt.tuote LEFT JOIN Tarjous AS ta ON t.tuote_id = ta.tuote '
                . ' WHERE tuoteluokka = :id GROUP BY t.tuote_id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();

        $tuotteet = array();

        foreach ($rows as $row) {
            $tuotteet[] = new Tuote(array(
                'tuote_id' => $row['tuote_id'],
                'nimi' => $row['nimi'],
                'kauppa_alkaa' => $row['kauppa_alkaa'],
                'kauppa_loppuu' => $row['kauppa_loppuu'],
                'minimihinta' => $row['minimihinta'],
                'max_tarjous' => $row['max'],
                'linkki_kuvaan' => $row['linkki_kuvaan']
            ));
        }

        return $tuotteet;
    }

    public static function count() {
        $query = DB::connection()->prepare('SELECT COUNT(tuote_id) as määrä, '
                . 'COUNT(CASE WHEN kauppa_alkaa < NOW() AND kauppa_loppuu > NOW() THEN 1 END) AS myynnissä FROM Tuote');
        $query->execute();

        $count = $query->fetch();

        return array($count['määrä'], $count['myynnissä']);
    }

    public function save($id) {
        $query = DB::connection()->prepare('INSERT INTO Tuote (nimi, kuvaus, kauppa_alkaa, kauppa_loppuu,'
                . ' minimihinta, linkki_kuvaan) VALUES (:nimi, :kuvaus, :alkaa,'
                . ' :loppuu, :minimihinta, :linkki) RETURNING tuote_id');
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus,
            'alkaa' => $this->kauppa_alkaa, 'loppuu' => $this->kauppa_loppuu,
            'minimihinta' => $this->minimihinta, 'linkki' => $this->linkki_kuvaan));
        $row = $query->fetch();
        $this->tuote_id = $row['tuote_id'];

        $query2 = DB::connection()->prepare('INSERT INTO Luokan_tuote (tuote, tuoteluokka)'
                . ' VALUES (:tuote, :tuoteluokka)');
        $query2->execute(array('tuote' => $this->tuote_id, 'tuoteluokka' => $id));
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Tuote SET nimi = :nimi, kuvaus = :kuvaus, '
                . 'kauppa_alkaa = :alkaa, kauppa_loppuu = :loppuu, minimihinta = :minimihinta, '
                . 'linkki_kuvaan = :linkki WHERE tuote_id = :id');
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus,
            'alkaa' => $this->kauppa_alkaa, 'loppuu' => $this->kauppa_loppuu,
            'minimihinta' => $this->minimihinta, 'linkki' => $this->linkki_kuvaan, 'id' => $this->tuote_id));
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Tuote WHERE tuote_id = :id');
        $query->execute(array('id' => $this->tuote_id));
    }

    public function validate_nimi() {
        return parent::validate_string_length('Nimi', $this->nimi, 2, 100);
    }

    public function validate_kuvaus() {
        return parent::validate_string_length('Kuvaus', $this->kuvaus, 4, 1500);
    }

    public function validate_kauppa_alkaa() {
        return parent::validate_timestamp('Kauppa alkaa', $this->kauppa_alkaa);
    }

    public function validate_kauppa_loppuu() {
        return parent::validate_timestamp('Kauppa päättyy', $this->kauppa_loppuu);
    }

    public function validate_alkaa_before_loppuu() {
        $errors = array();

        if (self::timestamp_to_int_format($this->kauppa_alkaa) > self::timestamp_to_int_format($this->kauppa_loppuu)) {
            $errors[] = 'Kaupan tulee alkaa ennen kuin se päättyy';
        }

        return $errors;
    }

    public function validate_alkaa_and_loppuu_after_now() {
        $errors = array();

        $now = time();

        if (self::timestamp_to_int_format($this->kauppa_alkaa) < $now) {
            $errors[] = 'Kaupan alkamisaika ei saa olla menneisyydessä!';
        }

        if (self::timestamp_to_int_format($this->kauppa_loppuu) < $now) {
            $errors[] = 'Kaupan päättymisaika ei saa olla menneisyydessä!';
        }

        return $errors;
    }

    public function validate_minimihinta() {
        return parent::validate_natural_number('Minimihinta', $this->minimihinta);
    }

}
