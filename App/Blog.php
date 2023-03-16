<?php

namespace App;
use PDO;

/**
* Class Blog - contains public methods for retrieving posts fram data base, creating new posts or delete if user have permission. 
* It uses PDO to connect to the database and protects against SQL injection by binding variables. 
* In addition, it includes a simple validation that prevents the addition of empty posts.
*/

class Blog
{
    public function getAllPosts(): void
    {
        require_once 'Database.php';
        $sql = 'SELECT * FROM blog ';

        $query = $db->prepare($sql);
        $query->execute();

        $posts = $query->fetchAll();

        if(count($posts) > 0)
        {
            echo "<h4>There is some posts for you:</h4>";
            foreach ($posts as $post) {
                echo "<p>{$post['text']}</p>";
            }
        }
    }

    public function createPost($text, $userId): void
    {
        if(empty($text) || empty($userId))
        {
            $_SESSION['error_post'] = "You entered a blank post!";
           
        } else {
            require_once 'Database.php';
            $sql = 'INSERT INTO blog (text, userid) VALUES (:text, :userid)';

            $query = $db->prepare($sql);

            $query->bindValue(':text', $text, PDO::PARAM_STR);
            $query->bindValue(':userid', $userId, PDO::PARAM_INT);

            $_SESSION['post_success'] = "Post created successfully!";
            $query->execute();
        }
    }

    public function deletePost($id, $permission, $readonly): void
    {
        if ($permission != 'superuser' || $readonly == 'yes') {
            $_SESSION['error_post'] = "You don't have permission to delete posts!";
           
        } else if (empty($id)) {
            $_SESSION['error_post'] = "Enter post id";

        } else {
            require_once 'Database.php';
            $sql = 'DELETE from blog WHERE id = :id';

            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            if ($query->rowCount() === 0) {
                $_SESSION['error_post'] = "Post id not found!";
            } else {
                $_SESSION['post_success'] = "Post deleted successfully!";
            }
        }   
    }

}
