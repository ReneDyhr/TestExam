<?php
include $_SERVER['DOCUMENT_ROOT'].'/config.php';


include $_SERVER['DOCUMENT_ROOT'].'/admin/header.php';
?>
<div class="content">
    <div class="header">
        <h1>Users</h1>
        <div class="clear"></div>
    </div>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($Account->get() as $user) {
                echo "<tr>\n";
                echo "<td>{$user->username}</td>\n";
                echo "<td>{$user->surname} {$user->lastname}</td>\n";
                echo "<td>{$user->email}</td>\n";
                echo "<td>{$user->address}</td>\n";
                echo "</tr>\n";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/footer.php';
?>
