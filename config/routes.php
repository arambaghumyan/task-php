<?php

use core\router\Route;
use core\router\RouteParam;

Route::get('/', function(RouteParam $site, RouteParam $date) {

})->to('page::home');

Route::get('/home', function(RouteParam $site, RouteParam $date) {

})->to('page::home');

Route::get('/pages', function(RouteParam $site, RouteParam $date) {

})->to('page::index');
