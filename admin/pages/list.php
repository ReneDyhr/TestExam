<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/header.php';

?>
<div class="content">
    <div class="header">
        <h1>Pages</h1>
        <div class="header-btn">
            <a href="create" class="btn btn-success">Create</a>
        </div>
        <div class="clear"></div>
    </div>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th style="width:148px;" class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($Pages->get(0, 0, true) as $page) {
                $author = $Account->get($page->user_id)->surname;
                if($page->status==0){$status="Public";}else{$status="Draft";}
                echo "<tr>\n";
                echo "<td>{$page->title}</td>\n";
                echo "<td>{$author}</td>\n";
                echo "<td>{$status}</td>\n";
                echo "<td class=\"text-right\">\n";
                echo "    <a href=\"/{$page->slug}\" target=\"_blank\" class=\"btn btn-default float-left\"><i class=\"fa fa-eye\"></i></a>\n";
                echo "    <a href=\"edit/{$page->id}\" class=\"btn btn-primary float-left\"><i class=\"fa fa-edit\"></i></a>\n";
                echo "    <a href=\"delete/{$page->id}\" class=\"btn btn-danger float-left\"><i class=\"fa fa-trash\"></i></a>\n";
                echo "</td>\n";
                echo "</tr>\n";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/footer.php';
?>
