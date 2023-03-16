# BLOG - topic development

Project is on main branch. 
To launch project on computer:
- download code
- run local server (for example using XAMPP)
- setup local MySQL database (for example with phpMyAdmin)

```
CREATE TABLE `user` (
    `userid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `username` VARCHAR( 45 ) NOT NULL ,
    `password` VARCHAR( 45 ) NOT NULL ,
    `permission` VARCHAR( 45 ) NOT NULL ,
    `readonly` VARCHAR( 45 ) NOT NULL
) ENGINE = InnoDB;
```

```
CREATE TABLE `blog` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `text` TEXT NOT NULL ,
    `userid` INT NOT NULL
) ENGINE = InnoDB;
```

Last step is to run project in browser, default localhost:8000


Following routes for using app:

- "?action=new_user&username=test&password=test&permission=superuser&readonly=yes" -> create new user

- "?action=login&user=test&password=test" -> log in

- "?action=new&text=Example+post+to+data+base" -> new entry

- "?action=delete&id={id}" -> delete entry by {id} (HINT: You should only grant special permissions to authorized users who are allowed to delete posts :-) )

- "?action=blog" -> list of all posts

- "?action=logout" -> log out