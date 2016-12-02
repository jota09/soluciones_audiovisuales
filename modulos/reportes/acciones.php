<?php

if (!defined('s3_entrada') || !s3_entrada) {
   die('No es un punto de entrada valido');
}

class AccionesReportes extends S3Accion {

   var $scripts;
   var $estilos;

   public function __construct() {
      parent::__construct();
      global $aplicacion;
      require_once 'modelo/Usuario.php';
      $usuario = new Usuario();
      $this->scripts = array('base/librerias/js/select2/select2.min.js', 'assets/js/general/editar.js',
          'librerias/js/amcharts/amcharts.js', 'librerias/js/amcharts/serial.js', 'librerias/js/amcharts/pie.js');
      $this->estilos = array('base/librerias/js/select2/select2.css', 'base/librerias/js/select2/select2-bootstrap.css');

      if (file_exists('assets/js/modulos/' . $this->modulo . '/editar.js')) {
         $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/editar.js';
      }
      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('estilos', $this->estilos);
      $aplicacion->getVista()->assign('contenidoModulo', 'modulos/reportes/reportes');
      $aplicacion->getVista()->assign('asesores', $usuario->obtenerListaRegistros());
      $this->confModulo = Spyc::YAMLLoad('modulos/' . $this->modulo . '/config.yml');
   }

   public function accionEditar() {
      $peticion = new S3Request();
      $peticion->redireccionar(array('modulo' => 'reportes', 'accion' => 'listar'));
   }

   public function accionListar() {
      $this->accionVentasxComercial();
   }

   public function accionReporteGeneral() {
      require_once 'modelo/Cotizacion.php';
      global $aplicacion;
      $cotizacion = new Cotizacion();
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/reporte_general.js';
      $this->estilos[] = 'assets/css/modulos/' . $this->modulo . '/reporte.css';

      $aplicacion->getVista()->assign('accion', 'reporte_general');
      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('estilos', $this->estilos);
      $aplicacion->getVista()->assign('reporte_name', "Tablero General");
      $aplicacion->getVista()->assign('ventas', $cotizacion->obtenerVentas());
      $aplicacion->getVista()->assign('ventasMes', $cotizacion->obtenerMensualidadVentas());
   }

   public function accionReporteComercial() {
      require_once 'modelo/Cotizacion.php';
      require_once 'modelo/Servicio.php';
      global $aplicacion;
      $cotizacion = new Cotizacion();
      $servicio = new Servicio();
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/reporte_comercial.js';
      $this->estilos[] = 'assets/css/modulos/' . $this->modulo . '/reporte.css';

      $aplicacion->getVista()->assign('accion', 'reporte_comercial');
      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('estilos', $this->estilos);
      $aplicacion->getVista()->assign('reporte_name', "Tablero Comercial");
      $aplicacion->getVista()->assign('ventas', $cotizacion->obtenerGanadasPorAsesor());
      $aplicacion->getVista()->assign('cotizaciones', $cotizacion->obtenerCotizacionPorAsesor());
      $aplicacion->getVista()->assign('servicios', $servicio->obtenerServicio());
      $aplicacion->getVista()->assign('ventasMes', $cotizacion->obtenerMensualidadVentas());
      $aplicacion->getVista()->assign('cotizacionesMes', $cotizacion->obtenerMensualidadCotizacion());
      $aplicacion->getVista()->assign('ventasLinea', $cotizacion->obtenerVentaLineaNegocio());
      $aplicacion->getVista()->assign('cotizacionesLinea', $cotizacion->obtenerCotizacionLineaNegocio());
      $aplicacion->getVista()->assign('serviciosMes', $servicio->obtenerMensualidadServicio());
      $aplicacion->getVista()->assign('serviciosLinea', $servicio->obtenerServicioLineaNegocio());
   }

