<?php


//Route::get('/', 'ClienteControlador@index'); - Utilizada no Metodo 1

Route::get('/', 'ClienteControlador@indexjs');
Route::get('/json', 'ClienteControlador@indexjson');
