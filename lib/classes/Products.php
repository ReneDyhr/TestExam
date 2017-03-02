<?php
class Products{
    private $DB;
    public function __construct(){
        $this->DB = DB::getInstance();
    }

    public function getLast(){
        return $this->DB->query("SELECT * FROM ".DB_PREFIX."products")->last();
    }
    public function getLastCat(){
        return $this->DB->query("SELECT * FROM ".DB_PREFIX."product_categories")->last();
    }

    public function create(int $id, int $user_id, $slug, $title, int $category, int $inventory, int $minInventory, int $maxInventory, int $image_1, int $image_2, int $image_3, $culturing, int $dirttype, float $price, $description, int $status){
        $this->DB->query("INSERT INTO ".DB_PREFIX."products (id, user_id, slug, name, category_id, inventory, min_inventory, max_inventory, image_1, image_2, image_3, culturing, dirt_id, price, description, status)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
    array($id, $user_id, $slug, $title, $category, $inventory, $minInventory, $maxInventory, $image_1, $image_2, $image_3, $culturing, $dirttype, $price, $description, $status));
    return true;
    }

    public function delete(int $product_id){
        $this->DB->query("UPDATE ".DB_PREFIX."products SET status=2 WHERE id = ?", array($product_id));
        return true;
    }

    public function edit(int $product_id, int $user_id, $slug, $title, int $category, int $inventory, int $minInventory, int $maxInventory, int $image_1, int $image_2, int $image_3, $culturing, int $dirttype, float $price, $description, int $status){
        $this->DB->query("UPDATE ".DB_PREFIX."products SET user_id = ?, slug = ?, name = ?, category_id = ?, inventory = ?, min_inventory = ?, max_inventory = ?, image_1 = ?, image_2 = ?, image_3 = ?, culturing = ?, dirt_id = ?, price = ?, description = ?, status = ? WHERE id = ?",
    array($user_id, $slug, $title, $category, $inventory, $minInventory, $maxInventory, $image_1, $image_2, $image_3, $culturing, $dirttype, $price, $description, $status, $product_id));
    return true;
    }

    public function get($limit="", int $product_id=0, $getAll=false){
        if(!empty($limit)){
            $limit="LIMIT $limit";
        }else{
            $limit="";
        }
        if($product_id==0){
            if(!$getAll){
                $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."products WHERE (status=0 OR status IS NULL) ORDER BY `inventory` DESC, $limit")->results();
            }else{
                $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."products WHERE (status=0 OR status IS NULL)  ORDER BY `inventory` DESC $limit")->results();
            }
        }else{
            if(!$getAll){
                $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."products WHERE id = ? AND (status=0 OR status IS NULL) ORDER BY `inventory` DESC $limit", array($product_id))->results()[0];
            }else{
                $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."products WHERE id = ? ORDER BY `inventory` DESC $limit", array($product_id))->results()[0];
            }
        }
        return $query;
    }

    public function getBySlug($slug){
        $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."products WHERE slug = ?", array($slug))->results()[0];
        return $query;
    }

    public function getByPopular($limit){
        if(!empty($limit)){
            $limit="LIMIT $limit";
        }else{
            $limit="";
        }
        $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."orders GROUP BY product_id ORDER BY qty DESC $limit")->results();
        return $query;
    }

    public function getByCat(int $category_id, $limit=""){
        if(!empty($limit)){
            $limit="LIMIT $limit";
        }else{
            $limit="";
        }
        $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."products WHERE category_id = ? AND (status=0 OR status IS NULL) ORDER BY `inventory` DESC $limit", array($category_id))->results();
        return $query;
    }


    public function addCategory($slug, $name){
        $this->DB->query("INSERT INTO ".DB_PREFIX."product_categories (slug, name)VALUES(?, ?)", array($slug, $name));
        return true;
    }

    public function deleteCat(int $category_id){
        $this->DB->query("DELETE FROM ".DB_PREFIX."product_categories WHERE id = ?", array($category_id));
        return true;
    }

    public function getCategories(int $category_id = 0){
        if($category_id == 0){
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."product_categories WHERE (status=0 OR status IS NULL) ORDER BY `name` DESC")->results();
        }else{
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."product_categories WHERE (status=0 OR status IS NULL) AND id = ? ORDER BY `name` DESC", array($category_id))->results()[0];
        }
        return $query;
    }

    public function getCatBySlug($slug){
        $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."product_categories WHERE (status=0 OR status IS NULL) AND slug = ? ORDER BY `name` DESC", array($slug))->results()[0];
        return $query;
    }

    public function addDirt($name){
        $this->DB->query("INSERT INTO ".DB_PREFIX."dirt_types (name)VALUES(?)", array($name));
        return true;
    }

    public function deleteDirt(int $dirt_id){
        $this->DB->query("DELETE FROM ".DB_PREFIX."dirt_types WHERE id = ?", array($dirt_id));
        return true;
    }

    public function getDirt(int $dirt_id = 0){
        if($dirt_id == 0){
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."dirt_types WHERE (status=0 OR status IS NULL) ORDER BY `name` DESC")->results();
        }else{
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."dirt_types WHERE (status=0 OR status IS NULL) AND id = ?", array($dirt_id))->results()[0];
        }
        return $query;
    }
}
