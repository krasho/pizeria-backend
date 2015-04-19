<?php
ini_set("display_errors",1);
error_reporting(-1);
class SiteController extends Controller
{
    public function actionIndex()
    {
        $this->render("index");

    }

    public function actionBuscarCientexTelefono()
    {
        $datos['cliente']['telefono']         = "9992254373";
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        $this->curl(Yii::app()->params['pagina'], 'cliente/buscarPorTelefono', $datos);
    }

    public function actionBuscarUltimoPedido()
    {
        $datos['cliente']['id']         = "1";
        $datos['usuario']               = Yii::app()->params['usuario'];
        $datos['password']              = Yii::app()->params['password'];


        $this->curl(Yii::app()->params['pagina'], 'cliente/buscarUltimoPedido', $datos);
    }


    public function actionBuscarProductosMasPedidos()
    {
        $datos['cliente']['id']         = "1";
        $datos['cliente']['cantidad']   = "";
        $datos['usuario']               = Yii::app()->params['usuario'];
        $datos['password']              = Yii::app()->params['password'];


        $this->curl(Yii::app()->params['pagina'], 'cliente/buscarProductosMasPedidos', $datos);
    }

    public function actionMarcarPedidoUrgente()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['pedido']['id']     = 161;

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/urgente', $datos);
    }

    public function actionDesmarcarPedidoUrgente()
    {
            $datos['usuario']          = Yii::app()->params['usuario'];
            $datos['password']         = Yii::app()->params['password'];
            $datos['pedido']['id']     = 161;

            echo $this->curl(Yii::app()->params['pagina'], 'pedido/desmarcarUrgente', $datos);
    }

    public function actionEntregarPedidos()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['pedido']['fecha']  = '';

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/entregar', $datos);
    }


    public function actionAsignarPedidos()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['entrega']['id_pedido']    = 163;
        $datos['entrega']['id_empleado']  = 1;
        $datos['entrega']['fecha_entrega_salida']    = date('Y/m/d');
        $datos['entrega']['hora_entrega_salida']     = date('H:m:s');

        echo $this->curl(Yii::app()->params['pagina'], 'entrega/insertar', $datos);
    }

    public function actionBuscarPedidosEnReparto()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['pedido']['sucursales'] = array(1);

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/enReparto', $datos);
    }


    public function actionConfirmarPedidos()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['entrega']['id_pedido']    = 163;
        $datos['entrega']['fecha_entrega_regreso']    = date('Y/m/d');
        $datos['entrega']['hora_entrega_regreso']     = date('H:m:s');
        $datos['entrega']['entregado']                = 1;
        $datos['entrega']['observaciones']            = "Puse este mensaje para probar, sólo se llena si entregado es 0";

        echo $this->curl(Yii::app()->params['pagina'], 'entrega/regreso', $datos);
    }

    public function actionInsertarCliente()
    {

        $datos['cliente']['nombre']           = "RODOLFO";
        $datos['cliente']['telefono']         = "9831340375";
        $datos['cliente']['id_tipo_telefono'] = 1;
        $datos['cliente']['id_sucursal']      = 1;
        $datos['cliente']['correo']           = "rbaezam@hotmail.com";

        $datos['cliente']['direcciones']          = array(

            array(
                "Id" => 0,
                "calle" => "Ble",
                "numero_ext" => "Ble",
                "colonia" => "Ble",
                "referencia" => 'Ble'
            ),
            array(
                "Id" => 0,
                "calle" => "Ble1",
                "numero_ext" => "Ble1",
                "colonia" => "Ble1",
                "referencia" => 'Ble1'
            ),

        );
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $this->curl(Yii::app()->params['pagina'], 'cliente/insertar', $datos);
    }

    public function actionActualizarCliente()
    {

        $datos['cliente']['nombre']           = "RODOLFOoooo";
        $datos['cliente']['telefono']         = "9831340375";
        $datos['cliente']['id_tipo_telefono'] = 1;
        $datos['cliente']['id_sucursal']      = 2;
        $datos['cliente']['rfc']              = 'RBAC';
        $datos['cliente']['id']               = 80;
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        $datos['cliente']['direcciones']          = array(

            array(
                "Id" => 0,
                "calle" => "Bla",
                "numero_ext" => "Bla",
                "colonia" => "Bla",
                "referencia" => 'Bla'
            ),
            array(
                "Id" => 0,
                "calle" => "Bla1",
                "numero_ext" => "Bla1",
                "colonia" => "Bla1",
                "referencia" => 'Bla1'
            ),

        );

        $this->curl(Yii::app()->params['pagina'], 'cliente/actualizar', $datos);

    }

    public function actionEliminarCliente()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['id']               = 5;

        echo $this->curl(Yii::app()->params['pagina'], 'cliente/eliminar', $datos);
    }

    public function actionAgregarDomicilioCliente()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['cliente']['id']               = 5;
        $datos['cliente']['calle']            = 'Calle calamar';
        $datos['cliente']['num_ext']          = '222';
        $datos['cliente']['colonia']          = 'siaankan';
        $datos['cliente']['referencia']       = 'Carro blanco';

        echo $this->curl(Yii::app()->params['pagina'], 'cliente/agregarDomicilio', $datos);
    }

    public function actionEliminarDomicilioCliente()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['cliente']['id']    = 1;

        echo $this->curl(Yii::app()->params['pagina'], 'cliente/eliminarDomicilio', $datos);
    }

    public function actionObtenerDomiciliosCliente()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['cliente']['id']    = 5;

        echo $this->curl(Yii::app()->params['pagina'], 'cliente/obtenerDomicilios', $datos);
    }


    public function actionBuscarPedido()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['pedido']['sucursales']          = array();
        $datos['pedido']['pedidos']             = array(214);
        $datos['pedido']['clientes']            = array();
        $datos['pedido']['estatus']             = array();
        $datos['pedido']['incluirProductos']    = true;
        $datos['pedido']['incluirIngredientes'] = true;

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/buscar', $datos);

    }


    public function actionBuscarPedidoEstatus()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['pedido']['sucursales']          = array();
        $datos['pedido']['pedidos']             = array(154);
        $datos['pedido']['clientes']            = array();
        $datos['pedido']['estatus']             = array();
        $datos['pedido']['incluirProductos']    = true;
        $datos['pedido']['incluirIngredientes'] = true;
        $datos['pedido']['enviarCocina']        = "";

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/buscarEstatus', $datos);

    }

    public function actionInsertarPedido()
    {
        $ingrediente1['id_ingrediente'] = 3;
        $ingrediente1['extra']          = true;
        $ingrediente1['precio_venta']   = "10.00";


        $ingrediente2['id_ingrediente'] = 4;
        $ingrediente2['extra']          = false;
        $ingrediente2['precio_venta']   = "0";


        $producto1['id_producto'] = 1;
        $producto1['Observaciones'] = "sin piña";
        $producto1['id_tamanio'] = 1;

        $producto2['id_producto'] = 1;
        $producto2['Observaciones'] = "";
        $producto2['id_tamanio'] = 2;

        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['pedido']['id_cliente']         = 1;
        $datos['pedido']['id_sucursal']        = 1;
        $datos['pedido']['id_estatus']         = 1;
        $datos['pedido']['fecha_pedido']       = date('Y/m/d HH:mm:ss');
        $datos['pedido']['enviar_domicilio']   = true;
        $datos['pedido']['id_domicilio']       = null;
        $datos['pedido']['hora']               = date('H:m:s') ;
        $datos['pedido']['subtotal']           = "100";
        $datos['pedido']['descuento']          = "0";
        $datos['pedido']['id_metodo_pago']     = 1;
        $datos['pedido']['id_tipo_entrega']    = 1;
        $datos['pedido']['id_origen']          = 2;
        $datos['pedido']['pagado']             = true;
        $datos['pedido']['enviarCocina']       = 1;

        $datos['pedido']['productos']          = array(

            array(
                "id_producto" => 1,
                "observaciones" => "Sin piña",
                "id_tamanio" => 1,
                "id_mitad_uno"=> 1,
                "id_mitad_dos"=> 2,
                "precio" => 10,
                "id_mitad_uno"=>null,
                "id_mitad_dos"=>null,
                "ingredientes"=> array(
                    $ingrediente1,
                    $ingrediente2,
                ),
                "total_ingredientes_extras" => '20.00'
            ),
            array(
                "id_producto" => 2,
                "observaciones" => "",
                "id_tamanio" => 1,
                "precio" => 20,
                "id_mitad_uno"=> null,
                "id_mitad_dos"=> null,
                "ingredientes"=> array(
                    $ingrediente1,
                ),
                "total_ingredientes_extras" => '0'
            ),

        );


        $productos['id_producto']              = 1;
        $productos['observaciones']            = "sin piña";
        $productos['id_tamanio']               = 1;
        $productos['ingredientes']             = array($ingrediente1,$ingrediente2);



        echo $this->curl(Yii::app()->params['pagina'], 'pedido/insertar', $datos);


    }


    public function actionActualizarPedido()
    {
        $ingrediente1['id_ingrediente'] = 3;
        $ingrediente1['extra']          = true;
        $ingrediente1['precio_venta']   = "10.00";


        $ingrediente2['id_ingrediente'] = 4;
        $ingrediente2['extra']          = false;
        $ingrediente2['precio_venta']   = "";

        $producto1['id_producto'] = 1;
        $producto1['Observaciones'] = "sin piña";
        $producto1['id_tamanio'] = 1;

        $producto2['id_producto'] = 1;
        $producto2['Observaciones'] = "";
        $producto2['id_tamanio'] = 2;

        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['pedido']['id']                 = 148;
        $datos['pedido']['id_cliente']         = 1;
        $datos['pedido']['id_sucursal']        = 1;
        $datos['pedido']['id_estatus']         = 1;
        $datos['pedido']['fecha_pedido']       = date('Y/m/d');
        $datos['pedido']['enviar_domicilio']   = true;
        $datos['pedido']['id_domicilio']       = null;
        $datos['pedido']['hora']               = date('H:m:s') ;
        $datos['pedido']['subtotal']           = "100";
        $datos['pedido']['descuento']          = "0";
        $datos['pedido']['pagado']             = true;
        $datos['pedido']['productos']          = array(

            array(
                "id_producto" => 1,
                "observaciones" => "Sin piña",
                "id_tamanio" => 1,
                "precio" => 10,
                "ingredientes"=> array(
                    $ingrediente1,
                    $ingrediente2,
                ),
                "total_ingredientes_extras" => '20.00'
            ),
            array(
                "id_producto" => 2,
                "observaciones" => "",
                "id_tamanio" => 1,
                "precio" => 20,
                "ingredientes"=> array(
                    $ingrediente1,
                ),
                "total_ingredientes_extras" => '0'
            ),

        );


        $productos['id_producto']              = 1;
        $productos['observaciones']            = "sin piña";
        $productos['id_tamanio']               = 1;
        $productos['ingredientes']             = array($ingrediente1,$ingrediente2);


        echo $this->curl(Yii::app()->params['pagina'], 'pedido/actualizar', $datos);
    }

    public function actionEliminarPedido()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['pedido']['id']     = 149;

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/eliminar', $datos);
    }


    public function actionCancelarPedido()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['pedido']['id']     = 146;

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/cancelar', $datos);
    }

    public function actionTransferirPedido()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['pedido']['id']              = 154;
        $datos['pedido']['id_sucursal']     = 2;

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/transferir', $datos);
    }

    public function actionEnviarCocinaPedido()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['pedido']['id']     = 158;

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/enviarACocina', $datos);
    }


    public function actionPrepararPedido()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['pedido']['id']     = 154;

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/preparar', $datos);
    }

    public function actionTerminarPedido()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['pedido']['id']     = 154;

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/terminar', $datos);
    }

    public function actionBuscarPedidoPendiente()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['pedido']['sucursales'] = array(1);

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/pendientesDeCocinar', $datos);
    }


    public function actionBuscarPedidoEnPreparacion()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['pedido']['sucursales'] = array(1);

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/enPreparacion', $datos);
    }


    public function actionBuscarTodosPedidos()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/todos', $datos);
    }


    public function actionBuscarPedidoTerminado()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['pedido']['sucursales'] = array(1);

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/terminado', $datos);
    }


    public function actionPagarPedido()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];
        $datos['pedido']['id']     = 160;

        echo $this->curl(Yii::app()->params['pagina'], 'pedido/pagar', $datos);
    }


    public function actionBuscarProductosVenta()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        echo $this->curl(Yii::app()->params['pagina'], 'producto/buscarParaVender', $datos);

    }

    public function actionBuscarIngredientes()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        echo $this->curl(Yii::app()->params['pagina'], 'producto/buscarIngredientes', $datos);

    }


    public function actionBuscarProductos()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        echo $this->curl(Yii::app()->params['pagina'], 'producto/buscar', $datos);

    }

    public function actionInsertarProducto()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['producto']['descripcion']     = "Producto Nuevo";
        $datos['producto']['cantidad']        = rand(1, 255) * 2;
        $datos['producto']['cantidad_minima'] = 10;
        $datos['producto']['tipo_producto']   = "V";
        $datos['producto']['precio_venta']    = "150.00";
        $datos['producto']['id_clasificacion_producto']= 1;
        $datos['producto']['enviar_cocina']   = 1;
        $datos['producto']['imagen']          = "probando.png";

        $datos['producto']['ingredientes']          = array(
            array(
                "id_producto" => 1,
                "id_ingrediente" => 3,
                "extra" => false
            ),
            array(
                "id_producto" => 1,
                "id_ingrediente" => 4,
                "extra" => false
            ),

        );



        $datos['producto']['tamanios']          = array(
            array(
                "id"            => 0,
                "id_producto"   => 0,
                "id_tamanio"    => 1,
                "precio_venta"  => 100,
                "estatus"       => "A",
            ),
            array(
                "id"            => 0,
                "id_producto"   => 0,
                "id_tamanio"    => 2,
                "precio_venta"  => 100,
                "estatus"       => "C",
            ),

        );




        echo $this->curl(Yii::app()->params['pagina'], 'producto/insertar', $datos);
    }

    public function actionActualizarProducto()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['producto']['id']              = 5;
        $datos['producto']['descripcion']     = "Producto Nuevo";
        $datos['producto']['cantidad']        = rand(1, 255) * 2;
        $datos['producto']['cantidad_minima'] = 10;
        $datos['producto']['tipo_producto']   = "V";
        $datos['producto']['precio_venta']    = "150.00";

        /*$datos['producto']['ingredientes']          = array(

            array(
                "id_producto" => 5,
                "id_ingrediente" => 19,
                "extra" => false
            ),
            array(
                "id_producto" => 5,
                "id_ingrediente" => 20,
                "extra" => false
            ),

        );
        */


        echo $this->curl(Yii::app()->params['pagina'], 'producto/actualizar', $datos);
    }


    public function actionEliminarProducto()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['producto']['id']     = 1;

        echo $this->curl(Yii::app()->params['pagina'], 'producto/eliminar', $datos);
    }

    public function actionEliminarTamanio()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tamanio']['id_producto']  = 44;
        $datos['tamanio']['id_tamanio']   = 1;

        echo $this->curl(Yii::app()->params['pagina'], 'tamanio/eliminar', $datos);
    }


    public function actionInsertarCaja()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        $datos['caja']['id_operacion_caja'] = 1;
        $datos['caja']['id_usuario']        = 1;
        $datos['caja']['total']             = 1;
        $datos['caja']['id_sucursal']       = 1;
        $datos['caja']['observaciones']     = "Bla Bla Bla";

        $datos['caja']['detalle'] = array(

            array(
                "id_denominacion" => 1,
                "cantidad"        => 10
            )

        ) ;

        echo $this->curl(Yii::app()->params['pagina'], 'caja/insertar', $datos);
    }

    public function actionCancelarCaja()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        $datos['caja']['id'] = 18;
        $datos['caja']['motivo'] =  "Motivo del movimiento";

        echo $this->curl(Yii::app()->params['pagina'], 'caja/cancelar', $datos);
    }

    public function actionBuscarOperacionesCaja()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'operacionesCaja/buscar', $datos);

    }

    public function actionInsertarOperacionesCaja()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['operacionesCaja']['descripcion'] = 'INSERT DESDE EL WS';


        echo $this->curl(Yii::app()->params['pagina'], 'operacionesCaja/insertar', $datos);

    }


    public function actionActualizarOperacionesCaja()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['operacionesCaja']['id']          = 4;
        $datos['operacionesCaja']['descripcion'] = 'UPDATE DESDE EL WS';


        echo $this->curl(Yii::app()->params['pagina'], 'operacionesCaja/actualizar', $datos);

    }

    public function actionEliminarOperacionesCaja()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['operacionesCaja']['id']          = 4;


        echo $this->curl(Yii::app()->params['pagina'], 'operacionesCaja/eliminar', $datos);

    }


    public function actionBuscarMetodosPago()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'metodosPago/buscar', $datos);

    }

    public function actionInsertarMetodosPago()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['metodosPago']['descripcion'] = 'INSERT DESDE EL WS';


        echo $this->curl(Yii::app()->params['pagina'], 'metodosPago/insertar', $datos);

    }

    public function actionActualizarMetodosPago()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['metodosPago']['id']          = 2;
        $datos['metodosPago']['descripcion'] = 'UPDATE DESDE EL WS';


        echo $this->curl(Yii::app()->params['pagina'], 'metodosPago/actualizar', $datos);

    }

    public function actionEliminarMetodosPago()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['metodosPago']['id'] = 2;

        echo $this->curl(Yii::app()->params['pagina'], 'metodosPago/eliminar', $datos);

    }



    public function actionBuscarOperacionesCajaXFecha()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        $datos['caja']['fecha']        = '2014-04-07';
        $datos['caja']['id_sucursal']  = array(1);

        echo $this->curl(Yii::app()->params['pagina'], 'caja/buscarOperacionesCajaXFecha', $datos);

    }

    public function actionBuscarCajaAbierta()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        $datos['caja']['fecha']        = '';
        $datos['caja']['id_sucursal']  = array();

        echo $this->curl(Yii::app()->params['pagina'], 'caja/buscarCajaAbierta', $datos);
    }

    public function actionBuscarDenominaciones()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        echo $this->curl(Yii::app()->params['pagina'], 'denominacion/buscar', $datos);

    }

    public function actionInsertarDenominaciones()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['denominacion']['descripcion'] = "Insert desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'denominacion/insertar', $datos);

    }

    public function actionActualizarDenominaciones()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['denominacion']['id'] = 7;
        $datos['denominacion']['descripcion'] = "Update desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'denominacion/actualizar', $datos);

    }

    public function actionEliminarDenominaciones()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['denominacion']['id'] = 7;

        echo $this->curl(Yii::app()->params['pagina'], 'denominacion/eliminar', $datos);

    }

    public function actionBuscarMetodosEntrega()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'tiposEntrega/buscar', $datos);
    }

    public function actionBuscarMetodoXIdEntrega()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tipoEntrega']['id'] = 2;

        echo $this->curl(Yii::app()->params['pagina'], 'tiposEntrega/buscarPorId', $datos);

    }


    public function actionInsertarMetodosEntrega()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tipoEntrega']['descripcion'] = "Insert desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'tiposEntrega/insertar', $datos);

    }

    public function actionActualizarMetodosEntrega()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tipoEntrega']['id'] = 4;
        $datos['tipoEntrega']['descripcion'] = "Update desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'tiposEntrega/actualizar', $datos);

    }

    public function actionEliminarMetodosEntrega()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tipoEntrega']['id'] = 4;

        echo $this->curl(Yii::app()->params['pagina'], 'tiposEntrega/eliminar', $datos);

    }

    public function actionBuscarColores()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'colores/buscar', $datos);

    }

    public function actionInsertarColores()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['colores']['color']      = 'INSERT DESDE EL WS';
        $datos['colores']['codigo']     = 'FF00FF';
        $datos['colores']['tolerancia'] = '10';


        echo $this->curl(Yii::app()->params['pagina'], 'colores/insertar', $datos);

    }



    public function actionActualizarColores()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['colores']['id'] = 7;
        $datos['colores']['color'] = "Update desde el web";
        $datos['colores']['codigo']     = 'FF0000';
        $datos['colores']['tolerancia'] = "4";

        echo $this->curl(Yii::app()->params['pagina'], 'colores/actualizar', $datos);

    }

    public function actionEliminarColores()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['colores']['id'] = 1;

        echo $this->curl(Yii::app()->params['pagina'], 'colores/eliminar', $datos);

    }


    public function actionBuscarSucursales()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'sucursal/buscar', $datos);

    }


    public function actionBuscarSucursalesPorId()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['sucursal']['id']   = 2;
        echo $this->curl(Yii::app()->params['pagina'], 'sucursal/buscarPorId', $datos);

    }

    public function actionInsertarSucursales()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['sucursal']['nombre']     = "Insert desde el web";
        $datos['sucursal']['telefono']   = "XXXXXXXXXX";
        $datos['sucursal']['direccion']  = "XXXXXXXXXX";
        $datos['sucursal']['horario']    = "XXXXXXXXXX";

        echo $this->curl(Yii::app()->params['pagina'], 'sucursal/insertar', $datos);

    }

    public function actionActualizarSucursales()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['sucursal']['id'] = 5;
        $datos['sucursal']['nombre'] = "Update desde el web";
        $datos['sucursal']['direccion'] = "Conocido";
        $datos['sucursal']['horario'] = "Conocido";
        $datos['sucursal']['telefono'] = "Conocido";

        echo $this->curl(Yii::app()->params['pagina'], 'sucursal/actualizar', $datos);

    }

    public function actionEliminarSucursales()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['sucursal']['id'] = 5;

        echo $this->curl(Yii::app()->params['pagina'], 'sucursal/eliminar', $datos);

    }


    public function actionBuscarOrigen()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'origen/buscar', $datos);

    }


    public function actionInsertarOrigen()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['origen']['descripcion'] = "Insert desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'origen/insertar', $datos);

    }

    public function actionActualizarOrigen()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['origen']['id'] = 2;
        $datos['origen']['descripcion'] = "Update desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'origen/actualizar', $datos);

    }

    public function actionEliminarOrigen()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['origen']['id'] = 3;

        echo $this->curl(Yii::app()->params['pagina'], 'origen/eliminar', $datos);

    }


    public function actionBuscarEmpleados()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'empleados/buscar', $datos);

    }

    public function actionInsertarEmpleado()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['empleado']['nombre']           = "Insert desde el web";
        $datos['empleado']['id_tipo_empleado'] = "2";

        echo $this->curl(Yii::app()->params['pagina'], 'empleados/insertar', $datos);

    }

    public function actionActualizarEmpleado()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['empleado']['id']               = 5;
        $datos['empleado']['nombre']           = "Update desde el web";
        $datos['empleado']['id_tipo_empleado'] = "3";

        echo $this->curl(Yii::app()->params['pagina'], 'empleados/actualizar', $datos);

    }

    public function actionEliminarEmpleado()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['empleado']['id'] = 5;

        echo $this->curl(Yii::app()->params['pagina'], 'empleados/eliminar', $datos);

    }


    public function actionBuscarEstatus()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'estatus/buscar', $datos);

    }


    public function actionBuscarTipoEmpleados()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'tipoEmpleados/buscar', $datos);

    }

    public function actionInsertarTipoEmpleado()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tipoEmpleado']['descripcion'] = "Insert desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'tipoEmpleados/insertar', $datos);

    }

    public function actionActualizarTipoEmpleado()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tipoEmpleado']['id']          = "6";
        $datos['tipoEmpleado']['descripcion'] = "UPdate desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'tipoEmpleados/actualizar', $datos);

    }

    public function actionEliminarTipoEmpleado()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tipoEmpleado']['id']          = "6";

        echo $this->curl(Yii::app()->params['pagina'], 'tipoEmpleados/eliminar', $datos);

    }


    public function actionLoginUsuario()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        $datos['password']         = md5("pepe");

        echo $this->curl(Yii::app()->params['pagina'], 'usuario/login', $datos);

    }

    public function actionBuscarUsuario()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'usuario/buscar', $datos);

    }

    public function actionInsertarUsuario()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['usuarios']['username']    = "pizzeria";
        $datos['usuarios']['pass']        = md5("pizzeria");
        $datos['usuarios']['id_perfil']   = 1;
        $datos['usuarios']['id_empleado'] = 1;



        echo $this->curl(Yii::app()->params['pagina'], 'usuario/insertar', $datos);

    }

    public function actionActualizarUsuario()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['usuarios']['id']          = 4;
        $datos['usuarios']['username']    = "pizzeria2";
        $datos['usuarios']['pass']        = md5("pizzeria2");
        $datos['usuarios']['id_perfil']   = 1;
        $datos['usuarios']['id_empleado'] = 1;
        $datos['usuarios']['estatus']     = "B";

        echo $this->curl(Yii::app()->params['pagina'], 'usuario/actualizar', $datos);

    }

    public function actionEliminarUsuario()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['usuarios']['id']          = 4;

        echo $this->curl(Yii::app()->params['pagina'], 'usuario/eliminar', $datos);

    }

    public function actionBuscarPerfil()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'perfil/buscar', $datos);

    }

    public function actionInsertarPerfil()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['perfil']['descripcion'] = "Insert desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'perfil/insertar', $datos);

    }

    public function actionActualizarPerfil()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['perfil']['id']          = 2;
        $datos['perfil']['descripcion'] = "Update desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'perfil/actualizar', $datos);

    }

    public function actionEliminarPerfil()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['perfil']['id']          = 2;

        echo $this->curl(Yii::app()->params['pagina'], 'perfil/eliminar', $datos);

    }


    public function actionBuscarInventario()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['inventario']['id_sucursal']         = 1;
        $datos['inventario']['incluirProductos']    = true;

        echo $this->curl(Yii::app()->params['pagina'], 'inventario/buscarMovimientos', $datos);

    }

    public function actionInsertarInventario()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['inventario']['id_sucursal_origen']    = 1;
        $datos['inventario']['id_sucursal_destino']   = 2;
        $datos['inventario']['folio']                 = "200000";
        $datos['inventario']['id_tipo_movimiento']    = 1;

        $datos['inventario']['productos']    = array(

            array(
                "id_producto" => 2,
                "cantidad" => 4,
                "precio_costo" => 20,
                "id_unidad_medida" =>2
            )

        );

        echo $this->curl(Yii::app()->params['pagina'], 'inventario/insertar', $datos);

    }

    public function actionCancelarInventario()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['inventario']['id']           = 1;

        echo $this->curl(Yii::app()->params['pagina'], 'inventario/cancelar', $datos);
    }


    public function actionBuscarUnidades()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'unidades/buscar', $datos);

    }

    public function actionInsertarUnidad()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['unidad']['descripcion'] = "INSERT DESDE EL WEB";

        echo $this->curl(Yii::app()->params['pagina'], 'unidades/insertar', $datos);

    }

    public function actionActualizarUnidad()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['unidad']['id']          = 7;
        $datos['unidad']['descripcion'] = "UPDATE DESDE EL WEB";

        echo $this->curl(Yii::app()->params['pagina'], 'unidades/actualizar', $datos);

    }

    public function actionEliminarUnidad()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['unidad']['id']          = 6;

        echo $this->curl(Yii::app()->params['pagina'], 'unidades/eliminar', $datos);

    }


    public function actionBuscarTipoMovimientos()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'tipoMovimientos/buscar', $datos);

    }


    public function actionBuscarTipoTelefonos()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'tipoTelefonos/buscar', $datos);

    }

    public function actionInsertarTipoTelefono()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tipoTelefono']['descripcion'] = "Insert desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'tipoTelefonos/insertar', $datos);

    }

    public function actionActualizarTipoTelefono()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tipoTelefono']['id']          = "3";
        $datos['tipoTelefono']['descripcion'] = "UPdate desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'tipoTelefonos/actualizar', $datos);

    }

    public function actionEliminarTipoTelefono()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['tipoTelefono']['id']          = "3";

        echo $this->curl(Yii::app()->params['pagina'], 'tipoTelefonos/eliminar', $datos);

    }


    public function actionBuscarMensaje()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];


        echo $this->curl(Yii::app()->params['pagina'], 'mensaje/buscar', $datos);

    }

    public function actionActualizarMensaje()
    {
        $datos['usuario']          = Yii::app()->params['usuario'];
        $datos['password']         = Yii::app()->params['password'];

        $datos['mensaje']['id']          = "1";
        $datos['mensaje']['descripcion'] = "UPdate desde el web";

        echo $this->curl(Yii::app()->params['pagina'], 'mensaje/actualizar', $datos);

    }

    private function curl($pagina, $controladorAccion, $datos)
    {
        $parametros = CJSON::encode(array("datos" => $datos));
        $handler = curl_init($pagina);

        curl_setopt($handler, CURLOPT_URL, $pagina);
        curl_setopt($handler, CURLOPT_POST, false);
        curl_setopt($handler, CURLOPT_POSTFIELDS, array("r" =>$controladorAccion, "datos"=>$parametros));

        $response = curl_exec($handler);
        curl_close($handler);
        return $response;

    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }

        }
    }


}