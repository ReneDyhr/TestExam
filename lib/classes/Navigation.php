<?php
class Navigation{

    private $DB;
    public function __construct(){
        $this->DB = DB::getInstance();
    }


    /**
    *
    * Update Navigation
    *
    * @param array $items  contains an array with all navigation data
    * @return boolean
    */
    public function updateNav($items){
        $nav_id = 1;
        $cnt = 0;
        foreach ($items as $item) {
            $cnt++;
            $this->DB->query("UPDATE ".DB_PREFIX."navigation_items SET nav_id = ?, name = ?, url = ?, position = ?, parent_id = ? WHERE id = ?", array($nav_id, $item->name, $item->url, $cnt, $item->parent_id, $item->id));
        }
        return true;
    }


    /**
    *
    * Converts JSON to Array
    *
    * @param json $data  contains json data
    * @return array
    */
    public function convertJSON($data){
        $data = json_decode($_POST['data']);
        foreach ($data as $depth_1) {
            $depth_1->name = $_POST['item-name-'.$depth_1->id];
            $depth_1->url = $_POST['item-url-'.$depth_1->id];
            $array[] = $depth_1;
            if($depth_1->children!=null){
                foreach ($depth_1->children as $depth_2) {
                    $depth_2->parent_id = $depth_1->id;
                    $depth_2->name = $_POST['item-name-'.$depth_2->id];
                    $depth_2->url = $_POST['item-url-'.$depth_2->id];
                    $array[] = $depth_2;

                    if($depth_2->children!=null){
                        foreach ($depth_2->children as $depth_3) {
                            $depth_3->parent_id = $depth_2->id;
                            $depth_3->name = $_POST['item-name-'.$depth_3->id];
                            $depth_3->url = $_POST['item-url-'.$depth_3->id];
                            $array[] = $depth_3;
                        }
                    }
                }
                unset($depth_2->children);
                unset($depth_1->children);
            }
        }
        return $array;
    }


    /**
    *
    * Add navigation item
    *
    * @param string $name  contains name for the item
    * @param string $url  contains the url for the item
    * @return boolean
    */
    public function addNav(int $nav_id, $name, $url){
        $this->DB->query("INSERT INTO ".DB_PREFIX."navigation_items (nav_id, name, url)VALUES(?, ?, ?)", array($nav_id, $name, $url));
        return true;
    }

    /**
    *
    * Get the navigation items
    *
    * @param int $nav_id  contains the id for the choosen navigation
    * @param int $parent_id  contains the id for the parents.
    * @return object data
    */
    public function getNav(int $nav_id, int $parent_id = 0){
        $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."navigation_items WHERE nav_id = ? AND parent_id = ? ORDER BY position ASC", array($nav_id, $parent_id))->results();
        return $query;
    }

    /**
    *
    * Get single navigation item
    *
    * @param int $item_id  contains the id for the choosen item
    * @return object data
    */
    public function getItem(int $item_id){
        $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."navigation_items WHERE id = ? ORDER BY position ASC", array($item_id))->results()[0];
        return $query;
    }

    /**
    *
    * Delete navigation item
    *
    * @param int $item_id  contains the id for the choosen item
    * @return boolean
    */
    public function deleteItem(int $item_id){
        $this->DB->query("DELETE FROM ".DB_PREFIX."navigation_items WHERE id = ?", array($item_id));
        return true;
    }

}
