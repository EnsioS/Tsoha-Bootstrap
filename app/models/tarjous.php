<?php

class Tarjous extends BaseModel {

    public $tarjous_id, $tuotteesta, $henkilotiedot, $tuotteen_nimi, $summa, $max_tuotteesta, $kauppa_loppuu;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_summa_is_natural_number', 'validate_summa_is_large_enough');
    }

    public static function findAll() {
        $query = DB::connection()->prepare('SELECT tuote_id, tarjous_id, nimi, summa, henkilotiedot, max, kauppa_loppuu FROM Tarjous'
                . ' LEFT JOIN Tuote ON tuote_id = tuote'
                . ' LEFT JOIN '
                . '   (SELECT tuote_id AS t_id, MAX(summa) AS max FROM Tuote '
                . '    LEFT JOIN Tarjous ON tuote = tuote_id GROUP BY tuote_id)'
                . ' AS M_t ON tuote_id = t_id ORDER BY tarjous_id DESC');
        $query->execute();
        $rows = $query->fetchAll();

        $tarjoukset = array();

        foreach ($rows as $row) {
            $tarjoukset[] = new Tarjous(array(
                'tarjous_id' => $row['tarjous_id'],
                'tuotteesta' => $row['tuote_id'],
                'tuotteen_nimi' => $row['nimi'],
                'summa' => $row['summa'],
                'henkilotiedot' => $row['henkilotiedot'],
                'max_tuotteesta' => $row['max'],
                'kauppa_loppuu' => self::timestamp_to_int_format($row['kauppa_loppuu'])
            ));
        }

        return $tarjoukset;
    }

    public static function findByHenkilotiedot($id) {
        $query = DB::connection()->prepare('SELECT tuote_id, nimi, summa, max, kauppa_loppuu FROM Tarjous'
                . ' LEFT JOIN Tuote ON tuote_id = tuote'
                . ' LEFT JOIN '
                . '   (SELECT tuote_id AS t_id, MAX(summa) AS max FROM Tuote '
                . '    LEFT JOIN Tarjous ON tuote = tuote_id GROUP BY tuote_id)'
                . ' AS M_t ON tuote_id = t_id'
                . ' WHERE henkilotiedot = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();

        $tarjoukset = array();

        foreach ($rows as $row) {
            $tarjoukset[] = new Tarjous(array(
//                'tarjous_id' => $row['tarjous_id'],
                'tuotteesta' => $row['tuote_id'],
                'tuotteen_nimi' => $row['nimi'],
                'summa' => $row['summa'],
                'max_tuotteesta' => $row['max'],
                'kauppa_loppuu' => self::timestamp_to_int_format($row['kauppa_loppuu'])
            ));
        }

        return $tarjoukset;
    }
    
    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tarjous WHERE tarjous_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if ($row) {
            $tarjous = new Tarjous(array(
                'tarjous_id' => $id,
                'tuotteesta' => $row['tuote'],
                'henkilotiedot' => $row['henkilotiedot'],
                'summa' => $row['summa']
            ));
            
            return $tarjous;
        }
        
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tarjous (tuote, henkilotiedot, summa) '
                . 'VALUES (:tuote, :henkilotiedot, :summa)');
        $query->execute(array('tuote' => $this->tuotteesta, 'henkilotiedot' => $this->henkilotiedot, 'summa' => $this->summa));
    }

    public function validate_summa_is_natural_number() {
        return parent::validate_natural_number('Summa', $this->summa);
    }

    public function validate_summa_is_large_enough() {
        $errors = array();

        $tuote = Tuote::findOne($this->tuotteesta);

        if ($this->summa > 1 && $this->summa < floor(1.05 * $tuote->max_tarjous + 1)) {
            $errors[] = 'Tarjouksen summan tulee vähintään 5% (' .
                    floor(0.05 * $tuote->max_tarjous + 1) . ' €) olla edellistä tarjousta korkeampi';
        }

        return $errors;
    }

}
