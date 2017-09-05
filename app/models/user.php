<?php

class User extends BaseModel {

    public $id, $henkilotiedot, $username, $password, $meklari;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Asiakastili WHERE asiakastili_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $user = new User(array(
                'id' => $row['asiakastili_id'],
                'henkilotiedot' => $row['henkilotiedot'],
                'username' => $row['kayttajatunnus'],
                'password' => $row['salasana'],
                'meklari' => $row['meklari']
            ));

            return $user;
        } else {
            return null;
        }
    }
    
    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Asiakastili'
                . ' WHERE kayttajatunnus = :username');
        $query->execute(array('username' => $username));
        $rows = $query->fetchAll();

        foreach ($rows as $row) {
            if (password_verify($password, $row['salasana'])) {
                return new User(array(
                    'id' => $row['asiakastili_id'],
                    'henkilotiedot' => $row['henkilotiedot'],
                    'username' => $row['kayttajatunnus'],
                    'password' => $row['salasana'],
                    'meklari' => $row['meklari']
                ));
            }
        }
        
        return null;
    }
}
