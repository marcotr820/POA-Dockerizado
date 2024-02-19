<?php
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AdminPoaController;
use App\Http\Controllers\ConsolidarPOAController;
use App\Http\Controllers\CortoPlazoAccionController;
use App\Http\Controllers\DatatableController;
use App\Http\Controllers\DeterminarOperacionesTareasController;
use App\Http\Controllers\DeterminarRequerimientosController;
use App\Http\Controllers\DirectrizPoaController;
use App\Http\Controllers\EstadoTrabajadorController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\GerenciaController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MedianoPlazoAccionController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\OperacionController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PeiObjetivoEspecificoController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PilarController;
use App\Http\Controllers\PlanificacionController;
use App\Http\Controllers\PoaController;
use App\Http\Controllers\PresupuestosRequeridosController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TareaEspecificaController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\UsuarioController;
use App\Models\Gerencias;
use Illuminate\Support\Facades\Route;

// eliminar
Route::get('/data', function () {
    return Gerencias::get();
});

Route::get('/pruebas', [NotificacionController::class, 'pruebas']);

Route::get('/welcome', function ($request) {
    return view('welcome');
});

Route::view('/', 'login')->name('login');

Route::post('/autenticacion', [LoginController::class, 'autenticacion'])->name('autenticacion');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//con el middleware indicamos que si no estamos autenticados no nos deje entrar a la ruta principal aumentando url
//protegemos la ruta con middleware para que usuarios no autenticados no puedan ingresar
//Route::view('principal', 'principal')->middleware('auth')->name('principal');
//agregamos el :usuario para que el guard usuario pueda ingresar a esta ruta

Route::view('principal', [UsuarioController::class, 'principal'])->middleware('auth:usuario')->name('principal');

Route::get('consulta', [DatatableController::class, 'consulta'] );

