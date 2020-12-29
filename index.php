<?php

use CoffeeCode\Router\Router;

require __DIR__ . "/vendor/autoload.php";

$router = new Router("http://localhost/projetos/Agenda");

$router->namespace("Source\controller");
$router->group(null);

$router->get("/", "home:view", "h.h");

$router->get("/cadastro", "cadastro:view", "c.c");
$router->post("/cadastrar", "cadastro:cadastrar");

$router->get("/login", "login:view", "login.login");
$router->post("/login", "login:logar");

$router->get("/deslogar", "login:deslogar");

$router->get("/addContato", "contato:view");
$router->post("/addContato", "contato:addContato");


$router->dispatch();
