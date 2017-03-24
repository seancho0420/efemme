eFemme Code Challenge
=====================

Created simple REST API for signup, signin, and change password



Environment
-----------

```
- Yii 2 Basic Project Template
- MySQL local server
```


API Call
--------

### Sign up

POST Request with username, password, and email.

~~~
http://localhost/api/user/signup/
~~~

### Sign in

POST Request with username, and password.

~~~
http://localhost/api/user/signup/
~~~

### Change password

POST Request with username, password and new_password.

~~~
http://localhost/api/user/changepassword/
~~~


Table Info
----------
~~~
  CREATE TABLE `user` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
~~~
