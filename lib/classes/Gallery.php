<?php

class Gallery{

    private $DB;
    public function __construct(){
        $this->DB = DB::getInstance();
    }

    /**
    *
    * Add image to database
    *
    * @param int $category_id  contains the id for the category
    * @param string $name  contains the name for the image
    * @param string $path  contains the path/image name for the image.
    * @param string $mime  contains the mime type for the image.
    * @return boolean
    */
    public function add(int $category_id, $name, $path, $mime){
        $this->DB->query("INSERT INTO ".DB_PREFIX."files (category_id, name, `path`, mime_type)VALUES(?, ?, ?, ?)", array($category_id, $name, $path, $mime));
        return true;
    }

    /**
    *
    * Update image to database
    *
    * @param int $image_id  contains the id for the image
    * @param int $category_id  contains the id for the category
    * @param string $name  contains the name for the image
    * @return boolean
    */
    public function update(int $image_id, int $category_id, $name){
        $this->DB->query("UPDATE ".DB_PREFIX."files SET name = ?, category_id = ? WHERE id = ?", array($name, $category_id, $image_id));
        return true;
    }

    /**
    *
    * Delete image from database
    *
    * @param int $image_id  contains the id for the image
    * @return boolean
    */
    public function delete(int $image_id){
        $this->DB->query("DELETE FROM ".DB_PREFIX."files WHERE id = ?", array($image_id));
        return true;
    }

    /**
    *
    * Rotate image from filename
    * Supports JPEG & PNG
    *
    * @param int degrees  contains how many degrees we're rotating, default 90
    * @param string $filename  contains the path to the image
    * @return boolean
    */
    public function rotateImage($degrees=90, $filename){
        $mime = mime_content_type($filename);
        if($mime=='image/jpeg'){
            $source = imagecreatefromjpeg($filename);
            $rotate = imagerotate($source,$degrees,0);
            imagejpeg($rotate, $filename, 100);
            imagedestroy($source);
            imagedestroy($rotate);

        }elseif($mime=='image/png'){
            $source = imagecreatefrompng($filename);
            $rotate = imagerotate($source,$degrees,0);
            imagealphablending($rotate, false);
            imagesavealpha($rotate, true);
            imagepng($rotate, $filename, 9);
            imagedestroy($source);
            imagedestroy($rotate);
        }
    }

    /**
    *
    * Add category to databse
    *
    * @param string $name  contains the name for the category
    * @return boolean
    */
    public function addCategory($name=""){
        $this->DB->query("INSERT INTO ".DB_PREFIX."file_categories (name)VALUES(?)", array($name));
        return true;
    }

    /**
    *
    * Fetch categories
    *
    * @param int $category_id  contains the id for the category, default empty
    * @return object data
    */
    public function getCategories(int $category_id = 0){
        if($category_id==0){
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."file_categories WHERE (status = 0 OR status IS NULL)")->results();
        }else{
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."file_categories WHERE (status = 0 OR status IS NULL) AND id = ?", array($category_id))->results()[0];
        }
        return $query;
    }

    /**
    *
    * Delete category from database
    *
    * @param int $cat_id  contains the id for the category
    * @return boolean
    */
    public function deleteCategory(int $cat_id){
        $dir_pics = $_SERVER['DOCUMENT_ROOT'].'/images/uploads/';
        $this->DB->query("DELETE FROM ".DB_PREFIX."file_categories WHERE id = ?", array($cat_id));

        $images = $this->DB->query("SELECT * FROM ".DB_PREFIX."files WHERE category_id = ?", array($cat_id))->results();
        foreach ($images as $image) {
            unlink($dir_pics."org_".$image->path);
            unlink($dir_pics."thumb_".$image->path);
        }
        return true;
    }

    /**
    *
    * Fetch images by category
    *
    * @param int $category_id  contains the id for the category, default empty
    * @return object data
    */
    public function getImages(int $category_id=0){
        if($category_id==0){
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."files WHERE (status = 0 OR status IS NULL)")->results();
        }else{
            $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."files WHERE (status = 0 OR status IS NULL) AND category_id = ?", array($category_id))->results();
        }
        return $query;
    }

    /**
    *
    * Fetch single image
    *
    * @param int $image_id  contains the id for the image, default 0
    * @return boolean / object data
    */
    public function getImage(int $image_id=0){
        if($image_id==0){return false;}
        $query = $this->DB->query("SELECT * FROM ".DB_PREFIX."files WHERE (status = 0 OR status IS NULL) AND id = ?", array($image_id))->results()[0];
        return $query;
    }
}
