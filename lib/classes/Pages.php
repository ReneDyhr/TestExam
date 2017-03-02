<?php
class Pages{

    private $DB;
    public function __construct(){
        $this->DB = DB::getInstance();
    }

    public function getLast(){
        return $this->DB->query("SELECT * FROM ".DB_PREFIX."pages")->last();
    }

    public function get(int $limit=0, int $page_id=0, $getAll=false){
        if($limit>0){
            $limit="LIMIT $limit";
        }else{
            $limit="";
        }
        if($page_id==0){
            if(!$getAll){
                $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."pages WHERE (status=0 OR status IS NULL) ORDER BY `date` DESC, $limit")->results();
            }else{
                $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."pages WHERE (status=0 OR status IS NULL)  ORDER BY `date` DESC $limit")->results();
            }
        }else{
            if(!$getAll){
                $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."pages WHERE id = ? AND (status=0 OR status IS NULL) ORDER BY `date` DESC $limit", array($page_id))->results()[0];
            }else{
                $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."pages WHERE id = ? ORDER BY `date` DESC $limit", array($page_id))->results()[0];
            }
        }
        return $query;
    }




    public function create(int $user_id, $slug, $title, $description, int $status=0){
        $this->DB->query("INSERT INTO ".DB_PREFIX."pages
            (user_id,
                slug,
                title,
                content,
                status
            )VALUES(
                ?,
                ?,
                ?,
                ?,
                ?
            )",
            array($user_id,
            $slug,
            $title,
            $description,
            $status
        ));
        return true;
    }

    public function edit(int $page_id, int $user_id, $slug, $title, $description, int $status=0){
        $this->DB->query("UPDATE ".DB_PREFIX."pages SET
            user_id = ?,
            slug = ?,
            title = ?,
            content= ?,
            status= ?
            WHERE id = ?
            ",
            array($user_id,
            $slug,
            $title,
            $description,
            $status,
            $page_id
        ));
        return true;
    }

    public function delete(int $page_id){
		$this->DB->query("UPDATE ".DB_PREFIX."pages SET status=2 WHERE id = ?", array($page_id));
		return true;
	}


    public function getBySlug($slug=""){
		$query = $this->DB->query("SELECT * FROM ".DB_PREFIX."pages WHERE (status=0 OR status IS NULL) AND slug = ?", array($slug))->results()[0];
		return $query;
	}
}
