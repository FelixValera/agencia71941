<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::view('/saludo','vista'); //metodo retorna una vista

Route::get('/datos',function()  //retorna accion
{

  //return 'hola mundo';

  return [
		'curso' => 'desarrollo con laravel',
		'codigo' => 71941,
		'inicio' => '20-07-2024',
		'fin' => '28-09-2024'
	];

});


Route::get('/vista',function()
{
  //proceso que vamos a escribir luego

	$curso = 'Desarrollo con Laravel';
		

  //retorno de una vista 
	
	return view('vista',
	[ 
		'curso' =>  'Crochet y bordado',
		'numero' => 80,
		'zeppelin' => [
						'Jimmy Page',
						'Robert Palnt',
						'John Paul Jones',
						'Bonzo Bonham'
					]
		
	]);
});


