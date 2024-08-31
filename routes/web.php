<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

/*Route::get('/', function () {
    return view('welcome');
});*/

/*
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
*/

//agragando la nuevas rutas creada en clase3
Route::view('/','dashboard');

Route::view('/dashboard', 'dashboard');

Route::get('/region/create',function(){

	return view('regionCreate');
});

Route::get('/regiones',function(){

	$regiones = DB::select('SELECT * FROM regiones Order by idRegion');

	return view('regiones',['regiones'=>$regiones]);
});

Route::post('/region/store',function(){

	$nombre = request()->nombre; //capturar input en laravel

	try{

		DB::table('regiones')->insert(['nombre'=>$nombre]);

		return redirect('/regiones')->with([

			'mensaje'=>'Region: '.$nombre.' Agregado correctamente',
			'css'=>'green'
		]); 
		//se llama flashing devolvemos un mensaje de exito o error 
		//el metodo "with" lo que hace es que manda una variable de session que luego se elimina
	}
	catch(Throwable $th){

		/*es mejor usar esa insterface que "Exception" por que todos las clases que lanzan excepciones implementan la interface Throwable*/
		return redirect('/regiones')->with([

			'mensaje'=>'No se pudo agregar la region '.$nombre,
			'css'=>'red'
		]); 
	}

});

//en las rutas esto {id} dice que el dato es dinamico 
Route::get('/region/edit/{id}',function(string $id){
	//pasamos el parametro de la ruta "id" a la function
	//obtenemos los datos de la region filtrado por su id 

	$region = DB::table('regiones')->where('idRegion',$id)->first();
	//en query builder no se requiere colocar el signo "="
	//get() "trae todos los registros igual a fetchall()" first()"solo trae un registro igual a fetch"  
	
	return view('regionEdit',['region'=>$region]);
});

Route::post('/region/update',function(){

	$nombre = request()->nombre;
	$idRegion = request()->idRegion;
	
	try{

		DB::table('regiones')->where('idRegion',$idRegion)->update(['nombre'=>$nombre]);

		return redirect('/regiones')->with([
			'mensaje'=>'Actualizado correctamente :)',
			'css'=>'green'
		]);

	}
	catch(Throwable $th){
		
		return redirect('/regiones')->with([
			'mensaje'=>'No se pudo actualizar :(',
			'css'=>'red'
		]);
	}
});

Route::get('/region/delete/{id}',function(string $id){

	try{

		DB::table('regiones')->where('idRegion',$id)->delete();

		return redirect('/regiones')->with([
			'mensaje'=>'Eliminado correctamente :)',
			'css'=>'green'
		]);
	}
	catch(throwable $th){
		
		return redirect('/regiones')->with([
			'mensaje'=>'No se pudo eliminar :(',
			'css'=>'red'
		]);
	}
});

//rutas de la vista destinos

Route::get('/destinos',function(){

	//$destinos = DB::table('destinos')->orderby('idDestino','asc')->select('idDestino','aeropuerto','precio')->get();
	$destinos = DB::table('destinos as d')->join('regiones as r','d.idRegion','=','r.idRegion')
	->select('idDestino','aeropuerto','precio','r.nombre')->get();
	
	return view('destinos',['destinos'=>$destinos]);
});

Route::get('/destino/create',function(){

	$regiones = DB::table('regiones')->get();

	return view('destinoCreate',['regiones'=>$regiones]);
});

Route::post('/destino/store',function(){

	$aeropuerto = request()->aeropuerto;
	$precio = request()->precio;
	$idRegion = request()->idRegion;

	try{

		DB::table('destinos')->insert(
			[
				'aeropuerto'=>$aeropuerto,
				'precio'=>$precio,
				'idRegion'=>$idRegion
			]
		);

		return redirect('/destinos')->with(
			[
				'mensaje'=>$aeropuerto.' Agregado Correctamente :)',
				'css'=>'green'
			]
		);
	}
	catch(Throwable $th){

		return redirect('/destinos')->with(
			[
				'mensaje'=>'No se pudo agregar el destino :(',
				'css'=>'red'
			]
		);
	}
});

Route::get('/destino/edit/{id}',function($id){

	$destino = DB::table('destinos as d')->join('regiones as r','d.idRegion','=','r.idRegion')
	->where('idDestino',$id)->select('idDestino','aeropuerto','precio','d.idRegion','r.nombre')->get();

	$regiones = DB::table('regiones')->get();
	
	return view('/destinoEdit',['destino'=>$destino[0],'regiones'=>$regiones]);
});

Route::post('/destino/update',function(){

	$idDestino = request()->idDestino;
	$aeropuerto = request()->aeropuerto;
	$precio = request()->precio;
	$idRegion = request()->idRegion;

	try{

		DB::table('destinos')->where('idDestino',$idDestino)->update([
			'aeropuerto'=>$aeropuerto,
			'precio'=>$precio,
			'idRegion'=>$idRegion
		]);

		return redirect('/destinos')->with(
			[
				'mensaje'=>'Destino actualizado correctamente :)',
				'css'=>'green'
			]
		);
	}
	catch(Throwable $th){
		
		return redirect('/destinos')->with(
			[
				'mensaje'=>'No se pudo actualizar el destino :(',
				'css'=>'red'
			]
		);
	}

});

Route::get('/destino/delete/{id}',function($id){

	try{

		DB::table('destinos')->where('idDestino',$id)->delete();

		return redirect('/destinos')->with(
			[
				'mensaje'=>'Eliminado correctamente :)',
				'css'=>'green'
			]
		);
	}
	catch(Throwable $th){

		return redirect('/destinos')->with(
			[
				'mensaje'=>'No se pudo eliminar  :(',
				'css'=>'red'
			]
		);
	}

});































