<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Seguridad\SeguridadController as SeguridadApiController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SeguridadController;
use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\pide\PideController;
use App\Http\Controllers\niubiz\NiubizController;
use App\Http\Controllers\pagalo\PagosEnLineaController;
use App\Http\Controllers\pagalo\ReporteIngresosOnlineController;
use App\Http\Controllers\pagalo\EstadoCuentaController;
use App\Http\Controllers\pagalo\EstadoCuentaPrintController;
use App\Http\Controllers\pagalo\ReciboPdfController;
use App\Http\Controllers\reporte_online\ReporteOnlineController;
use App\Http\Controllers\notificaciones\NotificacionesBandejaController;
use App\Http\Controllers\Contribuyente\ContribuyenteController;
use App\Http\Controllers\Seguridad\PerfilController;

#Route::get('/', [InicioController::class, 'index'])->name('inicio');
Route::get('inicio', [InicioController::class, 'redirectToInicio'])->name('inicio');

// Rutas de autenticación
Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/valida', [SeguridadApiController::class, 'login'])->name('valida-user');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['session.check'])->group(function () {
    Route::prefix('main')->group(function () {
        Route::get('/', [MainController::class, 'index'])->name('main');
    });

    Route::prefix('contribuyente')->group(function () {
        Route::get('cuponera', [ContribuyenteController::class, 'cuponera'])->name('contribuyente.cuponera');
    });
});


Route::get('recuperar-acceso', [LoginController::class, 'recuperarAcceso'])->name('recuperar-acceso');
Route::post('solicitar-clave', [LoginController::class, 'solicitarClave'])->name('solicitar-clave');
Route::post('buscar-persona', [LoginController::class, 'buscarPersona'])->name('buscar-persona');

Route::get('crear-cuenta', [LoginController::class, 'crearCuenta'])->name('crear-cuenta');
Route::post('api-persona', [LoginController::class, 'validarPersona'])->name('api-persona')->middleware(['validate.frontend', 'csrf.token']);
Route::post('guardar-cuenta', [LoginController::class, 'guardarCuenta'])->name('guardar-cuenta');
Route::post('valida-contribuyente', [LoginController::class, 'validarContribuyente'])->name('valida-contribuyente');
Route::post('buscar-contribuyente', [LoginController::class, 'buscarContribuyente'])->name('buscar-contribuyente');

Route::middleware(['session.check'])->group(function () {

    Route::prefix('seguridad')->group(function () {
        Route::get('/', [MainController::class, 'index']);
        Route::post('save-clave', [SeguridadController::class, 'guardarClave'])->name('save-clave');
        Route::get('claveView', [SeguridadController::class, 'claveView'])->name('claveView');
        #OPCIONES
        Route::get('opciones', [SeguridadController::class, 'opciones'])->name('opciones')->middleware('validarAcceso');
        Route::get('select-opciones', [SeguridadController::class, 'selectOpciones'])->name('select-opciones');
        Route::get('select-menu-opciones', [SeguridadController::class, 'selectCmbMenuOpciones'])->name('select-menu-opciones');
        Route::post('guardar-opcion', [SeguridadController::class, 'guardarOpciones'])->name('guardar-opcion');
        Route::get('editar-opcion', [SeguridadController::class, 'editarOpciones'])->name('editar-opcion');
        Route::get('eliminar-opcion', [SeguridadController::class, 'eliminarOpcion'])->name('eliminar-opcion');

        #ROLES
        Route::get('roles', [SeguridadController::class, 'roles'])->name('roles')->middleware('validarAcceso');
        Route::get('select-roles', [PerfilController::class, 'index'])->name('select-roles');
        Route::get('eliminar-rol', [SeguridadController::class, 'eliminarRoles'])->name('eliminar-rol');
        Route::get('select-leyendas', [SeguridadController::class, 'selectLeyendasOpcion'])->name('select-leyendas');
        Route::get('select-sub-leyendas', [SeguridadController::class, 'selectLeyendasSubOpcion'])->name('select-sub-leyendas');
        Route::get('grabar-opcion-roles', [SeguridadController::class, 'grabarOpcionRoles'])->name('grabar-opcion-roles');
        Route::post('grabar-roles', [SeguridadController::class, 'grabarRoles'])->name('grabar-roles');

        #PERSONA
        Route::get('personas', [SeguridadController::class, 'personas'])->name('personas')->middleware('validarAcceso');
        Route::get('select-personas', [SeguridadController::class, 'selectPersonas'])->name('select-personas');
        Route::get('eliminar-persona', [SeguridadController::class, 'eliminarPersona'])->name('eliminar-persona');
        Route::post('guardar-persona', [SeguridadController::class, 'grabarPersona'])->name('guardar-persona');

        #USUARIO
        Route::get('usuarios', [SeguridadController::class, 'usuarios'])->name('usuarios')->middleware('validarAcceso');
        Route::get('select-usuarios', [SeguridadController::class, 'listarUsuarios'])->name('select-usuarios');
        Route::get('eliminar-usuario', [SeguridadController::class, 'eliminarPersona'])->name('eliminar-usuario');
        Route::post('guardar-usuario', [SeguridadController::class, 'grabarUsuario'])->name('guardar-usuario');
        Route::get('modal-area', [SeguridadController::class, 'modalarea'])->name('modal-area');
        Route::get('grabar-usua-area', [SeguridadController::class, 'grabarUsuaArea'])->name('grabar-usua-area');
        Route::get('eliminar-usuario-area', [SeguridadController::class, 'eliminarUsuarioArea'])->name('eliminar-usuario-area');
        Route::get('select-usuario-area', [SeguridadController::class, 'selectUsuaArea'])->name('select-usuario-area');
        Route::get('cambiar-area', [SeguridadController::class, 'cambiarArea'])->name('cambiar-area');
        Route::get('accesos-usuario', [SeguridadController::class, 'accesosUsuario'])->name('accesos-usuario');
        Route::get('grabar-acceso-usuario', [SeguridadController::class, 'grabarAccesoUsuario'])->name('grabar-acceso-usuario');


        #CONFIGURACION
        Route::get('perfil', [SeguridadController::class, 'perfil'])->name('perfil');
        Route::get('tipo-contactos', [SeguridadController::class, 'selectTipoContactos'])->name('tipo-contactos');
        Route::get('select-contactos', [SeguridadController::class, 'selectContactos'])->name('select-contactos');
        Route::get('grabar-contactos', [SeguridadController::class, 'grabarContactos'])->name('grabar-contactos');
        Route::get('eliminar-contacto', [SeguridadController::class, 'eliminarContactos'])->name('eliminar-contacto');
        Route::get('select-contactos-individual', [SeguridadController::class, 'selectContactosIndivudual'])->name('select-contactos-individual');
        
        Route::get('documentacion', [SeguridadController::class, 'viewDocumentacion'])->name('documentacion');
    });

});

