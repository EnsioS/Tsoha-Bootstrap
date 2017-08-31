<?php

class Tarjous extends BaseModel {
    
    public $tarjous_id, $tuotteesta, $henkilotiedot, $tuotteen_nimi, $summa, $max_tuotteesta, $kauppa_loppuu;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function findByHenkilotiodot($id) {
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
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO ');
    }
    
}

