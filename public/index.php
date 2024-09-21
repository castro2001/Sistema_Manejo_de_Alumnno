<?php
session_start();
require_once __DIR__.'/../vendor/autoload.php';

use App\Model\Repository\UserRepository;
use Core\Routes;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__."/../");
 $dotenv->load();
 $app = new Routes();
/*
 $login = new UserRepository();
 var_dump($login->login('Administrador','Admin4578'));*/