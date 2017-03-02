<?php
class Order{
    private $DB;
    public function __construct(){
        $this->DB = DB::getInstance();
    }

    public function place($products, int $user_id){
        $getOrderID = $this->DB->query("SELECT * FROM ".DB_PREFIX."orders GROUP BY order_id")->last()->order_id+1;
        foreach ($products as $product) {
            $this->DB->query("INSERT INTO ".DB_PREFIX."orders (order_id, product_id, user_id, price, qty)VALUES(?, ?, ?, ?, ?)", array($getOrderID, $product['product_id'], $user_id, $product['price'], $product['qty']));
        }
        return true;
    }

    public function clear($session_id){
        $this->DB->query("DELETE FROM ".DB_PREFIX."cart WHERE session_id = ?", array($session_id));
        return true;
    }

    public function claimed(int $order_id){
        $this->DB->query("UPDATE ".DB_PREFIX."orders SET status = 1 WHERE order_id = ?", array($order_id));
        return true;
    }
    public function unclaimed(int $order_id){
        $this->DB->query("UPDATE ".DB_PREFIX."orders SET status = 0 WHERE order_id = ?", array($order_id));
        return true;
    }

    public function get(int $order_id=0){
        if($order_id == 0){
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."orders ORDER BY status ASC")->results();
            $data = array();
            foreach ($query as $order) {
                $data[$order->order_id][$order->product_id] = array("status"=>$order->status,"product_id"=>$order->product_id, "price"=>$order->price, "qty"=>$order->qty, "time"=>$order->time, "user_id"=>$order->user_id);
            }
        }else{
            $data = $this->DB->query("SELECT * FROM ".DB_PREFIX."orders WHERE order_id = ?", array($order_id))->results();
        }
        return $data;
    }

}
