<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

/* MySQL settings */
define( 'DB_PREFIX',   'plante__' );
define( 'DB_NAME',     'rend15_wi4_sde_dk' );
define( 'DB_USER',     'rend15.wi4' );
define( 'DB_PASSWORD', 'pz45p253' );
define( 'DB_HOST',     'localhost' );

date_default_timezone_set('Europe/Copenhagen');


spl_autoload_register(function ($class_name) {
    include 'lib/classes/'. $class_name . '.php';
});

$Account = new Account();
$Pages = new Pages();
$Gallery = new Gallery();
$Navigation = new Navigation();

$Products = new Products();

$Cart = new Cart();
$Order = new Order();

$loggedIn = false;
if(isset($_SESSION['user_id'])){
    $user_id=1;
    $loggedIn = true;
    $AccountInfo = $Account->get($user_id);
}

$limit=10;
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$limitT = (($page * $limit) - $limit);
$pagination = $limit;
