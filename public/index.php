<?php
session_start();

/**
* Front controller - responsible for receiving requests from users and directing them to the appropriate actions. 
* It also handles error messages in case of problems during the request processing.
*/
use \App\User;
use \App\Blog;
use \App\Database;

echo "<h3>Hello Venture!</h3>";

// Load Blog nad User classes:
require dirname(__DIR__) . '/App/Blog.php';
require dirname(__DIR__) . '/App/User.php';

$blog = new Blog();
$user = new User();

//Who is logged in?
if(isset($_SESSION['username']) ? $_SESSION['username'] : '')
{
    echo '<p> Logged user: ' . $_SESSION['username'] . '</p>';
}


//Routing: simple routing depending on action
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'login':
        $user->login($_GET['user'], $_GET['password']);
        break;
    case 'new_user':
        $user->createUser($_GET['username'], $_GET['password'], $_GET['permission'], $_GET['readonly']);
        break;
    case 'blog':
        $blog->getAllPosts();
        break;
    case 'new':
        if (isset($_SESSION['logged_id'])) {
            $blog->createPost($_GET['text'], $_SESSION['logged_id']);
        } else {
            $_SESSION['error_post'] = "You have to be logged in to create a post!";
        }
        break;
    case 'delete':
        $blog->deletePost($_GET['id'], $_SESSION['permission'], $_SESSION['readonly_status']);
        break;
    case 'logout':
        $user->logout();
    default:
        $blog->getAllPosts();
        break;
}

//Displaing errors or success messages:
foreach($_SESSION as $key => $value) {
    if (strpos($key, 'error_') !== false) {
        echo '<p class="error" style="color: red;">' . $value . '</p>';
        unset($_SESSION[$key]);
    } elseif (strpos($key, '_success') !== false) {
        echo '<p class="success" style="color: green;">' . $value . '</p>';
        unset($_SESSION[$key]);
    }
}