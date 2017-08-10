<?php

class Tuoteluokka extends BaseModel {

    public $tuoteluokka_id, $nimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Tuoteluokka');
        $query->execute();
        $rows = $query->fetchAll();

        $tuoteluokat = array();

        foreach ($rows as $row) {
            $tuoteluokat[] = new Tuoteluokka(array(
                'tuoteluokka_id' => $row['tuoteluokka_id'],
                'nimi' => $row['nimi']
            ));
        }

        return $tuoteluokat;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tuoteluokka WHERE tuoteluokka_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tuoteluokka = new Tuoteluokka(array(
                'tuoteluokka_id' => $row['tuoteluokka_id'],
                'nimi' => $row['nimi']
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

}
