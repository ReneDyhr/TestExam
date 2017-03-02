<?php
class Cart{
    private $DB;
    public function __construct(){
        $this->DB = DB::getInstance();
    }

    public function add($session_id, int $product_id, int $qty){
        for ($i=1; $i <= $qty; $i++) {
            $this->DB->query("INSERT INTO ".DB_PREFIX."cart (session_id, product_id)VALUES(?, ?)", array($session_id, $product_id));
        }
    }

    public function delete($session_id, int $product_id){
        $this->DB->query("DELETE FROM ".DB_PREFIX."cart WHERE session_id = ? AND product_id = ?", array($session_id, $product_id));
        return true;
    }

    public function get($session_id){
        $query = $this->DB->query("SELECT *, count(*) as qty FROM ".DB_PREFIX."cart WHERE session_id = ? GROUP BY product_id", array($session_id))->results();
        return $query;
    }

}
