<?php

class Tuote extends BaseModel {

    // Attribuutit
    public $tuote_id, $nimi, $kuvaus, $kauppa_alkaa, $kauppa_loppuu, $minimihinta, $linkki_kuvaan;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators =array('validate_nimi', 'validate_kuvaus', 'validate_minimihinta');
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
    
    public static function count() {
        $query = DB::connection()->prepare('SELECT COUNT(tuote_id) as maara FROM Tuote');
        $query->execute();
        $count = $query->fetch();
              
        return $count['maara'];
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
                .  'linkki_kuvaan = :linkki WHERE tuote_id = :id');
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 
            'alkaa' => $this->kauppa_alkaa, 'loppuu' => $this->kauppa_loppuu,
             'minimihinta' => $this->minimihinta, 'linkki' => $this->linkki_kuvaan, 'id' => $this->tuote_id));
        $query->fetch();       
    }
    
    public function validate_nimi() {
        return parent::validate_string_length('Nimi', $this->nimi, 2, 100);
    }
    
    public function validate_kuvaus() {
        return parent::validate_string_length('Kuvaus', $this->kuvaus, 4, 100000);
    }
    
    public function validate_minimihinta() {
        $errors = array();
        
        if (!is_int($this->minimihinta)) {
            $errors[] = 'Minimihinnan tulee olla kokonaisluku';
            
            if ($this->minimihinta < 1) {
                $errors[] = 'Minimihinta ei saa olla nolla tai negatiivinen';
            }
        }
        
        return $errors;
    }

}
