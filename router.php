<?php
session_start();
$path  = explode("/", $_SERVER['REQUEST_URI']);
$method = $_SERVER['REQUEST_METHOD'];
$mysqli = new mysqli("localhost", "root", "", "php1901");
require_once('php/classes/ArticleController.php');
require_once('php/classes/UserController.php');
require_once('php/classes/simple_html_dom.php');
require_once('php/classes/Route.php');

/* Маршруты для отображения страниц*/
Route::view('/login', "view/login.html");
Route::view('/reg', "view/reg.html");
Route::view('/articles', "view/articles.html");
Route::view('/article/{id}', "view/article.html");
Route::view('/addArticle', "view/addArticle.html");

/* Маршруты для обработки POST запросов*/
Route::post('/login', function (){return UserController::login();});
Route::post('/reg', function (){return UserController::reg();});


if ($path[1] == "getArticles"){
    exit(ArticleController::getArticles());
}elseif ($path[1] == "article" && $method == 'POST'){
    exit(ArticleController::getArticleById());
}elseif ($path[1] == "addArticle" && $method == 'POST'){
    ArticleController::addArticle();
}elseif ($path[1] == "deleteArticle"){
    ArticleController::deleteArticle();
}elseif ($path[1] == 'addComment'){
    ArticleController::addComment();
}elseif ($path[1] == 'getCommentByArticleId'){
    ArticleController::getCommentByArticleId($_POST['article_id']);
}elseif ($path[1] == 'getAuthUserData'){
    exit(UserController::getAuthUserData());
}elseif ($path[1] == 'profile' && $method == "GET"){
    $content = file_get_contents('view/profile.html');
}elseif ($path[1] == 'updateUserAvatar'){
    UserController::updateUserAvatar();
}else{
    $content = "Страница не найдена 404";
}
require_once('template.php');