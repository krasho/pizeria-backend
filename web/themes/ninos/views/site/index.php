<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarCientexTelefono"); ?>">Búsqueda de cliente por teléfono </a>
    </li>
    <li><a href="<?php echo $this->createUrl("site/insertarCliente"); ?>">Agregar Cliente </a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarCliente"); ?>">Actualizar Cliente </a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarCliente"); ?>">Eliminar Cliente </a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarUltimoPedido"); ?>">Último Pedido de un Cliente </a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarProductosMasPedidos"); ?>">Buscar los productos mas pedidos (5 por default) </a></li>
    <li><a href="<?php echo $this->createUrl("site/agregarDomicilioCliente"); ?>">Agregar un domicilio al cliente</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarDomicilioCliente"); ?>">Eliminar un domicilio al cliente</a></li>
    <li><a href="<?php echo $this->createUrl("site/obtenerDomiciliosCliente"); ?>">Obtener los domicilios de un cliente</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarPedido"); ?>">Buscar pedido</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarPedidoEstatus"); ?>">Buscar los estatus de un pedido</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarPedido"); ?>">Actualizar pedido</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarPedido"); ?>">Eliminar pedido</a></li>
    <li><a href="<?php echo $this->createUrl("site/cancelarPedido"); ?>">Cancelar pedido</a></li>
    <li><a href="<?php echo $this->createUrl("site/transferirPedido"); ?>">Transferir pedido</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarPedido"); ?>">Insertar pedido</a></li>
    <li><a href="<?php echo $this->createUrl("site/enviarCocinaPedido"); ?>">Enviar a Cocina el Pedido</a></li>
    <li><a href="<?php echo $this->createUrl("site/prepararPedido"); ?>">Preparar el Pedido</a></li>
    <li><a href="<?php echo $this->createUrl("site/terminarPedido"); ?>">Terminar de cocinar Pedido</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarPedidoPendiente"); ?>">Buscar pedidos para enviar a Cocina</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarPedidoenPreparacion"); ?>">Buscar pedidos en Preparación</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarPedidoTerminado"); ?>">Buscar pedidos Terminados</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarTodosPedidos"); ?>">Buscar todos los pedidos</a></li>
    <li><a href="<?php echo $this->createUrl("site/pagarPedido"); ?>">Marcar pedido como pagado</a></li>
    <li><a href="<?php echo $this->createUrl("site/marcarPedidoUrgente"); ?>">Marcar pedido como urgente</a></li>
    <li><a href="<?php echo $this->createUrl("site/desmarcarPedidoUrgente"); ?>">DesMarcar pedido como urgente</a></li>
    <li><a href="<?php echo $this->createUrl("site/entregarPedidos"); ?>">Entrega de pedidos</a></li>
    <li><a href="<?php echo $this->createUrl("site/asignarPedidos"); ?>">Asignar un pedido a un Repartidor</a></li>
    <li><a href="<?php echo $this->createUrl("site/confirmarPedidos"); ?>">Confirmación al regreso del repartidor</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarPedidoEnReparto"); ?>">Buscar Pedidos que están en reparto</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarProductosVenta"); ?>">Buscar los productos para venta</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarIngredientes"); ?>">Buscar los ingredientes</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarProducto"); ?>">Insertar Producto</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarProducto"); ?>">Actualizar Producto</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarProducto"); ?>">Eliminar Producto</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarProductos"); ?>">Buscar TODOS los productos</a></li>
</ul>


<ul>
    <li><a href="<?php echo $this->createUrl("site/insertarCaja"); ?>">Insertar movimiento de caja</a></li>
    <li><a href="<?php echo $this->createUrl("site/cancelarCaja"); ?>">Cancelar movimiento de caja</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarOperacionesCajaXFecha"); ?>">Buscar las Operaciones de la caja por fecha</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarCajaAbierta"); ?>">Buscar si la caja está abierta para una fecha dada</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarDenominaciones"); ?>">Buscar las denominaciones</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarDenominaciones"); ?>">insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarDenominaciones"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarDenominaciones"); ?>">eliminar</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarOperacionesCaja"); ?>">Buscar las operaciones de la caja</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarOperacionesCaja"); ?>">insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarOperacionesCaja"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarOperacionesCaja"); ?>">eliminar</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarMetodosPago"); ?>">Buscar los metodos de pago</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarMetodosPago"); ?>">insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarMetodosPago"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarMetodosPago"); ?>">eliminar</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarMetodosEntrega"); ?>">Buscar los metodos de entrega</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarMetodoXIdEntrega"); ?>">Buscar método de entrega por ID</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarMetodosEntrega"); ?>">insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarMetodosEntrega"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarMetodosEntrega"); ?>">eliminar</a></li>
</ul>


<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarColores"); ?>">Buscar los colores</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarColores"); ?>">insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarColores"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarColores"); ?>">eliminar</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarSucursales"); ?>">Buscar Sucursales</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarSucursalesPorId"); ?>">Buscar Sucursal por Id</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarSucursales"); ?>">insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarSucursales"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarSucursales"); ?>">eliminar</a></li>
</ul>


<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarOrigen"); ?>">Buscar Origen</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarOrigen"); ?>">insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarOrigen"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarOrigen"); ?>">eliminar</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarEmpleados"); ?>">Buscar Empleados</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarEmpleado"); ?>">insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarEmpleado"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarEmpleado"); ?>">eliminar</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarEstatus"); ?>">Buscar Estatus</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarTipoEmpleados"); ?>">Buscar Tipos de Empleados</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarTipoEmpleado"); ?>">insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarTipoEmpleado"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarTipoEmpleado"); ?>">eliminar</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/loginUsuario"); ?>">Loggearse Usuario</a></li>
    <li><a href="<?php echo $this->createUrl("site/buscarUsuario"); ?>">Buscar Usuarios</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarUsuario"); ?>">Insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarUsuario"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarUsuario"); ?>">eliminar</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarPerfil"); ?>">Buscar Perfiles</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarPerfil"); ?>">Insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarPerfil"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarPerfil"); ?>">eliminar</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarInventario"); ?>">Buscar Movimientos del inventario</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarInventario"); ?>">Insertar Movimiento en el inventario</a></li>
    <li><a href="<?php echo $this->createUrl("site/cancelarInventario"); ?>">Cancelar Movimiento en el inventario</a></li>
</ul>


<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarUnidades"); ?>">Buscar Unidades de Medida</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarUnidad"); ?>">Insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarUnidad"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarUnidad"); ?>">eliminar</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarTipoMovimientos"); ?>">Buscar los tipos de movimientos</a></li>
</ul>


<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarTipoTelefonos"); ?>">Buscar Tipos de Telefonos</a></li>
    <li><a href="<?php echo $this->createUrl("site/insertarTipoTelefono"); ?>">insertar</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarTipoTelefono"); ?>">actualizar</a></li>
    <li><a href="<?php echo $this->createUrl("site/eliminarTipoTelefono"); ?>">eliminar</a></li>
</ul>


<ul>
    <li><a href="<?php echo $this->createUrl("site/eliminarTamanio"); ?>">eliminar un tamaño de producto</a></li>
</ul>

<ul>
    <li><a href="<?php echo $this->createUrl("site/buscarMensaje"); ?>">Buscar mensaje</a></li>
    <li><a href="<?php echo $this->createUrl("site/actualizarMensaje"); ?>">Actualizar mensaje</a></li>
</ul>
