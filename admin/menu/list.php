<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(isset($_POST['add'])){
    $nav_id = 1;
    $name = $_POST['name'];
    $url = $_POST['url'];

    if(empty($name)){
        $errors[] = "You have to give it a name!";
    }
    if(empty($url)){
        $errors[] = "Where are we going? URL, please";
    }

    if(empty($errors)){
        // IT'S EMPTY
        Alert::setAlert('success', array("The link is added!"));
        $Navigation->addNav($nav_id, $name, $url);
        header("location:/admin/menu/list.php");
        exit();
    }else{
        // IT'S NOT EMPTY
        Alert::setAlert('danger', $errors);
    }
}

if(isset($_POST['save'])){
    $array = array();

    $array = $Navigation->convertJSON($_POST['data']);
    $Navigation->updateNav($array);
}


include $_SERVER['DOCUMENT_ROOT'].'/admin/header.php';
?>
<div class="content">
    <div class="header">
        <h1>Menu</h1>
        <div class="clear"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
            <h3>Add Item</h3>
            <form method="post">
                <div class="form-group">
                    <label for="form-name">Name</label>
                    <input id="form-name" class="form-control" name="name" type="text">
                </div>
                <div class="form-group">
                    <label for="form-url">URL</label>
                    <input id="form-url" class="form-control" name="url" type="text">
                </div>
                <div class="form-group">
                    <input type="submit" name="add" class="btn btn-success" value="Add">
                </div>
            </form>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-6">
            <h3>Menu: Main Nav</h3>
            <form method="post">
                <div class="row">
                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            <?php
                            foreach ($Navigation->getNav(1) as $item) {
                                $sub_items=$Navigation->getNav(1, $item->id);
                                echo "<li class=\"dd-item dd3-item\" data-id=\"{$item->id}\">\n";
                                echo "    <div class=\"dd-handle dd3-handle\">Drag</div>\n";
                                echo "    <a href=\"delete/{$item->id}\"><div class=\"dd3-delete\">Drag</div></a>\n";
                                echo "    <div class=\"dd3-content\">\n";
                                echo "        <input name=\"item-name-{$item->id}\" type=\"text\" value=\"{$item->name}\">\n";
                                echo "        <input name=\"item-url-{$item->id}\" type=\"text\" value=\"{$item->url}\">\n";
                                echo "    </div>\n";

                                if(!empty($sub_items)){
                                    echo "    <ol class=\"dd-list\">\n";
                                    foreach ($sub_items as $sub_item) {
                                        echo "        <li class=\"dd-item dd3-item\" data-id=\"{$sub_item->id}\">\n";
                                        echo "            <div class=\"dd-handle dd3-handle\">Drag</div>\n";
                                        echo "            <a href=\"delete/{$sub_item->id}\"><div class=\"dd3-delete\">Drag</div></a>\n";
                                        echo "            <div class=\"dd3-content\">\n";
                                        echo "                <input name=\"item-name-{$sub_item->id}\" type=\"text\" value=\"{$sub_item->name}\">\n";
                                        echo "                <input name=\"item-url-{$sub_item->id}\" type=\"text\" value=\"{$sub_item->url}\">\n";
                                        echo "                </div>\n";
                                        echo "        </li>\n";
                                    }

                                    echo "    </ol>\n";
                                }
                                echo "</li>\n";
                            }
                            ?>
                        </ol>
                    </div>

                </div>
                <div class="row">
                    <textarea style="display:none;" id="nestable-output" name="data"></textarea>
                    <input type="submit" class="btn btn-success" name="save" value="Save">
                </div>
            </form>

        </div>
    </div>
</div>
<script>

var updateOutput = function(e) {
    var list   = e.length ? e : $(e.target),
    output = list.data('output');
    if (window.JSON) {
        output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
    } else {
        output.val('JSON browser support required for this demo.');
    }
};
// activate Nestable for list 1
$('#nestable').nestable({
    group: 1,
    maxDepth: 2
})
.on('change', updateOutput);
updateOutput($('#nestable').data('output', $('#nestable-output')));
</script>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/footer.php';
?>
