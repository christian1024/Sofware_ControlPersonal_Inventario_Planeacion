<?php

use App\Model\ModelLabTipoMedios;
use App\User;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NovedadesYajustes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::query()->create(['name' => 'Menu de PlanB cargue Etiquetas', 'slug' => 'SubmenuPlanB', 'description' => 'Menu de PlanB cargue Etiquetas']);
        Permission::query()->create(['name' => 'Sub menu PlanB cargue Etiquetas', 'slug' => 'SubSubmenuCarguePlanB', 'description' => 'Sub menu PlanB cargue Etiquetas']);
        Permission::query()->create(['name' => 'Sub menu reportes monitoreo', 'slug' => 'submenuReportesMonitoreo', 'description' => 'Sub menu reportes monitoreo']);
        /*ModelLabTipoMedios::query()->create(['TipoMedio' => 'IN-03', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'LT-0', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'PT-0', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'PTS-0', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'BG-0', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'XML-025', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'XM-005', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'XM-01', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'XM-02', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'XM-05', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'XM-08', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'XM-2', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'XME-01', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'XMS-01', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'ERL-025', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'ER-04', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'ER-01', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'ER-025', 'Flag_Activo' => 1 ]);
        ModelLabTipoMedios::query()->create(['TipoMedio' => 'ERX-01', 'Flag_Activo' => 1 ]);

        Permission::query()->create(['name' => 'Tab Tipos de medios', 'slug' => 'VistaTabMedios', 'description' => 'Tab Tipos de medios']);
        Permission::query()->create(['name' => 'Tabla de Medios', 'slug' => 'VerTablaMedios', 'description' => 'Tabla de Medios']);

        DB::table('permission_user')->insert(['permission_id' => 198, 'user_id' => 4]);
        DB::table('permission_user')->insert(['permission_id' => 199, 'user_id' => 4]);*/

        /*User::query()->create([
            'id_Empleado' => 1519,
            'username' => 'Lmonrey',
            'email' => 'Lmonrey@darwnperennials.com',
            'password' => Hash::make('Lmonrey2021*'),
        ]);

        DB::table('permission_user')->insert(['permission_id' => 184, 'user_id' => 49]);
        DB::table('permission_user')->insert(['permission_id' => 185, 'user_id' => 49]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 49]);*/

        //ModelPlotsDesmarque::query()->create(['name' => 'Sub Submenu y vista Siembras Confirmadas urc', 'slug' => 'NewNovedad', 'description' => 'Sub Submenu y vista Siembras Confirmadas urc']);

        /*
         *
         * DB::table('permission_user')->insert(['permission_id' => 4, 'user_id' => 44]);
         *
        User::query()->create([

             'id_Empleado' => 1021,
             'username' => 'Favila',
             'email' => 'favila@darwnperennials.com',
             'password' => Hash::make('Favila2021.*'),
         ]);

         User::query()->create([
             'id_Empleado' => 926,
             'username' => 'Ainfante',
             'email' => 'Ainfante@darwnperennials.com',
             'password' => Hash::make('Ainfante2021*.'),
         ]);

         User::query()->create([
             'id_Empleado' => 73,
             'username' => 'Lgomez',
             'email' => 'Lgomez@darwnperennials.com',
             'password' => Hash::make('Lgomez.2021*.'),
         ]);

         User::query()->create([
             'id_Empleado' => 705,
             'username' => 'Dprieto',
             'email' => 'Dprieto@darwnperennials.com',
             'password' => Hash::make('Dprieto2021*.*'),
         ]);

         User::query()->create([
             'id_Empleado' => 1519,
             'username' => 'Frodriguez',
             'email' => 'frodriguez@darwnperennials.com',
             'password' => Hash::make('Frodriguez2021*.'),
         ]);

         User::query()->create([
             'id_Empleado' => 1938,
             'username' => 'Fquin',
             'email' => 'Fquin@ballhort.com',
             'password' => Hash::make('Fquin2021*'),
         ]);*/
        /*DB::table('permission_user')->insert(['permission_id' => 184, 'user_id' => 33]);
        DB::table('permission_user')->insert(['permission_id' => 185, 'user_id' => 33]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 33]);

        DB::table('permission_user')->insert(['permission_id' => 184, 'user_id' => 35]);
        DB::table('permission_user')->insert(['permission_id' => 185, 'user_id' => 35]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 35]);

        DB::table('permission_user')->insert(['permission_id' => 184, 'user_id' => 36]);
        DB::table('permission_user')->insert(['permission_id' => 185, 'user_id' => 36]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 36]);

        DB::table('permission_user')->insert(['permission_id' => 184, 'user_id' => 37]);
        DB::table('permission_user')->insert(['permission_id' => 185, 'user_id' => 37]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 37]);

        DB::table('permission_user')->insert(['permission_id' => 184, 'user_id' => 38]);
        DB::table('permission_user')->insert(['permission_id' => 184, 'user_id' => 38]);
        DB::table('permission_user')->insert(['permission_id' => 185, 'user_id' => 38]);

        DB::table('permission_user')->insert(['permission_id' => 185, 'user_id' => 39]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 39]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 39]);

        DB::table('permission_user')->insert(['permission_id' => 185, 'user_id' => 40]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 40]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 40]);

        DB::table('permission_user')->insert(['permission_id' => 185, 'user_id' => 41]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 41]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 41]);

        DB::table('permission_user')->insert(['permission_id' => 185, 'user_id' => 42]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 42]);
        DB::table('permission_user')->insert(['permission_id' => 186, 'user_id' => 42]);*/

        /*        Permission::query()->create(['name' => 'btn Solicitado Planeacion', 'slug' => 'InformacionTecnicaurc', 'description' => 'btn Solicitado Planeacion']);
                Permission::query()->create(['name' => 'btn Preconfirmado Planeacion', 'slug' => 'btnPreconfirmadoPlaneacion', 'description' => 'btn Preconfirmado Planeacion']);
                Permission::query()->create(['name' => 'btn Aceptado Planeacion', 'slug' => 'btnAceptadoPlaneacion', 'description' => 'btn Aceptado Planeacion']);
                Permission::query()->create(['name' => 'btn Cancelado Planeacion', 'slug' => 'btnCanceladoPlaneacion', 'description' => 'btn Cancelado Planeacion']);
                Permission::query()->create(['name' => 'CrearPedido', 'slug' => 'VerGenerarPedido', 'description' => 'CrearPedido']);
                Permission::query()->create(['name' => 'Lista Programas Planeacion', 'slug' => 'ListProgramasPlaneacion', 'description' => 'Lista Programas Planeacion']);
                Permission::query()->create(['name' => 'Realizar Planeacion', 'slug' => 'RealizarPlaneacion', 'description' => 'Realizar Planeacion']);
                Permission::query()->create(['name' => 'Cancelar Item Pedido', 'slug' => 'CancelarItemPedido', 'description' => 'Cancelar Item Pedido']);
                Permission::query()->create(['name' => 'Modificar Item Pedido', 'slug' => 'ModificarItemPedido', 'description' => 'Modificar Item Pedido']);
                Permission::query()->create(['name' => 'Nuevo Item Pedido', 'slug' => 'NuevoItemPedido', 'description' => 'Nuevo Item Pedido']);
                Permission::query()->create(['name' => 'Cancelacion Item Planeado', 'slug' => 'CancelacionItemPlaneado', 'description' => 'Cancelacion Item Planeado']);
                Permission::query()->create(['name' => 'Confirmacion Item Planeado', 'slug' => 'ConfirmacionItemPlaneado', 'description' => 'Confirmacion Item Planeado']);
                Permission::query()->create(['name' => 'btn Cancelar Pedido Planeado', 'slug' => 'btnCancelarPedidoPlaneado', 'description' => 'btn Cancelar Pedido Planeado']);

                Permission::query()->create(['name' => 'sub Menu ReportePedidos', 'slug' => 'subMenuReportePedidos', 'description' => 'sub Menu ReportePedidos']);
                Permission::query()->create(['name' => 'vista Reporte Confirmacion', 'slug' => 'ReporteConfirmacion', 'description' => 'Modulo Reporte Confirmacion']);
                Permission::query()->create(['name' => 'vista Reporte General Pedidos', 'slug' => 'ReporteGeneralPedidos', 'description' => 'Modulo Reporte General Pedidos']);
                Permission::query()->create(['name' => 'Vista Reporte Planeacion Pedidos', 'slug' => 'ReportePlaneacionPedidos', 'description' => 'Modulo Reporte Planeacion Pedidos']);

                Permission::query()->create(['name' => 'Vista Arqueo Propagacion', 'slug' => 'VistaLectArqueoPropagacion', 'description' => 'Vista Arqueo Propagacion']);
                Permission::query()->create(['name' => 'Vista Confirmaciones propagacion', 'slug' => 'ViewConfirmacionesPropagacion', 'description' => 'Vista Confirmaciones propagacion']);


                DB::table('permission_user')->insert(['permission_id' => 165, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 166, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 167, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 168, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 169, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 170, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 171, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 177, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 178, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 179, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 180, 'user_id' => 4]);
                DB::table('permission_user')->insert(['permission_id' => 181, 'user_id' => 4]);

                DB::table('permission_user')->insert(['permission_id' => 5, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 12, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 60, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 62, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 165, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 166, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 167, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 168, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 169, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 62, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 172, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 173, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 174, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 175, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 176, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 178, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 179, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 180, 'user_id' => 30]);
                DB::table('permission_user')->insert(['permission_id' => 181, 'user_id' => 30]);*/


        /*Permission::query()->create(['name' => 'Sub menu PLan B', 'slug' => 'SubmenuPlanB', 'description' => 'Sub menu PLan B']);
        Permission::query()->create(['name' => 'Sub menu cargue PLan B', 'slug' => 'SubSubmenuCarguePlanB', 'description' => 'Sub menu cargue PLan B']);

        Permission::query()->create(['name' => 'Sub menu lectura entrada PLan B', 'slug' => 'SubSubmenuLecturaEntradaPlanB', 'description' => 'Sub menu lectura entrada PLan B']);
        Permission::query()->create(['name' => 'Sub menu lectura salida PLan B', 'slug' => 'SubSubmenuLecturasalidaPlanB', 'description' => 'Sub menu lectura salida PLan B']);*/


        /* TipoCancelacionRenewalModel::query()->create(['TipoCancelacion' => 'QUEMAZÓN FOLIAR', 'Flag_Activo' => 1]);
         TipoCancelacionRenewalModel::query()->create(['TipoCancelacion' => 'PATA LARGA', 'Flag_Activo' => 1]);
         TipoCancelacionRenewalModel::query()->create(['TipoCancelacion' => 'MALTRATO', 'Flag_Activo' => 1]);

         Permission::query()->create(['name' => 'Sub menu Cancelacion Renewal', 'slug' => 'CancelacionRenewall', 'description' => 'Sub menu de Cancelacion del renewal']);

         DB::table('permission_user')->insert([
             ['permission_id' => 156, 'user_id' => 27],
         ]);*/


        /*URCPropagacionModel::query()->create(['Ubicacion' => '13-1-1', 'CapacidadBandejas' => '208', 'CapacidadEsquejes' => '14976', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-2', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-3', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-4', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-5', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-6', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-7', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-8', 'CapacidadBandejas' => '116', 'CapacidadEsquejes' => '8352', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-9', 'CapacidadBandejas' => '116', 'CapacidadEsquejes' => '8352', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-10', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-11', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-12', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-13', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-14', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-15', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-16', 'CapacidadBandejas' => '232', 'CapacidadEsquejes' => '16704', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-17', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-18', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-19', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-20', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-21', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-22', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-23', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-24', 'CapacidadBandejas' => '133', 'CapacidadEsquejes' => '9576', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-25', 'CapacidadBandejas' => '133', 'CapacidadEsquejes' => '9576', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-26', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-27', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-28', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-29', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-30', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-31', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);
        URCPropagacionModel::query()->create(['Ubicacion' => '13-1-32', 'CapacidadBandejas' => '266', 'CapacidadEsquejes' => '19152', 'Flag_Activo' => 1]);

        URCTipoSalidaModel::query()->create(['TipoSalida' => 'DESPACHO']);
        URCTipoSalidaModel::query()->create(['TipoSalida' => 'SALIDA']);

        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'BOTRYTIS', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'VIRUS', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'RAIZ', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'QUEMAZON FOLIAR', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'POSIBLE MEZCLA', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'PSEUDOMONAS', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'SCLEROTINIA', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'BANDEJA INCOMPLETA', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'CANCELACION CLIENTE', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'BANDEJA EN 0', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'SOBRANTE', 'Flag_Activo' => 1]);
        URCCausalSalidaModel::query()->create(['CausalSalidas' => 'ALISTAMIENTO', 'Flag_Activo' => 1]);

        Permission::query()->create(['name' => 'Menu Propagacion', 'slug' => 'MenuPropagacion', 'description' => 'Menu cumpleto de propagacion']);
        Permission::query()->create(['name' => 'Sub menu Propagacion Movimientos', 'slug' => 'SubMenuMovimintosPropagacion', 'description' => 'Sub menu de movimientos dentro de propagacion']);

        Permission::query()->create(['name' => 'Lectura de entrada Propagacion', 'slug' => 'GenerarEtiquetaNuevaPropagacion', 'description' => 'Lectura de entrada Propagacion']);
        Permission::query()->create(['name' => 'Lectura de Traslado Propagacion', 'slug' => 'VistaLectTrasladoPropagacion', 'description' => 'Lectura de traslado Propagacion']);
        Permission::query()->create(['name' => 'Lectura de Descarte Propagacion', 'slug' => 'VistaLectDescartePropagacion', 'description' => 'Lectura de Descartes Propagacion']);
        Permission::query()->create(['name' => 'Lectura de Salida Propagacion', 'slug' => 'VistaLectSalidaPropagacion', 'description' => 'Lectura de Salidas Propagacion']);

        Permission::query()->create(['name' => 'Vista Generacion Etiquetas Renewall', 'slug' => 'VistaEtiquetasPropagacion', 'description' => 'Vista final de cargue y generacion etiquetas Renewall']);

        Permission::query()->create(['name' => 'Sub menu Propagacion Reportes', 'slug' => 'SubMenuReportesPropagacion', 'description' => 'sub menu de reportes dentro menu de propagacion']);
        Permission::query()->create(['name' => 'Vista Reportes Propagacion', 'slug' => 'VistaReportesPropagacion', 'description' => 'Vista final de reportes de propagacion']);
        Permission::query()->create(['name' => 'Vista Espacio Propagacion', 'slug' => 'VistaEspacioPropagacion', 'description' => 'vista final de espacio en propagacion']);
        Permission::query()->create(['name' => 'Vista Modificar PlotIdOrigen', 'slug' => 'VistaUpdateEtiqueta', 'description' => 'Vista final Modificar plotId origen y procedencia']);
        Permission::query()->create(['name' => 'Vista Cargue Programas Propagacion', 'slug' => 'VistaProgramasSemanales', 'description' => 'Vista Cargue Programas comparacion cargue existente']);

        Permission::query()->create(['name' => 'SubmenuParametrizacionProd', 'slug' => 'SubmenuParametrizacionProd', 'description' => 'Sub Menu Parametrizacion Prod']);
        Permission::query()->create(['name' => 'SubSubmenuTiposDePiezaProd', 'slug' => 'SubSubmenuTiposDePiezaProd', 'description' => 'Sub Sub Menu Tipos De Pieza']);
        Permission::query()->create(['name' => 'SubSubmenuInformacionTecnicaProd', 'slug' => 'SubSubmenuInformacionTecnicaProd', 'description' => 'Sub Sub Menu Informacion Tecnica']);
        Permission::query()->create(['name' => 'SubmenuInventarioProd', 'slug' => 'SubmenuInventarioProd', 'description' => 'Sub menu Inventario Prod']);
        Permission::query()->create(['name' => 'SubSubmenuCargueInventarioProd', 'slug' => 'SubSubmenuCargueInventarioProd', 'description' => 'Sub Sub menu Cargue Inventario']);
        Permission::query()->create(['name' => 'SubSubmenuCargueRenewalProd', 'slug' => 'SubSubmenuCargueRenewalProd', 'description' => 'Sub Sub menu Cargue Renewal']);
        Permission::query()->create(['name' => 'SubmenuVentasProd', 'slug' => 'SubmenuVentasProd', 'description' => 'Sub menu Ventas']);
        Permission::query()->create(['name' => 'SubSubmenuCarguePedidosProd', 'slug' => 'SubSubmenuCarguePedidosProd', 'description' => 'Sub Sub Menu Cargue Pedidos']);
        Permission::query()->create(['name' => 'SubSubmenuAdicionalesProd', 'slug' => 'SubSubmenuAdicionalesProd', 'description' => 'Sub Sub Menu Adicionales']);
        Permission::query()->create(['name' => 'SubmenuDespachosProd', 'slug' => 'SubmenuDespachosProd', 'description' => 'Sub Menu Despachos']);
        Permission::query()->create(['name' => 'SubSubmenuVistaNegativosVentasProd', 'slug' => 'SubSubmenuVistaNegativosVentasProd', 'description' => 'Sub Sub Menu Vista Negativos Ventas']);
        Permission::query()->create(['name' => 'SubSubmenuAsignacionDespachosProd', 'slug' => 'SubSubmenuAsignacionDespachosProd', 'description' => 'Sub Sub Menu Asignacion Despachos']);
        Permission::query()->create(['name' => 'SubSubmenuLecturaEntradaProd', 'slug' => 'SubSubmenuLecturaEntradaProd', 'description' => 'Sub Sub Menu Lectura Entrada Prod']);
        Permission::query()->create(['name' => 'SubSubmenuLecturaSalidaProd', 'slug' => 'SubSubmenuLecturaSalidaProd', 'description' => 'Sub Sub Menu Lectura Salida Prod']);
        Permission::query()->create(['name' => 'SubmenuReportesProd', 'slug' => 'SubmenuReportesProd', 'description' => 'Sub Menu Reportes Prod']);
        Permission::query()->create(['name' => 'SubSubmenuVentasInventarioProd', 'slug' => 'SubSubmenuVentasInventarioProd', 'description' => 'Sub Sub Menu Ventas Inventario']);
        Permission::query()->create(['name' => 'SubSubmenuReporteEntradaProd', 'slug' => 'SubSubmenuReporteEntradaProd', 'description' => 'Sub Sub Menu Reporte Entrada Prod']);
        Permission::query()->create(['name' => 'SubSubmenuReporteSalidaProd', 'slug' => 'SubSubmenuReporteSalidaProd', 'description' => 'Sub Sub Menu Reporte Salida Prod']);
        Permission::query()->create(['name' => 'menuRevision', 'slug' => 'menuRevision', 'description' => 'Menu Monitoreo']);
        Permission::query()->create(['name' => 'SubmenuInventarioRevision', 'slug' => 'SubmenuInventarioRevision', 'description' => 'Sub Menu Inventario Monitoreo']);
        Permission::query()->create(['name' => 'SubSubmenuCargueInventarioRevision', 'slug' => 'SubSubmenuCargueInventarioRevision', 'description' => 'Sub Sub Menu Cargue Inventario Monitoreo']);
        Permission::query()->create(['name' => 'SubmenuMoviInventarioRevision', 'slug' => 'SubmenuMoviInventarioRevision', 'description' => 'Sub Menu Movimientos Inventario Monitoreo']);
        Permission::query()->create(['name' => 'SubSubmenuLecturaEntradaRevision', 'slug' => 'SubSubmenuLecturaEntradaRevision', 'description' => 'Sub Sub Menu Lectura Entrada Monitoreo']);
        Permission::query()->create(['name' => 'SubSubmenuLecturaSalidaRevision', 'slug' => 'SubSubmenuLecturaSalidaRevision', 'description' => 'Sub Sub Menu Lectura Salida Monitoreo']);
        Permission::query()->create(['name' => 'SubmenuReportesRevision', 'slug' => 'SubmenuReportesRevision', 'description' => 'Sub Menu Reportes Monitoreo']);
        Permission::query()->create(['name' => 'SubSubmenuReportesRevision', 'slug' => 'SubSubmenuReportesRevision', 'description' => 'Sub Sub menu Reportes Monitoreo']);
        Permission::query()->create(['name' => 'SubSubmenuLecturaSalidaRenewalProd', 'slug' => 'SubSubmenuLecturaSalidaRenewalProd', 'description' => 'Sub Sub Menu Lectura Salida Renewal Prod']);

        Permission::query()->create(['name' => 'Lectura alistamiento Propapagacion', 'slug' => 'VistaLecturaAlistamientoPropagacion', 'description' => 'Vista LEectura alistamiento Propapagacion']);
        Permission::query()->create(['name' => 'Lectura Devoluciones Propapagacion', 'slug' => 'VistaLecturaDevolucionPropagacion', 'description' => 'Vista Lectura Devoluciones Propapagacion']);


        User::query()->create([
            'id_Empleado' => 1402,
            'username' => 'lpatino',
            'email' => 'lpatino@darwinperennials.com',
            'password' => Hash::make('Lpatino2020*'),
        ]);
        User::query()->create([
            'id_Empleado' => 1197,
            'username' => 'jjuyo',
            'email' => 'jjuyo@darwinperennials.com',
            'password' => Hash::make('Jjuyo2020*'),
        ]);

        User::query()->create([
            'id_Empleado' => 1917,
            'username' => 'CDavid',
            'email' => 'PatinadorPropagacion@darwinperennials.com',
            'password' => Hash::make('CDavid2020*'),
        ]);

        User::query()->create([
            'id_Empleado' => 1904,
            'username' => 'CBeltran',
            'email' => 'coordinadorCuartoFrios@darwinperennials.com',
            'password' => Hash::make('CBeltran2020.*'),
        ]);

        User::query()->create([
            'id_Empleado' => 452,
            'username' => 'APaez',
            'email' => 'APaez@darwinperennials.com',
            'password' => Hash::make('APaez2020*.'),
        ]);

        User::query()->create([
            'id_Empleado' => 57,
            'username' => 'CBarrera',
            'email' => 'CBarrera@darwinperennials.com',
            'password' => Hash::make('CBarrera2020.*.'),
        ]);

        User::query()->create([
            'id_Empleado' => 1616,
            'username' => 'LBarrera',
            'email' => 'LBarrera@darwinperennials.com',
            'password' => Hash::make('LBarrera2020.*'),
        ]);


        DB::table('permission_user')->insert([
            ['permission_id' => 114, 'user_id' => 23],
            ['permission_id' => 115, 'user_id' => 23],
            ['permission_id' => 116, 'user_id' => 23],
            ['permission_id' => 117, 'user_id' => 23],
            ['permission_id' => 118, 'user_id' => 23],
            ['permission_id' => 119, 'user_id' => 23],
            ['permission_id' => 153, 'user_id' => 23],
            ['permission_id' => 154, 'user_id' => 23],
        ]);

        DB::table('permission_user')->insert([
            ['permission_id' => 114, 'user_id' => 21],
            ['permission_id' => 115, 'user_id' => 21],
            ['permission_id' => 120, 'user_id' => 21],
            ['permission_id' => 121, 'user_id' => 21],
            ['permission_id' => 122, 'user_id' => 21],
            ['permission_id' => 123, 'user_id' => 21],
            ['permission_id' => 124, 'user_id' => 21]
        ]);

        DB::table('permission_user')->insert([
            ['permission_id' => 114, 'user_id' => 22],
            ['permission_id' => 115, 'user_id' => 22],
            ['permission_id' => 121, 'user_id' => 22],
            ['permission_id' => 122, 'user_id' => 22],
            ['permission_id' => 123, 'user_id' => 22],
            ['permission_id' => 125, 'user_id' => 22],
        ]);


        DB::table('permission_user')->insert([
            ['permission_id' => 4, 'user_id' => 24],
            ['permission_id' => 144, 'user_id' => 24],
            ['permission_id' => 135, 'user_id' => 24],
            ['permission_id' => 147, 'user_id' => 24],
            ['permission_id' => 150, 'user_id' => 24],
            ['permission_id' => 138, 'user_id' => 24],
            ['permission_id' => 148, 'user_id' => 24],
            ['permission_id' => 139, 'user_id' => 24],
            ['permission_id' => 152, 'user_id' => 24],
            ['permission_id' => 149, 'user_id' => 24],
            ['permission_id' => 151, 'user_id' => 24],


            ['permission_id' => 4, 'user_id' => 25],
            ['permission_id' => 144, 'user_id' => 25],
            ['permission_id' => 135, 'user_id' => 25],
            ['permission_id' => 129, 'user_id' => 25],
            ['permission_id' => 145, 'user_id' => 25],
            ['permission_id' => 126, 'user_id' => 25],
            ['permission_id' => 150, 'user_id' => 25],
            ['permission_id' => 132, 'user_id' => 25],
            ['permission_id' => 134, 'user_id' => 25],
            ['permission_id' => 137, 'user_id' => 25],
            ['permission_id' => 130, 'user_id' => 25],
            ['permission_id' => 146, 'user_id' => 25],
            ['permission_id' => 133, 'user_id' => 25],
            ['permission_id' => 128, 'user_id' => 25],
            ['permission_id' => 139, 'user_id' => 25],
            ['permission_id' => 151, 'user_id' => 25],
            ['permission_id' => 127, 'user_id' => 25],
            ['permission_id' => 136, 'user_id' => 25],
            ['permission_id' => 4, 'user_id' => 26],
            ['permission_id' => 144, 'user_id' => 26],
            ['permission_id' => 135, 'user_id' => 26],
            ['permission_id' => 129, 'user_id' => 26],
            ['permission_id' => 145, 'user_id' => 26],
            ['permission_id' => 126, 'user_id' => 26],
            ['permission_id' => 150, 'user_id' => 26],
            ['permission_id' => 132, 'user_id' => 26],
            ['permission_id' => 134, 'user_id' => 26],
            ['permission_id' => 137, 'user_id' => 26],
            ['permission_id' => 130, 'user_id' => 26],
            ['permission_id' => 146, 'user_id' => 26],
            ['permission_id' => 133, 'user_id' => 26],
            ['permission_id' => 128, 'user_id' => 26],
            ['permission_id' => 138, 'user_id' => 26],
            ['permission_id' => 139, 'user_id' => 26],
            ['permission_id' => 151, 'user_id' => 26],
            ['permission_id' => 127, 'user_id' => 26],
            ['permission_id' => 136, 'user_id' => 26],

            ['permission_id' => 114, 'user_id' => 27],
            ['permission_id' => 121, 'user_id' => 27],
            ['permission_id' => 122, 'user_id' => 27],
            ['permission_id' => 123, 'user_id' => 27],


        ]);*/
    }
}

