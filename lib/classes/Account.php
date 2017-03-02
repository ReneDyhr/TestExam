<?php
class Account{
    private $DB;
    public function __construct(){
        $this->DB = DB::getInstance();
    }

    public function login($username, $password){
        $getAccount = $this->DB->query("SELECT * FROM ".DB_PREFIX."users WHERE username = ?", array($username))->results()[0];
        $password = Basics::verifyPassword($password, $getAccount->password);
        if($this->DB->count()>0 AND $password){
            $_SESSION['user_id'] = $getAccount->id;
            return true;
        }else{
            return false;
        }
    }

    public function create($username, $password, $surname, $lastname, $address, $email){
        $password = Basics::hashPassword($password);
        $this->DB->query("INSERT INTO ".DB_PREFIX."users (username, password, email, surname, lastname, address)VALUES(?, ?, ?, ?, ?, ?)", array($username, $password, $email, $surname, $lastname, $address));
        return true;
    }

    public function edit(int $user_id, $surname, $lastname, $address, $email){
        $this->DB->query("UPDATE ".DB_PREFIX."users SET surname = ?, lastname = ?, address = ?, email = ? WHERE id = ?", array($surname, $lastname, $address, $email, $user_id));
        return true;
    }


    public function get(int $user_id = 0){
        if($user_id == 0){
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."users")->results();
        }else{
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."users WHERE id = ?", array($user_id))->results()[0];
        }
        return $query;
    }
}
