<?php
require 'vendor/autoload.php';
require 'config.php';

use Pi\Guesbook\App\IndexController;

spl_autoload_register(function ($class) {
  $prefix_app = 'Pi\\Guestbook\\App\\';
  $prefix_db = 'Pi\\Guestbook\\Database\\';
    echo $class.'<br>';
    echo $prefix_app.'<br>';
    echo strlen($prefix_app).'<br>';
    echo strncasecmp($class, $prefix_app, strlen($prefix_app)-1).'<br>';
    $len = strlen($prefix_app);
    if (strncasecmp($class, $prefix_app, $len-1) !== 0) {
        $relative_class = substr($class, strlen($prefix_app)-1);
        echo 'app/'.$relative_class.'.php <br>';
        require_once 'app/'.$relative_class.'.php';
    } elseif (strncmp($class, $prefix_db, strlen($prefix_db)) !== 0) {
        $relative_class = substr($class, strlen($prefix_db)-1);
        require_once 'database/'.$relative_class.'.php';
    } else {
        return '';
    }
});

$init = new IndexController();

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} elseif (isset($_POST['send'])) {
    $init->addMessage($_POST);
    $sort = 'date_desc';
} else {
    $sort = 'date_desc';
}

$init->getBody($sort);
