<?php

Route::get('/welcome', function () {
    return view('Welcome');
})->name('Welcome');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/logout', function () {
    return view('welcome');
});
Route::get('login', function () {
    return view('layouts.Login');
});

Route::get('/register', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/viewAdminCuartos', 'AdministracionCuartosController@viewAdminCuartos')->name('viewAdminCuartos');//vista inicial cuartos
Route::get('/GenerarEtiquetas', 'GeneracionEtiquetasController@ViewGenerarEtiquetas')->name('GenerarEtiquetasCargue')->middleware('permission:vistaGenerarEtiquetas');//vista generacion etiquetas

/*********************************  RUTAS DE RRHH  **************************************/
Route::get('/Permisos/{id}/empelados', 'UsuariosController@ViewPermisos')->name('ViewPermisos');

Route::group(['prefix' => 'RecursosHumanos'], function () {
    Route::get('/EmpleadossubMenu', 'EmpleadosController@ViewEmpelados')->name('EmpleadossubMenu')->middleware('permission:menuRRHH');//Ruta de vista Empeados
    Route::get('/UsariossubMenu', 'UsuariosController@Usuarios')->name('UsariossubMenu')->middleware('permission:ListarUsuarios');
    Route::post('/EmpleadosCreate', 'EmpleadosController@CreateEmpleado')->name('crearEmpleados')->middleware('permission:crearEmpleado');//crear empleado
    Route::get('/FichaTecnica/{id}/empelados', 'EmpleadosController@ModificarEmpleados')->name('FichaTecnica')->middleware('permission:FichaTecnicaEmpleado');//pasar vista ficha tecnica
    Route::get('/Activar/{id}/empelado', 'EmpleadosController@ActivarEmpleado')->name('ActivarEmpleado')->middleware('permission:ActivarEmpleado');//activar empleado
    Route::get('/EliminarEmpelado/{id}/empelado', 'EmpleadosController@EliminarEmpleado')->name('InactivarEmpleado')->middleware('permission:InactivarEmpleado');//inactivar empleado
    Route::post('/EmpleadosCreate/fichatecnica', 'EmpleadosController@CrearFichaTecnica')->name('CrearFichaTecnica')->middleware('permission:ActualizarFichaTecnicaEmpleado');//guardar ficha tecnica
    Route::post('/Empleado/cargaTablaEmpleadosDocumento', 'EmpleadosController@ExisteEmpleado')->name('ExisteEmpleado');//
    Route::post('/UpdateImg', 'EmpleadosController@Updateimg')->name('UpdateImg')->middleware('permission:ActualizarFichaTecnicaEmpleado');//->middleware('permission:createEmpleado');//crear empleado
    Route::get('/Carnet/{id}/empleados', 'EmpleadosController@ImprimirCarnet')->name('ImprimirCarnet');
    Route::post('/Area', 'EmpleadosController@Area')->name('Area');
    Route::post('/Bloque', 'EmpleadosController@Bloque')->name('Bloque');
    Route::post('/Departamentos', 'EmpleadosController@Departamentos')->name('Departamentos');//
    Route::post('/EmpleadosLaboratorio', 'EmpleadosController@EmpleadosLaboratorio')->name('EmpleadosLaboratorio')->middleware('permission:VerEmpleadosLaboratorio');
    Route::post('/ImprimirMultiplesCarnets', 'EmpleadosController@ImprimirMultiplesCarnets')->name('ImprimirMultiplesCarnets');
});
/*********************************  RUTAS DE PORTAFOLIO  **************************************/
Route::group(['prefix' => 'Portafolio'], function () {
    Route::get('/VariedadessubMenu', 'PortafolioVariedadesContraller@VistaPortafolioVariedades')->name('VariedadessubMenu')->middleware('permission:Vistavariedades');
    /*GENEROS*/
    Route::get('/DatosGenerosActivos', 'PortafolioVariedadesContraller@cargaTablaGenerosActivos')->name('DatosGenerosActivos')->middleware('permission:VerGeneros');
    Route::post('/CreateGenero', 'PortafolioVariedadesContraller@createGenero')->name('CreateGenero')->middleware('permission:CrearGeneros');
    Route::post('/UpdateGenero', 'PortafolioVariedadesContraller@UpdateGenero')->name('UpdateGenero')->middleware('permission:ActualizarGeneros');
    Route::get('/Inactivar/{CodigoIntegracionGenero}/Genero', 'PortafolioVariedadesContraller@InavilitarGenero')->name('InactivarGenero')->middleware('permission:InactivarGeneros');
    Route::get('/Activar/{CodigoIntegracionGenero}/Genero', 'PortafolioVariedadesContraller@HabilitarGenero')->name('ActivarGenero')->middleware('permission:ActivarGeneros');
    /*ESPECIES*/
    Route::get('/Inactivar/{id}/Especie', 'PortafolioVariedadesContraller@InactivarEspecie')->name('InactivarEspecie')->middleware('permission:InactivarEspecies');//INACTIVAR ESPECIE
    Route::get('/Activar/{id}/Especie', 'PortafolioVariedadesContraller@ActivarEspecie')->name('ActivarEspecie')->middleware('permission:ActivarEspecies');//ACTIVAR ESPECIE
    Route::POST('/newEspecie', 'PortafolioVariedadesContraller@CreatenewEspecie')->name('CreatenewEspecie')->middleware('permission:CrearEspecies');
    Route::POST('/updateespecie', 'PortafolioVariedadesContraller@updateespecie')->name('updateespecie')->middleware('permission:ActualizarEspecies');
    /*VARIEDADES*/
    Route::post('/createVariedad', 'PortafolioVariedadesContraller@newvariedad')->name('createVariedad')->middleware('permission:CrearVariedades');
    Route::PUT('/updatevariedad', 'PortafolioVariedadesContraller@updatevariedad')->name('updatevariedad')->middleware('permission:ActualizarVariedades');;
    Route::get('/Inactivar/{id}/Variedad', 'PortafolioVariedadesContraller@InactivarVariedad')->name('InactivarVariedad')->middleware('permission:InactivarVariedades');//INACTIVAR VARIEDAD
    Route::get('/Activar/{id}/Variedad', 'PortafolioVariedadesContraller@ActivarVariedad')->name('ActivarVariedad')->middleware('permission:ActivarVariedades');//INACTIVAR VARIEDAD

    /*INFORMACION TECNICA*/
    Route::get('/InformacionTecnicaurc', 'PortafolioVariedadesContraller@InformacionTecnicaurc')->name('InformacionTecnicaurc')->middleware('permission:InformacionTecnica');//INACTIVAR VARIEDAD
    Route::post('/CargueInformacionTecnicaurc', 'PortafolioVariedadesContraller@CargueInformacionTecnicaurc')->name('CargueInformacionTecnicaurc');

    /*FICHA TECNICA GENEROS PRUEBAS*/
    Route::get('/viewFichaTecnicaGenerospruebas', 'PortafolioVariedadesContraller@viewFichaTecnicaGenerospruebas')->name('viewFichaTecnicaGenerospruebas');
    Route::post('/updateInformacionTecnicageneros', 'PortafolioVariedadesContraller@ModificarGeneroPruebas')->name('updateInformacionTecnicageneros');

});

Route::group(['prefix' => 'Laboratorio/Parametrizacion'], function () {
    Route::get('/TablasMaestras', 'TablasMaestrasController@ViewTablasMaestras')->name('TablasMaestras')->middleware('permission:MenuTablasMaestras');
    Route::post('/newCliente', 'TablasMaestrasController@newCliente')->name('newCliente');
    Route::put('/updateCliente', 'TablasMaestrasController@updateCliente')->name('updateCliente');
    Route::get('/Inactivar/{id}/cliente', 'TablasMaestrasController@inactivarCliente')->name('InactivarCliente');
    Route::get('/Activar/{id}/cliente', 'TablasMaestrasController@ActivarCliente')->name('ActivarCliente');
    Route::post('/newContenedor', 'TablasMaestrasController@newContenedor')->name('newContenedor');
    Route::post('/updateContenedor', 'TablasMaestrasController@updateContenedor')->name('updateContenedor');
    Route::get('/viewInfoTecnica', 'InfoTecnicaVariedadesController@viewInfoTecnica')->name('viewInfoTecnica')->middleware('permission:VistainfoTecnica');
    Route::post('/DetalleInfoTecnicaVar', 'InfoTecnicaVariedadesController@CargaTablaInfotecnica')->name('DetalleInfoTecnicaVar');
    Route::post('/DetalleInfoTecnicaVarFrasco', 'InfoTecnicaVariedadesController@CargaTablaInfotecnicaFrascos')->name('DetalleInfoTecnicaVarFrasco');
    Route::post('/GuardarInfotecnicaLaboratorio', 'InfoTecnicaVariedadesController@GuardarInfotecnicaLaboratorio')->name('GuardarInfotecnicaLaboratorio');
    Route::put('/GuardarInfoTecnicaFrascos', 'InfoTecnicaVariedadesController@GuardarInfoTecnicaFrascos')->name('GuardarInfoTecnicaFrascos');
});

Route::group(['prefix' => 'Laboratorio/MovimientosInventario'], function () {
    Route::get('/VistaReactivarProgramas', 'ReactivarCodigosController@VistaReactivarProgramas')->name('VistaReactivarProgramas')->middleware('permission:VistaActivarSalidas');
    Route::get('/AjusteInventario', 'AjusteInventarioController@AjusteInventario')->name('AjusteInventario')->middleware('permission:VistaAjsuteInv');//vista ajuste inventario
    Route::post('/LecAjusteInventarioTraslado', 'AjusteInventarioController@LecAjusteInventarioTraslado')->name('LecAjusteInventarioTraslado')->middleware('permission:LecturaTransInv');//->middleware('permission:crearEmpleado');
    Route::post('/LecAjusteInventarioRetorno', 'AjusteInventarioController@LecAjusteInventarioRetorno')->name('LecAjusteInventarioRetorno')->middleware('permission:LecturaTransInv');//->middleware('permission:crearEmpleado');
    Route::get('/ArqueoInventario', 'arqueoInventarioController@viewArqueoInventario')->name('ArqueoInventario')->middleware('permission:VistaLecturaArqueo');
    Route::post('/LecturaArqueo', 'arqueoInventarioController@LecturaEntradaArqueo')->name('LecturaArqueo');
    Route::get('/CambioEtiqueta', 'CambioEtiquetaController@viewCambioEtiqueta')->name('CambioEtiqueta')->middleware('permission:VistaMigrarEtq');
    Route::post('/MigrarEtiqueta', 'CambioEtiquetaController@MigrarEtiqueta')->name('MigrarEtiqueta');
    Route::post('/ImprimirEtiquetasMigradas', 'CambioEtiquetaController@ImprimirEtiquetasMigradas')->name('ImprimirEtiquetasMigradas');
    Route::get('/viewloadinventory', 'CargueInventarioController@viewloadinventory')->name('viewloadinventory')->middleware('permission:VistaCarguerInventario');//vista para cargue inventario
    Route::post('/LoadInventory', 'CargueInventarioController@LoadInventory')->name('LoadInventory')->middleware('permission:CargueInventario');
    Route::get('/LecturaEntrada', 'LecturaEntrada@readinginput')->name('LecturaEntrada')->middleware('permission:VistaLecturaEntrada');//vista lectura entrada
    Route::post('/LoadInventoryEntry', 'LecturaEntrada@LecturaEntrada')->name('LoadInventoryEntry')->middleware('permission:LecturaEntrada');
    Route::get('/LecturaSalida', 'LecturaSalida@readingexit')->name('LecturaSalida')->middleware('permission:VistaLecturaSalida');//vista lectura salida
    Route::post('/SalidaXCancelacion', 'LecturaSalida@SalidaXCancelacion')->name('SalidaXCancelacion')->middleware('permission:LecturaSalida');
    Route::post('/SalidaXDañoMaterial', 'LecturaSalida@SalidaXDanoMaterial')->name('SalidaXDañoMaterial')->middleware('permission:LecturaSalida');
    Route::post('/SalidaXDespacho', 'LecturaSalida@SalidaXDespacho')->name('SalidaXDespacho')->middleware('permission:LecturaSalida');
    Route::post('/SalidaAInvernadero', 'LecturaSalida@SalidaAInvernadero')->name('SalidaAInvernadero')->middleware('permission:LecturaSalida');
    Route::post('/SalidaAProduccion', 'LecturaSalida@SalidaAProduccion')->name('SalidaAProduccion')->middleware('permission:LecturaSalida');
    Route::post('/SalidaXsobrantes', 'LecturaSalida@SalidaXsobrantes')->name('SalidaXsobrantes')->middleware('permission:LecturaSalida');
    Route::get('/LecturaDespunte', 'LecturaDespunteController@ViewLecturaDespunte')->name('LecturaDespunte')->middleware('permission:LecturaSalida');
    Route::post('/LecturaEntradaDespunte', 'LecturaDespunteController@LecturaEntradaDespunte')->name('LecturaEntradaDespunte');
    Route::post('/DetallesProgramasReactivar', 'ReactivarCodigosController@DetallesProgramasReactivar')->name('DetallesProgramasReactivar');/*->middleware('permission:SubMenuReportesInvernadero')*/
    Route::post('/DetallesTableProgramasReactivar', 'ReactivarCodigosController@DetallesTableProgramasReactivar')->name('DetallesTableProgramasReactivar');
    Route::post('/ActivarCodigo', 'ReactivarCodigosController@ActivarCodigo')->name('ActivarCodigo');
    Route::post('/MoverEtqStock', 'CambioEtiquetaController@MoverEtqStock')->name('MoverEtqStock');
    Route::post('/MoverEtqMultiplicacion', 'CambioEtiquetaController@MoverEtqMultiplicacion')->name('MoverEtqMultiplicacion');
    Route::post('/MoverEtqEnraizamiento', 'CambioEtiquetaController@MoverEtqEnraizamiento')->name('MoverEtqEnraizamiento');
    Route::get('/VistaUbicacionVariedades', 'ConsultarEtiquetaController@VistaUbicacionVariedades')->name('VistaUbicacionVariedades')->middleware('permission:VistaUbicacionVari');
    Route::post('/DestallesUbicacionVariedades', 'ConsultarEtiquetaController@DestallesUbicacionVariedades')->name('DestallesUbicacionVariedades');
    Route::post('/CargarProgramas', 'CambioEtiquetaController@CargarProgramas')->name('CargarPrograma');
    Route::post('/Detallesprogramas', 'CambioEtiquetaController@Detallesprogramas')->name('Detallesprogramas');
    Route::post('/CambiarEtiqueta', 'CambioEtiquetaController@CambiarEtiqueta')->name('CambiarEtiqueta');
});

Route::group(['prefix' => 'Laboratorio/Reportes'], function () {
    Route::get('/ReportesLaboratorio', 'ReportesLaboratorioController@ReportesLaboratorio')->name('ReportesLaboratorio')->middleware('permission:vistaReporteinv');//vista reporte inventario
    Route::post('/ReporteEntradaLab', 'ReportesLaboratorioController@GenerarReporteEntrada')->name('ReporteEntradaLab');
    Route::post('/ReporteSalidasLab', 'ReportesLaboratorioController@GenerarReporteSalida')->name('ReporteSalidaLab');
    Route::get('/DescargaInventario', 'ReportesLaboratorioController@DescargaInventario')->name('DescargaInventario');
    Route::get('/DescargaInventarioTotal', 'ReportesLaboratorioController@DescargaInventarioTotal')->name('DescargaInventarioTotal');
    Route::get('/ReporteEntradaDinamicoFecha/{FechaInicial}/{FechaFinal}/Get', 'ReportesLaboratorioController@ReporteEntradaDinamicoFecha')->name('ReporteEntradaDinamicoFecha');
    Route::get('/ReporteEntradaDinamico/{FechaInicial}/{FechaFinal}/{IDVariedad}/Get', 'ReportesLaboratorioController@ReporteEntradaDinamico')->name('ReporteEntradaDinamico');
    Route::get('/ReporteSalidaDinamico/{FechaInicial}/{FechaFinal}/{IDVariedad}/Get', 'ReportesLaboratorioController@ReporteSalidaDinamico')->name('ReporteSalidaDinamico');
    Route::get('/ReporteDespunteDinamico/{FechaInicial}/{FechaFinal}/{IDVariedad}/Get', 'ReportesLaboratorioController@ReporteDespunteDinamico')->name('ReporteDespunteDinamico');
    Route::get('/ReporteSalidaDinamicoFecha/{FechaInicial}/{FechaFinal}/Get', 'ReportesLaboratorioController@ReporteSalidaDinamicoFecha')->name('ReporteSalidaDinamicoFecha');
});

Route::group(['prefix' => 'Laboratorio/ControlFases'], function () {
    Route::get('/MovimientoFasesLabChr', 'CambiofaselabController@MovimientoFasesLabView')->name('MovimientoFasesLabChr');
    Route::post('/DetallesIntroduccion', 'CambiofaselabController@DetallesIntroduccion')->name('DetallesIntroduccion');
    Route::post('/DetallesDespunte', 'LecturaDespunteController@DetallesDespunte')->name('DetallesDespunte');
    Route::post('/CambiarFaseLabChr', 'CambiofaselabController@CambiarFaseLabChr')->name('CambiarFaseLabChr');
    Route::post('/EtiquetasDespunte', 'LecturaDespunteController@EtiquetasDespunte')->name('EtiquetasDespunte');
    Route::post('/SelectFasenueva', 'CambiofaselabController@SelectFasenueva')->name('SelectFasenueva');

});

Route::group(['prefix' => 'Laboratorio/EstadoProgramas'], function () {
    Route::get('/ProgramasEjecutados', 'TableroController@ProgramasEjecutados')->name('ProgramasEjecutados');
    Route::get('/vistaProgramas', 'CargueInventarioController@vistaProgramas')->name('vistaProgramasImports')->middleware('permission:vistaProgramasImports');
    Route::post('/CargarExceleProgramas', 'CargueInventarioController@CargarExceleProgramas')->name('CargarExceleProgramas')->middleware('permission:CargarProgramasImports');
    Route::get('/ProgramasPendientes', 'TableroController@ProgramasPendientes')->name('ProgramasPendientes')->middleware('permission:BotonAlertasNotificaciones');
    Route::get('/FaltanteInventario', 'arqueoInventarioController@FaltanteInventario')->name('FaltanteInventario');
    Route::get('/ProgramasInvernaderoPendientes', 'InvernaderoController@ProgramasInvernaderoPendientes')->name('ProgramasInvernaderoPendientes')->middleware('permission:BotonAlertasNotificaciones');
});

Route::group(['prefix' => 'Laboratorio/Introduccion'], function () {
    Route::get('/Introduccion', 'IntroduccionController@ViewIntroduccion')->name('Introduccion')->middleware('permission:VistaIntroducciones');//vista para cargue inventario
    Route::POST('/NewIntroduccion', 'IntroduccionController@NewIntroduccion')->name('NewIntroduccion');
    Route::POST('/DetallesIntroducion', 'IntroduccionController@DetallesIntroducion')->name('DetallesIntroducion');
    Route::get('/ImprimirIntroduccion/{codigo}', 'IntroduccionController@procedimiento')->name('ImprimirIntroduccion');
    Route::POST('/ConsultaIntroducciones', 'IntroduccionController@ConsultaIntroducciones')->name('ConsultaIntroducciones');

    Route::get('/IntroduccionesFuturas', 'IntroduccionController@IntroduciconesFuturasView')->name('IntroduciconesFuturasView');
    Route::POST('/GuarddarIntroduciconesFuturas', 'IntroduccionController@GuarddarIntroduciconesFuturas')->name('GuarddarIntroduciconesFuturas');
});

Route::group(['prefix' => 'Invernadero/MovimientosInventario'], function () {
    /*ENTRADAS*/
    Route::get('/VistaLecturaEntradaInvernadero', 'InvernaderoController@VistaLecturaEntradaInvernadero')->name('VistaLecturaEntradaInvernadero')->middleware('permission:VistaLectEntradaInvernadero');
    Route::post('/LecturaEntradaInvernadero', 'InvernaderoController@LecturaEntradaInvernadero')->name('LecturaEntradaInvernadero');
    /*TRASLADOS*/
    Route::get('/VistaLecturaTrasladoInvernadero', 'InvernaderoController@VistaLecturaTrasladoInvernadero')->name('VistaLecturaTrasladoInvernadero')->middleware('permission:VistaLectTrasladoInvernadero');
    Route::post('/LecturatrasladoInvernadero', 'InvernaderoController@LecturatrasladoInvernadero')->name('LecturatrasladoInvernadero');
    /*TRASLADOS INTERNOS*/
    Route::get('/VistaLecturaTrasladoInternoInvernadero', 'InvernaderoController@VistaLecturaTrasladoInternoInvernadero')->name('VistaLecturaTrasladoInternoInvernadero')->middleware('permission:VistaLectTrasladoInvernadero');
    Route::post('/LecturaTrasladoInternoInvernadero', 'InvernaderoController@LecturaTrasladoInternoInvernadero')->name('LecturaTrasladoInternoInvernadero');
    /*DESCARTES*/
    Route::get('/VistaLecturaDescarteInvernadero', 'InvernaderoController@VistaLecturaDescarteInvernadero')->name('VistaLecturaDescarteInvernadero')->middleware('permission:VistaLectDescarteInvernadero');
    Route::post('/LecturaDescarteInvernadero', 'InvernaderoController@LecturaDescarteInvernadero')->name('LecturaDescarteInvernadero');
    /*CANCELACION*/
    Route::get('/VistaLecturaSalidaCancelacion', 'InvernaderoController@VistaLecturaCanecelacionInvernadero')->name('VistaLecturaSalidaCancelacion')->middleware('permission:VistaLectDescarteInvernadero');
    Route::post('/LecturaSalidaCancelacion', 'InvernaderoController@LecturaCanecelacionInvernadero')->name('LecturaSalidaCancelacion');
    /*DESPACHO*/
    Route::get('/VistaLecturaDespachoInvernadero', 'InvernaderoController@VistaLecturaDespachoInvernadero')->name('VistaLecturaDespachoInvernadero')->middleware('permission:VistaLectTrasladoInvernadero');
    Route::post('/LecturaDepachoInvernadero', 'InvernaderoController@LecturaDepachoInvernadero')->name('LecturaDepachoInvernadero');
    /*PREALISTAMIENTO*/
    Route::get('/VistaLecturaAlistamientoDespachoInvernadero', 'InvernaderoController@VistaLecturaPrealistamientoDespachoInvernadero')->name('VistaLecturaAlistamientoDespachoInvernadero')->middleware('permission:VistaLectTrasladoInvernadero');
    Route::post('/LecturaAlistamientoDepachoInvernadero', 'InvernaderoController@LecturaPreAlistamientoDepachoInvernadero')->name('LecturaAlistamientoDepachoInvernadero');
    /*SALIDAS ALISTAMIENTO*/
    Route::get('/VistaLecturaSalidaAlistamientoDespachoInvernadero', 'InvernaderoController@VistaLecturaSalidaAlistamientoDespachoInvernadero')->name('VistaLecturaSalidaAlistamientoDespachoInvernadero')->middleware('permission:VistaLectTrasladoInvernadero');
    Route::post('/LecturaSalidaAlistamientoDepachoInvernadero', 'InvernaderoController@LecturaSalidaAlistamientoDepachoInvernadero')->name('LecturaSalidaAlistamientoDepachoInvernadero');
    /*Consutlar Codigo*/
    Route::get('/VistaConsultaCodigoInvernadero', 'InvernaderoController@VistaConsultaCodigoInvernadero')->name('VistaConsultaCodigoInvernadero')->middleware('permission:VistaLectTrasladoInvernadero');
    Route::post('/LecturaConsultaCodigoInvernadero', 'InvernaderoController@LecturaConsultaCodigoInvernadero')->name('LecturaConsultaCodigoInvernadero');
});

Route::group(['prefix' => 'Invernadero/Reportes'], function () {
    Route::get('/VistaReportesInvernadero', 'InvernaderoController@VistaReportesInvernadero')->name('VistaReportesInvernadero')->middleware('permission:SubMenuReportesInvernadero');
    Route::post('/ReporteEntradaInvernadero', 'InvernaderoController@ReporteEntradaInvernadero')->name('ReporteEntradaInvernadero');
    Route::post('/ReporteSalidaInvernadero', 'InvernaderoController@ReporteSalidaInvernadero')->name('ReporteSalidaInvernadero');

    Route::post('/DescargaInventarioInvernaderoDescartes', 'InvernaderoController@DescargaInventarioInvernaderoDescartes')->name('DescargaInventarioInvernaderoDescartes');

    Route::get('/ReporteEntradaInvDinamico/{FechaInicial}/{FechaFinal}/{IDVariedad}/Get', 'InvernaderoController@ReporteEntradaInvDinamico')->name('ReporteEntradaInvDinamico');
    Route::get('/DescargaInventarioInvernadero', 'InvernaderoController@DescargaInventarioInvernadero')->name('DescargaInventarioInvernadero');
    Route::get('/ReporteEntradaInvDinamicoF/{FechaInicial}/{FechaFinal}/Get', 'InvernaderoController@ReporteEntradaInvDinamicoFecha')->name('ReporteEntradaInvDinamicoF');
    Route::get('/ReporteDinamicoSalidasF/{FechaInicial}/{FechaFinal}/Get', 'InvernaderoController@ReporteSalidaInvDinamicoFecha')->name('ReporteDinamicoSalidasF');
    Route::get('/ReporteDinamicoDescarteF/{FechaInicial}/{FechaFinal}/Get', 'InvernaderoController@ReportedescarteInvDinamicoFecha')->name('ReporteDinamicoDescarteF');
    Route::get('/ReporteDinamicoDescarteTF/{FechaInicial}/{FechaFinal}/Get', 'InvernaderoController@ReporteDescarteTotalInvDinamicoFecha')->name('ReporteDinamicoDescarteTF');
    Route::get('/ReporteDinamicoAlistamientoF/{FechaInicial}/{FechaFinal}/Get', 'InvernaderoController@ReporteAlistamientoInvDinamicoFecha')->name('ReporteDinamicoAlistamientoF');
});

Route::group(['prefix' => 'Invernadero/ServicioAdaptacion'], function () {
    Route::get('/Servicioadaptacion', 'InvernaderoController@Servicioadaptacion')->name('Servicioadaptacion')->middleware('permission:SubMenuServicioAdaptacion');
    Route::post('/NewAdaptacion', 'InvernaderoController@NewAdaptacion')->name('NewAdaptacion');
    Route::POST('/DetallesAdaptacion', 'InvernaderoController@DetallesAdaptacion')->name('DetallesAdaptacion');
    Route::get('/ImprimirAdaptacion/{codigo}', 'InvernaderoController@procedimientoAdaptacion')->name('ImprimirAdaptacion');
    Route::get('/ImprimirEtqSA', 'ConsultarEtiquetaController@ImprimirEtqSA')->name('ImprimirEtqSA');
});

Route::group(['prefix' => 'Propagacion'], function () {
    /*ENTRADAS*/
    Route::get('/VistaLecturaEntradaPropagacion', 'PropagacionController@VistaLecturaEntradaPropagacion')->name('VistaLecturaEntradaPropagacion')->middleware('permission:VistaLectEntradaPropagacion');
    Route::post('/LecturaEntradaProgpagacion', 'PropagacionController@LecturaEntradaProgpagacion')->name('LecturaEntradaProgpagacion');
    /*TRASLADOS*/
    Route::get('/VistaLecturaTraladoPropagacion', 'PropagacionController@VistaLecturaTraladoPropagacion')->name('VistaLecturaTraladoPropagacion')->middleware('permission:VistaLectTrasladoPropagacion');
    Route::post('/LecturatrasladoPropagacion', 'PropagacionController@LecturatrasladoPropagacion')->name('LecturatrasladoPropagacion');
    /*DESCARTES*/
    Route::get('/VistaLecturaDescartePropagacion', 'PropagacionController@VistaLecturaDescartePropagacion')->name('VistaLecturaDescartePropagacion')->middleware('permission:VistaLectDescartePropagacion');
    Route::post('/LecturaDescartePropagacion', 'PropagacionController@LecturaDescartePropagacion')->name('LecturaDescartePropagacion');
    Route::post('/ConsultarBandeja', 'PropagacionController@ConsultarBandeja')->name('ConsultarBandeja');

    /*ARQUEO*/
    Route::get('/VistaLecturaArqueoPropagacion', 'PropagacionController@VistaLecturaArqueoPropagacion')->name('VistaLecturaArqueoPropagacion');
    Route::post('/LecturaArqueoProgpagacion', 'PropagacionController@LecturaArqueoProgpagacion')->name('LecturaArqueoProgpagacion');

    /*SALIDA*/
    Route::get('/VistaLecturaSalidaPropagacion', 'PropagacionController@VistaLecturaSalidaPropagacion')->name('VistaLecturaSalidaPropagacion')->middleware('permission:VistaLectSalidaPropagacion');
    Route::post('/LecturaSalidaDespachoPropagacion', 'PropagacionController@LecturaSalidaDespachoPropagacion')->name('LecturaSalidaDespachoPropagacion');
    Route::post('/PropagacionConfirmacionesSalidas', 'PropagacionController@ConfirmacionesSalidasPlot')->name('PropagacionConfirmacionesSalidas');

    /*CONFIRMACIONES PROPAGACIÓN*/
    Route::get('/ViewConfirmacionesPropagacion', 'PropagacionController@ViewConfirmacionesPropagacion')->name('ViewConfirmacionesPropagacion');
    Route::post('/ConsultarPlotConfiracion', 'PropagacionController@ConsultarPlotConfiracion')->name('ConsultarPlotConfiracion');
    Route::post('/GuardaConfirmacionesPropagacion', 'PropagacionController@GuardaConfirmacionesPropagacion')->name('GuardaConfirmacionesPropagacion');

    /*REPORTES*/
    Route::get('/VistaReportePropagacion', 'PropagacionController@VistaReportePropagacion')->name('VistaReportePropagacion')->middleware('permission:VistaReportesPropagacion');
    Route::get('/VistaEspacioPropagacion', 'PropagacionController@VistaEspacioPropagacion')->name('VistaEspacioPropagacion')->middleware('permission:VistaEspacioPropagacion');
    Route::get('/ExportarInventerioDiscriminado', 'PropagacionController@ExportInventarioTotal')->name('ExportInventarioTotal');
    Route::get('/ExportarInventerioAgrupado', 'PropagacionController@ExportInventarioAgrupado')->name('ExportInventarioAgrupado');
    Route::get('/ExportInventarioDescartado', 'PropagacionController@ExportInventarioDescartado')->name('ExportInventarioDescartado');
    Route::get('/ExportSalidasPlot', 'PropagacionController@ExportSalidasPlot')->name('ExportSalidasPlot');
    Route::post('/ReporteEntradaPropagacionEsta', 'PropagacionController@ReporteEntradaPropagacionEsta')->name('ReporteEntradaPropagacionEsta');
    Route::post('/ReporteSalidaPropagacionEsta', 'PropagacionController@ReporteSalidaPropagacionEsta')->name('ReporteSalidaPropagacionEsta');
    Route::post('/ReporteDescartesPropagacionEsta', 'PropagacionController@ReporteDescartesPropagacionEsta')->name('ReporteDescartesPropagacionEsta');
    Route::post('/ReporteDevolucionPropagacionEsta', 'PropagacionController@ReporteDevolucionPropagacionEsta')->name('ReporteDevolucionPropagacionEsta');
    Route::get('/CancelacionRenewall', 'PropagacionController@ViewCancelacionRenewall')->name('CancelacionRenewall')->middleware('permission:CancelacionRenewall');
    Route::post('/DetallesCajaCancelacionRenewall', 'PropagacionController@DetallesCajaCancelacionRenewall')->name('DetallesCajaCancelacionRenewall');
    Route::post('/CancelacionRenewall', 'PropagacionController@CancelacionRenewall')->name('CancelacionRenewall');
    Route::post('/ReporteAlistamientioPropagacionEsta', 'PropagacionController@ReporteAlistamientioPropagacionEsta')->name('ReporteAlistamientioPropagacionEsta');
    /*RENEWALL*/
    Route::get('/CargueInventarioRenewalProduccion', 'PropagacionController@CargueInventarioRenewalProduccion')->name('CargueInventarioRenewalProduccion')->middleware('permission:VistaEtiquetasPropagacion');;
    Route::get('/VistaUpdateEtiqueta', 'PropagacionController@VistaUpdateEtiqueta')->name('VistaUpdateEtiqueta')->middleware('permission:VistaUpdateEtiqueta');;
    Route::post('/LoadInventoryRenewall', 'PropagacionController@LoadInventoryRenewall')->name('LoadInventoryRenewall');
    Route::post('/GenerarEtiquetasRenewal', 'PropagacionController@GenerarEtiquetasRenewal')->name('GenerarEtiquetasRenewal');
    Route::post('/DetallesEtiqueta', 'PropagacionController@DetallesEtiqueta')->name('DetallesEtiqueta');
    Route::post('/UpdatePlotIdOrigen', 'PropagacionController@UpdatePlotIdOrigen')->name('UpdatePlotIdOrigen');
    Route::get('/VistaProgramasSemanalesRenewall', 'PropagacionController@VistaProgramasSemanalesRenewall')->name('VistaProgramasSemanalesRenewall')->middleware('permission:VistaProgramasSemanales');;
    Route::post('/LoadInventora', 'PropagacionController@LoadInventora')->name('LoadInventora');
    Route::post('/EspacioBancos', 'PropagacionController@EspacioBancos')->name('EspacioBancos');
    Route::get('/ReporteEntradaPropagacionDianmico/{FechaInicial}', 'PropagacionController@ReporteEntradaPropagacionDianmico')->name('ReporteEntradaPropagacionDianmico');

    Route::get('/VistaEtiRecursosHumanos/UsariossubMenuquetasNuevas', 'PropagacionController@VistaEtiquetasNuevas')->name('VistaEtiquetasNuevas');
    Route::get('/VistaTablasMaestrasPropagacion', 'PropagacionController@VistaTablasMaestrasPropagacion')->name('VistaTablasMaestrasPropagacion');
    Route::get('/Inactivar/{id}/CausalDescarte/Propagacion', 'PropagacionController@InactivarCausalDescarte')->name('InactivarCausalDescarte');
    Route::get('/Activar/{id}/CausalDescarte/Propagacion', 'PropagacionController@ActivarCausalDescarte')->name('ActivarCausalDescarte');
    Route::put('/ModificarCausalDescarte', 'PropagacionController@ModificarCausalDescarte')->name('ModificarCausalDescarte');
    Route::post('/CrearCausalDescarte', 'PropagacionController@CrearCausalDescarte')->name('CrearCausalDescarte');

    Route::put('/ModificarConfirmacion', 'PropagacionController@ModificarConfirmacion')->name('ModificarConfirmacion');
    Route::post('/CancelarConfirmacion', 'PropagacionController@CancelarConfirmacion')->name('CancelarConfirmacion');

    Route::post('/IniciarArqueo', 'PropagacionController@IniciarArqueo')->name('IniciarArqueo');

    Route::get('/Estadoplotidentrega', 'PropagacionController@Estadoplotidentrega')->name('Estadoplotidentrega');
    Route::get('/ExportConfirmacionesEntregadas', 'PropagacionController@ExportConfirmacionesEntregadas')->name('ExportConfirmacionesEntregadas');

    Route::get('/VistaEntregasNovedadesRenewall', 'PropagacionController@VistaEntregasNovedadesRenewall')->name('VistaEntregasNovedadesRenewall');//->middleware('VistaEntregasNovedades');
    Route::post('/newNovedadRenewall', 'PropagacionController@newNovedadRenewall')->name('newNovedadRenewall');//->middleware('VistaEntregasNovedades');


});

Route::group(['prefix' => 'Ventas/Pedidos'], function () {
    Route::get('/OrdenesPedidos', 'OrdenesPedidoLaboratorioController@OrdenesPedidosLaboratorio')->name('OrdenesPedidos')->middleware('permission:VerVistaOrdenesPedido');//vista para cargue inventario
    Route::get('/Orden/{id}/pedido/Detalle', 'OrdenesPedidoLaboratorioController@DetallesPedido')->name('OrdenPedidoDetalle');
    Route::post('/SimulacroCalcularPedido', 'OrdenesPedidoLaboratorioController@CantidadInventarioSimulacro')->name('SimulacroCalcularPedido');
    Route::post('/NewPedidoSolicitado', 'OrdenesPedidoLaboratorioController@NewPedidoSolicitado')->name('NewPedidoSolicitado');
    Route::post('/PlaneacionVariedad', 'OrdenesPedidoLaboratorioController@ViewPLaneacionVariedad')->name('PLaneacionVaridedad');
    Route::post('/CalcularPedido', 'OrdenesPedidoLaboratorioController@CalcularPedido')->name('CalcularPedido');
    Route::post('/GuardarCalculoPedido', 'OrdenesPedidoLaboratorioController@GuardarCalculoPedido')->name('GuardarCalculoPedido');
    Route::post('/NuevoitemPedido', 'OrdenesPedidoLaboratorioController@NuevoitemPedido')->name('NuevoitemPedido');
    Route::post('/NewVariedad', 'OrdenesPedidoLaboratorioController@NewVariedad')->name('NewVariedad');
    Route::post('/DeleteItem', 'OrdenesPedidoLaboratorioController@DeleteItem')->name('DeleteItem');
    Route::post('/updateItem', 'OrdenesPedidoLaboratorioController@updateItem')->name('updateItem');
    Route::get('/DetallesPedidoPreConfirmado/{id}/Detalle', 'OrdenesPedidoLaboratorioController@ViewPedidoConfirmado')->name('DetallesPedidoPreConfirmado');
    Route::post('/VistaDetallasProgramasSaberEjecutados', 'OrdenesPedidoLaboratorioController@VistaDetallasProgramasPlaneados')->name('VistaDetallasProgramasSaberEjecutados');

    Route::get('/Confirmar/{id},{idCabeza}/pedido/Detalle', 'OrdenesPedidoLaboratorioController@ConfirmacionItemPedidoPreConfirmado')->name('ConfirmacionItemPedidoPreConfirmado');
    Route::get('/Cancelar/{id},{idCabeza}/pedido/Detalle', 'OrdenesPedidoLaboratorioController@CancelacionItemPedidoPreConfirmado')->name('CancelacionItemPedidoPreConfirmado');

    Route::get('/PedidoAceptado/{id}/Detalle', 'OrdenesPedidoLaboratorioController@ViewPedidoAceptado')->name('ViewPedidoAceptado');
    Route::post('/DeleteItemPlaneado', 'OrdenesPedidoLaboratorioController@DeleteItemPlaneado')->name('DeleteItemPlaneado');

});

Route::group(['prefix' => 'Ventas/Simulador'], function () {
    Route::get('/SimuladorView', 'SimuladorPlaneacionController@SimuladorView')->name('SimuladorView')->middleware('permission:SimuladorView');//vista para cargue inventario
    Route::post('/ConsultaIntroduccionesFactor', 'SimuladorPlaneacionController@ConsultaIntroduccionesFactor')->name('ConsultaIntroduccionesFactor');
    Route::post('/CalcularSimulacionPedido', 'SimuladorPlaneacionController@CalcularSimulacionPedido')->name('CalcularSimulacionPedido');
    Route::post('/SimulacroCalcularPedido', 'SimuladorPlaneacionController@CantidadInventarioSimulacro')->name('SimulacroCalcularPedido');
    Route::post('/ProyeccionRegresion', 'SimuladorPlaneacionController@ProyeccionRegresion')->name('ProyeccionRegresion');
});

Route::group(['prefix' => 'Ventas/Reporte'], function () {
    Route::get('/ReporteConfirmacion', 'OrdenesPedidoLaboratorioController@ReporteConfirmacion')->name('ReporteConfirmacion');
    Route::get('/ReporteGeneralPedidos', 'OrdenesPedidoLaboratorioController@ReporteGeneralPedidos')->name('ReporteGeneralPedidos');
    Route::get('/ReportePlaneacionPedidos', 'OrdenesPedidoLaboratorioController@ReportePlaneacionPedidos')->name('ReportePlaneacionPedidos');

    Route::get('/ExportarReportePedido', 'OrdenesPedidoLaboratorioController@ExportarReportePedido')->name('ExportarReportePedido');

    Route::get('/ReporteEjecucionesSemanales', 'OrdenesPedidoLaboratorioController@vistaRepoteEjecucionesSemanales')->name('ReporteEjecucionesSemanales');
});

Route::group(['prefix' => 'Sistemas/Soporte'], function () {

    Route::get('/Tickets', 'SoporteSistemasController@ViewTickes')->name('ViewTickes');
    Route::post('/newTickets', 'SoporteSistemasController@newTickets')->name('newTickets');

    Route::get('/tickets/{id}/Cumplido', 'SoporteSistemasController@ticketsCumplido')->name('ticketsCumplido');

});

Route::group(['prefix' => 'Produccion'], function () {

    Route::get('/ReporteSiembrasConfirmadas', 'ProduccionController@ReporteSiembrasConfirmadas')->name('ReporteSiembrasConfirmadas')->middleware('permission:SubSubmenuReporteSiembrasConfirmadasurc');
    Route::get('/Viewcarguesiembrasurc', 'ProduccionController@Viewcarguesiembrasurc')->name('Viewcarguesiembrasurc');
    Route::post('/Carguesiembrasurc', 'ProduccionController@Carguesiembrasurc')->name('Carguesiembrasurc');

    Route::get('/ViewSiembrasProximasEntregas', 'ProduccionController@ViewSiembrasProximasEntregas')->name('ViewSiembrasProximasEntregas');
});


Route::group(['prefix' => 'Fitopatologia'], function () {
    Route::get('/ViewVirusFitopatogenos', 'FitopatologiaController@viewConsultarEtiquetas')->name('ViewVirusFitopatogenos');

    Route::get('/viewmuestraslaboratorio', 'FitopatologiaController@viewmuestraslaboratorio')->name('viewmuestraslaboratorio');
    Route::get('/Muestras/{Identificador}/Detalle', 'FitopatologiaController@viewmuestraslaboratorioDetallado')->name('viewmuestraslaboratorioDetallado');

    Route::get('/IndexPositivo/{id}/Resultado', 'FitopatologiaController@IndexPositivo')->name('IndexPositivo');
    Route::get('/IndexNegativo/{id}/Resultado', 'FitopatologiaController@IndexNegativo')->name('IndexNegativo');

    Route::POST('/ResultadoScreen', 'FitopatologiaController@ResultadoScreen')->name('ResultadoScreen');
    Route::POST('/SelectRestingidos', 'FitopatologiaController@SelectRestingidos')->name('SelectRestingidos');

    Route::POST('/ResultadoIndexMasivo', 'FitopatologiaController@ResultadoIndexMasivo')->name('ResultadoIndexMasivo');
    Route::POST('/ResultadoScreenMasivo', 'FitopatologiaController@ResultadoScreenMasivo')->name('ResultadoScreenMasivo');

});

Route::group(['prefix' => 'Monitoreo'], function () {
    Route::get('/ViewLecturaEntradaCuarto', 'MonitoreoController@VistaLecturaEntradaCuarto')->name('ViewLecturaEntradaCuarto');
    Route::post('/LecturaEntradaCuartoMonitoreo', 'MonitoreoController@DatosLecturaEntradaCuarto')->name('LecturaEntradaCuartoMonitoreo');

    Route::get('/ViewLecturaEntradaCuartoOperario', 'MonitoreoController@VistaControlEntradaMonitoreoOperario')->name('ViewLecturaEntradaCuartoOperario');
    Route::post('/LecturaEntradaCuartoOperario', 'MonitoreoController@DatosControlEntradaMonitoreoOperario')->name('LecturaEntradaCuartoOperario');

    Route::get('/ViewLecturaFinCuartoOperario', 'MonitoreoController@VistaControlFinMonitoreoOperario')->name('ViewLecturaFinCuartoOperario');
    Route::post('/LecturaFinCuartoOperario', 'MonitoreoController@DatosControlFinMonitoreoOperario')->name('LecturaFinCuartoOperario');

    Route::get('/ViewLecturaInicioMonitoreo', 'MonitoreoController@VistaLecturaInicioMonitoreo')->name('ViewLecturaInicioMonitoreo');
    Route::post('/LecturaInicioMonitoreo', 'MonitoreoController@DatosLecturaInicioMonitoreo')->name('LecturaInicioMonitoreo');

    Route::get('/ViewLecturaSalidaMonitoreo', 'MonitoreoController@VistaLecturaSalidaMonitoreo')->name('ViewLecturaSalidaMonitoreo');
    Route::post('/LecturaSalidaMonitoreo', 'MonitoreoController@DatosLecturaSalidaMonitoreo')->name('LecturaSalidaMonitoreo');

    Route::get('/ReportesMonitoreo', 'MonitoreoController@VistaReportesMonitoreos')->name('VistaReportesMonitoreos');
    Route::post('/ReporteEstandarMonitoreo', 'MonitoreoController@ReporteEstandarMonitoreo')->name('ReporteEstandarMonitoreo');
    Route::post('/ReporteRendimeintoMonitoreo', 'MonitoreoController@ReporteRendimeintoMonitoreo')->name('ReporteRendimeintoMonitoreo');
    Route::post('/ReporteEstandarMonitoreoDespacho', 'MonitoreoController@ReporteEstandarMonitoreoDespacho')->name('ReporteEstandarMonitoreoDespacho');

});

/*rutas reales*/
Route::get('/LecturaEntradaProduccionView', 'ProduccionController@LecturaEntradaProduccionView')->name('LecturaEntradaProduccionView');//Ruta que abre la vista lectura entrada produccion
Route::get('/LecturaSalidaRenewalProduccionView', 'ProduccionController@LecturaSalidaRenewalProduccionView')->name('LecturaSalidaRenewalProduccionView');//Ruta que abre la vista lectura entrada produccion
Route::get('/VistaEstadoCajasRenewal', 'ProduccionController@VistaEstadoCajasRenewal')->name('VistaEstadoCajasRenewal');//Ruta que abre la vista del reporte de renewal
Route::post('/ConsultaEstadoCajasDespachos', 'ProduccionController@ConsultaEstadoCajasDespachos')->name('ConsultaEstadoCajasDespachos');//ruta para reporte de renewal
Route::post('/LecturaEntradaCFProd', 'ProduccionController@LecturaEntradaCFProd')->name('LecturaEntradaCFProd');//ruta para guardar la lectura de los codigos de barras
Route::post('/LecturaSalidaRenewalCFProd', 'ProduccionController@LecturaSalidaRenewalCFProd')->name('LecturaSalidaRenewalCFProd');//ruta para guardar la lectura de los codigos de barras
Route::post('/ConsultaEstadoCajasRenewal', 'ProduccionController@ConsultaEstadoCajasRenewal')->name('ConsultaEstadoCajasRenewal');//ruta para reporte de renewal
Route::post('/ConsultaDetallesCajasRenewal', 'ProduccionController@ConsultaDetallesCajasRenewal')->name('ConsultaDetallesCajasRenewal');//ruta para reporte de renewal

/*rutas control cuarto PLAB B*/
Route::get('/VistaCargueEtiquetas', 'ProduccionController@VistaCargueEtiquetas')->name('VistaCargueEtiquetas');
Route::post('/LoadInventoryEtq', 'ProduccionController@LoadInventoryEtq')->name('LoadInventoryEtq');
Route::post('/Truncatetable', 'ProduccionController@Truncatetable')->name('Truncatetable');

/*lectura plan B cuarto frio*/
Route::get('/VistaLecturaEntradaCuarto', 'ProduccionController@VistaLecturaEntradaCuarto')->name('VistaLecturaEntradaCuarto');
Route::post('/LecturaEntradaCuarto', 'ProduccionController@LecturaEntradaCuarto')->name('LecturaEntradaCuarto');

Route::get('/VistaLecturaSalidaCuarto', 'ProduccionController@VistaLecturaSalidaCuarto')->name('VistaLecturaSalidaCuarto');
Route::post('/LecturaSalidaCuarto', 'ProduccionController@LecturaSalidaCuarto')->name('LecturaSalidaCuarto');

/*********************************  RUTAS DE LABORATORIO **************************************/
Route::post('/CreateCuarto', 'AdministracionCuartosController@CreateCuarto')->name('CreateCuarto');
Route::post('/CreateEstanteCuarto', 'AdministracionCuartosController@CreateEstanteCuarto')->name('CreateEstanteCuarto');
Route::post('/createNivelEstante', 'AdministracionCuartosController@createNivelEstante')->name('createNivelEstante');
Route::get('/GenerarEtiquetasInventario', 'GeneracionEtiquetasController@GenerarEtiquetasInventario')->name('GenerarEtiquetasInventario');
Route::get('/GenerarEtiquetasInventario1', 'GeneracionEtiquetasController@GenerarEtiquetasInventario1')->name('GenerarEtiquetasInventario1');
Route::get('/ConsultarEtiquetas', 'ConsultarEtiquetaController@viewConsultarEtiquetas')->name('ConsultarEtiquetas')->middleware('permission:Consulta');
Route::post('/CargarDatos', 'ConsultarEtiquetaController@cargardatos')->name('cargardatos');
Route::get('/ImprimirEtq', 'ConsultarEtiquetaController@ImprimirEtq')->name('ImprimirEtq');
Route::post('/ExisteOperario', 'EmpleadosController@ExisteOperario')->name('ExisteOperario');
Route::post('/ExisteOperario/Existe', 'EmpleadosController@ExisteOperarioLab')->name('ExisteOperarioLab');
/********************************* RUTAS DE USUARIOS SISTEMA **************************************/
Route::get('/MostrasUsuariosSistema', 'UsuariosController@TablaUsuarios')->name('MostrasUsuarios');
Route::post('/CreateUsers', 'UsuariosController@CreateUsers')->name('CreateUsers');
/********************************* RUTAS DE SELECT MULTIPLES **************************************/
Route::get('/Genero/{id}/Especie', 'PortafolioVariedadesContraller@SelectGenero')->name('Genero');
Route::get('/Cuarto/{id}/Cuarto', 'LecturaEntrada@SelectCuarto');
Route::get('/Estante/{id}/Estante', 'LecturaEntrada@SelectEstante');
Route::post('/LabCuatos', 'AdministracionCuartosController@Cuartos')->name('LabCuatos');
Route::get('/CuartoEtiquetas/{id}/Cuarto', 'GeneracionEtiquetasController@SelectCuarto');
Route::get('/EstanteEtiquetas/{id}/Estante', 'GeneracionEtiquetasController@SelectEstante');
Route::get('/Cama/{id}/Cama', 'InvernaderoController@SelectValvula');
Route::get('/Banco/{id}/Banco', 'InvernaderoController@SelectBanco');

Route::get('/ch', function () {

   /* $SemanaCicloFinal = ModelCalculoSemanasPlaneacion::query()
        ->select('AnoYSemana', 'Consecutivo')
        ->where('AnoYSemana', 202149)
        ->first();
    $semanaInicio = 202129;
    $SemanaFin = $SemanaCicloFinal->AnoYSemana;
    $NumConsecutivo = $SemanaCicloFinal->Consecutivo;
    $SemanaCalculo = '';
    $Factor = 1.5;
    $plantas = 4554;
    $PlantasCalculo = $plantas;
    $resta = 4;
    $fecha ='';

    while ($SemanaFin >= $semanaInicio) {
        $array = array('Semana' => $fecha, 'Plantas' => $PlantasCalculo);
        print_r('Semana-> '.$SemanaFin . ' plantas-> '. $PlantasCalculo."\n");
        $dato = ModelCalculoSemanasPlaneacion::query()
            ->select('AnoYSemana', 'Consecutivo')
            ->where('Consecutivo', '=', $NumConsecutivo)
            ->first();
        $NumConsecutivo = $NumConsecutivo - $resta;
        $plantas = ceil($plantas) / $Factor;
        $PlantasCalculo = ceil($plantas);
        $fecha = ModelCalculoSemanasPlaneacion::query()
            ->select('AnoYSemana')
            ->where('Consecutivo', $NumConsecutivo)
            ->first();
        $Inicial = substr($fecha, 15,6);
        $SemanaFin = $Inicial;
    }
    echo $SemanaFin;*/
});
