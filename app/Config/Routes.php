<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::menu');
//usuarios
$routes->get('usuarios/registro', 'UsuarioController::registro');
$routes->post('usuarios/registrar', 'UsuarioController::registrar');
$routes->get('usuarios/login', 'UsuarioController::login');
$routes->post('usuarios/ingresar', 'UsuarioController::ingresar');
$routes->get('usuarios/logout', 'UsuarioController::logout');
$routes->get('usuarios/ocultar-modal', 'UsuarioController::ocultarModal');
//tareas
$routes->get('tareas', 'TareaController::index');
$routes->get('tareas/crear', 'TareaController::crear');
$routes->post('tareas/guardar', 'TareaController::guardar');
$routes->get('tareas/listar', 'TareaController::listar');
$routes->get('tareas/editar/(:num)', 'TareaController::editar/$1');
$routes->post('tareas/actualizar/(:num)', 'TareaController::actualizar/$1');
$routes->get('tareas/eliminar/(:num)', 'TareaController::eliminar/$1');
//archivadas
$routes->get('tareas/archivadas', 'TareaController::verArchivadas');
$routes->post('tareas/restaurar/(:num)', 'TareaController::restaurar/$1');
$routes->post('tareas/eliminarArchivada/(:num)', 'TareaController::eliminarArchivada/$1');
//subtareas
$routes->get('subtareas/(:num)', 'SubtareaController::index/$1');  // Lista subtareas de una tarea
$routes->get('subtareas/crear/(:num)', 'SubtareaController::crear/$1');  // Form para crear subtarea de tarea $1
$routes->post('subtareas/guardar', 'SubtareaController::guardar');  // Guarda nueva subtarea
$routes->get('subtareas/editar/(:num)', 'SubtareaController::editar/$1');
$routes->post('subtareas/actualizar/(:num)', 'SubtareaController::actualizar/$1');
$routes->get('subtareas/eliminar/(:num)', 'SubtareaController::eliminar/$1');
$routes->get('subtareas/listar/(:num)', 'SubtareaController::listar/$1');
//compartir
$routes->get('tareas/mostrarCompartir/(:num)', 'TareaController::mostrarCompartir/$1');
$routes->post('tareas/asignar_subtarea/(:num)', 'TareaController::asignar_subtarea/$1');
$routes->get('subtareas/quitarColaborador/(:num)', 'SubtareaController::quitarColaborador/$1');

//colaboradores
$routes->get('colaboradores/login', 'ColaboradorController::login');
$routes->get('colaboradores/logout', 'ColaboradorController::logout');
$routes->post('colaboradores/procesarLogin', 'ColaboradorController::procesarLogin');
$routes->post('colaboradores/ingresar', 'ColaboradorController::ingresar');
$routes->get('colaboradores/solicitar', 'ColaboradorController::solicitar');
$routes->post('colaboradores/registrar', 'ColaboradorController::registrar');
$routes->post('colaboradores/cambiarEstado', 'ColaboradorController::cambiarEstado');
$routes->get('colaboradores/dashboard', 'ColaboradorController::dashboard');
$routes->get('colaboradores/crearColaboradorTest', 'ColaboradorController::crearColaboradorTest');