Route::prefix('areas')->group(function () {
    Route::get('/', [AreasController::class, 'vistaArea']);
    Route::get('select-areas', [AreasController::class, 'selectAreas'])->name('select-areas');
    Route::post('guardar-areas', [AreasController::class, 'guardarArea'])->name('guardar-areas');
    Route::get('eliminar-area', [AreasController::class, 'eliminarArea'])->name('eliminar-area');
    Route::get('select-tema', [AreasController::class, 'selectTemas'])->name('select-tema');

});

Route::prefix('administracion')->group(function () {
    Route::get('/', [AdministracionController::class, 'vistaArea']);
    Route::get('horarios-de-cita', [AdministracionController::class, 'vistaHorarios'])->name('horarios-de-cita');
    Route::get('select-horarios', [AdministracionController::class, 'selectHorarios'])->name('select-horarios');
    Route::post('valid-persona', [AdministracionController::class, 'validarPersona'])->name('valid-persona')->middleware('validate.frontend');
    Route::get('horarios-existentes', [AdministracionController::class, 'selectHorariosExistentes'])->name('horarios-existentes');

});

Route::middleware(['session.check'])->group(function () {
    //pago en linea
    Route::get('pagalo/pago-en-linea', [PagosEnLineaController::class, 'viewPagoLinea'])->name('pago-en-linea');

    Route::post('pago-linea/valida-cuenta', [PagosEnLineaController::class, 'validarCuentaParaPago']);
    Route::post('pago-linea/procesar', [PagosEnLineaController::class, 'procesarSeleccion'])->name('procesar-seleccion');
    Route::post('pago-linea/validar-contribuyente', [PagosEnLineaController::class, 'validarContribuyente'])->name('validar-contribuyente');
    Route::post('pago-linea/confirmar-contribuyente', [PagosEnLineaController::class, 'confirmarContribuyente'])->name('confirmar-contribuyente');

    Route::get('pagalo/estado-de-cuenta', [EstadoCuentaController::class, 'viewEcuenta'])->name('estado-de-cuenta');
    Route::get('pagalo/get-ecuenta', [EstadoCuentaController::class, 'getEcuenta'])->name('get-ecuenta');
    Route::get('pagalo/estado-de-cuenta-pdf', [EstadoCuentaPrintController::class, 'generatePdf'])->name('estado-de-cuenta-pdf');
    Route::get('pagalo/mis-recibos', [PagosEnLineaController::class, 'viewMisRecibos'])->name('mis-recibos');
    Route::get('pagalo/mis-recibos-pdf/{codigo}', [ReciboPdfController::class, 'generatePdf'])->name('pagalo.mis-recibos-pdf');

    Route::post('pago-linea/finalizar-pago/{codigo}', [PagosEnLineaController::class, 'finalizarPago'])->name('pagalo.finalizar-pago');

    Route::get('pagalo/reporte-ingresos', [ReporteIngresosOnlineController::class, 'viewPagosLinea'])->name('pagalo.reporte-ingresos');
    Route::get('pagalo/reporte-ingresos-select', [ReporteIngresosOnlineController::class, 'consultaPagosOnline'])->name('pagalo.reporte-ingresos-select');

    Route::prefix('reportes-online')->group(function () {
        Route::get('reporte-canchas', [ReporteOnlineController::class, 'selectCanchas'])->name('reporte-online.canchas');
        Route::get('reporte-talleres', [ReporteOnlineController::class, 'selectTalleres'])->name('reporte-online.talleres');
    });
});

Route::middleware(['session.check'])->group(function () {
    Route::prefix('notificaciones')->group(function () {
        Route::get('bandeja', [NotificacionesBandejaController::class, 'index']);
        Route::get('select-bandeja', [NotificacionesBandejaController::class, 'selectBandeja']);
    });
});

#PIDE
Route::get('pide/consulta', [PideController::class, 'validarPersona'])->name('pide/consulta');

Route::get('terminos-y-condiciones', [NiubizController::class, 'terminosCondiciones'])->name('terminos-y-condiciones');
Route::get('terminos-y-condiciones/talleres', [NiubizController::class, 'terminosCondicionesTalleres'])->name('terminos-y-condiciones-talleres');