Route::group(['middleware' => ['auth:usuario']], function(){
    
    Route::view('/index', [IndexController::class, 'index'])->name('index.home');

    //************************************* GERENCIAS **************************************
    Route::resource('gerencias', GerenciaController::class)->only('index', 'store', 'update', 'destroy');

    //*************************************** UNIDADES *************************************
    Route::resource('unidades', UnidadController::class)->only('index', 'store', 'update', 'destroy')
    ->parameters([ // cambiando el parametro de la variable que recibimos /usuario/{usuario}
        'unidades' => 'unidad'
    ]);

    //************************************** TRABAJADORES ************************************
    Route::resource('trabajadores', TrabajadorController::class)->only('index', 'store', 'update', 'destroy')->parameters([
        'trabajadores' => 'trabajador'
    ]);
    

    //************************************* USUARIOS ****************************************
    Route::get('/selectTrabajadores', [UsuarioController::class, 'selectTrabajador']);
    Route::get('/rolesUsuario/{usuario}', [UsuarioController::class, 'rolesUsuario']);
    Route::resource('/usuarios', UsuarioController::class)->middleware('auth:usuario')->only('index', 'store', 'update', 'destroy')->parameters([ // cambiando el parametro de la variable que recibimos /usuario/{usuario}
        'usuarios' => 'usuario'] //solo cambiamos el nombre del parametro para entender que sera un objeto en el controlador
    );
    Route::get('/usuarios/{usuario}/update_password', [UsuarioController::class, 'index_password'])->name("index.password");
    Route::put('/update_password/{usuario}', [UsuarioController::class, 'update_password'])->name('update.password');

    //************************************** PILARES **************************************
    Route::resource('pilares', PilarController::class)->only('index', 'store', 'update', 'destroy')->parameters([
        'pilares' => 'pilar'
    ]);

    //************************************** METAS ***************************************
    Route::get('pilares/{pilar}/metas', [MetaController::class, 'index'] )->name('metas.index');
    Route::post('metas/{pilar}', [MetaController::class, 'store']);
    Route::resource('metas', MetaController::class)->only('update', 'destroy')->parameters([
        'metas' => 'meta'
    ]);

    //************************************** RESULTADOS **********************************
    Route::get('metas/{meta}/resultados', [ResultadoController::class, 'index'] )->name('resultados.index');
    Route::post('resultados/{meta}', [ResultadoController::class, 'store'])->name('resultados.store');
    Route::resource('resultados', ResultadoController::class)->only('update', 'destroy');

    //********************************** MEDIANO PLAZO ACCIONES ****************************
    Route::get('resultados/{resultado}/acciones_mediano_plazo', [MedianoPlazoAccionController::class, 'index'] )->name('mediano_plazo_accion.index');
    Route::post('mediano_plazo_acciones/{resultado}', [MedianoPlazoAccionController::class, 'store']);
    Route::resource('mediano_plazo_acciones', MedianoPlazoAccionController::class)->only('update', 'destroy')->parameters([
        'mediano_plazo_acciones' => 'mediano_plazo_accion'
    ]);

    //************************************ PEI OBJETIVOS ESPECIFICOS ****************************
    Route::get('mediano_plazo_acciones/{mediano_plazo_accion}/pei_objetivos_especificos', [PeiObjetivoEspecificoController::class, 'index'])->name('pei.index');
    Route::post('pei_objetivos_especificos/{mediano_plazo_accion}', [PeiObjetivoEspecificoController::class, 'store']);
    Route::resource('pei_objetivos_especificos', PeiObjetivoEspecificoController::class)->only('update', 'destroy')->parameters([
        'pei_objetivos_especificos' => 'pei_objetivo_especifico'
    ]);

    //************************************** ESTADO TRABAJADORES **********************************
    Route::get('estados_trabajadores', [EstadoTrabajadorController::class, 'index'])->name('estados_trabajadores.index');
    Route::put('estados_trabajadores/poa_status/{trabajador}', [EstadoTrabajadorController::class, 'poa_status']);
    Route::put('estados_trabajadores/poa_evaluacion/{trabajador}', [EstadoTrabajadorController::class, 'poa_evaluacion']);
    Route::get('estados_trabajadores/habilitar_creacion_all', [EstadoTrabajadorController::class, 'habilitar_creacion_all']);
    Route::get('estados_trabajadores/deshabilitar_creacion_all', [EstadoTrabajadorController::class, 'deshabilitar_creacion_all']);
    Route::post('estados_trabajadores/habilitar_evaluacion_all', [EstadoTrabajadorController::class, 'habilitar_evaluacion_all']);
    Route::post('estados_trabajadores/deshabilitar_evaluacion_all', [EstadoTrabajadorController::class, 'deshabilitar_evaluacion_all']);

    //************************************** PARTIDAS *************************************************/
    Route::resource('/partidas', PartidaController::class)->only('index', 'store', 'update', 'destroy');
    Route::get('/partidas_gestion', [PartidaController::class, 'partida_gestion'])->name('partidas.gestion');
    Route::get('/pdf_partidas_grupo', [PdfController::class, 'pdf_partida_grupo'])->name('pdf_partidas_grupo');
    Route::get('/pdf_sub_grupos_partidas', [PdfController::class, 'pdf_sub_grupos_partidas'])->name('pdf_sub_grupos_partidas');
    Route::get('/pdf_gerencia_grupo_partidas', [PdfController::class, 'pdf_gerencia_grupo_partidas'])->name('pdf_gerencia_grupo_partidas');
    Route::get('/pdf_gerencia_subgrupo_partidas', [PdfController::class, 'pdf_gerencia_subgrupo_partidas'])->name('pdf_gerencia_subgrupo_partidas');

    //*************************************** Creacion VER POAS ***********************************
    Route::get('poa', [PoaController::class, 'index'])->name('poa.index');
    Route::get('ver_poas', [PoaController::class, 'ver_poas'])->name('poa.ver_poas');
    Route::get('unidades/{gerencia}', [PoaController::class, 'obtener_unidades']);
    Route::get('accion_corto_plazo/{accion_corto_plazo}/actividades', [PoaController::class, 'actividades_accion_corto_plazo'])->name('actividades_accion_corto_plazo');
    Route::get('items_actividad/{actividad}', [PoaController::class, 'items_actividad'])->name('items_actividad.index');
    Route::get('tareas_especificas_actividad/{actividad}', [PoaController::class, 'tareas_especificas_actividad'])->name('tareas_especificas_actividad.index');

    Route::get('poas_gerencia', [PoaController::class, 'poas_gerencia'])->name('poas.gerencia');
    Route::get('get_poas_gerencia/{gerencia}', [PoaController::class, 'get_poas_gerencia']);
    Route::get('acciones_unidad/{unidad}', [PoaController::class, 'acciones_unidad']);


    //************************************** CORTO PLAZO ACCIONES **************************
    Route::get('/pei_objetivos_especifico/{pei_objetivo_especifico}/corto_plazo_acciones', [CortoPlazoAccionController::class, 'index'])->name('corto_plazo_acciones');
    Route::post('corto_plazo_acciones/{pei_objetivo_especifico}', [CortoPlazoAccionController::class, 'store']);
    Route::resource('corto_plazo_acciones', CortoPlazoAccionController::class)->only('update', 'destroy')->parameters([
        'corto_plazo_acciones' => 'corto_plazo_accion'
    ]);
    Route::get('/planificacion_evaluacion', [CortoPlazoAccionController::class, 'planificacion_evaluacion'])->name('planificacion_evaluacion');

    //************************************** PLANIFICACION ********************************/
    Route::get('/acciones_corto_plazo/planificacion', [PlanificacionController::class, 'acciones_corto_plazo_planificacion'])->name('acciones_corto_plazo.planificacion');
    Route::get('/planificacion/{corto_plazo_accion}', [PlanificacionController::class, 'index'])->name('planificacion.index');
    Route::post('/planificacion/{corto_plazo_accion}', [PlanificacionController::class, 'store']);
    Route::delete('planificacion/{planificacion}', [PlanificacionController::class, 'destroy']);

    //************************************ ADMIN POA ************************************
    Route::get('admin_poa', [AdminPoaController::class, 'index'])->name('admin_poa.index');
    Route::get('status_corto_plazo_accion/{corto_plazo_accion}', [AdminPoaController::class, 'status_accion_corto_plazo']);
    Route::put('update_status_corto_plazo_accion/{corto_plazo_accion}', [AdminPoaController::class, 'update_status_corto_plazo_accion']);
    Route::get('data_pei/{pei}', [AdminPoaController::class, 'data_pei']);
    Route::get('listar_acciones/{pei}', [AdminPoaController::class, 'listar_acciones']);
    Route::get('get_objetivos_ajax', [AdminPoaController::class, 'get_objetivos_ajax'])->name("get_objetivos_ajax");

    //*********************************** NOTIFICACIONES ********************************
    Route::get('notificacion', [NotificacionController::class, 'CountStatusAccionesCorto']);

    //************************************ OPERACIONES ***********************************
    Route::get('corto_plazo_acciones/{corto_plazo_accion}/operaciones', [OperacionController::class, 'index'])->name('operacion.index');
    Route::post('operaciones/{corto_plazo_accion}', [OperacionController::class, 'store']);
    Route::resource('operaciones', OperacionController::class)->only('update', 'destroy')->parameters([
        'operaciones' => 'operacion'
    ]);

    //************************************* ACTIVIDADES ***********************************
    Route::get('/operaciones/{operacion}/actividades', [ActividadController::class, 'index'])->name('actividad.index');
    Route::post('actividades/{operacion}', [ActividadController::class, 'store'])->name('actividad.store');
    Route::resource('actividades', ActividadController::class)->only('update', 'destroy')->parameters([
        'actividades' => 'actividad']
    );

    //************************************ TAREAS ESPECIFICAS *******************************/
    Route::get('actividades/{actividad}/tareas_especificas', [TareaEspecificaController::class, 'index']);
    Route::post('tareas_especificas/{actividad}', [TareaEspecificaController::class, 'store']);
    Route::resource('/tareas_especificas', TareaEspecificaController::class)->only('update', 'destroy')->parameters([
        'tareas_especificas' => 'tarea_especifica'
    ]);

    //************************************* ITEMS ***********************************************/
    Route::get('/actividades/{actividad}/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/items/{actividad}', [ItemController::class, 'store']);
    Route::resource('/items', ItemController::class)->only('update', 'destroy');

    /***************************************** EVALUACIONES ************************************/
    Route::get('/acciones_corto_plazo/evaluacion', [EvaluacionController::class, 'acciones_corto_plazo_evaluacion'])->name('acciones_corto_plazo.evaluacion');
    Route::get('/evaluacion/{corto_plazo_accion}', [EvaluacionController::class, 'index'])->name('evaluacion.index');
    Route::post('/evaluacion/{corto_plazo_accion}', [EvaluacionController::class, 'store']);
    Route::get('/get_evaluacion/{evaluacion}', [EvaluacionController::class, 'get_evaluacion']);
    Route::put('/evaluacion/{evaluacion}', [EvaluacionController::class, 'update']);
    Route::get('/ver_evaluaciones/{trabajador}', [EvaluacionController::class, 'ver_evaluaciones'])->name('ver_evaluaciones');
    Route::get('/reporte_evaluaciones/{trabajador}', [EvaluacionController::class, 'reporte_evaluaciones'])->name('reporte_evaluaciones');
    // Route::get('/evaluaciones_graficas/{trabajador}', [EvaluacionController::class, 'evaluaciones_graficas'])->name('evaluaciones_graficas');
    // Route::get('/evaluaciones_presupuesto_grafica/{trabajador}', [EvaluacionController::class, 'evaluaciones_presupuesto_grafica'])->name('evaluaciones_presupuesto_graficas');
    Route::get('/evaluacion_graficas/{corto_plazo_accion}', [EvaluacionController::class, 'evaluacion_graficas'])->name('evaluacion_graficas');

    /****************************************** ROLES ******************************************/
    Route::resource('/roles', RoleController::class)->only('index', 'store', 'update', 'destroy');
    Route::get('/permisos_rol/{role}', [RoleController::class, 'permisos_rol']);

    /****************************************** PERMISOS ******************************************/
    Route::resource('/permissions', PermissionController::class)->only('index', 'store', 'update', 'destroy');

    /****************************************** DIRECTRIZ_POA ******************************************/
    // Route::resource('/directriz_poa', DirectrizPoaController::class)->only('index');
    Route::get('/directriz', [DirectrizPoaController::class, 'index'])->name('directriz.index');
    Route::get('/directriz_pdf', [DirectrizPoaController::class, 'directriz_pdf'])->name('directriz_pdf');

    /************************************** REPORTE OPERACIONES Y TAREAS ******************************************/
    Route::get('operaciones_tareas/{unidad}', [DeterminarOperacionesTareasController::class, 'index'])->name('operaciones_tareas.index');
    Route::get('operaciones_tareas_pdf/{unidad}', [DeterminarOperacionesTareasController::class, 'operaciones_tareas_pdf'])->name('operaciones_tareas_pdf');

    //************************************** REPORTE DETERMINCACION DE REQUERIMIENTOS **********************************
    Route::get('determinacion_requerimientos/{unidad}', [DeterminarRequerimientosController::class, 'index'])->name('requerimientos.index');
    Route::get('requerimientos_pdf/{unidad}', [DeterminarRequerimientosController::class, 'requerimientos_pdf'])->name('requerimientos.pdf');

    /************************************** REPORTE PRESUPUESTOS REQUERIDOS ******************************************/
    Route::get('presupuestos_requeridos', [PresupuestosRequeridosController::class, 'lista_presupuestos'])->name('index.presupuestos');
    Route::get('presupuestos_pdf/{f_inicio?}/{f_fin?}', [PresupuestosRequeridosController::class, 'presupuestos_pdf'])->name('presupuestos.pdf');

    /************************************** CONSOLIDAR POA ******************************************/
    Route::get('consolidar_poa', [ConsolidarPOAController::class, 'index'])->name('consolidar.poa.index');
    Route::get('pdf_consolidar', [ConsolidarPOAController::class, 'pdf_consolidar'])->name('pdf.consolidar');
});