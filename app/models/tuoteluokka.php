<?php

class Tuoteluokka extends BaseModel {

    public $tuoteluokka_id, $nimi, $tuotteita;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi');
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT tl.tuoteluokka_id, tl.nimi, COUNT(lt.tuote) AS määrä FROM Tuoteluokka AS tl'
                . ' LEFT JOIN Luokan_tuote AS lt ON lt.tuoteluokka = tl.tuoteluokka_id'
                . ' GROUP BY tl.tuoteluokka_id ORDER BY tl.nimi');
        $query->execute();
        $rows = $query->fetchAll();

        $tuoteluokat = array();

        foreach ($rows as $row) {
            $tuoteluokat[] = new Tuoteluokka(array(
                'tuoteluokka_id' => $row['tuoteluokka_id'],
                'nimi' => $row['nimi'], 
                'tuotteita' => $row['määrä']   
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
    
    public function validate_nimi() {
        return parent::validate_string_length('Nimi', $this->nimi, 2, 50);       
    }
    
    

}
