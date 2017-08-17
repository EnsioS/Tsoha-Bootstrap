<?php

class User extends BaseModel {
    
    public $id, $username, $password, $meklari;
    
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
                'username' => $row['kayttajatunnus'],
                'password' => $row['salasana'],
                'meklari' => $row['Meklari']
            ));
            
            return $user;
        } else {
            return null;
        }
    }
    
    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Asiakastili'
                .' WHERE kayttajatunnus = :username AND salasana = :password LIMIT 1');
        $query->execute(array('username' => $username, 'password' => $password));
        $row = $query->fetch();
        
        if($row) {
            return new User(array(
                'username' => $row['kayttajatunnus'],
                'password' => $row['salasana'],
                'meklari' => $row['meklari']
            ));
        } else {
            return null;
        }
    }
    
}
