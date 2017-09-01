<?php

class Tuoteluokka extends BaseModel {

    public $tuoteluokka_id, $nimi, $tuotteita, $myynnissa;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi_length', 'validate_nimi_unique');
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT tl.tuoteluokka_id, tl.nimi, COUNT(lt.tuote) AS määrä,'
                . ' COUNT(CASE WHEN t.kauppa_alkaa < NOW() AND t.kauppa_loppuu > NOW() THEN 1 END) AS myynnissä'
                . ' FROM Tuoteluokka AS tl LEFT JOIN Luokan_tuote AS lt ON lt.tuoteluokka = tl.tuoteluokka_id'
                . ' LEFT JOIN Tuote AS t ON t.tuote_id = lt.tuote GROUP BY tl.tuoteluokka_id ORDER BY tl.nimi');
        $query->execute();
        $rows = $query->fetchAll();

        $tuoteluokat = array();

        foreach ($rows as $row) {
            $tuoteluokat[] = new Tuoteluokka(array(
                'tuoteluokka_id' => $row['tuoteluokka_id'],
                'nimi' => $row['nimi'],
                'tuotteita' => $row['määrä'],
                'myynnissa' => $row['myynnissä']
            ));
        }

        return $tuoteluokat;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT tuoteluokka_id, nimi, COUNT(tuote) AS määrä FROM Tuoteluokka '
                . 'LEFT JOIN Luokan_tuote ON tuoteluokka = tuoteluokka_id '
                . 'WHERE tuoteluokka_id = :id GROUP BY tuoteluokka_id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tuoteluokka = new Tuoteluokka(array(
                'tuoteluokka_id' => $row['tuoteluokka_id'],
                'nimi' => $row['nimi'],
                'tuotteita' => $row['määrä']
            ));

            return $tuoteluokka;
        }
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tuoteluokka (nimi) VALUES (:nimi) RETURNING tuoteluokka_id');
        $query->execute(array('nimi' => $this->nimi));
        $row = $query->fetch();
        $this->tuoteluokka_id = $row['tuoteluokka_id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Tuoteluokka SET nimi = :nimi WHERE tuoteluokka_id = :id');
        $query->execute(array('nimi' => $this->nimi, 'id' => $this->tuoteluokka_id));
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Tuoteluokka WHERE tuoteluokka_id = :id');
        $query->execute(array('id' => $this->tuoteluokka_id));
    }

    public function validate_nimi_length() {
        return parent::validate_string_length('Nimi', $this->nimi, 2, 50);
    }

    public function validate_nimi_unique() {
        $query = DB::connection()->prepare('SELECT * FROM Tuoteluokka WHERE nimi = :nimi LIMIT 1');
        $query->execute(array('nimi' => $this->nimi));
        $row = $query->fetch();

        $errors = array();

        if ($row || $this->nimi == 'Kaikki') {
            $errors[] = 'Tämä nimi on jo käytössä';
        }

        return $errors;
    }

}
