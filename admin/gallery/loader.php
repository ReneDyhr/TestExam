<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

$extra_id = "";
if(isset($_GET['extra_id'])){
    $extra_id = "-".$_GET['extra_id'];
}

if(!isset($_GET['item'])){
    $Categories = $Gallery->getCategories();
    echo "<select class=\"selectCat form-control\">\n";
    foreach ($Categories as $category) {
        echo "<option value=\"{$category->id}{$extra_id}\">{$category->name}</option>\n";
    }
    echo "</select>";

    foreach ($Categories as $keyID => $category) {
        $display="none";
        if($keyID==0){
            $display="block";
        }
        echo "<div id=\"cat-{$category->id}{$extra_id}\" class=\"categories{$extra_id}\" style=\"display:$display;\">\n";



        echo "<div class=\"media-frame mode-grid\">\n";
        echo "    <div class=\"media-frame-content\">\n";
        echo "        <ul tabindex=\"-1\" class=\"attachments ui-sortable ui-sortable-disabled\" id=\"__attachments-view-40\">\n";

        $images = $Gallery->getImages($category->id);
        if(count($images)){$nothing="hidden";}else{$nothing="";}
        foreach ($images as $image) {
            list($width, $height) = getimagesize($_SERVER['DOCUMENT_ROOT'].'/images/uploads/thumb_'.$image->path);
            if($width > $height){
                $class="landscape";
            }else{
                $class="portrait";
            }

            echo "<li tabindex=\"0\" data-id=\"{$image->id}\" onclick=\"selectImage(this)\" class=\"attachment\">\n";
            echo "    <div class=\"attachment-preview $class\">\n";
            echo "        <div class=\"image-thumbnail\">\n";
            echo "            <div class=\"centered\">\n";
            echo "                <img src=\"/images/uploads/thumb_{$image->path}\" draggable=\"false\" alt=\"{$image->name}\" title=\"{$image->name}\">\n";
            echo "            </div>\n";
            echo "        </div>\n";
            echo "    </div>\n";
            echo "</li>\n";
        }

        echo "        </ul>\n";
        echo "        <p class=\"$nothing no-media\">No media files found.</p>\n";
        echo "    </div>\n";
        echo "</div>\n";





        echo "</div>\n";
    }

    echo "<script>
    $('.selectCat').on('change', function() {
        $('.categories{$extra_id}').hide();
        console.log('#cat-' + this.value);
        $('#cat-' + this.value).show();
    })
    </script>";
}else{
    $image = $Gallery->getImage($_GET['item']);
        echo "<div class=\"modal-header\">\n";
        echo "    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>\n";
        echo "    <h4 class=\"modal-title\">{$image->name}</h4>\n";
        echo "</div>\n";
        echo "<form method=\"post\">\n";
        echo "    <div class=\"modal-body\">\n";
        echo "        <div class=\"row\">\n";
        echo "            <div class=\"col-md-12\">\n";
        echo "                <input value=\"0\" style=\"display:none;\" type=\"number\" name=\"degrees\" id=\"form-degrees\">\n";
        echo "                <button type=\"button\" class=\"btn btn-default\" onclick=\"rotate('{$image->id}', 0)\">0</button>";
        echo "                <button type=\"button\" class=\"btn btn-default\" onclick=\"rotate('{$image->id}', 90)\">90</button>";
        echo "                <button type=\"button\" class=\"btn btn-default\" onclick=\"rotate('{$image->id}', 180)\">180</button>";
        echo "                <button type=\"button\" class=\"btn btn-default\" onclick=\"rotate('{$image->id}', -90)\">-90</button>";
        echo "                <div id=\"image\">\n";
        echo "                    <img src=\"getImage.php?image_id={$image->id}&degrees=0\">\n";
        echo "                </div>\n";
        echo "            </div>\n";
        echo "        </div>\n";
        echo "        <div class=\"row\">\n";
        echo "            <div class=\"col-md-12\">\n";
        echo "                <div class=\"form-group\">\n";
        echo "                    <label>Name</label>\n";
        echo "                    <input type=\"text\" class=\"form-control\" name=\"name\" value=\"{$image->name}\">\n";
        echo "                </div>\n";
        echo "                <div class=\"form-group\">\n";
        echo "                    <label>Category</label>\n";
        echo "                    <select name=\"category\" class=\"form-control\">\n";
        foreach ($Gallery->getCategories() as $category) {
            $selected="";
            if($category->id==$image->category_id){$selected="selected";}
            echo "                        <option $selected value=\"{$category->id}\">{$category->name}</option>\n";
        }
        echo "                    </select>\n";
        echo "                </div>\n";
        echo "            </div>\n";
        echo "        </div>\n";
        echo "    </div>\n";
        echo "    <div class=\"modal-footer\">\n";
        echo "        <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n";
        echo "        <button type=\"submit\" name=\"delete\" class=\"btn btn-danger\">Delete</button>\n";
        echo "        <a target=\"_blank\" href=\"/images/uploads/org_{$image->path}\" class=\"btn btn-default\">Open</a>\n";
        echo "        <input type=\"submit\" name=\"save\" class=\"btn btn-primary\" value=\"Save\">\n";
        echo "    </div>\n";
        echo "</form>\n";
}
?>
