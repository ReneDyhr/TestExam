<?php
class Upload {

    private $error = array();
    private $name;
    private $ext;
    private $orgWidth;
    private $orgHeight;
    private $width;
    private $height;
    private $prefix;
    private $suffix;
    private $uploadedFile;
    private $source;
    private $newImage;

    private $KB = 1024;
    private $MB = 1048576;
    private $GB = 1073741824;
    private $TB = 1099511627776;

    function __construct(array $fileToUpload){
        $this->name = pathinfo($fileToUpload['name'], PATHINFO_FILENAME);
        $this->ext = strtolower(pathinfo($fileToUpload['name'], PATHINFO_EXTENSION));
        $this->filesize = $fileToUpload['size'];
        $this->uploadedFile = $fileToUpload['tmp_name'];

        $this->orgWidth = getimagesize($this->uploadedFile)[0];
        $this->orgHeight = getimagesize($this->uploadedFile)[1];
        $this->setWidth($this->orgWidth);
        $this->setHeight($this->orgHeight);

        if(!is_uploaded_file($this->uploadedFile) OR !file_exists($this->uploadedFile) OR $this->filesize==0){
            $this->error[] = _("You have to upload something!");
        }
    }

    public function errors(){
        return $this->error;
    }

    public function AllowedTypes(array $types){
        if(!in_array(mime_content_type($this->uploadedFile), $types)){
            $this->error[] = _("This type of file is not allowed!");
        }
    }

    public function setMaxSize($size, $type){
        if($this->filesize > $size*$this->$type){
            $this->error[] = _("Your file hits the limit!");
        }
    }

    public function setPrefix($prefix){
        $this->prefix = $prefix;
    }

    public function setSuffix($suffix){
        $this->suffix = $suffix;
    }

    public function setWidth($width){
        $this->width = $width;
    }

    public function setHeight($height){
        $this->height = $height;
    }

    public function setPath($path){
        $this->path = $path;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function rotateImage($degrees=90, $filename=""){
        if(empty($filename)){
            $mime = mime_content_type($this->uploadedFile);
        }else{
            $mime = mime_content_type($filename);
        }

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


    public function Move(){
        if(!empty($this->error)){
            return false;
        }
        $filename = $this->prefix . $this->name . $this->suffix . "." .$this->ext;
        if(move_uploaded_file($this->uploadedFile, $this->path.$filename)){
            return true;
        }else{
            return false;
        }
    }

    public function Render(){
        if(!empty($this->error)){
            return false;
        }

        $width = $this->width;
        if($this->height != $this->orgHeight){
            $height = $this->height;
        }else{
            $height = ($this->orgHeight/$this->orgWidth) * $width;
        }


        $this->newImage = imagecreatetruecolor($width, $height);

        switch ($this->ext) {
            case 'png':
            imagealphablending($this->newImage, false);
            imagesavealpha($this->newImage, true);
            $this->source = imagecreatefrompng($this->uploadedFile);
            imagecopyresampled($this->newImage, $this->source,0,0,0,0,$width, $height, $this->orgWidth, $this->orgHeight);
            $filename = $this->path . $this->prefix . $this->name . $this->suffix . "." .$this->ext;
            imagepng($this->newImage,$filename, 9);
            break;
            case 'gif':
                $this->source = imagecreatefromgif($this->uploadedFile);
                imagecopyresampled($this->newImage, $this->source,0,0,0,0,$width, $height, $this->orgWidth, $this->orgHeight);
                $filename = $this->path . $this->prefix . $this->name . $this->suffix . "." .$this->ext;
                imagegif($this->newImage,$filename);
                break;
                case 'jpeg':
                case  'jpg':
                $this->source = imagecreatefromjpeg($this->uploadedFile);
                imagecopyresampled($this->newImage, $this->source,0,0,0,0,$width, $height, $this->orgWidth, $this->orgHeight);
                $filename = $this->path . $this->prefix . $this->name . $this->suffix . "." .$this->ext;
                imagejpeg($this->newImage,$filename,100);

                $exif = exif_read_data($this->uploadedFile);
                switch ($exif['Orientation']){
                    case 3:
                    $this->rotateImage(180, $filename);
                    break;
                    case 6:
                    $this->rotateImage(-90, $filename);
                    break;
                    case 8:
                    $this->rotateImage(90, $filename);
                    break;
                }

                break;
            }
            imagedestroy($this->newImage);
            return $this->prefix . $this->name . $this->suffix . "." .$this->ext;
        }

        public function Clean(){
            imagedestroy($this->source);
        }
    }
