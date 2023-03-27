<?php

class UserController{
    public static function reg(){
        global $mysqli;
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        //echo "Имя: $name, Фамилия: $lastname, Email: $email, Pass: $pass";
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
        if($result->num_rows){
            echo "Такой пользователь уже существует <a href='/reg.php'>зарегистрировать другого</a>";
        }else{
            $mysqli->query("INSERT INTO `users`(`name`, `lastname`, `email`, `pass`) VALUES ('$name','$lastname','$email','$pass')");
            echo "Пользователь зарегистрирован!";
            header("Location: /login"); // Редирект (перенаправление пользователя)
        }
    }

    public static function login(){
        global $mysqli;
        $email = $_POST['email']; // admin@mail.ru
        $pass = $_POST['pass']; // 456
        //echo "$email $pass";
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email' AND pass='$pass'");
        $row = $result->fetch_assoc(); // Получаем ответ от БД в виде ассоциативного массива
        if($result->num_rows){
            $_SESSION['name'] = $row['name'];
            $_SESSION['lastname'] = $row['lastname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['img'] = $row['img'];
            return json_encode(['result'=>'success']);
        }else{
            return json_encode(['result'=>'error']);
        }
    }

    public static function getAuthUserData(){
        $userData = [
            "name"=>$_SESSION['name'],
            "lastname"=>$_SESSION['lastname'],
            "email"=>$_SESSION['email'],
            "id"=>$_SESSION['id'],
            "img"=>$_SESSION['img']
        ];
        return json_encode($userData);
    }

    public static function getUserDataById($id){

    }
}