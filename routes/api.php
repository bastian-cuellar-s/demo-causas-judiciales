<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});


Route::namespace('App\\Http\\Controllers\\API\V1')->group(function () {
    //user routes
    Route::get('profile', 'ProfileController@profile');
    Route::put('profile', 'ProfileController@updateProfile');
    Route::post('change-password', 'ProfileController@changePassword');
    //Persona routes
    Route::get('abogados/listaAbogados', 'PersonaController@listaAbogados');
    Route::get('abogadosCliente/listaAbogadosCliente', 'PersonaController@listaAbogadosCliente');
    Route::get('personasRecibo/listaPersonasRecibo', 'PersonaController@listaPersonasRecibo');
    Route::get('clientes/listaClientes', 'PersonaController@listaClientes');
    Route::get('demandados/listaDemandados', 'PersonaController@listaDemandados');
    Route::get('clientesAbogados/listaClientesAbogadosAll', 'PersonaController@listaClientesAbogadosAll');
    Route::get('personas/{id}', 'PersonaController@get');
    Route::get('personas', 'PersonaController@index');
    Route::post('personas/search', 'PersonaController@searchPersona');
    Route::get('/personas/all/', 'PersonaController@allPersona');
    Route::delete('/personas/all/{personas}', 'PersonaController@destroyAll');
    //Domicilios Routes
    //Route::get('domicilios', 'DomicilioController@index');
    Route::get('getRegiones', 'DomicilioController@getRegiones');
    Route::get('getComunas', 'DomicilioController@getComunas');
    Route::post('domicilios/search', 'DomicilioController@searchDomicilio');
    //Aranceles Routes (paginacion)
    Route::post('aranceles/search', 'ArancelController@searchArancel');
    Route::post('aranceles/createExcel', 'ArancelController@storeExcel');
    //Deligencias Routes
    Route::post('deligencias/search', 'DeligenciaController@searchDeligencia');
    Route::post('deligencias/getDeligenciaCliente', 'DeligenciaController@getDeligenciaCliente');
    Route::get('/deligencias/all', 'DeligenciaController@allDeligencia');
    //Gestiones Routes
    Route::post('gestiones/getGestionClienteAbogado', 'GestionController@getGestionClienteAbogado');
    Route::post('gestiones/search', 'GestionController@searchGestion');
    Route::get('gestiones/export/{gestiones}','GestionController@export');
    Route::delete('/gestiones/all/{gestiones}', 'GestionController@destroyAll');
    Route::get('/gestiones/all', 'GestionController@allGestion');
    Route::put('gestiones/editCorreo/{id}', 'GestionController@updateCorreo');
    Route::put('gestiones/editEstampe/{id}', 'GestionController@updateEstampe');
    Route::put('gestiones/editCobrado/{id}', 'GestionController@updateCobrado');
    Route::put('gestiones/editPagado/{id}', 'GestionController@updatePagado');
    Route::put('gestiones/editCorreoF/{id}', 'GestionController@updateCorreoF');
    Route::put('gestiones/editEstampeF/{id}', 'GestionController@updateEstampeF');
    Route::put('gestiones/editCobradoF/{id}', 'GestionController@updateCobradoF');
    Route::put('gestiones/editPagadoF/{id}', 'GestionController@updatePagadoF');
    //Grupo Aranceles Routes
    Route::post('grupoAranceles/search', 'GrupoArancelController@searchGrupoArancel');
    //WORD estampados
    Route::post('estampado', 'WORDEstampadoController@store');
    //Enviar email via gmail, con clave para app
    Route::post('sendEmail', 'SendEmailController@sendEmail');

    Route::apiResources([
        'user'                  => 'UserController',
        'personas'              => 'PersonaController',
        'domicilios'            => 'DomicilioController',
        'deligencias'           => 'DeligenciaController',
        'gestiones'             => 'GestionController',
        'encargos'              => 'EncargoController',
        'materias'              => 'MateriaController',
        'tribunales'            => 'TribunalController',
        'aranceles'             => 'ArancelController',
        'grupoAranceles'        => 'GrupoArancelController',
        'tipoArancel'           => 'TipoArancelController',
        'tipoCuaderno'          => 'TipoCuadernoController',
        'gestionFecha'          => 'GestionFechaController',
        'recibos'               => 'ReciboController',
        'reciboExtra'          => 'ReciboExtraController',
    ]);
});