   public function accionReporteVenta() {
      require_once 'modelo/Cotizacion.php';
      global $aplicacion;
      $cotizacion = new Cotizacion();
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/reporte_venta.js';
      $this->scripts[] = 'librerias/js/jquery.powertip.min.js';
      $this->estilos[] = 'assets/css/modulos/' . $this->modulo . '/reporte.css';
      $this->estilos[] = 'librerias/css/jquery.powertip.min.css';

      $aplicacion->getVista()->assign('accion', 'reporte_venta');
      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('estilos', $this->estilos);
      $aplicacion->getVista()->assign('configModulo', $this->confModulo);
      $aplicacion->getVista()->assign('reporte_name', "Tablero Ventas");
      $aplicacion->getVista()->assign('ventas', $cotizacion->obtenerVentas());
      $aplicacion->getVista()->assign('ventasAsesor', $cotizacion->obtenerGanadasPorAsesor());
      $aplicacion->getVista()->assign('ventasLinea', $cotizacion->obtenerVentaLineaNegocio());
      $aplicacion->getVista()->assign('ventasSector', $cotizacion->obtenerVentaSector());
      $aplicacion->getVista()->assign('ventasTop', $cotizacion->obtenerVentaTop());
      $aplicacion->getVista()->assign('ventasPorProducto', $cotizacion->obtenerVentaPorProducto());
   }

   public function accionReporteCotizacion() {
      require_once 'modelo/Cotizacion.php';
      global $aplicacion;
      $cotizacion = new Cotizacion();
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/reporte_cotizacion.js';
      $this->estilos[] = 'assets/css/modulos/' . $this->modulo . '/reporte.css';

      $aplicacion->getVista()->assign('accion', 'reporte_cotizacion');
      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('estilos', $this->estilos);
      $aplicacion->getVista()->assign('reporte_name', "Tablero Cotizaciones");
      $aplicacion->getVista()->assign('cotizaciones', $cotizacion->obtenerCotizacionPorAsesor());
      $aplicacion->getVista()->assign('cotizacionesEtapa', $cotizacion->obtenerCotizacionEtapa());
      $aplicacion->getVista()->assign('cotizacionesLinea', $cotizacion->obtenerCotizacionLineaNegocio());
      $aplicacion->getVista()->assign('cotizacionesSector', $cotizacion->obtenerCotizacionSector());
      $aplicacion->getVista()->assign('cotizacionesporMes', $cotizacion->obtenerCotizacionPorMes());
   }

   public function accionReporteServicio() {
      require_once 'modelo/Servicio.php';
      global $aplicacion;
      $servicio = new Servicio();
      $this->scripts[] = 'assets/js/modulos/' . $this->modulo . '/reporte_servicio.js';
      $this->estilos[] = 'assets/css/modulos/' . $this->modulo . '/reporte.css';

      $aplicacion->getVista()->assign('accion', 'reporte_servicio');
      $aplicacion->getVista()->assign('scripts', $this->scripts);
      $aplicacion->getVista()->assign('estilos', $this->estilos);
      $aplicacion->getVista()->assign('reporte_name', "Tablero Servicios");
      $aplicacion->getVista()->assign('serviciosLinea', $servicio->obtenerServicioLineaNegocio());
      $aplicacion->getVista()->assign('serviciosEstado', $servicio->obtenerServicioEstado());
      $aplicacion->getVista()->assign('serviciosIngreso', $servicio->obtenerIngresoPorServicio());
   }
   
   public function accionFiltro_general_1() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerVentas();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_venta() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerGanadasPorAsesor();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_venta_linea() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerVentaLineaNegocio();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_venta_top() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerVentaTop();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_venta_sector() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerVentaSector();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_venta_producto() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerVentaPorProducto();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_cotizacion() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerCotizacionPorAsesor();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_cotizacion_etapa() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerCotizacionEtapa();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_cotizacion_linea() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerCotizacionLineaNegocio();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_cotizacion_sector() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerCotizacionSector();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_cotizacion_mes() {
//      __P('entro aqui');
      require_once 'modelo/Cotizacion.php';
      $cotizacion = new Cotizacion();
      $data = $cotizacion->obtenerCotizacionPorMes();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_servicio() {
//      __P('entro aqui');
      require_once 'modelo/Servicio.php';
      $servicio = new Servicio();
      $data = $servicio->obtenerServicio();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_servicio_linea() {
//      __P('entro aqui');
      require_once 'modelo/Servicio.php';
      $servicio = new Servicio();
      $data = $servicio->obtenerServicioLineaNegocio();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_servicio_ingreso() {
//      __P('entro aqui');
      require_once 'modelo/Servicio.php';
      $servicio = new Servicio();
      $data = $servicio->obtenerIngresoPorServicio();
      die(json_encode($data));
   }
   public function accionFiltro_general_2_servicio_estado() {
//      __P('entro aqui');
      require_once 'modelo/Servicio.php';
      $servicio = new Servicio();
      $data = $servicio->obtenerServicioEstado();
      die(json_encode($data));
   }

}
