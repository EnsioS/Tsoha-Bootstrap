<?php

class Henkilotiedot extends BaseModel {

    public $henkilo_id, $nimi, $sahkoposti, $osoite;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_sahkoposti', 'validate_osoite');
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Henkilotiedot WHERE henkilo_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $henkilotiedot = new Henkilotiedot(array(
                'henkilo_id' => $row['henkilo_id'],
                'nimi' => $row['nimi'],
                'sahkoposti' => $row['sahkoposti'],
                'osoite' => $row['osoite']
            ));

            return $henkilotiedot;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Henkilotiedot (nimi, sahkoposti, osoite)'
                . ' VALUES (:nimi, :sahkoposti, :osoite) RETURNING henkilo_id');
        $query->execute(array('nimi' => $this->nimi, 'sahkoposti' => $this->sahkoposti, 'osoite' => $this->osoite));
        $id = $query->fetch()['henkilo_id'];

        return $id;
    }

    public function validate_nimi() {
        return parent::validate_string_length('Nimi', $this->nimi, 3, 100);
    }

    public function validate_sahkoposti() {
        return parent::validate_string_length('Sähköposti', $this->sahkoposti, 5, 50);
    }

    public function validate_osoite() {
        return parent::validate_string_length('Kotiosoite', $this->osoite, 10, 150);
    }

}
