<?php

// Composer hoitaa luokkien automaattisen lataamisen
//require 'app/models/tuote.php'; 
class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        $tuoteluokat = Tuoteluokka::findAll();
        $tuotteet = Tuote::findAll();

        View::make('suunnitelmat/etusivu.html', array('tuoteluokat' => $tuoteluokat, 'tuotteet' => $tuotteet));
    }

    public static function tuoteluokat() {
        View::make('suunnitelmat/tuoteluokat.html');
    }

    public static function tuoteluokka() {
        View::make('suunnitelmat/tuoteluokka.html');
    }

    public static function tuote() {
        View::make('suunnitelmat/tuote.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
//        $a = new Tuoteluokka(array(
//           'nimi' => null 
//        ));
//        
//        $errors = $a->errors();
//        
//        Kint::dump($errors);

        
        $password = 'Salasana3';
        $password = password_hash($password, 1);
        
        Kint::dump($password);


        $query = DB::connection()->prepare('SELECT * FROM Asiakastili');
//                . ' WHERE kayttajatunnus = :username');
//        $query->execute(array('username' => $username));
        $query->execute();
        $rows = $query->fetchAll();

        
        
        foreach ($rows as $row) {
            Kint::dump($row['salasana']);
            Kint::dump(password_verify('Salasana1',$row['salasana']));
            
//            if (password_verify('salasana1', $row['salasana'])) {
//                new User(array(
//                    'id' => $row['asiakastili_id'],
//                    'henkilotiedot' => $row['henkilotiedot'],
//                    'username' => $row['kayttajatunnus'],
//                    'password' => $row['salasana'],
//                    'meklari' => $row['meklari']
//                ));
//            }
        }
    }

}
