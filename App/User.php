<?php

namespace App;
use PDO;

/**
* Class User - contains public methods for creating, logging in, and logging out of a user. 
* It uses PDO to connect to the database and protects against SQL injection by binding variables. 
* In addition, it includes a simple validation that prevents the addition of empty records.
*/

class User
{
    public function createUser($username, $password, $permission, $readonly): void
    {
        if(empty($username) || empty($password) || empty($permission) || empty($readonly))
        {
            $_SESSION['error_reg'] = "Entered data can not be empty!";
           
        } else {
            require_once 'Database.php';
            $sql = 'SELECT userid FROM user WHERE username = :username';
            $query = $db->prepare($sql);
            $query->bindValue(':username', $username, PDO::PARAM_STR);
    
            $query->execute();
    
            if ($query->rowCount() > 0) {
    
                $_SESSION['error_reg'] = "This username is already taken!";
    
            } else {
    
                $sql = 'INSERT INTO user (username, password, permission, readonly)
                VALUES (:username, :password, :permission, :readonly)';
    
                $query = $db->prepare($sql);
    
                $query->bindValue(':username', $username, PDO::PARAM_STR);
                $query->bindValue(':password', $password, PDO::PARAM_STR);
                $query->bindValue(':permission', $permission, PDO::PARAM_STR);
                $query->bindValue(':readonly', $readonly, PDO::PARAM_STR);
                $_SESSION['reg_success'] = "User created successfully!";
                $query->execute();
            }
        }
    }

    public function login($username, $password): void
    {
        require_once 'Database.php';
        $sql = 'SELECT userid, permission, readonly, username  FROM user WHERE username = :username AND password = :password ';

        $query = $db->prepare($sql);
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->bindValue(':password', $password, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch();

        if($user)
        {
            $_SESSION['log_success'] = "User logged in successfully!";
            $_SESSION['logged_id'] = $user['userid'];
            $_SESSION['permission'] = $user['permission'];
            $_SESSION['readonly_status'] = $user['readonly'];
            $_SESSION['username'] = $user['username'];
            
        } else
            $_SESSION['error_log'] = "Wrong credentials!";

    }

    public function logout(): void
    {
        unset($_SESSION['logged_id']);
        unset($_SESSION['permission']);
        unset($_SESSION['readonly_status']);
        unset($_SESSION['username']);
        $_SESSION['logout_success'] = "User logged out successfully!";

    }

}
