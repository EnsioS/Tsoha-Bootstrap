<?php

class Tarjous extends BaseModel {
    
    public $tarjous_id, $tuotteesta, $tuotteen_nimi, $tuotteen_kuva, $summa, $max_tuotteesta;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function findByHenkilotiodot($id) {
        $query = DB::connection()->prepare('SELECT tuote_id, nimi, summa, MAX(summa) AS max FROM Tarjous'
                . ' LEFT JOIN Tuote ON tuote_id = tuote WHERE henkilotiedot = :id GROUP BY tuote_id, summa');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        
        $tarjoukset = array();
        
        foreach ($rows as $row) {
            $tarjoukset[] = new Tarjous(array(
//                'tarjous_id' => $row['tarjous_id'],
                'tuotteesta' => $row['tuote_id'],
                'tuotteen_nimi' => $row['nimi'],
                'summa' => $row['summa'],
                'max_tuotteesta' => $row['max']
            ));
        }
        
        return $tarjoukset;
    }
    
}

