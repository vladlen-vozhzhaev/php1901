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
Route::view('/profile', 'view/profile.html');

/* Маршруты для обработки GET запросов*/
Route::get("/getArticles", function (){return ArticleController::getArticles();});
Route::get('/getAuthUserData', function (){return UserController::getAuthUserData();});
Route::get('/exit', function (){UserController::logout();});

/* Маршруты для обработки POST запросов*/
Route::post('/login', function (){return UserController::login();});
Route::post('/reg', function (){return UserController::reg();});
Route::post('/article', function (){return ArticleController::getArticleById();});
Route::post('/addArticle', function (){return ArticleController::addArticle();});
Route::post('/addComment', function (){return ArticleController::addComment();});
Route::post('/getCommentByArticleId', function (){return ArticleController::getCommentByArticleId($_POST['article_id']);});
Route::post('/updateUserAvatar', function (){return UserController::updateUserAvatar();});
if ($path[1] == "deleteArticle"){
    ArticleController::deleteArticle();
}else{
    $content = "Страница не найдена 404";
}
require_once('template.php');