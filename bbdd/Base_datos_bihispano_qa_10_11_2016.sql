/*
SQLyog Ultimate v11.11 (32 bit)
MySQL - 5.5.46-log : Database - nicecrm_soluciones_audiovisiales
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`nicecrm_soluciones_audiovisiales_qa` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `nicecrm_soluciones_audiovisiales_qa`;

/*Table structure for table `accion` */

DROP TABLE IF EXISTS `accion`;

CREATE TABLE `accion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

/*Data for the table `accion` */

insert  into `accion`(`id`,`nombre`,`activo`,`fecha_creacion`,`fecha_modificacion`,`eliminado`) values (1,'Crear',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0),(2,'Ver',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0),(3,'Actualizar',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0),(4,'Eliminar',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0),(5,'Listar',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0),(6,'logout',1,NULL,NULL,1),(7,'login',1,NULL,NULL,1),(8,'ver',1,NULL,NULL,1),(10,'default',1,NULL,NULL,1),(11,'administrador',1,NULL,NULL,1),(12,'inicio',1,NULL,NULL,1),(13,'autenticar',1,NULL,NULL,1),(14,'registrarme',1,NULL,NULL,1),(15,'registrar',1,NULL,NULL,1),(16,'autocompletar',1,NULL,NULL,1),(17,'verificarcorreo',1,NULL,NULL,1),(18,'verificarnusuario',1,NULL,NULL,1),(19,'registrarmeg',1,NULL,NULL,1),(20,'activacion',1,NULL,NULL,1),(21,'guardarprop',1,NULL,NULL,1),(22,'getproductoxid',1,NULL,NULL,1),(23,'publicacion',1,NULL,NULL,1),(24,'huella',1,NULL,NULL,1),(25,'ajaxtabla',1,NULL,NULL,1),(26,'mascota',1,NULL,NULL,1),(27,'cambiarperfil',1,NULL,NULL,1),(28,'obtenerestablecimientos',1,NULL,NULL,1),(29,'cambiarimagenperfil',1,NULL,NULL,1),(30,'establecimiento',1,NULL,NULL,1),(31,'obtenerbaner',1,NULL,NULL,1),(32,'nuevasnotificaciones',1,NULL,NULL,1),(33,'agregaramigo',1,NULL,NULL,1),(34,'aceptaramigo',1,NULL,NULL,1),(35,'mostraramigo',1,NULL,NULL,1),(36,'obtenergrupofci',1,NULL,NULL,1),(37,'obtenerseccionfci',1,NULL,NULL,1),(38,'verificar_activacion',1,NULL,NULL,1),(39,'seguirnoseguir',1,NULL,NULL,1),(40,'perfil',1,NULL,NULL,1),(41,'obtenerseccionmascota',1,NULL,NULL,1),(42,'obtenergrupomascota',1,NULL,NULL,1),(43,'reconstruirdetalle',1,NULL,NULL,1),(44,'obtenermembresiaportipocliente',1,NULL,NULL,1),(45,'recuperar',1,NULL,NULL,1),(46,'cambiar',1,NULL,NULL,1),(47,'obtenerbanerporcliente',1,NULL,NULL,1),(48,'poscambiar',1,NULL,NULL,1),(49,'prueba',1,NULL,NULL,1),(50,'listarpropierario',1,NULL,NULL,1),(51,'comentario',1,NULL,NULL,1),(52,'enviarmensaje',1,NULL,NULL,1),(53,'listarpropietario',1,NULL,NULL,1),(54,'verificarclientecatalogo',1,NULL,NULL,1),(55,'enviarcorreo',1,NULL,NULL,1),(56,'publicar',1,NULL,NULL,1),(57,'obtenerbanners',1,NULL,NULL,1),(58,'directorio',1,NULL,NULL,1),(59,'publicacioncliente',1,NULL,NULL,1),(60,'abriralbum',1,NULL,NULL,1),(61,'guardarmensajecliente',1,NULL,NULL,1),(62,'logclick',1,NULL,NULL,1),(63,'imagenalbum',1,NULL,NULL,1),(64,'propgeneral',1,NULL,NULL,1),(65,'obtenermasestablecimientos',1,NULL,NULL,1),(66,'compartir',1,NULL,NULL,1),(67,'bloquearmascota',1,NULL,NULL,1),(68,'pedircompartir',1,NULL,NULL,1),(69,'propregistromascota',1,NULL,NULL,1),(70,'paseo',1,NULL,NULL,1),(71,'obtenermasestablecimientosmovil',1,NULL,NULL,1),(72,'notificacionesvistas',1,NULL,NULL,1),(73,'amistadesvistas',1,NULL,NULL,1),(74,'eliminarimg',1,NULL,NULL,1);

/*Table structure for table `acl_perfil_permiso` */

DROP TABLE IF EXISTS `acl_perfil_permiso`;

CREATE TABLE `acl_perfil_permiso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perfil_id` int(11) NOT NULL,
  `modulo_accion_id` int(11) NOT NULL,
  `lista_tipo_permiso` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `eliminado` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_acl_perfil_modulo_perfil1_idx` (`perfil_id`),
  KEY `fk_acl_perfil_modulo_accion1_idx` (`modulo_accion_id`),
  CONSTRAINT `acl_perfil_permiso_ibfk_1` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`),
  CONSTRAINT `acl_perfil_permiso_ibfk_2` FOREIGN KEY (`modulo_accion_id`) REFERENCES `modulo_accion` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

/*Data for the table `acl_perfil_permiso` */

insert  into `acl_perfil_permiso`(`id`,`perfil_id`,`modulo_accion_id`,`lista_tipo_permiso`,`fecha_creacion`,`fecha_modificacion`,`activo`,`eliminado`) values (1,3,101,0,NULL,NULL,1,0),(2,3,102,0,NULL,NULL,1,0),(3,3,103,0,NULL,NULL,1,0),(4,3,104,0,NULL,NULL,1,0),(5,3,105,0,NULL,NULL,1,0),(6,3,76,0,NULL,NULL,1,0),(7,3,77,0,NULL,NULL,1,0),(8,3,78,0,NULL,NULL,1,0),(9,3,79,0,NULL,NULL,1,0),(10,3,80,0,NULL,NULL,1,0),(11,3,16,0,NULL,NULL,1,0),(12,3,17,0,NULL,NULL,1,0),(13,3,18,0,NULL,NULL,1,0),(14,3,19,0,NULL,NULL,1,0),(15,3,20,0,NULL,NULL,1,0),(16,3,6,0,NULL,NULL,1,0),(17,3,7,0,NULL,NULL,1,0),(18,3,8,0,NULL,NULL,1,0),(19,3,9,0,NULL,NULL,1,0),(20,3,10,0,NULL,NULL,1,0),(21,3,11,0,NULL,NULL,1,0),(22,3,12,0,NULL,NULL,1,0),(23,3,13,0,NULL,NULL,1,0),(24,3,14,0,NULL,NULL,1,0),(25,3,15,0,NULL,NULL,1,0),(26,3,71,0,NULL,NULL,1,0),(27,3,72,0,NULL,NULL,1,0),(28,3,73,0,NULL,NULL,1,0),(29,3,74,0,NULL,NULL,1,0),(30,3,75,0,NULL,NULL,1,0),(31,3,21,0,NULL,NULL,1,0),(32,3,22,0,NULL,NULL,1,0),(33,3,23,0,NULL,NULL,1,0),(34,3,24,0,NULL,NULL,1,0),(35,3,25,0,NULL,NULL,1,0),(36,3,26,0,NULL,NULL,1,0),(37,3,27,0,NULL,NULL,1,0),(38,3,28,0,NULL,NULL,1,0),(39,3,29,0,NULL,NULL,1,0),(40,3,30,0,NULL,NULL,1,0),(41,3,81,0,NULL,NULL,1,0),(42,3,82,0,NULL,NULL,1,0),(43,3,83,0,NULL,NULL,1,0),(44,3,84,0,NULL,NULL,1,0),(45,3,85,0,NULL,NULL,1,0),(46,3,86,0,NULL,NULL,1,0),(47,3,87,0,NULL,NULL,1,0),(48,3,88,0,NULL,NULL,1,0),(49,3,89,0,NULL,NULL,1,0),(50,3,90,0,NULL,NULL,1,0),(51,3,31,0,NULL,NULL,1,0),(52,3,32,0,NULL,NULL,1,0),(53,3,33,0,NULL,NULL,1,0),(54,3,34,0,NULL,NULL,1,0),(55,3,35,0,NULL,NULL,1,0),(56,3,1,0,NULL,NULL,1,0),(57,3,2,0,NULL,NULL,1,0),(58,3,3,0,NULL,NULL,1,0),(59,3,4,0,NULL,NULL,1,0),(60,3,5,0,NULL,NULL,1,0),(61,3,36,0,NULL,NULL,1,0),(62,3,37,0,NULL,NULL,1,0),(63,3,38,0,NULL,NULL,1,0),(64,3,39,0,NULL,NULL,1,0),(65,3,40,0,NULL,NULL,1,0),(66,3,91,0,NULL,NULL,1,0),(67,3,92,0,NULL,NULL,1,0),(68,3,93,0,NULL,NULL,1,0),(69,3,94,0,NULL,NULL,1,0),(70,3,95,0,NULL,NULL,1,0),(71,3,96,0,NULL,NULL,1,0),(72,3,97,0,NULL,NULL,1,0),(73,3,98,0,NULL,NULL,1,0),(74,3,99,0,NULL,NULL,1,0),(75,3,100,0,NULL,NULL,1,0),(76,3,41,0,NULL,NULL,1,0),(77,3,42,0,NULL,NULL,1,0),(78,3,43,0,NULL,NULL,1,0),(79,3,44,0,NULL,NULL,1,0),(80,3,45,0,NULL,NULL,1,0),(81,3,46,0,NULL,NULL,1,0),(82,3,47,0,NULL,NULL,1,0),(83,3,48,0,NULL,NULL,1,0),(84,3,49,0,NULL,NULL,1,0),(85,3,50,0,NULL,NULL,1,0),(86,3,51,0,NULL,NULL,1,0),(87,3,52,0,NULL,NULL,1,0),(88,3,53,0,NULL,NULL,1,0),(89,3,54,0,NULL,NULL,1,0),(90,3,55,0,NULL,NULL,1,0),(91,3,56,0,NULL,NULL,1,0),(92,3,57,0,NULL,NULL,1,0),(93,3,58,0,NULL,NULL,1,0),(94,3,59,0,NULL,NULL,1,0),(95,3,60,0,NULL,NULL,1,0),(96,3,61,0,NULL,NULL,1,0),(97,3,62,0,NULL,NULL,1,0),(98,3,63,0,NULL,NULL,1,0),(99,3,64,0,NULL,NULL,1,0),(100,3,65,0,NULL,NULL,1,0),(101,3,66,0,NULL,NULL,1,0),(102,3,67,0,NULL,NULL,1,0),(103,3,68,0,NULL,NULL,1,0),(104,3,69,0,NULL,NULL,1,0),(105,3,70,0,NULL,NULL,1,0);

/*Table structure for table `actividad` */

DROP TABLE IF EXISTS `actividad`;

CREATE TABLE `actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `relacionado_id` int(11) DEFAULT NULL,
  `relacionado` varchar(45) DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `meridiano_inicio` char(4) DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `meridiano_fin` char(4) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `descripcion` text,
  `contacto` varchar(45) DEFAULT NULL,
  `prioridad` varchar(45) DEFAULT NULL,
  `duracion` varchar(100) DEFAULT NULL,
  `tipo_llamada` varchar(45) DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT '0',
  `activo` tinyint(1) DEFAULT '1',
  `aviso` varchar(45) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `actividad_usuario_FK` (`usuario_id`),
  KEY `fk_actividad_modulo_idx` (`relacionado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

/*Data for the table `actividad` */

/*Table structure for table `acuerdo` */

DROP TABLE IF EXISTS `acuerdo`;

CREATE TABLE `acuerdo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_acuerdo_id` int(11) DEFAULT NULL,
  `cuenta_id` int(11) DEFAULT NULL,
  `modalidad_cobro_id` int(11) DEFAULT NULL,
  `periodo_cobro_id` int(11) DEFAULT NULL,
  `estado_servicio_id` int(11) DEFAULT NULL,
  `responsable_id` int(11) DEFAULT NULL,
  `tipo_servicio_id` varchar(145) DEFAULT NULL COMMENT '																						',
  `linea_id` varchar(145) DEFAULT NULL,
  `linea_str` varchar(255) DEFAULT NULL,
  `forma_pago_id` int(11) DEFAULT NULL,
  `fecha_vigencia_desde` date DEFAULT NULL,
  `fecha_vigencia_hasta` date DEFAULT NULL,
  `valor_servicio` varchar(45) DEFAULT NULL,
  `tarifa` varchar(45) DEFAULT NULL,
  `tarifa_obs` varchar(45) DEFAULT NULL,
  `condiciones_comerciales` text,
  `descripcion` text,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  `eliminado` tinyint(4) DEFAULT '0',
  `tipo_servicio_str` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_acuerdo_responsable_idx` (`responsable_id`),
  KEY `fk_acuerdo_cliente_idx` (`cuenta_id`),
  CONSTRAINT `fk_acuerdo_cliente` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_acuerdo_responsable` FOREIGN KEY (`responsable_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `acuerdo` */

/*Table structure for table `acuerdo_actividad` */

DROP TABLE IF EXISTS `acuerdo_actividad`;

CREATE TABLE `acuerdo_actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acuerdo_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_acuerdo_actividad_acuerdo_idx` (`acuerdo_id`),
  KEY `fk_acuerdo_actividad_actividad_idx` (`actividad_id`),
  CONSTRAINT `fk_acuerdo_actividad_actividad` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_acuerdo_actividad_acuerdo` FOREIGN KEY (`acuerdo_id`) REFERENCES `acuerdo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `acuerdo_actividad` */

/*Table structure for table `acuerdo_documento` */

DROP TABLE IF EXISTS `acuerdo_documento`;

CREATE TABLE `acuerdo_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acuerdo_id` int(11) NOT NULL,
  `documento_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_acuerdo_documento_docuemnto_idx` (`documento_id`),
  KEY `fk_acuerdo_documento_acerdo_idx` (`acuerdo_id`),
  CONSTRAINT `fk_acuerdo_documento_acerdo` FOREIGN KEY (`acuerdo_id`) REFERENCES `acuerdo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_acuerdo_documento_docuemnto` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `acuerdo_documento` */

/*Table structure for table `auditoria_registro` */

DROP TABLE IF EXISTS `auditoria_registro`;

CREATE TABLE `auditoria_registro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `modulo` varchar(45) DEFAULT NULL,
  `accion` varchar(45) DEFAULT NULL,
  `registro_id` int(11) DEFAULT NULL,
  `fecha_modificacion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_auditoria_registro_usuario1_idx` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `auditoria_registro` */

/*Table structure for table `caso` */

DROP TABLE IF EXISTS `caso`;

CREATE TABLE `caso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_id` int(11) DEFAULT NULL,
  `cuenta_id` int(11) NOT NULL,
  `estado_id` int(11) DEFAULT NULL,
  `origen_id` int(11) DEFAULT NULL,
  `asesor_asignado_id` int(11) NOT NULL,
  `numero` varchar(45) DEFAULT NULL,
  `prioridad_id` int(11) DEFAULT NULL,
  `asunto` varchar(45) NOT NULL,
  `descripcion` text,
  `resolucion` text,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT '1',
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  `servicio_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_caso_usuario_idx` (`asesor_asignado_id`),
  KEY `fk_caso_cuenta_idx` (`cuenta_id`),
  CONSTRAINT `fk_caso_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_caso_usuario` FOREIGN KEY (`asesor_asignado_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `caso` */

/*Table structure for table `caso_actividad` */

DROP TABLE IF EXISTS `caso_actividad`;

CREATE TABLE `caso_actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caso_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_caso_actividad_actividad_idx` (`actividad_id`),
  KEY `fk_caso_actividad_caso_idx` (`caso_id`),
  CONSTRAINT `fk_caso_actividad_actividad` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_caso_actividad_caso` FOREIGN KEY (`caso_id`) REFERENCES `caso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `caso_actividad` */

/*Table structure for table `caso_documento` */

DROP TABLE IF EXISTS `caso_documento`;

CREATE TABLE `caso_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caso_id` int(11) NOT NULL,
  `documento_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_caso_documento_caso_idx` (`caso_id`),
  KEY `fk_caso_documento_documento_idx` (`documento_id`),
  CONSTRAINT `fk_caso_documento_caso` FOREIGN KEY (`caso_id`) REFERENCES `caso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_caso_documento_documento` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `caso_documento` */

/*Table structure for table `categoria` */

DROP TABLE IF EXISTS `categoria`;

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_padre_id` varchar(50) DEFAULT NULL COMMENT 'Utilizado para las sub categorias\n- Se muestran todas las categorías existentes separando los diferentes\nniveles por guiones. Ejemplo: Audio – Sonido – Plantas de Sonido.\n- En caso de haber una categoría inactiva no debe de mostrar todas las\ncategorías hijas.',
  `estado_id` int(11) NOT NULL COMMENT 'Estado actual',
  `referencia` varchar(45) NOT NULL COMMENT 'Referencia de la Categoria',
  `descripcion` text COMMENT 'Descripción de la Categoria',
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  `eliminado` tinyint(4) DEFAULT '0' COMMENT 'Si el valor es 1, estará eliminada\nSi el valor es 0, estará visible',
  PRIMARY KEY (`id`),
  KEY `fk_categoria_categoria_idx` (`categoria_padre_id`),
  KEY `fk_categoria_estado_idx` (`estado_id`),
  CONSTRAINT `fk_categoria_estado` FOREIGN KEY (`estado_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `categoria` */

/*Table structure for table `ciudad` */

DROP TABLE IF EXISTS `ciudad`;

CREATE TABLE `ciudad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departamento_id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_por` varchar(20) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_ciudad_departamento1_idx` (`departamento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ciudad` */

/*Table structure for table `cliente_potencial` */

DROP TABLE IF EXISTS `cliente_potencial`;

CREATE TABLE `cliente_potencial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `view_ubicacion_id` varchar(45) DEFAULT NULL COMMENT 'Id de la vista view_ubicacion',
  `clasificacion_id` int(11) DEFAULT NULL,
  `toma_contacto_id` int(11) DEFAULT NULL,
  `asesor_id` int(11) NOT NULL COMMENT 'Id del usuario del sistema aquien se asigna dicho cliente',
  `estado_id` int(11) NOT NULL COMMENT 'Id del estado del contacto frente a la opcion de negocio',
  `nombres` varchar(45) NOT NULL COMMENT 'Nombre del contacto',
  `apellidos` varchar(45) NOT NULL COMMENT 'Apellido del contacto',
  `nombre_empresa` varchar(45) DEFAULT NULL,
  `cargo` varchar(45) NOT NULL COMMENT 'Cargo del contacto',
  `edad` int(11) DEFAULT NULL COMMENT 'Cuando se seleccione la fecha de nacimiento del calendario se debe de\ncalcular la edad.',
  `descripcion` text COMMENT 'Descripcion del contacto',
  `direccion_web` varchar(45) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL COMMENT 'Fecha en la cual el contacto ha nacido.\nCuando se seleccione la fecha de nacimiento del calendario se debe de\ncalcular la edad.',
  `departamento` varchar(100) DEFAULT NULL COMMENT 'Departamento o área donde labora el empleado',
  `descripcion_estado` text,
  `descripcion_toma_contacto` text,
  `referido_por` varchar(45) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `convertido` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_contacto_asesor_id_idx` (`asesor_id`),
  KEY `fk_contacto_estado_idx` (`estado_id`),
  CONSTRAINT `fk_contacto_asesor0` FOREIGN KEY (`asesor_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contacto_estado0` FOREIGN KEY (`estado_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `cliente_potencial` */

/*Table structure for table `cliente_potencial_actividad` */

DROP TABLE IF EXISTS `cliente_potencial_actividad`;

CREATE TABLE `cliente_potencial_actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_potencial_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cliente_potencial_actividad_cliente_potencial_idx` (`cliente_potencial_id`),
  KEY `fk_cliente_potencial_actividad_actividad_idx` (`actividad_id`),
  CONSTRAINT `fk_cliente_potencial_actividad_actividad` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_potencial_actividad_cliente_potencial` FOREIGN KEY (`cliente_potencial_id`) REFERENCES `cliente_potencial` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `cliente_potencial_actividad` */

/*Table structure for table `cliente_potencial_correo` */

DROP TABLE IF EXISTS `cliente_potencial_correo`;

CREATE TABLE `cliente_potencial_correo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_potencial_id` int(11) NOT NULL,
  `correo_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_potencial_correo_correo_idx` (`correo_id`),
  KEY `fk_cliente_potencial_correo_cliente_poytencial_idx` (`cliente_potencial_id`),
  CONSTRAINT `fk_cliente_potencial_correo_cliente_poytencial` FOREIGN KEY (`cliente_potencial_id`) REFERENCES `cliente_potencial` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_potencial_correo_correo` FOREIGN KEY (`correo_id`) REFERENCES `correo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `cliente_potencial_correo` */

/*Table structure for table `cliente_potencial_direccion` */

DROP TABLE IF EXISTS `cliente_potencial_direccion`;

CREATE TABLE `cliente_potencial_direccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_potencial_id` int(11) NOT NULL,
  `direccion_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cliente_potencial_direccion_direccion_idx` (`direccion_id`),
  KEY `fk_cliente_potencial_direccion_cliente_potencial_idx` (`cliente_potencial_id`),
  CONSTRAINT `fk_cliente_potencial_direccion_cliente_potencial` FOREIGN KEY (`cliente_potencial_id`) REFERENCES `cliente_potencial` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_potencial_direccion_direccion` FOREIGN KEY (`direccion_id`) REFERENCES `direccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `cliente_potencial_direccion` */

/*Table structure for table `cliente_potencial_documento` */

DROP TABLE IF EXISTS `cliente_potencial_documento`;

CREATE TABLE `cliente_potencial_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_potencial_id` int(11) NOT NULL,
  `documento_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cliente_potencial_documento_cliente_potencial_idx` (`cliente_potencial_id`),
  KEY `fk_cliente_potencial_documento_documento_idx` (`documento_id`),
  CONSTRAINT `fk_cliente_potencial_documento_cliente_potencial` FOREIGN KEY (`cliente_potencial_id`) REFERENCES `cliente_potencial` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_potencial_documento_documento` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `cliente_potencial_documento` */

/*Table structure for table `cliente_potencial_telefono` */

DROP TABLE IF EXISTS `cliente_potencial_telefono`;

CREATE TABLE `cliente_potencial_telefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_potencial_id` int(11) NOT NULL,
  `telefono_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_potencial_telefono_telefono_idx` (`telefono_id`),
  KEY `fk_cliente_potencial_telefono_cliente_potencial_idx` (`cliente_potencial_id`),
  CONSTRAINT `fk_cliente_potencial_telefono_cliente_potencial` FOREIGN KEY (`cliente_potencial_id`) REFERENCES `cliente_potencial` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_potencial_telefono_telefono` FOREIGN KEY (`telefono_id`) REFERENCES `telefono` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `cliente_potencial_telefono` */

/*Table structure for table `contacto` */

DROP TABLE IF EXISTS `contacto`;

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL COMMENT 'Id del cliente al que esta relacionado el contacto.\nCuando se selecciona el cliente en la lista desplegable de Informa a deben de\naparecer todos los contactos del cliente seleccionado.',
  `informa_a_id` int(11) DEFAULT NULL COMMENT 'Id del contacto con el cual se relaciona el nuevo contacto del mismo cliente.\n',
  `view_ubicacion_id` varchar(45) DEFAULT NULL COMMENT 'Id de la vista view_ubicacion',
  `asesor_id` int(11) NOT NULL COMMENT 'Id del usuario del sistema aquien se asigna dicho cliente',
  `estado_id` int(11) NOT NULL COMMENT 'Id del estado del contacto frente a la opcion de negocio',
  `nombres` varchar(45) NOT NULL COMMENT 'Nombre del contacto',
  `apellidos` varchar(45) NOT NULL COMMENT 'Apellido del contacto',
  `cargo` varchar(45) NOT NULL COMMENT 'Cargo del contacto',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `departamento` varchar(100) DEFAULT NULL COMMENT 'Departamento o área donde labora el empleado',
  `fecha_nacimiento` date DEFAULT NULL COMMENT 'Fecha en la cual el contacto ha nacido.\nCuando se seleccione la fecha de nacimiento del calendario se debe de\ncalcular la edad.',
  `edad` int(11) DEFAULT NULL COMMENT 'Cuando se seleccione la fecha de nacimiento del calendario se debe de\ncalcular la edad.',
  `descripcion` text COMMENT 'Descripcion del contacto',
  `direccion_web` varchar(45) DEFAULT NULL,
  `cliente_potencial_id` int(11) DEFAULT NULL,
  `numero_documento` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contacto_cliente1_idx` (`cuenta_id`),
  KEY `fk_contacto_asesor_id_idx` (`asesor_id`),
  KEY `fk_contacto_estado_idx` (`estado_id`),
  CONSTRAINT `fk_contacto_asesor` FOREIGN KEY (`asesor_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contacto_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contacto_estado` FOREIGN KEY (`estado_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `contacto` */

/*Table structure for table `contacto_actividad` */

DROP TABLE IF EXISTS `contacto_actividad`;

CREATE TABLE `contacto_actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contacto_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_contacto_actividad_contacto_idx` (`contacto_id`),
  KEY `fk_contacto_actividad_actividad_idx` (`actividad_id`),
  CONSTRAINT `fk_contacto_actividad_actividad` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contacto_actividad_contacto` FOREIGN KEY (`contacto_id`) REFERENCES `contacto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `contacto_actividad` */

/*Table structure for table `contacto_correo` */

DROP TABLE IF EXISTS `contacto_correo`;

CREATE TABLE `contacto_correo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contacto_id` int(11) NOT NULL,
  `correo_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_contacto_correo_contacto_idx` (`contacto_id`),
  KEY `fk_contacto_correo_correo_idx` (`correo_id`),
  CONSTRAINT `fk_contacto_correo_contacto` FOREIGN KEY (`contacto_id`) REFERENCES `contacto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contacto_correo_correo` FOREIGN KEY (`correo_id`) REFERENCES `correo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `contacto_correo` */

/*Table structure for table `contacto_direccion` */

DROP TABLE IF EXISTS `contacto_direccion`;

CREATE TABLE `contacto_direccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contacto_id` int(11) NOT NULL,
  `direccion_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_contacto_correo_contacto_idx` (`contacto_id`),
  KEY `fk_contacto_direccion_direccion_idx` (`direccion_id`),
  CONSTRAINT `fk_contacto_direccion_contacto` FOREIGN KEY (`contacto_id`) REFERENCES `contacto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contacto_direccion_direccion` FOREIGN KEY (`direccion_id`) REFERENCES `direccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `contacto_direccion` */

/*Table structure for table `contacto_documento` */

DROP TABLE IF EXISTS `contacto_documento`;

CREATE TABLE `contacto_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contacto_id` int(11) NOT NULL,
  `documento_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_contacto_documento_contacto_idx` (`contacto_id`),
  KEY `fk_contacto_documento_documento_idx` (`documento_id`),
  CONSTRAINT `fk_contacto_documento_contacto` FOREIGN KEY (`contacto_id`) REFERENCES `contacto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contacto_documento_documento` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `contacto_documento` */

/*Table structure for table `contacto_telefono` */

DROP TABLE IF EXISTS `contacto_telefono`;

CREATE TABLE `contacto_telefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contacto_id` int(11) NOT NULL,
  `telefono_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contacto_telefono_contacto_idx` (`contacto_id`),
  KEY `fk_contacto_telefono_telefono_idx` (`telefono_id`),
  CONSTRAINT `fk_contacto_telefono_contacto` FOREIGN KEY (`contacto_id`) REFERENCES `contacto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contacto_telefono_telefono` FOREIGN KEY (`telefono_id`) REFERENCES `telefono` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `contacto_telefono` */

/*Table structure for table `contrasenia` */

DROP TABLE IF EXISTS `contrasenia`;

CREATE TABLE `contrasenia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `hash` varchar(45) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_contrasenia_usuario1_idx` (`usuario_id`),
  CONSTRAINT `contrasenia_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `contrasenia` */

insert  into `contrasenia`(`id`,`usuario_id`,`hash`,`fecha_creacion`,`fecha_modificacion`,`eliminado`) values (6,1,'ca3f472ffc7674218ccb17aa6fd85ae7be7b3812',NULL,NULL,0),(8,5,'32d7286e33c7f4ec312d01012cb11dac5261071d',NULL,NULL,0),(11,7,'0d8a1ccdefd3b1111968959afaeb056f88e91b18',NULL,NULL,0);

/*Table structure for table `convenio` */

DROP TABLE IF EXISTS `convenio`;

CREATE TABLE `convenio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) DEFAULT NULL,
  `modalidad_cobro_id` int(11) DEFAULT NULL,
  `periodo_cobro_id` int(11) DEFAULT NULL,
  `estado_servicio_id` int(11) DEFAULT NULL,
  `responsable_id` int(11) DEFAULT NULL,
  `tipo_servicio_id` varchar(145) DEFAULT NULL,
  `tipo_servicio_str` varchar(255) DEFAULT NULL,
  `linea_id` varchar(145) DEFAULT NULL,
  `linea_str` varchar(255) DEFAULT NULL,
  `forma_pago_id` int(11) DEFAULT NULL,
  `fecha_vigencia_desde` date DEFAULT NULL,
  `fecha_vigencia_hasta` date DEFAULT NULL,
  `valor_servicio` varchar(45) DEFAULT NULL,
  `tarifa` varchar(45) DEFAULT NULL,
  `tarifa_obs` varchar(45) DEFAULT NULL,
  `condiciones_comerciales` text,
  `descripcion` text,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  `eliminado` tinyint(4) DEFAULT '0',
  `convenio_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_convenio_responsable_idx` (`responsable_id`),
  KEY `fk_convenio_cuenta_idx` (`cuenta_id`),
  CONSTRAINT `fk_convenio_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_convenio_responsable` FOREIGN KEY (`responsable_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `convenio` */

/*Table structure for table `convenio_actividad` */

DROP TABLE IF EXISTS `convenio_actividad`;

CREATE TABLE `convenio_actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `convenio_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_convenio_actividad_convenio_idx` (`convenio_id`),
  KEY `fk_convenio_actividad_actividad_idx` (`actividad_id`),
  CONSTRAINT `fk_convenio_actividad_actividad` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_convenio_actividad_convenio` FOREIGN KEY (`convenio_id`) REFERENCES `convenio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `convenio_actividad` */

/*Table structure for table `convenio_documento` */

DROP TABLE IF EXISTS `convenio_documento`;

CREATE TABLE `convenio_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `convenio_id` int(11) NOT NULL,
  `documento_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_convenio_documento_docuemnto_idx` (`documento_id`),
  KEY `fk_convenio_documento_convenio_idx` (`convenio_id`),
  CONSTRAINT `fk_convenio_documento_convenio` FOREIGN KEY (`convenio_id`) REFERENCES `convenio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_convenio_documento_docuemnto` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `convenio_documento` */

/*Table structure for table `correo` */

DROP TABLE IF EXISTS `correo`;

CREATE TABLE `correo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(45) NOT NULL,
  `principal` tinyint(4) DEFAULT '0',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT '0',
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

/*Data for the table `correo` */

/*Table structure for table `cotizacion` */

DROP TABLE IF EXISTS `cotizacion`;

CREATE TABLE `cotizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL COMMENT 'Id del cliente a quien pertenece la cotización.\nCuando se seleccione el campo de cliente se debe de filtrar la lista de las\noportunidades.',
  `etapa_id` int(11) NOT NULL COMMENT 'Estado de la cotización',
  `asesor_id` int(11) NOT NULL COMMENT 'Id del usuario del sistema a quien se asigna dicha cotización',
  `oportunidad_id` int(11) DEFAULT NULL COMMENT 'Id de la oportunidad flitrada por cliente, \ncon la cual esta relacionada la cotización',
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  `eliminado` tinyint(4) DEFAULT '0',
  `descripcion` text COMMENT 'Descripción de la cotización',
  `subtotal` varchar(45) DEFAULT NULL COMMENT 'Valor de la sumatoria del valor total de los productos en el detalle',
  `descuento` varchar(45) DEFAULT '0' COMMENT 'Descuento asignado a la cotización',
  `iva` int(11) DEFAULT NULL COMMENT 'El valor del IVA asignado a la cotización',
  `retencion` int(11) DEFAULT NULL COMMENT 'El valor de la retención asignado a la cotización',
  `numero` varchar(45) DEFAULT NULL COMMENT 'El sistema debe de generar un consecutivo para el campo Número, que es\nautoincremental.',
  `linea_id` varchar(45) DEFAULT NULL,
  `linea_str` varchar(145) DEFAULT NULL,
  `fecha_caducidad` date DEFAULT NULL,
  `numero_factura` varchar(20) DEFAULT NULL,
  `fecha_cierre` date DEFAULT NULL,
  `fecha_factura` date DEFAULT NULL,
  `version_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cotizacion_cliente_idx` (`cuenta_id`),
  KEY `fk_cotizacion_asesor_idx` (`asesor_id`),
  KEY `fk_cotizacion_oportunidad_idx` (`oportunidad_id`),
  CONSTRAINT `fk_cotizacion_asesor` FOREIGN KEY (`asesor_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cotizacion_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cotizacion_oportunidad` FOREIGN KEY (`oportunidad_id`) REFERENCES `oportunidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

/*Data for the table `cotizacion` */

/*Table structure for table `cotizacion_documento` */

DROP TABLE IF EXISTS `cotizacion_documento`;

CREATE TABLE `cotizacion_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cotizacion_id` int(11) NOT NULL,
  `documento_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cotizacion_documento_cotizacion_idx` (`cotizacion_id`),
  KEY `fk_cotizacion_documento_documento_idx` (`documento_id`),
  CONSTRAINT `fk_cotizacion_documento_cotizacion` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cotizacion_documento_documento` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cotizacion_documento` */

/*Table structure for table `cuenta` */

DROP TABLE IF EXISTS `cuenta`;

CREATE TABLE `cuenta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naturaleza_id` int(11) NOT NULL COMMENT 'Id del tipo de naturaleza como puede ser definido un cliente.\n- Si se selecciona Naturaleza Jurídica se muestran los campos de Nombre\nComercial y Razón Social.\n- Si se selecciona Natural se muestran los campos de Nombres y Apellidos.',
  `tipo_documento_id` int(11) DEFAULT NULL COMMENT 'Id del tipo de documento ',
  `view_ubicacion_id` varchar(45) DEFAULT NULL COMMENT 'Id de la vista view_ubicacion',
  `asesor_asignado_id` int(11) NOT NULL COMMENT 'Id del usuario del sistema aquien se asigna dicho cliente',
  `estado_id` int(11) NOT NULL COMMENT 'Id del estado del cliente frente a la opcion de negocio',
  `clasificacion_id` int(11) NOT NULL COMMENT 'Id de la clasificación del cliente',
  `segmento_id` varchar(45) DEFAULT NULL,
  `toma_contacto_id` int(11) DEFAULT NULL COMMENT 'Id de "tomado de contacto"',
  `nombres` varchar(45) DEFAULT NULL COMMENT 'Nombre del cliente, usado cuando la naturaleza del cliente es Natural',
  `apellidos` varchar(45) DEFAULT NULL COMMENT 'Apellidos del cliente, usado cuando la naturaleza del cliente es Natural',
  `tipo_cuenta_id` int(11) DEFAULT NULL COMMENT 'NA',
  `num_documento` varchar(200) DEFAULT NULL COMMENT 'Numero de identificación o NIT, de acuerdo a la naturaleza del cliente',
  `descripcion` text COMMENT 'Descripción del cliente',
  `direccion_web` varchar(45) DEFAULT NULL COMMENT 'URL de la página web del cliente',
  `nombre_comercial` varchar(45) DEFAULT NULL COMMENT 'Nombre comercial del cliente, usado cuando la naturaleza \ndel cliente es Jurídica',
  `razon_social` varchar(45) DEFAULT NULL COMMENT 'Razón social del cliente, usado cuando la naturaleza \ndel cliente es Jurídica',
  `descendiente` int(11) DEFAULT NULL COMMENT 'NA',
  `calificacion` varchar(45) DEFAULT NULL COMMENT 'NA',
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `creado_por` varchar(20) DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `descripcion_estado` text COMMENT 'Descripción del estado del cliente',
  `referido_por` varchar(45) DEFAULT NULL COMMENT 'El campo de referido por se muestra cuando se seleccione la opción de\nReferido en Toma de Contacto.',
  `descripcion_toma_contacto` text COMMENT 'Se describe la toma de contacto',
  `cliente_potencial_id` int(11) DEFAULT NULL,
  `cupo_credito` varchar(45) DEFAULT NULL,
  `fecha_cartera` date DEFAULT NULL,
  `valor_cartera` varchar(45) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cuenta_tipo_documento1_idx` (`tipo_documento_id`),
  KEY `fk_cuenta_naturaleza1_idx` (`naturaleza_id`),
  KEY `fk_cuenta_usuario1_idx` (`asesor_asignado_id`),
  KEY `fk_cliente_clasificacion_idx` (`estado_id`),
  KEY `fk_cuenta_clasificacion_idx1` (`clasificacion_id`),
  KEY `fk_cuenta_toma_contacto_idx` (`toma_contacto_id`),
  CONSTRAINT `fk_cuenta_asesor` FOREIGN KEY (`asesor_asignado_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_clasificacion` FOREIGN KEY (`clasificacion_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_estado` FOREIGN KEY (`estado_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_naturaleza` FOREIGN KEY (`naturaleza_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_tipo_documento` FOREIGN KEY (`tipo_documento_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_toma_contacto` FOREIGN KEY (`toma_contacto_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `cuenta` */

/*Table structure for table `cuenta_actividad` */

DROP TABLE IF EXISTS `cuenta_actividad`;

CREATE TABLE `cuenta_actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cliente_actividad_cliente_idx` (`cuenta_id`),
  KEY `fk_cliente_actividad_actividad_idx` (`actividad_id`),
  CONSTRAINT `fk_cliente_actividad_actividad` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_actividad_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

/*Data for the table `cuenta_actividad` */

/*Table structure for table `cuenta_correo` */

DROP TABLE IF EXISTS `cuenta_correo`;

CREATE TABLE `cuenta_correo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL,
  `correo_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cuenta_correo_correo_idx` (`correo_id`),
  KEY `fk_cuenta_correo_cuenta_idx` (`cuenta_id`),
  CONSTRAINT `fk_cuenta_correo_correo` FOREIGN KEY (`correo_id`) REFERENCES `correo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_correo_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `cuenta_correo` */

/*Table structure for table `cuenta_direccion` */

DROP TABLE IF EXISTS `cuenta_direccion`;

CREATE TABLE `cuenta_direccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL,
  `direccion_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cuenta_direccion_cuenta_idx` (`cuenta_id`),
  KEY `fk_cuenta_direccion_direccion_idx` (`direccion_id`),
  CONSTRAINT `fk_cuenta_direccion_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_direccion_direccion` FOREIGN KEY (`direccion_id`) REFERENCES `direccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `cuenta_direccion` */

/*Table structure for table `cuenta_documento` */

DROP TABLE IF EXISTS `cuenta_documento`;

CREATE TABLE `cuenta_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL,
  `documento_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cuenta_documento_documento_idx` (`documento_id`),
  KEY `fk_cuenta_documento_cliente_idx` (`cuenta_id`),
  CONSTRAINT `fk_cuenta_documento_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_documento_documento` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `cuenta_documento` */

/*Table structure for table `cuenta_telefono` */

DROP TABLE IF EXISTS `cuenta_telefono`;

CREATE TABLE `cuenta_telefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL,
  `telefono_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cuenta_telefono_cuenta_idx` (`cuenta_id`),
  KEY `fk_cuenta_telefono_telefono_idx` (`telefono_id`),
  CONSTRAINT `fk_cuenta_telefono_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_telefono_telefono` FOREIGN KEY (`telefono_id`) REFERENCES `telefono` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `cuenta_telefono` */

/*Table structure for table `departamento` */

DROP TABLE IF EXISTS `departamento`;

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais_id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_por` varchar(20) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_departamento_pais1_idx` (`pais_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `departamento` */

/*Table structure for table `detalle_cotizacion` */

DROP TABLE IF EXISTS `detalle_cotizacion`;

CREATE TABLE `detalle_cotizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL COMMENT 'Id del producto seleccionado',
  `cotizacion_id` int(11) NOT NULL COMMENT 'Id de la cotización con la cual esta relacionada.',
  `cantidad` int(11) NOT NULL COMMENT 'Cantidad de productos para la cotización',
  `activo` tinyint(4) DEFAULT '1',
  `eliminado` tinyint(4) DEFAULT '0',
  `valor_unitario` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_cotizacion_cotizacion_idx` (`cotizacion_id`),
  KEY `fk_detalle_cotizacion_producto_idx` (`producto_id`),
  CONSTRAINT `fk_detalle_cotizacion_cotizacion` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_cotizacion_producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Data for the table `detalle_cotizacion` */

/*Table structure for table `direccion` */

DROP TABLE IF EXISTS `direccion`;

CREATE TABLE `direccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `direccion` varchar(45) DEFAULT NULL,
  `barrio` varchar(45) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

/*Data for the table `direccion` */

/*Table structure for table `documento` */

DROP TABLE IF EXISTS `documento`;

CREATE TABLE `documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo_relacionado_id` int(11) DEFAULT NULL,
  `modulo_relacionado` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `adjunto` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `categoria` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `tipo_documento` varchar(45) DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `nombre_adjunto` varchar(45) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `descripcion` text,
  `activo` tinyint(1) DEFAULT '1',
  `eliminado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_documento_modulo_idx` (`modulo_relacionado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='CREATE TABLE IF NOT EXISTS `nicecrm-inmo`.`documentos` (\n  `id` INT(11) NOT NULL AUTO_INCREMENT,\n  `modulo_relacionado_id` VARCHAR(45) NULL DEFAULT NULL,\n  `modulo_relacionado` VARCHAR(45) NULL DEFAULT NULL,\n  `nombre` VARCHAR(45) NULL DEFAULT NULL,\n  `adjunto` VARCHAR(255) NULL DEFAULT NULL,\n  `version` VARCHAR(45) NULL,\n  `categoria` VARCHAR(45) NULL DEFAULT NULL,\n  `estado` VARCHAR(45) NULL DEFAULT NULL,\n  `tipo_documento` VARCHAR(45) NULL DEFAULT NULL,\n  `fecha_publicacion` DATE NULL DEFAULT NULL,\n  `creado_por` VARCHAR(45) NULL DEFAULT NULL,\n  `fecha_creacion` DATE NULL DEFAULT NULL,\n  `descripcion` VARCHAR(255) NULL DEFAULT NULL,\n  `activo` TINYINT(1) NULL DEFAULT ''1'',\n  `eliminado` TINYINT(1) NULL DEFAULT ''0'',\n  PRIMARY KEY (`id`))\nENGINE = InnoDB\n\nDEFAULT CHARACTER SET = utf8';

/*Data for the table `documento` */

/*Table structure for table `foto` */

DROP TABLE IF EXISTS `foto`;

CREATE TABLE `foto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `bandera` tinyint(1) DEFAULT '0',
  `path` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `eliminado` tinyint(1) DEFAULT '0',
  `gestion_inmueble_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_foto_gestion_inmueble_idx` (`gestion_inmueble_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `foto` */

/*Table structure for table `invitado` */

DROP TABLE IF EXISTS `invitado`;

CREATE TABLE `invitado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo_actividad` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `nombre_actividad` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `email_actividad` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT '0',
  `actividad_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invitado_actividad1_idx` (`actividad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `invitado` */

/*Table structure for table `lista_maestra` */

DROP TABLE IF EXISTS `lista_maestra`;

CREATE TABLE `lista_maestra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo_id` int(11) DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `etiqueta` varchar(150) NOT NULL,
  `general` tinyint(1) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_lista_maestra_modulo1_idx` (`modulo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

/*Data for the table `lista_maestra` */

insert  into `lista_maestra`(`id`,`modulo_id`,`nombre`,`etiqueta`,`general`,`activo`,`eliminado`) values (1,NULL,'tipo permiso','tipo_permiso',1,1,0),(2,NULL,'esatdo','estado',1,1,0),(3,NULL,'toma_de_contacto','toma_de_contacto',1,1,0),(4,0,'clasificacion','clasificacion',1,1,0),(5,26,'tipo','tipo',0,1,0),(6,5,'etapa','etapa',0,1,0),(7,23,'estado','estado',0,1,0),(8,23,'iva','iva',0,1,0),(9,23,'retencion','retencion',0,1,0),(10,12,'estado','estado',0,1,0),(11,12,'naturaleza','naturaleza',0,1,0),(12,12,'tipo de documento','tipo_de_documento',0,1,0),(13,1,'tipo','tipo',0,1,0),(14,1,'tipo_llamada','tipo_llamada',0,1,0),(15,1,'estado_llamada','estado_llamada',0,1,0),(16,1,'estado_reunion','estado_reunion',0,1,0),(17,1,'estado_tarea','estado_tarea',0,1,0),(18,1,'aviso','aviso',0,1,0),(19,1,'prioridad','prioridad',0,1,0),(20,25,'tipo acuerdo','tipo_acuerdo',0,1,0),(21,25,'modalidad cobro','modalidad_cobro',0,1,0),(22,25,'periodo cobro','periodo_cobro',0,1,0),(23,NULL,'linea','linea',1,1,0),(24,25,'tipo servicio','tipo_servicio',0,1,0),(25,25,'estado servicio','estado_servicio',0,1,0),(26,14,'tipo','tipo',0,1,0),(27,14,'origen','origen',0,1,0),(28,14,'prioridad','prioridad',0,1,0),(29,14,'estado','estado',0,1,0),(30,7,'estado','estado',0,1,0),(31,25,'forma pago','forma_pago',0,1,0),(32,2,'arl','arl',0,1,0),(33,2,'afp','afp',0,1,0),(34,2,'eps','eps',0,1,0),(35,2,'Tipo contrato','tipo_contrato',0,1,0),(36,12,'tipo cuenta','tipo_cuenta',0,1,0),(37,23,'version','version',0,1,0),(38,NULL,'rol','rol',1,1,0),(39,9,'objetivo busqueda','objetivo_busqueda',0,1,1),(40,9,'estado demanda','estado_demanda',0,1,1),(41,18,'plazo firma documento','plazo_firma_documento',0,1,1),(42,14,'prioridad','prioridad',0,1,1),(43,14,'estado caso','estado_caso',0,1,1),(44,19,'modulo','modulo',0,1,1),(45,19,'tipo_documento','tipo_documento',0,1,1),(46,19,'estado','estado',0,1,1),(47,19,'categoria','categoria',0,1,1),(48,20,'mes','mes',0,1,1),(49,20,'tipo','tipo',0,1,1),(50,1,'tipo','tipo',0,1,1),(51,1,'tipo_llamada','tipo_llamada',0,1,1),(52,1,'estado_llamada','estado_llamada',0,1,1),(53,1,'estado_reunion','estado_reunion',0,1,1),(54,1,'estado_tarea','estado_tarea',0,1,1),(55,1,'aviso','aviso',0,1,1),(56,1,'prioridad','prioridad',0,1,1),(57,7,'ubicado en','ubicado_en',0,1,1),(58,7,'tipo oficina','tipo_oficina',0,1,1),(59,NULL,'meses','meses',1,1,1),(60,NULL,'cargo_inmueble','cargo_inmueble',1,1,1),(61,NULL,'negociable','negociable',1,1,1),(62,7,'tipo_amoblado','tipo_amoblado',0,1,1),(63,12,'segmento','segmento',0,1,0);

/*Table structure for table `lista_precio` */

DROP TABLE IF EXISTS `lista_precio`;

CREATE TABLE `lista_precio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_id` int(11) NOT NULL COMMENT 'Id del tipo de lista de precio.\nCuando se seleccione el tipo de cliente:\n- Si es Cliente se oculta el campo Clasificación Cliente y se muestra el\ncampo Cliente.\n- Si es Clasificación Cliente se oculta el campo de cliente y se muestra el\ncampo de clasificación cliente.',
  `clasificacion_id` int(11) DEFAULT NULL COMMENT 'Id de clasificación de la lista de precio',
  `estado_id` int(11) NOT NULL COMMENT 'Id del estado de la lista de precio',
  `cuenta_id` int(11) DEFAULT NULL COMMENT 'Id del cliente en la lista de precio',
  `referencia` varchar(45) NOT NULL COMMENT 'Referencia de la lista de precio',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio de la lista de precio',
  `fecha_fin` date NOT NULL COMMENT 'Fecha de fin de la lista de precio',
  `descripcion` text COMMENT 'Descripción de la lista de precio',
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  `eliminado` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_lista_precio_tipo_idx` (`tipo_id`),
  KEY `fk_lista_precio_clasificacion_idx` (`clasificacion_id`),
  KEY `fk_lista_precio_estado_idx` (`estado_id`),
  KEY `fk_lista_precio_cliente_idx` (`cuenta_id`),
  CONSTRAINT `fk_lista_precio_clasificacion` FOREIGN KEY (`clasificacion_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lista_precio_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lista_precio_estado` FOREIGN KEY (`estado_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lista_precio_tipo` FOREIGN KEY (`tipo_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `lista_precio` */

/*Table structure for table `lista_precio_producto` */

DROP TABLE IF EXISTS `lista_precio_producto`;

CREATE TABLE `lista_precio_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lista_precio_id` int(11) NOT NULL COMMENT 'Id de la lista de precio relacionado',
  `producto_id` int(11) NOT NULL COMMENT 'Id del producto seleccionado',
  `eliminado` tinyint(4) DEFAULT '0',
  `precio` varchar(45) DEFAULT NULL COMMENT 'Precio del producto seleccionado',
  PRIMARY KEY (`id`),
  KEY `fk_precio_lista_precio_idx` (`lista_precio_id`),
  KEY `fk_precio_producto_idx` (`producto_id`),
  CONSTRAINT `fk_precio_lista_precio` FOREIGN KEY (`lista_precio_id`) REFERENCES `lista_precio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_precio_producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `lista_precio_producto` */

/*Table structure for table `modulo` */

DROP TABLE IF EXISTS `modulo`;

CREATE TABLE `modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `modulo` */

insert  into `modulo`(`id`,`nombre`,`activo`,`fecha_creacion`,`fecha_modificacion`,`eliminado`) values (1,'actividades',1,NULL,NULL,0),(2,'usuarios',1,NULL,NULL,0),(3,'reportes',1,NULL,NULL,0),(4,'perfiles',1,NULL,NULL,0),(5,'oportunidades',1,NULL,NULL,0),(6,'listasmaestras',1,NULL,NULL,0),(7,'clientes_potenciales',1,NULL,NULL,0),(8,'home',1,NULL,NULL,0),(9,'demandas',1,NULL,NULL,0),(10,'config_lista_maestra',1,NULL,NULL,0),(11,'configuracion',1,NULL,NULL,0),(12,'cuentas',1,NULL,NULL,0),(13,'ciudades',1,NULL,NULL,0),(14,'casos',1,NULL,NULL,0),(15,'captaciones',1,NULL,NULL,0),(16,'calendario',1,NULL,NULL,0),(17,'ubicaciones',1,NULL,NULL,0),(18,'gestion_inmuebles',1,NULL,NULL,0),(19,'documentos',1,NULL,NULL,0),(20,'metas',1,NULL,NULL,0),(21,'contratos',1,NULL,NULL,0),(22,'contactos',1,NULL,NULL,0),(23,'cotizaciones',1,NULL,NULL,0),(24,'productos',1,NULL,NULL,0),(25,'acuerdos',1,NULL,NULL,0),(26,'lista_precios',1,NULL,NULL,0),(27,'buscador',1,NULL,NULL,0),(28,'categorias',1,NULL,NULL,0),(29,'convenios',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0),(30,'servicios',1,NULL,NULL,0);

/*Table structure for table `modulo_accion` */

DROP TABLE IF EXISTS `modulo_accion`;

CREATE TABLE `modulo_accion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo_id` int(11) NOT NULL,
  `accion_id` int(11) NOT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `eliminado` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modulo_id` (`modulo_id`),
  KEY `accion_id` (`accion_id`),
  CONSTRAINT `fk_modulo_accion_1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `modulo_accion_ibfk_2` FOREIGN KEY (`accion_id`) REFERENCES `accion` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1680 DEFAULT CHARSET=latin1;

/*Data for the table `modulo_accion` */

insert  into `modulo_accion`(`id`,`modulo_id`,`accion_id`,`activo`,`eliminado`) values (1,23,1,1,0),(2,23,2,1,0),(3,23,3,1,0),(4,23,4,1,0),(5,23,5,1,0),(6,2,1,1,0),(7,2,2,1,0),(8,2,3,1,0),(9,2,4,1,0),(10,2,5,1,0),(11,4,1,1,0),(12,4,2,1,0),(13,4,3,1,0),(14,4,4,1,0),(15,4,5,1,0),(16,22,1,1,0),(17,22,2,1,0),(18,22,3,1,0),(19,22,4,1,0),(20,22,5,1,0),(21,3,1,1,0),(22,3,2,1,0),(23,3,3,1,0),(24,3,4,1,0),(25,3,5,1,0),(26,13,1,1,0),(27,13,2,1,0),(28,13,3,1,0),(29,13,4,1,0),(30,13,5,1,0),(31,14,1,1,0),(32,14,2,1,0),(33,14,3,1,0),(34,14,4,1,0),(35,14,5,1,0),(36,5,1,1,0),(37,5,2,1,0),(38,5,3,1,0),(39,5,4,1,0),(40,5,5,1,0),(41,1,1,1,0),(42,1,2,1,0),(43,1,3,1,0),(44,1,4,1,0),(45,1,5,1,0),(46,19,1,1,0),(47,19,2,1,0),(48,19,3,1,0),(49,19,4,1,0),(50,19,5,1,0),(51,16,1,1,0),(52,16,2,1,0),(53,16,3,1,0),(54,16,4,1,0),(55,16,5,1,0),(56,8,1,1,0),(57,8,2,1,0),(58,8,3,1,0),(59,8,4,1,0),(60,8,5,1,0),(61,6,1,1,0),(62,6,2,1,0),(63,6,3,1,0),(64,6,4,1,0),(65,6,5,1,0),(66,17,1,1,0),(67,17,2,1,0),(68,17,3,1,0),(69,17,4,1,0),(70,17,5,1,0),(71,27,1,1,0),(72,27,2,1,0),(73,27,3,1,0),(74,27,4,1,0),(75,27,5,1,0),(76,7,1,1,0),(77,7,2,1,0),(78,7,3,1,0),(79,7,4,1,0),(80,7,5,1,0),(81,12,1,1,0),(82,12,2,1,0),(83,12,3,1,0),(84,12,4,1,0),(85,12,5,1,0),(86,25,1,1,0),(87,25,2,1,0),(88,25,3,1,0),(89,25,4,1,0),(90,25,5,1,0),(91,26,1,1,0),(92,26,2,1,0),(93,26,3,1,0),(94,26,4,1,0),(95,26,5,1,0),(96,24,1,1,0),(97,24,2,1,0),(98,24,3,1,0),(99,24,4,1,0),(100,24,5,1,0),(101,28,1,1,0),(102,28,2,1,0),(103,28,3,1,0),(104,28,4,1,0),(105,28,5,1,0),(106,30,1,1,0),(107,30,2,1,0),(108,30,3,1,0),(109,30,4,1,0),(110,30,5,1,0),(111,29,1,1,0),(112,29,2,1,0),(113,29,3,1,0),(114,29,4,1,0),(115,29,5,1,0),(116,25,6,1,0),(117,25,7,1,0),(118,25,8,1,0),(119,25,10,1,0),(120,25,11,1,0),(121,25,12,1,0),(122,25,13,1,0),(123,25,14,1,0),(124,25,15,1,0),(125,25,16,1,0),(126,25,17,1,0),(127,25,18,1,0),(128,25,19,1,0),(129,25,20,1,0),(130,25,21,1,0),(131,25,22,1,0),(132,25,23,1,0),(133,25,24,1,0),(134,25,25,1,0),(135,25,26,1,0),(136,25,27,1,0),(137,25,28,1,0),(138,25,29,1,0),(139,25,30,1,0),(140,25,31,1,0),(141,25,32,1,0),(142,25,33,1,0),(143,25,34,1,0),(144,25,35,1,0),(145,25,36,1,0),(146,25,37,1,0),(147,25,38,1,0),(148,25,39,1,0),(149,25,40,1,0),(150,25,41,1,0),(151,25,42,1,0),(152,25,43,1,0),(153,25,44,1,0),(154,25,45,1,0),(155,25,46,1,0),(156,25,47,1,0),(157,25,48,1,0),(158,25,49,1,0),(159,25,50,1,0),(160,25,51,1,0),(161,25,52,1,0),(162,25,53,1,0),(163,25,54,1,0),(164,25,55,1,0),(165,25,56,1,0),(166,25,57,1,0),(167,25,58,1,0),(168,25,59,1,0),(169,25,60,1,0),(170,25,61,1,0),(171,25,62,1,0),(172,25,63,1,0),(173,25,64,1,0),(174,25,65,1,0),(175,25,66,1,0),(176,25,67,1,0),(177,25,68,1,0),(178,25,69,1,0),(179,25,70,1,0),(180,25,71,1,0),(181,25,72,1,0),(182,25,73,1,0),(183,25,74,1,0),(184,26,6,1,0),(185,26,7,1,0),(186,26,8,1,0),(187,26,10,1,0),(188,26,11,1,0),(189,26,12,1,0),(190,26,13,1,0),(191,26,14,1,0),(192,26,15,1,0),(193,26,16,1,0),(194,26,17,1,0),(195,26,18,1,0),(196,26,19,1,0),(197,26,20,1,0),(198,26,21,1,0),(199,26,22,1,0),(200,26,23,1,0),(201,26,24,1,0),(202,26,25,1,0),(203,26,26,1,0),(204,26,27,1,0),(205,26,28,1,0),(206,26,29,1,0),(207,26,30,1,0),(208,26,31,1,0),(209,26,32,1,0),(210,26,33,1,0),(211,26,34,1,0),(212,26,35,1,0),(213,26,36,1,0),(214,26,37,1,0),(215,26,38,1,0),(216,26,39,1,0),(217,26,40,1,0),(218,26,41,1,0),(219,26,42,1,0),(220,26,43,1,0),(221,26,44,1,0),(222,26,45,1,0),(223,26,46,1,0),(224,26,47,1,0),(225,26,48,1,0),(226,26,49,1,0),(227,26,50,1,0),(228,26,51,1,0),(229,26,52,1,0),(230,26,53,1,0),(231,26,54,1,0),(232,26,55,1,0),(233,26,56,1,0),(234,26,57,1,0),(235,26,58,1,0),(236,26,59,1,0),(237,26,60,1,0),(238,26,61,1,0),(239,26,62,1,0),(240,26,63,1,0),(241,26,64,1,0),(242,26,65,1,0),(243,26,66,1,0),(244,26,67,1,0),(245,26,68,1,0),(246,26,69,1,0),(247,26,70,1,0),(248,26,71,1,0),(249,26,72,1,0),(250,26,73,1,0),(251,26,74,1,0),(252,14,6,1,0),(253,14,7,1,0),(254,14,8,1,0),(255,14,10,1,0),(256,14,11,1,0),(257,14,12,1,0),(258,14,13,1,0),(259,14,14,1,0),(260,14,15,1,0),(261,14,16,1,0),(262,14,17,1,0),(263,14,18,1,0),(264,14,19,1,0),(265,14,20,1,0),(266,14,21,1,0),(267,14,22,1,0),(268,14,23,1,0),(269,14,24,1,0),(270,14,25,1,0),(271,14,26,1,0),(272,14,27,1,0),(273,14,28,1,0),(274,14,29,1,0),(275,14,30,1,0),(276,14,31,1,0),(277,14,32,1,0),(278,14,33,1,0),(279,14,34,1,0),(280,14,35,1,0),(281,14,36,1,0),(282,14,37,1,0),(283,14,38,1,0),(284,14,39,1,0),(285,14,40,1,0),(286,14,41,1,0),(287,14,42,1,0),(288,14,43,1,0),(289,14,44,1,0),(290,14,45,1,0),(291,14,46,1,0),(292,14,47,1,0),(293,14,48,1,0),(294,14,49,1,0),(295,14,50,1,0),(296,14,51,1,0),(297,14,52,1,0),(298,14,53,1,0),(299,14,54,1,0),(300,14,55,1,0),(301,14,56,1,0),(302,14,57,1,0),(303,14,58,1,0),(304,14,59,1,0),(305,14,60,1,0),(306,14,61,1,0),(307,14,62,1,0),(308,14,63,1,0),(309,14,64,1,0),(310,14,65,1,0),(311,14,66,1,0),(312,14,67,1,0),(313,14,68,1,0),(314,14,69,1,0),(315,14,70,1,0),(316,14,71,1,0),(317,14,72,1,0),(318,14,73,1,0),(319,14,74,1,0),(320,22,6,1,0),(321,22,7,1,0),(322,22,8,1,0),(323,22,10,1,0),(324,22,11,1,0),(325,22,12,1,0),(326,22,13,1,0),(327,22,14,1,0),(328,22,15,1,0),(329,22,16,1,0),(330,22,17,1,0),(331,22,18,1,0),(332,22,19,1,0),(333,22,20,1,0),(334,22,21,1,0),(335,22,22,1,0),(336,22,23,1,0),(337,22,24,1,0),(338,22,25,1,0),(339,22,26,1,0),(340,22,27,1,0),(341,22,28,1,0),(342,22,29,1,0),(343,22,30,1,0),(344,22,31,1,0),(345,22,32,1,0),(346,22,33,1,0),(347,22,34,1,0),(348,22,35,1,0),(349,22,36,1,0),(350,22,37,1,0),(351,22,38,1,0),(352,22,39,1,0),(353,22,40,1,0),(354,22,41,1,0),(355,22,42,1,0),(356,22,43,1,0),(357,22,44,1,0),(358,22,45,1,0),(359,22,46,1,0),(360,22,47,1,0),(361,22,48,1,0),(362,22,49,1,0),(363,22,50,1,0),(364,22,51,1,0),(365,22,52,1,0),(366,22,53,1,0),(367,22,54,1,0),(368,22,55,1,0),(369,22,56,1,0),(370,22,57,1,0),(371,22,58,1,0),(372,22,59,1,0),(373,22,60,1,0),(374,22,61,1,0),(375,22,62,1,0),(376,22,63,1,0),(377,22,64,1,0),(378,22,65,1,0),(379,22,66,1,0),(380,22,67,1,0),(381,22,68,1,0),(382,22,69,1,0),(383,22,70,1,0),(384,22,71,1,0),(385,22,72,1,0),(386,22,73,1,0),(387,22,74,1,0),(388,3,6,1,0),(389,3,7,1,0),(390,3,8,1,0),(391,3,10,1,0),(392,3,11,1,0),(393,3,12,1,0),(394,3,13,1,0),(395,3,14,1,0),(396,3,15,1,0),(397,3,16,1,0),(398,3,17,1,0),(399,3,18,1,0),(400,3,19,1,0),(401,3,20,1,0),(402,3,21,1,0),(403,3,22,1,0),(404,3,23,1,0),(405,3,24,1,0),(406,3,25,1,0),(407,3,26,1,0),(408,3,27,1,0),(409,3,28,1,0),(410,3,29,1,0),(411,3,30,1,0),(412,3,31,1,0),(413,3,32,1,0),(414,3,33,1,0),(415,3,34,1,0),(416,3,35,1,0),(417,3,36,1,0),(418,3,37,1,0),(419,3,38,1,0),(420,3,39,1,0),(421,3,40,1,0),(422,3,41,1,0),(423,3,42,1,0),(424,3,43,1,0),(425,3,44,1,0),(426,3,45,1,0),(427,3,46,1,0),(428,3,47,1,0),(429,3,48,1,0),(430,3,49,1,0),(431,3,50,1,0),(432,3,51,1,0),(433,3,52,1,0),(434,3,53,1,0),(435,3,54,1,0),(436,3,55,1,0),(437,3,56,1,0),(438,3,57,1,0),(439,3,58,1,0),(440,3,59,1,0),(441,3,60,1,0),(442,3,61,1,0),(443,3,62,1,0),(444,3,63,1,0),(445,3,64,1,0),(446,3,65,1,0),(447,3,66,1,0),(448,3,67,1,0),(449,3,68,1,0),(450,3,69,1,0),(451,3,70,1,0),(452,3,71,1,0),(453,3,72,1,0),(454,3,73,1,0),(455,3,74,1,0),(456,27,6,1,0),(457,27,7,1,0),(458,27,8,1,0),(459,27,10,1,0),(460,27,11,1,0),(461,27,12,1,0),(462,27,13,1,0),(463,27,14,1,0),(464,27,15,1,0),(465,27,16,1,0),(466,27,17,1,0),(467,27,18,1,0),(468,27,19,1,0),(469,27,20,1,0),(470,27,21,1,0),(471,27,22,1,0),(472,27,23,1,0),(473,27,24,1,0),(474,27,25,1,0),(475,27,26,1,0),(476,27,27,1,0),(477,27,28,1,0),(478,27,29,1,0),(479,27,30,1,0),(480,27,31,1,0),(481,27,32,1,0),(482,27,33,1,0),(483,27,34,1,0),(484,27,35,1,0),(485,27,36,1,0),(486,27,37,1,0),(487,27,38,1,0),(488,27,39,1,0),(489,27,40,1,0),(490,27,41,1,0),(491,27,42,1,0),(492,27,43,1,0),(493,27,44,1,0),(494,27,45,1,0),(495,27,46,1,0),(496,27,47,1,0),(497,27,48,1,0),(498,27,49,1,0),(499,27,50,1,0),(500,27,51,1,0),(501,27,52,1,0),(502,27,53,1,0),(503,27,54,1,0),(504,27,55,1,0),(505,27,56,1,0),(506,27,57,1,0),(507,27,58,1,0),(508,27,59,1,0),(509,27,60,1,0),(510,27,61,1,0),(511,27,62,1,0),(512,27,63,1,0),(513,27,64,1,0),(514,27,65,1,0),(515,27,66,1,0),(516,27,67,1,0),(517,27,68,1,0),(518,27,69,1,0),(519,27,70,1,0),(520,27,71,1,0),(521,27,72,1,0),(522,27,73,1,0),(523,27,74,1,0),(524,24,6,1,0),(525,24,7,1,0),(526,24,8,1,0),(527,24,10,1,0),(528,24,11,1,0),(529,24,12,1,0),(530,24,13,1,0),(531,24,14,1,0),(532,24,15,1,0),(533,24,16,1,0),(534,24,17,1,0),(535,24,18,1,0),(536,24,19,1,0),(537,24,20,1,0),(538,24,21,1,0),(539,24,22,1,0),(540,24,23,1,0),(541,24,24,1,0),(542,24,25,1,0),(543,24,26,1,0),(544,24,27,1,0),(545,24,28,1,0),(546,24,29,1,0),(547,24,30,1,0),(548,24,31,1,0),(549,24,32,1,0),(550,24,33,1,0),(551,24,34,1,0),(552,24,35,1,0),(553,24,36,1,0),(554,24,37,1,0),(555,24,38,1,0),(556,24,39,1,0),(557,24,40,1,0),(558,24,41,1,0),(559,24,42,1,0),(560,24,43,1,0),(561,24,44,1,0),(562,24,45,1,0),(563,24,46,1,0),(564,24,47,1,0),(565,24,48,1,0),(566,24,49,1,0),(567,24,50,1,0),(568,24,51,1,0),(569,24,52,1,0),(570,24,53,1,0),(571,24,54,1,0),(572,24,55,1,0),(573,24,56,1,0),(574,24,57,1,0),(575,24,58,1,0),(576,24,59,1,0),(577,24,60,1,0),(578,24,61,1,0),(579,24,62,1,0),(580,24,63,1,0),(581,24,64,1,0),(582,24,65,1,0),(583,24,66,1,0),(584,24,67,1,0),(585,24,68,1,0),(586,24,69,1,0),(587,24,70,1,0),(588,24,71,1,0),(589,24,72,1,0),(590,24,73,1,0),(591,24,74,1,0),(592,29,6,1,0),(593,29,7,1,0),(594,29,8,1,0),(595,29,10,1,0),(596,29,11,1,0),(597,29,12,1,0),(598,29,13,1,0),(599,29,14,1,0),(600,29,15,1,0),(601,29,16,1,0),(602,29,17,1,0),(603,29,18,1,0),(604,29,19,1,0),(605,29,20,1,0),(606,29,21,1,0),(607,29,22,1,0),(608,29,23,1,0),(609,29,24,1,0),(610,29,25,1,0),(611,29,26,1,0),(612,29,27,1,0),(613,29,28,1,0),(614,29,29,1,0),(615,29,30,1,0),(616,29,31,1,0),(617,29,32,1,0),(618,29,33,1,0),(619,29,34,1,0),(620,29,35,1,0),(621,29,36,1,0),(622,29,37,1,0),(623,29,38,1,0),(624,29,39,1,0),(625,29,40,1,0),(626,29,41,1,0),(627,29,42,1,0),(628,29,43,1,0),(629,29,44,1,0),(630,29,45,1,0),(631,29,46,1,0),(632,29,47,1,0),(633,29,48,1,0),(634,29,49,1,0),(635,29,50,1,0),(636,29,51,1,0),(637,29,52,1,0),(638,29,53,1,0),(639,29,54,1,0),(640,29,55,1,0),(641,29,56,1,0),(642,29,57,1,0),(643,29,58,1,0),(644,29,59,1,0),(645,29,60,1,0),(646,29,61,1,0),(647,29,62,1,0),(648,29,63,1,0),(649,29,64,1,0),(650,29,65,1,0),(651,29,66,1,0),(652,29,67,1,0),(653,29,68,1,0),(654,29,69,1,0),(655,29,70,1,0),(656,29,71,1,0),(657,29,72,1,0),(658,29,73,1,0),(659,29,74,1,0),(660,23,6,1,0),(661,23,7,1,0),(662,23,8,1,0),(663,23,10,1,0),(664,23,11,1,0),(665,23,12,1,0),(666,23,13,1,0),(667,23,14,1,0),(668,23,15,1,0),(669,23,16,1,0),(670,23,17,1,0),(671,23,18,1,0),(672,23,19,1,0),(673,23,20,1,0),(674,23,21,1,0),(675,23,22,1,0),(676,23,23,1,0),(677,23,24,1,0),(678,23,25,1,0),(679,23,26,1,0),(680,23,27,1,0),(681,23,28,1,0),(682,23,29,1,0),(683,23,30,1,0),(684,23,31,1,0),(685,23,32,1,0),(686,23,33,1,0),(687,23,34,1,0),(688,23,35,1,0),(689,23,36,1,0),(690,23,37,1,0),(691,23,38,1,0),(692,23,39,1,0),(693,23,40,1,0),(694,23,41,1,0),(695,23,42,1,0),(696,23,43,1,0),(697,23,44,1,0),(698,23,45,1,0),(699,23,46,1,0),(700,23,47,1,0),(701,23,48,1,0),(702,23,49,1,0),(703,23,50,1,0),(704,23,51,1,0),(705,23,52,1,0),(706,23,53,1,0),(707,23,54,1,0),(708,23,55,1,0),(709,23,56,1,0),(710,23,57,1,0),(711,23,58,1,0),(712,23,59,1,0),(713,23,60,1,0),(714,23,61,1,0),(715,23,62,1,0),(716,23,63,1,0),(717,23,64,1,0),(718,23,65,1,0),(719,23,66,1,0),(720,23,67,1,0),(721,23,68,1,0),(722,23,69,1,0),(723,23,70,1,0),(724,23,71,1,0),(725,23,72,1,0),(726,23,73,1,0),(727,23,74,1,0),(728,16,6,1,0),(729,16,7,1,0),(730,16,8,1,0),(731,16,10,1,0),(732,16,11,1,0),(733,16,12,1,0),(734,16,13,1,0),(735,16,14,1,0),(736,16,15,1,0),(737,16,16,1,0),(738,16,17,1,0),(739,16,18,1,0),(740,16,19,1,0),(741,16,20,1,0),(742,16,21,1,0),(743,16,22,1,0),(744,16,23,1,0),(745,16,24,1,0),(746,16,25,1,0),(747,16,26,1,0),(748,16,27,1,0),(749,16,28,1,0),(750,16,29,1,0),(751,16,30,1,0),(752,16,31,1,0),(753,16,32,1,0),(754,16,33,1,0),(755,16,34,1,0),(756,16,35,1,0),(757,16,36,1,0),(758,16,37,1,0),(759,16,38,1,0),(760,16,39,1,0),(761,16,40,1,0),(762,16,41,1,0),(763,16,42,1,0),(764,16,43,1,0),(765,16,44,1,0),(766,16,45,1,0),(767,16,46,1,0),(768,16,47,1,0),(769,16,48,1,0),(770,16,49,1,0),(771,16,50,1,0),(772,16,51,1,0),(773,16,52,1,0),(774,16,53,1,0),(775,16,54,1,0),(776,16,55,1,0),(777,16,56,1,0),(778,16,57,1,0),(779,16,58,1,0),(780,16,59,1,0),(781,16,60,1,0),(782,16,61,1,0),(783,16,62,1,0),(784,16,63,1,0),(785,16,64,1,0),(786,16,65,1,0),(787,16,66,1,0),(788,16,67,1,0),(789,16,68,1,0),(790,16,69,1,0),(791,16,70,1,0),(792,16,71,1,0),(793,16,72,1,0),(794,16,73,1,0),(795,16,74,1,0),(796,4,6,1,0),(797,4,7,1,0),(798,4,8,1,0),(799,4,10,1,0),(800,4,11,1,0),(801,4,12,1,0),(802,4,13,1,0),(803,4,14,1,0),(804,4,15,1,0),(805,4,16,1,0),(806,4,17,1,0),(807,4,18,1,0),(808,4,19,1,0),(809,4,20,1,0),(810,4,21,1,0),(811,4,22,1,0),(812,4,23,1,0),(813,4,24,1,0),(814,4,25,1,0),(815,4,26,1,0),(816,4,27,1,0),(817,4,28,1,0),(818,4,29,1,0),(819,4,30,1,0),(820,4,31,1,0),(821,4,32,1,0),(822,4,33,1,0),(823,4,34,1,0),(824,4,35,1,0),(825,4,36,1,0),(826,4,37,1,0),(827,4,38,1,0),(828,4,39,1,0),(829,4,40,1,0),(830,4,41,1,0),(831,4,42,1,0),(832,4,43,1,0),(833,4,44,1,0),(834,4,45,1,0),(835,4,46,1,0),(836,4,47,1,0),(837,4,48,1,0),(838,4,49,1,0),(839,4,50,1,0),(840,4,51,1,0),(841,4,52,1,0),(842,4,53,1,0),(843,4,54,1,0),(844,4,55,1,0),(845,4,56,1,0),(846,4,57,1,0),(847,4,58,1,0),(848,4,59,1,0),(849,4,60,1,0),(850,4,61,1,0),(851,4,62,1,0),(852,4,63,1,0),(853,4,64,1,0),(854,4,65,1,0),(855,4,66,1,0),(856,4,67,1,0),(857,4,68,1,0),(858,4,69,1,0),(859,4,70,1,0),(860,4,71,1,0),(861,4,72,1,0),(862,4,73,1,0),(863,4,74,1,0),(864,17,6,1,0),(865,17,7,1,0),(866,17,8,1,0),(867,17,10,1,0),(868,17,11,1,0),(869,17,12,1,0),(870,17,13,1,0),(871,17,14,1,0),(872,17,15,1,0),(873,17,16,1,0),(874,17,17,1,0),(875,17,18,1,0),(876,17,19,1,0),(877,17,20,1,0),(878,17,21,1,0),(879,17,22,1,0),(880,17,23,1,0),(881,17,24,1,0),(882,17,25,1,0),(883,17,26,1,0),(884,17,27,1,0),(885,17,28,1,0),(886,17,29,1,0),(887,17,30,1,0),(888,17,31,1,0),(889,17,32,1,0),(890,17,33,1,0),(891,17,34,1,0),(892,17,35,1,0),(893,17,36,1,0),(894,17,37,1,0),(895,17,38,1,0),(896,17,39,1,0),(897,17,40,1,0),(898,17,41,1,0),(899,17,42,1,0),(900,17,43,1,0),(901,17,44,1,0),(902,17,45,1,0),(903,17,46,1,0),(904,17,47,1,0),(905,17,48,1,0),(906,17,49,1,0),(907,17,50,1,0),(908,17,51,1,0),(909,17,52,1,0),(910,17,53,1,0),(911,17,54,1,0),(912,17,55,1,0),(913,17,56,1,0),(914,17,57,1,0),(915,17,58,1,0),(916,17,59,1,0),(917,17,60,1,0),(918,17,61,1,0),(919,17,62,1,0),(920,17,63,1,0),(921,17,64,1,0),(922,17,65,1,0),(923,17,66,1,0),(924,17,67,1,0),(925,17,68,1,0),(926,17,69,1,0),(927,17,70,1,0),(928,17,71,1,0),(929,17,72,1,0),(930,17,73,1,0),(931,17,74,1,0),(932,2,6,1,0),(933,2,7,1,0),(934,2,8,1,0),(935,2,10,1,0),(936,2,11,1,0),(937,2,12,1,0),(938,2,13,1,0),(939,2,14,1,0),(940,2,15,1,0),(941,2,16,1,0),(942,2,17,1,0),(943,2,18,1,0),(944,2,19,1,0),(945,2,20,1,0),(946,2,21,1,0),(947,2,22,1,0),(948,2,23,1,0),(949,2,24,1,0),(950,2,25,1,0),(951,2,26,1,0),(952,2,27,1,0),(953,2,28,1,0),(954,2,29,1,0),(955,2,30,1,0),(956,2,31,1,0),(957,2,32,1,0),(958,2,33,1,0),(959,2,34,1,0),(960,2,35,1,0),(961,2,36,1,0),(962,2,37,1,0),(963,2,38,1,0),(964,2,39,1,0),(965,2,40,1,0),(966,2,41,1,0),(967,2,42,1,0),(968,2,43,1,0),(969,2,44,1,0),(970,2,45,1,0),(971,2,46,1,0),(972,2,47,1,0),(973,2,48,1,0),(974,2,49,1,0),(975,2,50,1,0),(976,2,51,1,0),(977,2,52,1,0),(978,2,53,1,0),(979,2,54,1,0),(980,2,55,1,0),(981,2,56,1,0),(982,2,57,1,0),(983,2,58,1,0),(984,2,59,1,0),(985,2,60,1,0),(986,2,61,1,0),(987,2,62,1,0),(988,2,63,1,0),(989,2,64,1,0),(990,2,65,1,0),(991,2,66,1,0),(992,2,67,1,0),(993,2,68,1,0),(994,2,69,1,0),(995,2,70,1,0),(996,2,71,1,0),(997,2,72,1,0),(998,2,73,1,0),(999,2,74,1,0),(1000,12,6,1,0),(1001,12,7,1,0),(1002,12,8,1,0),(1003,12,10,1,0),(1004,12,11,1,0),(1005,12,12,1,0),(1006,12,13,1,0),(1007,12,14,1,0),(1008,12,15,1,0),(1009,12,16,1,0),(1010,12,17,1,0),(1011,12,18,1,0),(1012,12,19,1,0),(1013,12,20,1,0),(1014,12,21,1,0),(1015,12,22,1,0),(1016,12,23,1,0),(1017,12,24,1,0),(1018,12,25,1,0),(1019,12,26,1,0),(1020,12,27,1,0),(1021,12,28,1,0),(1022,12,29,1,0),(1023,12,30,1,0),(1024,12,31,1,0),(1025,12,32,1,0),(1026,12,33,1,0),(1027,12,34,1,0),(1028,12,35,1,0),(1029,12,36,1,0),(1030,12,37,1,0),(1031,12,38,1,0),(1032,12,39,1,0),(1033,12,40,1,0),(1034,12,41,1,0),(1035,12,42,1,0),(1036,12,43,1,0),(1037,12,44,1,0),(1038,12,45,1,0),(1039,12,46,1,0),(1040,12,47,1,0),(1041,12,48,1,0),(1042,12,49,1,0),(1043,12,50,1,0),(1044,12,51,1,0),(1045,12,52,1,0),(1046,12,53,1,0),(1047,12,54,1,0),(1048,12,55,1,0),(1049,12,56,1,0),(1050,12,57,1,0),(1051,12,58,1,0),(1052,12,59,1,0),(1053,12,60,1,0),(1054,12,61,1,0),(1055,12,62,1,0),(1056,12,63,1,0),(1057,12,64,1,0),(1058,12,65,1,0),(1059,12,66,1,0),(1060,12,67,1,0),(1061,12,68,1,0),(1062,12,69,1,0),(1063,12,70,1,0),(1064,12,71,1,0),(1065,12,72,1,0),(1066,12,73,1,0),(1067,12,74,1,0),(1068,28,6,1,0),(1069,28,7,1,0),(1070,28,8,1,0),(1071,28,10,1,0),(1072,28,11,1,0),(1073,28,12,1,0),(1074,28,13,1,0),(1075,28,14,1,0),(1076,28,15,1,0),(1077,28,16,1,0),(1078,28,17,1,0),(1079,28,18,1,0),(1080,28,19,1,0),(1081,28,20,1,0),(1082,28,21,1,0),(1083,28,22,1,0),(1084,28,23,1,0),(1085,28,24,1,0),(1086,28,25,1,0),(1087,28,26,1,0),(1088,28,27,1,0),(1089,28,28,1,0),(1090,28,29,1,0),(1091,28,30,1,0),(1092,28,31,1,0),(1093,28,32,1,0),(1094,28,33,1,0),(1095,28,34,1,0),(1096,28,35,1,0),(1097,28,36,1,0),(1098,28,37,1,0),(1099,28,38,1,0),(1100,28,39,1,0),(1101,28,40,1,0),(1102,28,41,1,0),(1103,28,42,1,0),(1104,28,43,1,0),(1105,28,44,1,0),(1106,28,45,1,0),(1107,28,46,1,0),(1108,28,47,1,0),(1109,28,48,1,0),(1110,28,49,1,0),(1111,28,50,1,0),(1112,28,51,1,0),(1113,28,52,1,0),(1114,28,53,1,0),(1115,28,54,1,0),(1116,28,55,1,0),(1117,28,56,1,0),(1118,28,57,1,0),(1119,28,58,1,0),(1120,28,59,1,0),(1121,28,60,1,0),(1122,28,61,1,0),(1123,28,62,1,0),(1124,28,63,1,0),(1125,28,64,1,0),(1126,28,65,1,0),(1127,28,66,1,0),(1128,28,67,1,0),(1129,28,68,1,0),(1130,28,69,1,0),(1131,28,70,1,0),(1132,28,71,1,0),(1133,28,72,1,0),(1134,28,73,1,0),(1135,28,74,1,0),(1136,5,6,1,0),(1137,5,7,1,0),(1138,5,8,1,0),(1139,5,10,1,0),(1140,5,11,1,0),(1141,5,12,1,0),(1142,5,13,1,0),(1143,5,14,1,0),(1144,5,15,1,0),(1145,5,16,1,0),(1146,5,17,1,0),(1147,5,18,1,0),(1148,5,19,1,0),(1149,5,20,1,0),(1150,5,21,1,0),(1151,5,22,1,0),(1152,5,23,1,0),(1153,5,24,1,0),(1154,5,25,1,0),(1155,5,26,1,0),(1156,5,27,1,0),(1157,5,28,1,0),(1158,5,29,1,0),(1159,5,30,1,0),(1160,5,31,1,0),(1161,5,32,1,0),(1162,5,33,1,0),(1163,5,34,1,0),(1164,5,35,1,0),(1165,5,36,1,0),(1166,5,37,1,0),(1167,5,38,1,0),(1168,5,39,1,0),(1169,5,40,1,0),(1170,5,41,1,0),(1171,5,42,1,0),(1172,5,43,1,0),(1173,5,44,1,0),(1174,5,45,1,0),(1175,5,46,1,0),(1176,5,47,1,0),(1177,5,48,1,0),(1178,5,49,1,0),(1179,5,50,1,0),(1180,5,51,1,0),(1181,5,52,1,0),(1182,5,53,1,0),(1183,5,54,1,0),(1184,5,55,1,0),(1185,5,56,1,0),(1186,5,57,1,0),(1187,5,58,1,0),(1188,5,59,1,0),(1189,5,60,1,0),(1190,5,61,1,0),(1191,5,62,1,0),(1192,5,63,1,0),(1193,5,64,1,0),(1194,5,65,1,0),(1195,5,66,1,0),(1196,5,67,1,0),(1197,5,68,1,0),(1198,5,69,1,0),(1199,5,70,1,0),(1200,5,71,1,0),(1201,5,72,1,0),(1202,5,73,1,0),(1203,5,74,1,0),(1204,13,6,1,0),(1205,13,7,1,0),(1206,13,8,1,0),(1207,13,10,1,0),(1208,13,11,1,0),(1209,13,12,1,0),(1210,13,13,1,0),(1211,13,14,1,0),(1212,13,15,1,0),(1213,13,16,1,0),(1214,13,17,1,0),(1215,13,18,1,0),(1216,13,19,1,0),(1217,13,20,1,0),(1218,13,21,1,0),(1219,13,22,1,0),(1220,13,23,1,0),(1221,13,24,1,0),(1222,13,25,1,0),(1223,13,26,1,0),(1224,13,27,1,0),(1225,13,28,1,0),(1226,13,29,1,0),(1227,13,30,1,0),(1228,13,31,1,0),(1229,13,32,1,0),(1230,13,33,1,0),(1231,13,34,1,0),(1232,13,35,1,0),(1233,13,36,1,0),(1234,13,37,1,0),(1235,13,38,1,0),(1236,13,39,1,0),(1237,13,40,1,0),(1238,13,41,1,0),(1239,13,42,1,0),(1240,13,43,1,0),(1241,13,44,1,0),(1242,13,45,1,0),(1243,13,46,1,0),(1244,13,47,1,0),(1245,13,48,1,0),(1246,13,49,1,0),(1247,13,50,1,0),(1248,13,51,1,0),(1249,13,52,1,0),(1250,13,53,1,0),(1251,13,54,1,0),(1252,13,55,1,0),(1253,13,56,1,0),(1254,13,57,1,0),(1255,13,58,1,0),(1256,13,59,1,0),(1257,13,60,1,0),(1258,13,61,1,0),(1259,13,62,1,0),(1260,13,63,1,0),(1261,13,64,1,0),(1262,13,65,1,0),(1263,13,66,1,0),(1264,13,67,1,0),(1265,13,68,1,0),(1266,13,69,1,0),(1267,13,70,1,0),(1268,13,71,1,0),(1269,13,72,1,0),(1270,13,73,1,0),(1271,13,74,1,0),(1272,30,6,1,0),(1273,30,7,1,0),(1274,30,8,1,0),(1275,30,10,1,0),(1276,30,11,1,0),(1277,30,12,1,0),(1278,30,13,1,0),(1279,30,14,1,0),(1280,30,15,1,0),(1281,30,16,1,0),(1282,30,17,1,0),(1283,30,18,1,0),(1284,30,19,1,0),(1285,30,20,1,0),(1286,30,21,1,0),(1287,30,22,1,0),(1288,30,23,1,0),(1289,30,24,1,0),(1290,30,25,1,0),(1291,30,26,1,0),(1292,30,27,1,0),(1293,30,28,1,0),(1294,30,29,1,0),(1295,30,30,1,0),(1296,30,31,1,0),(1297,30,32,1,0),(1298,30,33,1,0),(1299,30,34,1,0),(1300,30,35,1,0),(1301,30,36,1,0),(1302,30,37,1,0),(1303,30,38,1,0),(1304,30,39,1,0),(1305,30,40,1,0),(1306,30,41,1,0),(1307,30,42,1,0),(1308,30,43,1,0),(1309,30,44,1,0),(1310,30,45,1,0),(1311,30,46,1,0),(1312,30,47,1,0),(1313,30,48,1,0),(1314,30,49,1,0),(1315,30,50,1,0),(1316,30,51,1,0),(1317,30,52,1,0),(1318,30,53,1,0),(1319,30,54,1,0),(1320,30,55,1,0),(1321,30,56,1,0),(1322,30,57,1,0),(1323,30,58,1,0),(1324,30,59,1,0),(1325,30,60,1,0),(1326,30,61,1,0),(1327,30,62,1,0),(1328,30,63,1,0),(1329,30,64,1,0),(1330,30,65,1,0),(1331,30,66,1,0),(1332,30,67,1,0),(1333,30,68,1,0),(1334,30,69,1,0),(1335,30,70,1,0),(1336,30,71,1,0),(1337,30,72,1,0),(1338,30,73,1,0),(1339,30,74,1,0),(1340,8,6,1,0),(1341,8,7,1,0),(1342,8,8,1,0),(1343,8,10,1,0),(1344,8,11,1,0),(1345,8,12,1,0),(1346,8,13,1,0),(1347,8,14,1,0),(1348,8,15,1,0),(1349,8,16,1,0),(1350,8,17,1,0),(1351,8,18,1,0),(1352,8,19,1,0),(1353,8,20,1,0),(1354,8,21,1,0),(1355,8,22,1,0),(1356,8,23,1,0),(1357,8,24,1,0),(1358,8,25,1,0),(1359,8,26,1,0),(1360,8,27,1,0),(1361,8,28,1,0),(1362,8,29,1,0),(1363,8,30,1,0),(1364,8,31,1,0),(1365,8,32,1,0),(1366,8,33,1,0),(1367,8,34,1,0),(1368,8,35,1,0),(1369,8,36,1,0),(1370,8,37,1,0),(1371,8,38,1,0),(1372,8,39,1,0),(1373,8,40,1,0),(1374,8,41,1,0),(1375,8,42,1,0),(1376,8,43,1,0),(1377,8,44,1,0),(1378,8,45,1,0),(1379,8,46,1,0),(1380,8,47,1,0),(1381,8,48,1,0),(1382,8,49,1,0),(1383,8,50,1,0),(1384,8,51,1,0),(1385,8,52,1,0),(1386,8,53,1,0),(1387,8,54,1,0),(1388,8,55,1,0),(1389,8,56,1,0),(1390,8,57,1,0),(1391,8,58,1,0),(1392,8,59,1,0),(1393,8,60,1,0),(1394,8,61,1,0),(1395,8,62,1,0),(1396,8,63,1,0),(1397,8,64,1,0),(1398,8,65,1,0),(1399,8,66,1,0),(1400,8,67,1,0),(1401,8,68,1,0),(1402,8,69,1,0),(1403,8,70,1,0),(1404,8,71,1,0),(1405,8,72,1,0),(1406,8,73,1,0),(1407,8,74,1,0),(1408,19,6,1,0),(1409,19,7,1,0),(1410,19,8,1,0),(1411,19,10,1,0),(1412,19,11,1,0),(1413,19,12,1,0),(1414,19,13,1,0),(1415,19,14,1,0),(1416,19,15,1,0),(1417,19,16,1,0),(1418,19,17,1,0),(1419,19,18,1,0),(1420,19,19,1,0),(1421,19,20,1,0),(1422,19,21,1,0),(1423,19,22,1,0),(1424,19,23,1,0),(1425,19,24,1,0),(1426,19,25,1,0),(1427,19,26,1,0),(1428,19,27,1,0),(1429,19,28,1,0),(1430,19,29,1,0),(1431,19,30,1,0),(1432,19,31,1,0),(1433,19,32,1,0),(1434,19,33,1,0),(1435,19,34,1,0),(1436,19,35,1,0),(1437,19,36,1,0),(1438,19,37,1,0),(1439,19,38,1,0),(1440,19,39,1,0),(1441,19,40,1,0),(1442,19,41,1,0),(1443,19,42,1,0),(1444,19,43,1,0),(1445,19,44,1,0),(1446,19,45,1,0),(1447,19,46,1,0),(1448,19,47,1,0),(1449,19,48,1,0),(1450,19,49,1,0),(1451,19,50,1,0),(1452,19,51,1,0),(1453,19,52,1,0),(1454,19,53,1,0),(1455,19,54,1,0),(1456,19,55,1,0),(1457,19,56,1,0),(1458,19,57,1,0),(1459,19,58,1,0),(1460,19,59,1,0),(1461,19,60,1,0),(1462,19,61,1,0),(1463,19,62,1,0),(1464,19,63,1,0),(1465,19,64,1,0),(1466,19,65,1,0),(1467,19,66,1,0),(1468,19,67,1,0),(1469,19,68,1,0),(1470,19,69,1,0),(1471,19,70,1,0),(1472,19,71,1,0),(1473,19,72,1,0),(1474,19,73,1,0),(1475,19,74,1,0),(1476,7,6,1,0),(1477,7,7,1,0),(1478,7,8,1,0),(1479,7,10,1,0),(1480,7,11,1,0),(1481,7,12,1,0),(1482,7,13,1,0),(1483,7,14,1,0),(1484,7,15,1,0),(1485,7,16,1,0),(1486,7,17,1,0),(1487,7,18,1,0),(1488,7,19,1,0),(1489,7,20,1,0),(1490,7,21,1,0),(1491,7,22,1,0),(1492,7,23,1,0),(1493,7,24,1,0),(1494,7,25,1,0),(1495,7,26,1,0),(1496,7,27,1,0),(1497,7,28,1,0),(1498,7,29,1,0),(1499,7,30,1,0),(1500,7,31,1,0),(1501,7,32,1,0),(1502,7,33,1,0),(1503,7,34,1,0),(1504,7,35,1,0),(1505,7,36,1,0),(1506,7,37,1,0),(1507,7,38,1,0),(1508,7,39,1,0),(1509,7,40,1,0),(1510,7,41,1,0),(1511,7,42,1,0),(1512,7,43,1,0),(1513,7,44,1,0),(1514,7,45,1,0),(1515,7,46,1,0),(1516,7,47,1,0),(1517,7,48,1,0),(1518,7,49,1,0),(1519,7,50,1,0),(1520,7,51,1,0),(1521,7,52,1,0),(1522,7,53,1,0),(1523,7,54,1,0),(1524,7,55,1,0),(1525,7,56,1,0),(1526,7,57,1,0),(1527,7,58,1,0),(1528,7,59,1,0),(1529,7,60,1,0),(1530,7,61,1,0),(1531,7,62,1,0),(1532,7,63,1,0),(1533,7,64,1,0),(1534,7,65,1,0),(1535,7,66,1,0),(1536,7,67,1,0),(1537,7,68,1,0),(1538,7,69,1,0),(1539,7,70,1,0),(1540,7,71,1,0),(1541,7,72,1,0),(1542,7,73,1,0),(1543,7,74,1,0),(1544,1,6,1,0),(1545,1,7,1,0),(1546,1,8,1,0),(1547,1,10,1,0),(1548,1,11,1,0),(1549,1,12,1,0),(1550,1,13,1,0),(1551,1,14,1,0),(1552,1,15,1,0),(1553,1,16,1,0),(1554,1,17,1,0),(1555,1,18,1,0),(1556,1,19,1,0),(1557,1,20,1,0),(1558,1,21,1,0),(1559,1,22,1,0),(1560,1,23,1,0),(1561,1,24,1,0),(1562,1,25,1,0),(1563,1,26,1,0),(1564,1,27,1,0),(1565,1,28,1,0),(1566,1,29,1,0),(1567,1,30,1,0),(1568,1,31,1,0),(1569,1,32,1,0),(1570,1,33,1,0),(1571,1,34,1,0),(1572,1,35,1,0),(1573,1,36,1,0),(1574,1,37,1,0),(1575,1,38,1,0),(1576,1,39,1,0),(1577,1,40,1,0),(1578,1,41,1,0),(1579,1,42,1,0),(1580,1,43,1,0),(1581,1,44,1,0),(1582,1,45,1,0),(1583,1,46,1,0),(1584,1,47,1,0),(1585,1,48,1,0),(1586,1,49,1,0),(1587,1,50,1,0),(1588,1,51,1,0),(1589,1,52,1,0),(1590,1,53,1,0),(1591,1,54,1,0),(1592,1,55,1,0),(1593,1,56,1,0),(1594,1,57,1,0),(1595,1,58,1,0),(1596,1,59,1,0),(1597,1,60,1,0),(1598,1,61,1,0),(1599,1,62,1,0),(1600,1,63,1,0),(1601,1,64,1,0),(1602,1,65,1,0),(1603,1,66,1,0),(1604,1,67,1,0),(1605,1,68,1,0),(1606,1,69,1,0),(1607,1,70,1,0),(1608,1,71,1,0),(1609,1,72,1,0),(1610,1,73,1,0),(1611,1,74,1,0),(1612,6,6,1,0),(1613,6,7,1,0),(1614,6,8,1,0),(1615,6,10,1,0),(1616,6,11,1,0),(1617,6,12,1,0),(1618,6,13,1,0),(1619,6,14,1,0),(1620,6,15,1,0),(1621,6,16,1,0),(1622,6,17,1,0),(1623,6,18,1,0),(1624,6,19,1,0),(1625,6,20,1,0),(1626,6,21,1,0),(1627,6,22,1,0),(1628,6,23,1,0),(1629,6,24,1,0),(1630,6,25,1,0),(1631,6,26,1,0),(1632,6,27,1,0),(1633,6,28,1,0),(1634,6,29,1,0),(1635,6,30,1,0),(1636,6,31,1,0),(1637,6,32,1,0),(1638,6,33,1,0),(1639,6,34,1,0),(1640,6,35,1,0),(1641,6,36,1,0),(1642,6,37,1,0),(1643,6,38,1,0),(1644,6,39,1,0),(1645,6,40,1,0),(1646,6,41,1,0),(1647,6,42,1,0),(1648,6,43,1,0),(1649,6,44,1,0),(1650,6,45,1,0),(1651,6,46,1,0),(1652,6,47,1,0),(1653,6,48,1,0),(1654,6,49,1,0),(1655,6,50,1,0),(1656,6,51,1,0),(1657,6,52,1,0),(1658,6,53,1,0),(1659,6,54,1,0),(1660,6,55,1,0),(1661,6,56,1,0),(1662,6,57,1,0),(1663,6,58,1,0),(1664,6,59,1,0),(1665,6,60,1,0),(1666,6,61,1,0),(1667,6,62,1,0),(1668,6,63,1,0),(1669,6,64,1,0),(1670,6,65,1,0),(1671,6,66,1,0),(1672,6,67,1,0),(1673,6,68,1,0),(1674,6,69,1,0),(1675,6,70,1,0),(1676,6,71,1,0),(1677,6,72,1,0),(1678,6,73,1,0),(1679,6,74,1,0);

/*Table structure for table `opcion_lista_maestra` */

DROP TABLE IF EXISTS `opcion_lista_maestra`;

CREATE TABLE `opcion_lista_maestra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lista_maestra_id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `por_defecto` tinyint(1) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_opciones_lista_maestra_lista_maestra1_idx` (`lista_maestra_id`),
  CONSTRAINT `fk_opcion_lista_maestra_lista_maestra` FOREIGN KEY (`lista_maestra_id`) REFERENCES `lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=277 DEFAULT CHARSET=utf8;

/*Data for the table `opcion_lista_maestra` */

insert  into `opcion_lista_maestra`(`id`,`lista_maestra_id`,`nombre`,`por_defecto`,`activo`,`eliminado`) values (1,1,'Todo',1,1,0),(2,1,'Propietario',0,1,0),(3,1,'Nada',0,1,0),(4,2,'Activo',1,1,0),(5,2,'Inactivo',0,1,0),(6,3,'Llamada en Frio',1,1,0),(7,3,'Referido',0,1,0),(8,3,'Conferencia',0,1,0),(9,3,'Página Web',0,1,0),(10,3,'Relaciones Públicas',0,1,0),(11,3,'Campaña',0,1,0),(12,4,'A',1,1,0),(13,4,'AA',0,1,0),(14,4,'AAA',0,1,0),(15,5,'Cliente',1,1,0),(16,5,'Clasificación Cliente',0,1,0),(17,6,'Cotización',1,1,0),(18,6,'Negociación',0,1,0),(19,6,'Ganada',0,1,0),(20,6,'Perdida',0,1,0),(21,6,'Abandonada',0,1,0),(22,7,'Nueva',1,1,0),(23,7,'Borrador',0,1,0),(24,7,'Presentada',0,1,0),(25,8,'16',1,1,0),(26,8,'0',0,1,0),(27,9,'4',1,1,0),(28,9,'6',0,1,0),(29,9,'10',0,1,0),(30,10,'Activo',0,1,0),(31,10,'Stand by',0,1,0),(32,10,'Perdido',0,1,0),(33,11,'Jurídica',1,1,0),(34,11,'Natural',0,1,0),(35,12,'NIT',0,1,0),(36,12,'Cedula de Ciudadanía',0,1,0),(37,12,'Cedula Extranjería',0,1,0),(38,13,'Tarea',1,1,0),(39,13,'Llamada',0,1,0),(40,13,'Reunión',0,1,0),(41,14,'Entrante',1,1,0),(42,14,'Saliente',0,1,0),(43,15,'Planificada',1,1,0),(44,15,'Realizada',0,1,0),(45,15,'No Realizada',0,1,0),(46,7,'Ganada',0,1,0),(47,17,'No Iniciada',0,1,0),(48,17,'En Progreso',0,1,0),(49,17,'Completada',0,1,0),(50,17,'Aplazada',0,1,0),(51,7,'Descartada',0,1,0),(52,18,'un minuto antes',1,1,0),(53,18,'un dia antes',0,1,0),(54,19,'Baja',1,1,0),(55,19,'Media',0,1,0),(56,19,'Alta',0,1,0),(57,20,'Servicio',1,1,0),(58,20,'Convenio',0,1,0),(59,21,'Variable',0,1,0),(60,21,'Constante',0,1,0),(61,22,'Semanal',0,1,0),(62,22,'Quincenal',0,1,0),(63,22,'Mensual',0,1,0),(64,22,'Trimestral',0,1,0),(65,22,'Semestral',0,1,0),(66,22,'Anual',0,1,0),(67,24,'Alquiler Inhouse',0,1,0),(68,24,'Alquiler Equipos',0,1,0),(69,24,'Pauta Digital',0,1,0),(70,24,'Contenido Digital',0,1,0),(71,23,'Alquiler Inhouse',0,1,0),(72,23,'Alquiler Demanda',0,1,0),(73,23,'Venta Equipos',0,1,0),(74,23,'Digital Signage',0,1,0),(75,23,'Contenido Digital',0,1,0),(76,25,'Activo',0,1,0),(77,25,'retirado',0,1,0),(78,25,'Suspendido',0,1,0),(79,26,'Mal Servicio',0,1,0),(80,26,'Incumplimiento',0,1,0),(81,26,'Precio',0,1,0),(82,26,'Equipos defectuosos',0,1,0),(83,27,'Llamada Telefónica',0,1,0),(84,27,'Email',0,1,0),(85,27,'Página Web',0,1,0),(86,27,'Carta',0,1,0),(87,28,'Baja',0,1,0),(88,28,'Media',0,1,0),(89,28,'Alta',0,1,0),(90,29,'Nuevo',0,1,0),(91,29,'Pendiente de información',0,1,0),(92,29,'Solucionado',0,1,0),(93,30,'Nuevo',1,1,0),(94,30,'Asignado',0,1,0),(95,30,'En Proceso',0,1,0),(96,30,'Perdido',0,1,0),(97,30,'Recicledo',0,1,0),(98,30,'Convertido',0,1,0),(99,31,'Contado',1,1,0),(100,31,'Credito',0,1,0),(101,32,'ARL Sura',0,1,0),(102,32,'Vida Aurora S.A',0,1,0),(103,32,'Seguros Bolivar S.A',0,1,0),(104,32,'La Equidad',0,1,0),(105,32,'Positiva',0,1,0),(106,32,'Liberty Seguros',0,1,0),(107,32,'Mapfre Colombia',0,1,0),(108,32,'Colmena',0,1,0),(109,32,'Seguros Alfa',0,1,0),(110,32,'Axa Colpatria',0,1,0),(111,33,'Fondo Nacional del Ahorro',0,1,0),(112,33,'Colpensiones',0,1,0),(113,33,'Colfondos',0,1,0),(114,33,'Protección',0,1,0),(115,33,'Porvenir S.A',0,1,0),(116,33,'Old Mutual',0,1,0),(117,34,'Compensar',0,1,0),(118,34,'Sanitas',0,1,0),(119,34,'Famisanar',0,1,0),(120,34,'Salud Total',0,1,0),(121,34,'Cafesalud',0,1,0),(122,34,'Solsalud',0,1,0),(123,34,'Colsubsidio',0,1,0),(124,35,'Indefinido',0,1,0),(125,35,'Fijo',0,1,0),(126,36,'Cliente',0,1,0),(127,36,'Proveedor',0,1,0),(128,37,'1',0,1,0),(129,37,'2',0,1,0),(130,37,'3',0,1,0),(131,37,'4',0,1,0),(132,37,'5',0,1,0),(133,37,'6',0,1,0),(134,37,'7',0,1,0),(135,38,'Rol 1',0,1,0),(136,38,'Rol 2',0,1,0),(137,38,'Rol 3',0,1,0),(138,35,'Esclusiva',1,1,1),(139,35,'Exclusiva en Publicadad',0,1,1),(140,36,'Administración',1,1,1),(141,36,'Correteaje',0,1,1),(142,37,'1',1,1,1),(143,37,'2',0,1,1),(144,37,'5',0,1,1),(145,38,'Busqueda 1',1,1,1),(146,38,'Tp Busqueda 2',0,1,1),(147,39,'Arriendo',1,1,1),(148,39,'Compra',0,1,1),(149,40,'Activa',1,1,1),(150,40,'Ganada',0,1,1),(151,41,'1',1,1,1),(152,41,'3',0,1,1),(153,41,'5',0,1,1),(154,41,'7',0,1,1),(155,41,'9',0,1,1),(156,33,'Perdida',0,1,1),(157,33,'En Administración',0,1,1),(158,33,'En Promoción',0,1,1),(159,42,'Alta',1,1,1),(160,42,'Media',0,1,1),(161,42,'Baja',0,1,1),(162,43,'Abierto',1,1,1),(163,43,'Asignado',0,1,1),(164,43,'Cerrado',0,1,1),(165,43,'Pendiente de Información',0,1,1),(166,43,'Rechazado',0,1,1),(167,43,'Duplicado',0,1,1),(168,31,'Ganada',0,1,1),(169,31,'Perdida',0,1,1),(170,3,'Llamada Directa',0,1,1),(171,3,'Página Web',0,1,1),(172,3,'Email',0,1,1),(173,34,'Avaluó',0,1,1),(174,34,'Restructuración',0,1,1),(175,34,'Encargo Fiduciario',0,1,1),(176,34,'Sala de Venta',0,1,1),(177,34,'Construcción',0,1,1),(178,34,'Remodelación',0,1,1),(179,34,'Inventoria',0,1,1),(180,34,'Otro',0,1,1),(181,35,'No Exclusiva',0,1,1),(182,36,'Contrato Privado',0,1,1),(183,36,'Fiddeicomiso',0,1,1),(184,36,'Otro',0,1,1),(185,40,'Perdida',0,1,1),(186,2,'Analisis de Percepción',0,1,1),(187,2,'Propuesta/Presupuesto',0,1,1),(188,2,'Abandonada',0,1,1),(189,2,'Ganada',0,1,1),(190,2,'Perdida',0,1,1),(191,44,'cliente',1,1,1),(192,44,'caso',0,1,1),(193,44,'gestion_inmueble',0,1,1),(194,44,'demanda',0,1,1),(195,45,'interno',1,1,1),(196,45,'externo',0,1,1),(197,46,'borrador',1,1,1),(198,46,'publicado',0,1,1),(199,46,'temporal',0,1,1),(200,47,'personales',1,1,1),(201,47,'financieros',0,1,1),(202,48,'Enero',0,1,1),(203,48,'Febrero',0,1,1),(204,48,'Marzo',0,1,1),(205,48,'Abril',0,1,1),(206,48,'Mayo',0,1,1),(207,48,'Junio',0,1,1),(208,48,'Julio',0,1,1),(209,48,'Agosto',0,1,1),(210,48,'Septiembre',0,1,1),(211,48,'Octubre',0,1,1),(212,48,'Noviembre',0,1,1),(213,48,'Diciembre',0,1,1),(214,49,'Valor Ventas',1,1,1),(215,49,'Valor Arriendo',0,1,1),(216,49,'Valor Captado',0,1,1),(217,49,'Número Actividades',0,1,1),(218,49,'Número Visitas',0,1,1),(219,49,'Número de Captaciones',0,1,1),(220,50,'Tarea',1,1,1),(221,50,'Llamada',0,1,1),(222,50,'Visita',0,1,1),(223,51,'Entrante',1,1,1),(224,51,'Saliente',0,1,1),(225,52,'Planificada',1,1,1),(226,52,'Realizada',0,1,1),(227,52,'No Realizada',0,1,1),(228,53,'Planificada',1,1,1),(229,53,'Realizada',0,1,1),(230,53,'No Realizada',0,1,1),(231,54,'Planificada',1,1,1),(232,54,'Realizada',0,1,1),(233,54,'No Realizada',0,1,1),(234,55,'un minuto antes',1,1,1),(235,55,'un dia antes',0,1,1),(236,56,'Baja',1,1,1),(237,56,'Media',0,1,1),(238,56,'Alta',0,1,1),(239,57,'Ninguno',1,1,1),(240,57,'Centro Comercial',0,1,1),(241,58,'Ninguno',1,1,1),(242,58,'Edificio',0,1,1),(243,59,'Enero',1,1,1),(244,59,'Febrero',0,1,1),(245,59,'Marzo',0,1,1),(246,59,'Abril',0,1,1),(247,59,'Mayo',0,1,1),(248,59,'Junio',0,1,1),(249,59,'Julio',0,1,1),(250,59,'Agosto',0,1,1),(251,59,'Septiembre',0,1,1),(252,59,'Octubre',0,1,1),(253,59,'Noviembre',0,1,1),(254,59,'Diciembre',0,1,1),(255,60,'Directo',1,1,1),(256,60,'Bróker',0,1,1),(257,60,'Tercería',0,1,1),(258,60,'Referido',0,1,1),(259,61,'SI',1,1,1),(260,61,'NO',0,1,1),(261,61,'NO SE SABE',0,1,1),(262,7,'Apartaestudio',0,1,1),(263,62,'No',1,1,1),(264,62,'Si',0,1,1),(265,62,'Si se requiere',0,1,1),(266,60,'Inmobiliaria',0,1,1),(267,63,'Hotelería y Turismo',1,1,0),(268,63,'Tecnología',0,1,0),(269,63,'Construcción',0,1,0),(270,63,'Centros Comerciales',0,1,0),(271,63,'Telefonica',0,1,1),(272,63,'Industrial',0,1,1),(273,63,'Luces',0,1,1),(274,63,'Cableado',0,1,1),(275,23,'Alquiler Permanente',0,1,0),(276,7,'En Negociación',0,1,0);

/*Table structure for table `oportunidad` */

DROP TABLE IF EXISTS `oportunidad`;

CREATE TABLE `oportunidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL COMMENT 'Id cliente de la oportunidad',
  `etapa_id` int(11) NOT NULL COMMENT 'Id de la etapa de oportunidad',
  `toma_contacto_id` int(11) NOT NULL COMMENT 'Id de tipo de contacto de la oportunidad.\nCuando el campo de toma de contacto tome el valor de Campaña se \nmuestra el campo de Campaña. Para las otras opciones se oculta.',
  `asesor_asignado_id` int(11) NOT NULL COMMENT 'Id del usuario del sistema a quien se asigna dicha oportunidad',
  `campanna_id` int(11) DEFAULT NULL COMMENT 'Id de la campaña',
  `referencia` varchar(45) DEFAULT NULL COMMENT 'Referencia',
  `valor` varchar(45) DEFAULT NULL COMMENT 'Valor',
  `fecha_cierre` date DEFAULT NULL COMMENT 'Fecha de cierre',
  `descripcion` text COMMENT 'Descripción',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `cliente_potencial_id` int(11) DEFAULT NULL,
  `linea_id` varchar(45) DEFAULT NULL,
  `linea_str` varchar(145) DEFAULT NULL,
  `convenio_id` int(11) DEFAULT NULL,
  `contradictor_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oportunidad_moneda1_idx` (`campanna_id`),
  KEY `fk_oportunidad_etapa_idx` (`etapa_id`),
  KEY `fk_oportunidad_toma_contacto_idx` (`toma_contacto_id`),
  KEY `fk_oportunidad_usuario_idx` (`asesor_asignado_id`),
  KEY `fk_oportunidad_cuenta1_idx` (`cuenta_id`),
  CONSTRAINT `fk_oportunidad_asesor` FOREIGN KEY (`asesor_asignado_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oportunidad_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oportunidad_etapa` FOREIGN KEY (`etapa_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oportunidad_toma_contacto` FOREIGN KEY (`toma_contacto_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `oportunidad` */

/*Table structure for table `oportunidad_actividad` */

DROP TABLE IF EXISTS `oportunidad_actividad`;

CREATE TABLE `oportunidad_actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oportunidad_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_oportunidad_actividad_actividad_idx` (`actividad_id`),
  KEY `fk_oportunidad_actividad_oportunidad_idx` (`oportunidad_id`),
  CONSTRAINT `fk_oportunidad_actividad_actividad` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oportunidad_actividad_oportunidad` FOREIGN KEY (`oportunidad_id`) REFERENCES `oportunidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `oportunidad_actividad` */

/*Table structure for table `oportunidad_contacto` */

DROP TABLE IF EXISTS `oportunidad_contacto`;

CREATE TABLE `oportunidad_contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oportunidad_id` int(11) NOT NULL COMMENT 'Id de la oportunidad en relacion con el contacto',
  `contacto_id` int(11) NOT NULL COMMENT 'Id del contacto en relación con la oportunidad',
  `rol_id` int(11) NOT NULL COMMENT 'Id del rol contacto-oportunidad',
  `eliminado` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_oportunidad_contacto_oportunidad_idx` (`oportunidad_id`),
  KEY `fk_oportunidad_contacto_contacto_idx` (`contacto_id`),
  KEY `fk_oportunidad_contacto_rol_idx` (`rol_id`),
  CONSTRAINT `fk_oportunidad_contacto_contacto` FOREIGN KEY (`contacto_id`) REFERENCES `contacto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oportunidad_contacto_oportunidad` FOREIGN KEY (`oportunidad_id`) REFERENCES `oportunidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oportunidad_contacto_rol` FOREIGN KEY (`rol_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `oportunidad_contacto` */

/*Table structure for table `oportunidad_documento` */

DROP TABLE IF EXISTS `oportunidad_documento`;

CREATE TABLE `oportunidad_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oportunidad_id` int(11) NOT NULL,
  `documento_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_oportunidad_documento_oportunidad_idx` (`oportunidad_id`),
  KEY `fk_oportunidad_documento_documento_idx` (`documento_id`),
  CONSTRAINT `fk_oportunidad_documento_documento` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oportunidad_documento_oportunidad` FOREIGN KEY (`oportunidad_id`) REFERENCES `oportunidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `oportunidad_documento` */

/*Table structure for table `pais` */

DROP TABLE IF EXISTS `pais`;

CREATE TABLE `pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_por` varchar(20) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pais` */

/*Table structure for table `perfil` */

DROP TABLE IF EXISTS `perfil`;

CREATE TABLE `perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `perfil` */

insert  into `perfil`(`id`,`nombre`,`activo`,`fecha_creacion`,`fecha_modificacion`,`eliminado`) values (1,'admin',1,'2015-06-12 00:00:00','2016-06-24 00:00:00',0),(2,'admin',1,'2015-06-12 00:00:00','2016-06-24 00:00:00',1),(3,'Nuevo perfil',1,'2016-07-26 17:13:20',NULL,0);

/*Table structure for table `producto` */

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL COMMENT 'Id de la categoria a la que pertenece el producto.\nEn caso de haber una categoría inactiva no debe de mostrar todas las\ncategorías hijas.',
  `estado_id` int(11) NOT NULL COMMENT 'Estado del producto',
  `referencia` varchar(45) NOT NULL COMMENT 'Referencia del producto',
  `codigo` varchar(45) NOT NULL COMMENT 'Código del producto',
  `descripcion` text COMMENT 'Descripción del producto',
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  `eliminado` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_producto_categoria_idx` (`categoria_id`),
  KEY `fk_producto_estado_idx` (`estado_id`),
  CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_estado` FOREIGN KEY (`estado_id`) REFERENCES `opcion_lista_maestra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `producto` */

/*Table structure for table `revision` */

DROP TABLE IF EXISTS `revision`;

CREATE TABLE `revision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bandera` tinyint(1) DEFAULT '0',
  `documentos_id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `adjunto` varchar(255) DEFAULT NULL,
  `nombre_adjunto` varchar(255) DEFAULT NULL,
  `version` varchar(45) DEFAULT NULL,
  `creado_por` varchar(45) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `eliminado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_revision_documentos1_idx` (`documentos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='CREATE TABLE IF NOT EXISTS `nicecrm-inmo`.`documentos` (\n  `id` INT(11) NOT NULL AUTO_INCREMENT,\n  `modulo_relacionado_id` VARCHAR(45) NULL DEFAULT NULL,\n  `modulo_relacionado` VARCHAR(45) NULL DEFAULT NULL,\n  `nombre` VARCHAR(45) NULL DEFAULT NULL,\n  `adjunto` VARCHAR(255) NULL DEFAULT NULL,\n  `version` VARCHAR(45) NULL,\n  `categoria` VARCHAR(45) NULL DEFAULT NULL,\n  `estado` VARCHAR(45) NULL DEFAULT NULL,\n  `tipo_documento` VARCHAR(45) NULL DEFAULT NULL,\n  `fecha_publicacion` DATE NULL DEFAULT NULL,\n  `creado_por` VARCHAR(45) NULL DEFAULT NULL,\n  `fecha_creacion` DATE NULL DEFAULT NULL,\n  `descripcion` VARCHAR(255) NULL DEFAULT NULL,\n  `activo` TINYINT(1) NULL DEFAULT ''1'',\n  `eliminado` TINYINT(1) NULL DEFAULT ''0'',\n  PRIMARY KEY (`id`))\nENGINE = InnoDB\n\nDEFAULT CHARACTER SET = utf8';

/*Data for the table `revision` */

/*Table structure for table `servicio` */

DROP TABLE IF EXISTS `servicio`;

CREATE TABLE `servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) DEFAULT NULL,
  `modalidad_cobro_id` int(11) DEFAULT NULL,
  `periodo_cobro_id` int(11) DEFAULT NULL,
  `estado_servicio_id` int(11) DEFAULT NULL,
  `responsable_id` int(11) DEFAULT NULL,
  `tipo_servicio_id` varchar(145) DEFAULT NULL,
  `tipo_servicio_str` varchar(255) DEFAULT NULL,
  `linea_id` varchar(145) DEFAULT NULL,
  `linea_str` varchar(255) DEFAULT NULL,
  `forma_pago_id` int(11) DEFAULT NULL,
  `fecha_vigencia_desde` date DEFAULT NULL,
  `fecha_vigencia_hasta` date DEFAULT NULL,
  `valor_servicio` varchar(45) DEFAULT NULL,
  `tarifa` varchar(45) DEFAULT NULL,
  `tarifa_obs` varchar(45) DEFAULT NULL,
  `condiciones_comerciales` text,
  `descripcion` text,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  `eliminado` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_servicio_responsable_idx` (`responsable_id`),
  KEY `fk_servicio_cuenta_idx` (`cuenta_id`),
  CONSTRAINT `fk_servicio_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_servicio_responsable` FOREIGN KEY (`responsable_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `servicio` */

/*Table structure for table `servicio_actividad` */

DROP TABLE IF EXISTS `servicio_actividad`;

CREATE TABLE `servicio_actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `servicio_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_servicio_actividad_servicio_idx` (`servicio_id`),
  KEY `fk_servicio_actividad_actividad_idx` (`actividad_id`),
  CONSTRAINT `fk_servicio_actividad_actividad` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_servicio_actividad_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `servicio_actividad` */

/*Table structure for table `servicio_documento` */

DROP TABLE IF EXISTS `servicio_documento`;

CREATE TABLE `servicio_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `servicio_id` int(11) NOT NULL,
  `documento_id` int(11) NOT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_servicio_documento_docuemnto_idx` (`documento_id`),
  KEY `fk_servicio_documento_servicio_idx` (`servicio_id`),
  CONSTRAINT `fk_servicio_documento_docuemnto` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_servicio_documento_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `servicio_documento` */

/*Table structure for table `servicio_pago` */

DROP TABLE IF EXISTS `servicio_pago`;

CREATE TABLE `servicio_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `servicio_id` int(11) NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `valor` int(11) DEFAULT NULL,
  `pagado` tinyint(1) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_servicio_pago_servicio1_idx` (`servicio_id`),
  CONSTRAINT `fk_servicio_pago_servicio1` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `servicio_pago` */

/*Table structure for table `telefono` */

DROP TABLE IF EXISTS `telefono`;

CREATE TABLE `telefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

/*Data for the table `telefono` */

/*Table structure for table `tipo_ubicacion` */

DROP TABLE IF EXISTS `tipo_ubicacion`;

CREATE TABLE `tipo_ubicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `nivel` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `tipo_ubicacion` */

insert  into `tipo_ubicacion`(`id`,`nombre`,`nivel`,`activo`,`fecha_creacion`,`fecha_modificacion`,`eliminado`) values (1,'Continente',1,1,NULL,NULL,0),(2,'Pais',2,1,NULL,NULL,0),(3,'Departamento',3,1,NULL,NULL,0),(4,'Municipio',4,1,NULL,NULL,0),(5,'Localidad',5,1,NULL,NULL,0),(6,'UPZ',6,1,NULL,NULL,0),(7,'Barrio',7,1,NULL,NULL,0),(8,'Ciudad',8,1,NULL,NULL,0);

/*Table structure for table `ubicacion` */

DROP TABLE IF EXISTS `ubicacion`;

CREATE TABLE `ubicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_ubicacion_id` int(11) NOT NULL,
  `ubicacion_padre_id` int(11) DEFAULT NULL,
  `nombre` varchar(45) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_ubicacion_tipo_ubicacion1_idx` (`tipo_ubicacion_id`),
  KEY `fk_ubicacion_ubicacion1_idx` (`ubicacion_padre_id`),
  CONSTRAINT `fk_ubicacion_tipo_ubicacion1` FOREIGN KEY (`tipo_ubicacion_id`) REFERENCES `tipo_ubicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ubicacion_ubicacion1` FOREIGN KEY (`ubicacion_padre_id`) REFERENCES `ubicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2767 DEFAULT CHARSET=utf8;

/*Data for the table `ubicacion` */

insert  into `ubicacion`(`id`,`tipo_ubicacion_id`,`ubicacion_padre_id`,`nombre`,`activo`,`fecha_creacion`,`fecha_modificacion`,`eliminado`) values (1,1,NULL,'Africa',1,NULL,NULL,0),(2,1,NULL,'América',1,NULL,NULL,0),(3,1,NULL,'Asia',1,NULL,NULL,0),(4,1,NULL,'Europa',1,NULL,NULL,0),(5,1,NULL,'Oceanía',1,NULL,NULL,0),(6,2,3,'Abjasia',1,NULL,NULL,0),(7,2,4,'Acrotiri y Dhekelia',1,NULL,NULL,0),(8,2,3,'Afganistán',1,NULL,NULL,0),(9,2,4,'Albania',1,NULL,NULL,0),(10,2,4,'Alemania',1,NULL,NULL,0),(11,2,4,'Andorra',1,NULL,NULL,0),(12,2,1,'Angola',1,NULL,NULL,0),(13,2,2,'Anguila',1,NULL,NULL,0),(14,2,2,'Antigua y Barbuda',1,NULL,NULL,0),(15,2,3,'Arabia Saudita',1,NULL,NULL,0),(16,2,1,'Argelia',1,NULL,NULL,0),(17,2,2,'Argentina',1,NULL,NULL,0),(18,2,3,'Armenia',1,NULL,NULL,0),(19,2,2,'Aruba',1,NULL,NULL,0),(20,2,5,'Australia',1,NULL,NULL,0),(21,2,4,'Austria',1,NULL,NULL,0),(22,2,3,'Azerbaiyán',1,NULL,NULL,0),(23,2,2,'Bahamas',1,NULL,NULL,0),(24,2,3,'Baréin',1,NULL,NULL,0),(25,2,3,'Bangladés',1,NULL,NULL,0),(26,2,2,'Barbados',1,NULL,NULL,0),(27,2,4,'Bélgica',1,NULL,NULL,0),(28,2,2,'Belice',1,NULL,NULL,0),(29,2,1,'Benín',1,NULL,NULL,0),(30,2,2,'Bermudas',1,NULL,NULL,0),(31,2,4,'Bielorrusia',1,NULL,NULL,0),(32,2,3,'Birmania',1,NULL,NULL,0),(33,2,2,'Bolivia',1,NULL,NULL,0),(34,2,4,'Bosnia y Herzegovina',1,NULL,NULL,0),(35,2,1,'Botsuana',1,NULL,NULL,0),(36,2,2,'Brasil',1,NULL,NULL,0),(37,2,3,'Brunéi',1,NULL,NULL,0),(38,2,4,'Bulgaria',1,NULL,NULL,0),(39,2,1,'Burkina Faso',1,NULL,NULL,0),(40,2,1,'Burundi',1,NULL,NULL,0),(41,2,3,'Bután',1,NULL,NULL,0),(42,2,1,'Cabo Verde',1,NULL,NULL,0),(43,2,2,'Caimán, Islas',1,NULL,NULL,0),(44,2,3,'Camboya',1,NULL,NULL,0),(45,2,1,'Camerún',1,NULL,NULL,0),(46,2,2,'Canadá',1,NULL,NULL,0),(47,2,3,'Catar',1,NULL,NULL,0),(48,2,1,'Centroafricana, República',1,NULL,NULL,0),(49,2,1,'Chad',1,NULL,NULL,0),(50,2,4,'Checa, República',1,NULL,NULL,0),(51,2,2,'Chile',1,NULL,NULL,0),(52,2,3,'China',1,NULL,NULL,0),(53,2,3,'Chipre',1,NULL,NULL,0),(54,2,3,'Chipre del Norte',1,NULL,NULL,0),(55,2,3,'Cocos, Islas',1,NULL,NULL,0),(56,2,2,'Colombia',1,NULL,NULL,0),(57,2,1,'Comoras',1,NULL,NULL,0),(58,2,1,'Congo, República del',1,NULL,NULL,0),(59,2,1,'Congo, República Democrática del',1,NULL,NULL,0),(60,2,5,'Cook, Islas',1,NULL,NULL,0),(61,2,3,'Corea del Norte',1,NULL,NULL,0),(62,2,3,'Corea del Sur',1,NULL,NULL,0),(63,2,1,'Costa de Marfil',1,NULL,NULL,0),(64,2,2,'Costa Rica',1,NULL,NULL,0),(65,2,4,'Croacia',1,NULL,NULL,0),(66,2,2,'Cuba',1,NULL,NULL,0),(67,2,2,'Curazao',1,NULL,NULL,0),(68,2,4,'Dinamarca',1,NULL,NULL,0),(69,2,2,'Dominica',1,NULL,NULL,0),(70,2,2,'Dominicana, República',1,NULL,NULL,0),(71,2,2,'Ecuador',1,NULL,NULL,0),(72,2,1,'Egipto',1,NULL,NULL,0),(73,2,2,'El Salvador',1,NULL,NULL,0),(74,2,3,'Emiratos Árabes Unidos',1,NULL,NULL,0),(75,2,1,'Eritrea',1,NULL,NULL,0),(76,2,4,'Eslovaquia',1,NULL,NULL,0),(77,2,4,'Eslovenia',1,NULL,NULL,0),(78,2,4,'España',1,NULL,NULL,0),(79,2,2,'Estados Unidos',1,NULL,NULL,0),(80,2,4,'Estonia',1,NULL,NULL,0),(81,2,1,'Etiopía',1,NULL,NULL,0),(82,2,4,'Feroe, Islas',1,NULL,NULL,0),(83,2,3,'Filipinas',1,NULL,NULL,0),(84,2,4,'Finlandia',1,NULL,NULL,0),(85,2,5,'Fiyi',1,NULL,NULL,0),(86,2,4,'Francia',1,NULL,NULL,0),(87,2,1,'Gabón',1,NULL,NULL,0),(88,2,1,'Gambia',1,NULL,NULL,0),(89,2,3,'Georgia',1,NULL,NULL,0),(90,2,1,'Ghana',1,NULL,NULL,0),(91,2,4,'Gibraltar',1,NULL,NULL,0),(92,2,2,'Granada',1,NULL,NULL,0),(93,2,4,'Grecia',1,NULL,NULL,0),(94,2,2,'Groenlandia',1,NULL,NULL,0),(95,2,5,'Guam',1,NULL,NULL,0),(96,2,2,'Guatemala',1,NULL,NULL,0),(97,2,4,'Guernsey',1,NULL,NULL,0),(98,2,1,'Guinea',1,NULL,NULL,0),(99,2,1,'Guinea-Bisáu',1,NULL,NULL,0),(100,2,1,'Guinea Ecuatorial',1,NULL,NULL,0),(101,2,2,'Guyana',1,NULL,NULL,0),(102,2,2,'Haití',1,NULL,NULL,0),(103,2,2,'Honduras',1,NULL,NULL,0),(104,2,3,'Hong Kong',1,NULL,NULL,0),(105,2,4,'Hungría',1,NULL,NULL,0),(106,2,3,'India',1,NULL,NULL,0),(107,2,3,'Indonesia',1,NULL,NULL,0),(108,2,3,'Irak',1,NULL,NULL,0),(109,2,3,'Irán',1,NULL,NULL,0),(110,2,4,'Irlanda',1,NULL,NULL,0),(111,2,4,'Islandia',1,NULL,NULL,0),(112,2,3,'Israel',1,NULL,NULL,0),(113,2,4,'Italia',1,NULL,NULL,0),(114,2,2,'Jamaica',1,NULL,NULL,0),(115,2,3,'Japón',1,NULL,NULL,0),(116,2,4,'Jersey',1,NULL,NULL,0),(117,2,3,'Jordania',1,NULL,NULL,0),(118,2,3,'Kazajistán',1,NULL,NULL,0),(119,2,1,'Kenia',1,NULL,NULL,0),(120,2,3,'Kirguistán',1,NULL,NULL,0),(121,2,5,'Kiribati',1,NULL,NULL,0),(122,2,4,'Kosovo',1,NULL,NULL,0),(123,2,3,'Kuwait',1,NULL,NULL,0),(124,2,3,'Laos',1,NULL,NULL,0),(125,2,1,'Lesoto',1,NULL,NULL,0),(126,2,4,'Letonia',1,NULL,NULL,0),(127,2,3,'Líbano',1,NULL,NULL,0),(128,2,1,'Liberia',1,NULL,NULL,0),(129,2,1,'Libia',1,NULL,NULL,0),(130,2,4,'Liechtenstein',1,NULL,NULL,0),(131,2,4,'Lituania',1,NULL,NULL,0),(132,2,4,'Luxemburgo',1,NULL,NULL,0),(133,2,3,'Macao',1,NULL,NULL,0),(134,2,4,'Macedonia',1,NULL,NULL,0),(135,2,1,'Madagascar',1,NULL,NULL,0),(136,2,3,'Malasia',1,NULL,NULL,0),(137,2,1,'Malaui',1,NULL,NULL,0),(138,2,3,'Maldivas',1,NULL,NULL,0),(139,2,1,'Malí',1,NULL,NULL,0),(140,2,4,'Malta',1,NULL,NULL,0),(141,2,4,'Man, Isla de',1,NULL,NULL,0),(142,2,5,'Marianas del Norte, Islas',1,NULL,NULL,0),(143,2,1,'Marruecos',1,NULL,NULL,0),(144,2,5,'Marshall, Islas',1,NULL,NULL,0),(145,2,1,'Mauricio',1,NULL,NULL,0),(146,2,1,'Mauritania',1,NULL,NULL,0),(147,2,2,'México',1,NULL,NULL,0),(148,2,5,'Micronesia',1,NULL,NULL,0),(149,2,4,'Moldavia',1,NULL,NULL,0),(150,2,4,'Mónaco',1,NULL,NULL,0),(151,2,3,'Mongolia',1,NULL,NULL,0),(152,2,4,'Montenegro',1,NULL,NULL,0),(153,2,2,'Montserrat',1,NULL,NULL,0),(154,2,1,'Mozambique',1,NULL,NULL,0),(155,2,3,'Nagorno Karabaj',1,NULL,NULL,0),(156,2,1,'Namibia',1,NULL,NULL,0),(157,2,5,'Nauru',1,NULL,NULL,0),(158,2,3,'Navidad, Isla de',1,NULL,NULL,0),(159,2,3,'Nepal',1,NULL,NULL,0),(160,2,2,'Nicaragua',1,NULL,NULL,0),(161,2,1,'Níger',1,NULL,NULL,0),(162,2,1,'Nigeria',1,NULL,NULL,0),(163,2,5,'Niue',1,NULL,NULL,0),(164,2,5,'Norfolk, Isla',1,NULL,NULL,0),(165,2,4,'Noruega',1,NULL,NULL,0),(166,2,5,'Nueva Caledonia',1,NULL,NULL,0),(167,2,4,'Nueva Rusia',1,NULL,NULL,0),(168,2,5,'Nueva Zelanda',1,NULL,NULL,0),(169,2,3,'Omán',1,NULL,NULL,0),(170,2,3,'Osetia del Sur',1,NULL,NULL,0),(171,2,4,'Países Bajos',1,NULL,NULL,0),(172,2,3,'Pakistán',1,NULL,NULL,0),(173,2,5,'Palaos',1,NULL,NULL,0),(174,2,3,'Palestina',1,NULL,NULL,0),(175,2,2,'Panamá',1,NULL,NULL,0),(176,2,5,'Papúa Nueva Guinea',1,NULL,NULL,0),(177,2,2,'Paraguay',1,NULL,NULL,0),(178,2,2,'Perú',1,NULL,NULL,0),(179,2,5,'Pitcairn, Islas',1,NULL,NULL,0),(180,2,5,'Polinesia Francesa',1,NULL,NULL,0),(181,2,4,'Polonia',1,NULL,NULL,0),(182,2,4,'Portugal',1,NULL,NULL,0),(183,2,2,'Puerto Rico',1,NULL,NULL,0),(184,2,4,'Reino Unido',1,NULL,NULL,0),(185,2,1,'Ruanda',1,NULL,NULL,0),(186,2,4,'Rumania',1,NULL,NULL,0),(187,2,3,'Rusia',1,NULL,NULL,0),(188,2,1,'Sahara Occidental',1,NULL,NULL,0),(189,2,5,'Salomón, Islas',1,NULL,NULL,0),(190,2,5,'Samoa',1,NULL,NULL,0),(191,2,5,'Samoa Americana',1,NULL,NULL,0),(192,2,2,'San Bartolomé',1,NULL,NULL,0),(193,2,2,'San Cristóbal y Nieves',1,NULL,NULL,0),(194,2,4,'San Marino',1,NULL,NULL,0),(195,2,2,'San Martín',1,NULL,NULL,0),(196,2,2,'Sint Maarten',1,NULL,NULL,0),(197,2,2,'San Pedro y Miquelón',1,NULL,NULL,0),(198,2,2,'San Vicente y las Granadinas',1,NULL,NULL,0),(199,2,5,'Santa Elena, Ascensión y Tristán de Acuña',1,NULL,NULL,0),(200,2,2,'Santa Lucía',1,NULL,NULL,0),(201,2,1,'Santo Tomé y Príncipe',1,NULL,NULL,0),(202,2,1,'Senegal',1,NULL,NULL,0),(203,2,4,'Serbia',1,NULL,NULL,0),(204,2,1,'Seychelles',1,NULL,NULL,0),(205,2,1,'Sierra Leona',1,NULL,NULL,0),(206,2,3,'Singapur',1,NULL,NULL,0),(207,2,3,'Siria',1,NULL,NULL,0),(208,2,1,'Somalia',1,NULL,NULL,0),(209,2,1,'Somalilandia',1,NULL,NULL,0),(210,2,3,'Sri Lanka',1,NULL,NULL,0),(211,2,1,'Suazilandia',1,NULL,NULL,0),(212,2,1,'Sudáfrica',1,NULL,NULL,0),(213,2,1,'Sudán',1,NULL,NULL,0),(214,2,1,'Sudán del Sur',1,NULL,NULL,0),(215,2,4,'Suecia',1,NULL,NULL,0),(216,2,4,'Suiza',1,NULL,NULL,0),(217,2,2,'Surinam',1,NULL,NULL,0),(218,2,4,'Svalbard',1,NULL,NULL,0),(219,2,3,'Tailandia',1,NULL,NULL,0),(220,2,3,'Taiwán',1,NULL,NULL,0),(221,2,1,'Tanzania',1,NULL,NULL,0),(222,2,3,'Tayikistán',1,NULL,NULL,0),(223,2,3,'Timor Oriental',1,NULL,NULL,0),(224,2,1,'Togo',1,NULL,NULL,0),(225,2,5,'Tokelau',1,NULL,NULL,0),(226,2,5,'Tonga',1,NULL,NULL,0),(227,2,4,'Transnistria',1,NULL,NULL,0),(228,2,2,'Trinidad y Tobago',1,NULL,NULL,0),(229,2,1,'Túnez',1,NULL,NULL,0),(230,2,2,'Turcas y Caicos, Islas',1,NULL,NULL,0),(231,2,3,'Turkmenistán',1,NULL,NULL,0),(232,2,3,'Turquía',1,NULL,NULL,0),(233,2,5,'Tuvalu',1,NULL,NULL,0),(234,2,4,'Ucrania',1,NULL,NULL,0),(235,2,1,'Uganda',1,NULL,NULL,0),(236,2,2,'Uruguay',1,NULL,NULL,0),(237,2,3,'Uzbekistán',1,NULL,NULL,0),(238,2,5,'Vanuatu',1,NULL,NULL,0),(239,2,4,'Vaticano, Ciudad del',1,NULL,NULL,0),(240,2,2,'Venezuela',1,NULL,NULL,0),(241,2,3,'Vietnam',1,NULL,NULL,0),(242,2,2,'Vírgenes Británicas, Islas',1,NULL,NULL,0),(243,2,2,'Vírgenes de los Estados Unidos, Islas',1,NULL,NULL,0),(244,2,5,'Wallis y Futuna',1,NULL,NULL,0),(245,2,3,'Yemen',1,NULL,NULL,0),(246,2,1,'Yibuti',1,NULL,NULL,0),(247,2,1,'Zambia',1,NULL,NULL,0),(248,2,1,'Zimbabue',1,NULL,NULL,0),(249,3,56,'Amazonas',1,NULL,NULL,0),(250,3,56,'Antioquia',1,NULL,NULL,0),(251,3,56,'Arauca',1,NULL,NULL,0),(252,3,56,'Atlántico',1,NULL,NULL,0),(253,3,56,'Bogota D.C',1,NULL,NULL,0),(254,3,56,'Bolívar',1,NULL,NULL,0),(255,3,56,'Boyacá',1,NULL,NULL,0),(256,3,56,'Caldas',1,NULL,NULL,0),(257,3,56,'Caquetá',1,NULL,NULL,0),(258,3,56,'Casanare',1,NULL,NULL,0),(259,3,56,'Cauca',1,NULL,NULL,0),(260,3,56,'Cesar',1,NULL,NULL,0),(261,3,56,'Chocó',1,NULL,NULL,0),(262,3,56,'Córdoba',1,NULL,NULL,0),(263,3,56,'Cundinamarca',1,NULL,NULL,0),(264,3,56,'Guainía',1,NULL,NULL,0),(265,3,56,'Guaviare',1,NULL,NULL,0),(266,3,56,'Huila',1,NULL,NULL,0),(267,3,56,'La Guajira',1,NULL,NULL,0),(268,3,56,'Magdalena',1,NULL,NULL,0),(269,3,56,'Meta',1,NULL,NULL,0),(270,3,56,'Nariño',1,NULL,NULL,0),(271,3,56,'Norte de Santander',1,NULL,NULL,0),(272,3,56,'Putumayo',1,NULL,NULL,0),(273,3,56,'Quindío',1,NULL,NULL,0),(274,3,56,'Risaralda',1,NULL,NULL,0),(275,3,56,'San Andrés y Providencia',1,NULL,NULL,0),(276,3,56,'Santander',1,NULL,NULL,0),(277,3,56,'Sucre',1,NULL,NULL,0),(278,3,56,'Tolima',1,NULL,NULL,0),(279,3,56,'Valle del Cauca',1,NULL,NULL,0),(280,3,56,'Vaupés',1,NULL,NULL,0),(281,3,56,'Vichada',1,NULL,NULL,0),(283,4,253,'Bogotá D.C',1,NULL,NULL,0),(284,5,283,'Barrios Unidos',1,NULL,NULL,0),(285,5,283,'Bosa',1,NULL,NULL,0),(286,5,283,'Candelaria',1,NULL,NULL,0),(287,5,283,'Chapinero',1,NULL,NULL,0),(288,5,283,'Ciudad Bolivar',1,NULL,NULL,0),(289,5,283,'Engativa',1,NULL,NULL,0),(290,5,283,'Fontibon',1,NULL,NULL,0),(291,5,283,'Kennedy',1,NULL,NULL,0),(292,5,283,'Martires',1,NULL,NULL,0),(293,5,283,'Puente Aranda',1,NULL,NULL,0),(294,5,283,'Rafael Uribe',1,NULL,NULL,0),(295,5,283,'San Antonio',1,NULL,NULL,0),(296,5,283,'San Cristobal',1,NULL,NULL,0),(297,5,283,'Santa Fe',1,NULL,NULL,0),(298,5,283,'Suba',1,NULL,NULL,0),(299,5,283,'Teusaquillo',1,NULL,NULL,0),(300,5,283,'Tunjuelo',1,NULL,NULL,0),(301,5,283,'Usaquen',1,NULL,NULL,0),(302,5,283,'Usme',1,NULL,NULL,0),(303,6,296,'20 De Julio',1,NULL,NULL,0),(304,6,290,'Aeropuerto El Dorado',1,NULL,NULL,0),(305,6,289,'Alamos',1,NULL,NULL,0),(306,6,302,'Alfonso Lopez',1,NULL,NULL,0),(307,6,291,'Americas',1,NULL,NULL,0),(308,6,285,'Apogeo',1,NULL,NULL,0),(309,6,288,'Arborizadora',1,NULL,NULL,0),(310,6,291,'Bavaria',1,NULL,NULL,0),(311,6,289,'Bolivia',1,NULL,NULL,0),(312,6,285,'Bosa Central',1,NULL,NULL,0),(313,6,285,'Bosa Occidental',1,NULL,NULL,0),(314,6,289,'Boyaca Real',1,NULL,NULL,0),(315,6,298,'Britalia',1,NULL,NULL,0),(316,6,291,'Calandaima',1,NULL,NULL,0),(317,6,286,'Candelaria',1,NULL,NULL,0),(318,6,290,'Capellania',1,NULL,NULL,0),(319,6,291,'Carvajal',1,NULL,NULL,0),(320,6,298,'Casa Blanca Suba',1,NULL,NULL,0),(321,6,291,'Castilla',1,NULL,NULL,0),(322,6,287,'Chapinero',1,NULL,NULL,0),(323,6,287,'Chico Lago',1,NULL,NULL,0),(324,6,302,'Ciudad De Usme',1,NULL,NULL,0),(325,6,295,'Ciudad Jardin',1,NULL,NULL,0),(326,6,293,'Ciudad Montes',1,NULL,NULL,0),(327,6,290,'Ciudad Salitre Occidente',1,NULL,NULL,0),(328,6,299,'Ciudad Salitre Oriental',1,NULL,NULL,0),(329,6,302,'Comuneros',1,NULL,NULL,0),(330,6,291,'Corabastos',1,NULL,NULL,0),(331,6,301,'Country Club',1,NULL,NULL,0),(332,6,302,'Danubio',1,NULL,NULL,0),(333,6,294,'Diana Turbay',1,NULL,NULL,0),(334,6,284,'Doce De Octubre',1,NULL,NULL,0),(335,6,288,'El Mochuelo',1,NULL,NULL,0),(336,6,285,'El Porvenir',1,NULL,NULL,0),(337,6,298,'El Prado',1,NULL,NULL,0),(338,6,287,'El Refugio',1,NULL,NULL,0),(339,6,298,'El Rincon',1,NULL,NULL,0),(340,6,288,'El Tesoro',1,NULL,NULL,0),(341,6,289,'Engativa',1,NULL,NULL,0),(342,6,290,'Fontibon',1,NULL,NULL,0),(343,6,290,'Fontibon San Pablo',1,NULL,NULL,0),(344,6,299,'Galerias',1,NULL,NULL,0),(345,6,289,'Garces Navas',1,NULL,NULL,0),(346,6,291,'Gran Britalia',1,NULL,NULL,0),(347,6,302,'Gran Yomasa',1,NULL,NULL,0),(348,6,290,'Granjas De Techo',1,NULL,NULL,0),(349,6,298,'Guaymaral',1,NULL,NULL,0),(350,6,288,'Ismael Perdomo',1,NULL,NULL,0),(351,6,289,'Jardin Botanico',1,NULL,NULL,0),(352,6,288,'Jerusalen',1,NULL,NULL,0),(353,6,291,'Kennedy Central',1,NULL,NULL,0),(354,6,298,'La Academia',1,NULL,NULL,0),(355,6,298,'La Alhambra',1,NULL,NULL,0),(356,6,299,'La Esmeralda',1,NULL,NULL,0),(357,6,302,'La Flora',1,NULL,NULL,0),(358,6,298,'La Floresta',1,NULL,NULL,0),(359,6,296,'La Gloria',1,NULL,NULL,0),(360,6,297,'La Macarena',1,NULL,NULL,0),(361,6,292,'La Sabana',1,NULL,NULL,0),(362,6,301,'La Uribe',1,NULL,NULL,0),(363,6,297,'Las Cruces',1,NULL,NULL,0),(364,6,289,'Las Ferias',1,NULL,NULL,0),(365,6,291,'Las Margaritas',1,NULL,NULL,0),(366,6,297,'Las Nieves',1,NULL,NULL,0),(367,6,284,'Los Alcazares',1,NULL,NULL,0),(368,6,284,'Los Andres',1,NULL,NULL,0),(369,6,301,'Los Cedros',1,NULL,NULL,0),(370,6,296,'Los Libertadores',1,NULL,NULL,0),(371,6,297,'Lourdes',1,NULL,NULL,0),(372,6,288,'Lucero',1,NULL,NULL,0),(373,6,294,'Marco Fidel Suarez',1,NULL,NULL,0),(374,6,294,'Marruecos',1,NULL,NULL,0),(375,6,289,'Minuto De Dios',1,NULL,NULL,0),(376,6,290,'Modelia',1,NULL,NULL,0),(377,6,288,'Monteblanco',1,NULL,NULL,0),(378,6,293,'Muzu',1,NULL,NULL,0),(379,6,298,'Niza',1,NULL,NULL,0),(380,6,287,'Pardo Rubio',1,NULL,NULL,0),(381,6,302,'Parque Entrenubes',1,NULL,NULL,0),(382,6,284,'Parque Salitre',1,NULL,NULL,0),(383,6,299,'Parque Simon Bolivar - CAN',1,NULL,NULL,0),(384,6,301,'Paseo De Los Libertadores',1,NULL,NULL,0),(385,6,291,'Patio Bonito',1,NULL,NULL,0),(386,6,293,'Puente Aranda',1,NULL,NULL,0),(387,6,299,'Quinta Paredes',1,NULL,NULL,0),(388,6,294,'Quiroga',1,NULL,NULL,0),(389,6,295,'Restrepo',1,NULL,NULL,0),(390,6,297,'Sagrado Corazón',1,NULL,NULL,0),(391,6,296,'San Blas',1,NULL,NULL,0),(392,6,301,'San Cristobal Norte',1,NULL,NULL,0),(393,6,288,'San Francisco',1,NULL,NULL,0),(394,6,287,'San Isidrio Patios',1,NULL,NULL,0),(395,6,294,'San Jose',1,NULL,NULL,0),(396,6,298,'San Jose De Bavaria',1,NULL,NULL,0),(397,6,293,'San Rafael',1,NULL,NULL,0),(398,6,301,'Santa Barbara',1,NULL,NULL,0),(399,6,289,'Santa Cecilia',1,NULL,NULL,0),(400,6,292,'Santa Isabel',1,NULL,NULL,0),(401,6,296,'Sociego',1,NULL,NULL,0),(402,6,298,'Suba',1,NULL,NULL,0),(403,6,299,'Teusaquillo',1,NULL,NULL,0),(404,6,298,'Tibabuyes',1,NULL,NULL,0),(405,6,291,'Timiza',1,NULL,NULL,0),(406,6,291,'Tintal Norte',1,NULL,NULL,0),(407,6,285,'Tintal Sur',1,NULL,NULL,0),(408,6,301,'Toberin',1,NULL,NULL,0),(409,6,300,'Tunjuelito',1,NULL,NULL,0),(410,6,301,'Usaquen',1,NULL,NULL,0),(411,6,300,'Venecia',1,NULL,NULL,0),(412,6,301,'Verbenal',1,NULL,NULL,0),(413,6,290,'Zona Franca',1,NULL,NULL,0),(414,6,293,'Zona Industrial',1,NULL,NULL,0),(415,7,384,'Canaima',1,NULL,NULL,0),(416,7,384,'La Floresta De La Sabana',1,NULL,NULL,0),(417,7,384,'Torca',1,NULL,NULL,0),(418,7,412,'Alto De Serrezuela',1,NULL,NULL,0),(419,7,412,'Balcones De Vista Hermosa',1,NULL,NULL,0),(420,7,412,'Balmoral Norte',1,NULL,NULL,0),(421,7,412,'Buenavista',1,NULL,NULL,0),(422,7,412,'Chaparral',1,NULL,NULL,0),(423,7,412,'El Codito',1,NULL,NULL,0),(424,7,412,'El Refugio De San Antonio',1,NULL,NULL,0),(425,7,412,'El Verbenal',1,NULL,NULL,0),(426,7,412,'Horizontes',1,NULL,NULL,0),(427,7,412,'La Estrellita',1,NULL,NULL,0),(428,7,412,'La Frontera',1,NULL,NULL,0),(429,7,412,'La Llanurita',1,NULL,NULL,0),(430,7,412,'Los Consuelos',1,NULL,NULL,0),(431,7,412,'Maranta',1,NULL,NULL,0),(432,7,412,'Maturin',1,NULL,NULL,0),(433,7,412,'Medellin',1,NULL,NULL,0),(434,7,412,'Mirador Del Norte',1,NULL,NULL,0),(435,7,412,'Nuevo Horizonte',1,NULL,NULL,0),(436,7,412,'San Antonio Norte',1,NULL,NULL,0),(437,7,412,'Santa Felisa',1,NULL,NULL,0),(438,7,412,'Santandersito',1,NULL,NULL,0),(439,7,412,'Tibabita',1,NULL,NULL,0),(440,7,412,'Viña Del Mar',1,NULL,NULL,0),(441,7,362,'Bosque De San Antonio ',1,NULL,NULL,0),(442,7,362,'Conjunto Camino Del Palmar',1,NULL,NULL,0),(443,7,362,'El Pite',1,NULL,NULL,0),(444,7,362,'El Redil',1,NULL,NULL,0),(445,7,362,'La Cita',1,NULL,NULL,0),(446,7,362,'La Granja Norte',1,NULL,NULL,0),(447,7,362,'La Uribe',1,NULL,NULL,0),(448,7,362,'Los Naranjos',1,NULL,NULL,0),(449,7,362,'San Juan Bosco',1,NULL,NULL,0),(450,7,362,'Urbanizacion Los Laureles',1,NULL,NULL,0),(451,7,392,'Ainsuca',1,NULL,NULL,0),(452,7,392,'Altablanca',1,NULL,NULL,0),(453,7,392,'Barrancas',1,NULL,NULL,0),(454,7,392,'California',1,NULL,NULL,0),(455,7,392,'Cerro Norte',1,NULL,NULL,0),(456,7,392,'Danubio',1,NULL,NULL,0),(457,7,392,'Don Bosco',1,NULL,NULL,0),(458,7,392,'La Perla Oriental',1,NULL,NULL,0),(459,7,392,'Las Areneras',1,NULL,NULL,0),(460,7,392,'Milan (Barrancas)',1,NULL,NULL,0),(461,7,392,'San Cristobal Norte',1,NULL,NULL,0),(462,7,392,'Santa Cecilia Norte Parte Alta',1,NULL,NULL,0),(463,7,392,'Santa Cecilia Parte Baja',1,NULL,NULL,0),(464,7,392,'Santa Teresa',1,NULL,NULL,0),(465,7,392,'Soratama',1,NULL,NULL,0),(466,7,392,'Torcoroma',1,NULL,NULL,0),(467,7,392,'Villa Nydia',1,NULL,NULL,0),(468,7,392,'Villa Oliva',1,NULL,NULL,0),(469,7,408,'El Toberin',1,NULL,NULL,0),(470,7,408,'Babilonia',1,NULL,NULL,0),(471,7,408,'Dardanelos',1,NULL,NULL,0),(472,7,408,'Estrella Del Norte',1,NULL,NULL,0),(473,7,408,'Guanoa',1,NULL,NULL,0),(474,7,408,'Jardin Norte',1,NULL,NULL,0),(475,7,408,'La Liberia',1,NULL,NULL,0),(476,7,408,'La Pradera Norte',1,NULL,NULL,0),(477,7,408,'Las Orquideas',1,NULL,NULL,0),(478,7,408,'Pantanito',1,NULL,NULL,0),(479,7,408,'Santa Monica',1,NULL,NULL,0),(480,7,408,'Villa Magdala',1,NULL,NULL,0),(481,7,408,'Villas De Aranjuez',1,NULL,NULL,0),(482,7,408,'Villas Del Mediterraneo',1,NULL,NULL,0),(483,7,408,'Zaragoza',1,NULL,NULL,0),(484,7,369,'Acacias',1,NULL,NULL,0),(485,7,369,'Antigua',1,NULL,NULL,0),(486,7,369,'Belmira',1,NULL,NULL,0),(487,7,369,'Bosque De Pinos',1,NULL,NULL,0),(488,7,369,'Caobos Salazar',1,NULL,NULL,0),(489,7,369,'Capri',1,NULL,NULL,0),(490,7,369,'Cedritos',1,NULL,NULL,0),(491,7,369,'Cedro Bolivar',1,NULL,NULL,0),(492,7,369,'Cedro Golf',1,NULL,NULL,0),(493,7,369,'Cedro Madeira',1,NULL,NULL,0),(494,7,369,'Cedro Narvaez',1,NULL,NULL,0),(495,7,369,'Cedro Salazar',1,NULL,NULL,0),(496,7,369,'El Contador',1,NULL,NULL,0),(497,7,369,'El Rincon De Las Margaritas',1,NULL,NULL,0),(498,7,369,'La Sonora',1,NULL,NULL,0),(499,7,369,'Las Margaritas',1,NULL,NULL,0),(500,7,369,'Lisboa ',1,NULL,NULL,0),(501,7,369,'Los Cedros ',1,NULL,NULL,0),(502,7,369,'Los Cedros Oriental',1,NULL,NULL,0),(503,7,369,'Montearroyo',1,NULL,NULL,0),(504,7,369,'Nueva Autopista',1,NULL,NULL,0),(505,7,369,'Nuevo Country',1,NULL,NULL,0),(506,7,369,'Sierras Del Moral',1,NULL,NULL,0),(507,7,410,'Bella Suiza ',1,NULL,NULL,0),(508,7,410,'Bellavista',1,NULL,NULL,0),(509,7,410,'Bosque Medina',1,NULL,NULL,0),(510,7,410,'El Pañuelito',1,NULL,NULL,0),(511,7,410,'El Pedregal',1,NULL,NULL,0),(512,7,410,'Escuela De Caballeria I',1,NULL,NULL,0),(513,7,410,'Escuela De Infanteria',1,NULL,NULL,0),(514,7,410,'Francisco Miranda',1,NULL,NULL,0),(515,7,410,'Ginebra',1,NULL,NULL,0),(516,7,410,'La Esperanza',1,NULL,NULL,0),(517,7,410,'La Glorieta',1,NULL,NULL,0),(518,7,410,'Las Delicias Del Carmen',1,NULL,NULL,0),(519,7,410,'Sagrado Corazon',1,NULL,NULL,0),(520,7,410,'San Gabriel',1,NULL,NULL,0),(521,7,410,'Santa Ana',1,NULL,NULL,0),(522,7,410,'Santa Ana Occidental',1,NULL,NULL,0),(523,7,410,'Santa Barbara Alta',1,NULL,NULL,0),(524,7,410,'Santa Barbara Oriental',1,NULL,NULL,0),(525,7,410,'Unicerros',1,NULL,NULL,0),(526,7,410,'Usaquen',1,NULL,NULL,0),(527,7,331,'Country Club',1,NULL,NULL,0),(528,7,331,'La Calleja',1,NULL,NULL,0),(529,7,331,'La Carolina',1,NULL,NULL,0),(530,7,331,'La Cristalina',1,NULL,NULL,0),(531,7,331,'Prados Del Country',1,NULL,NULL,0),(532,7,331,'Recodo Del Country',1,NULL,NULL,0),(533,7,331,'Santa Coloma',1,NULL,NULL,0),(534,7,331,'Soatama',1,NULL,NULL,0),(535,7,331,'Toledo',1,NULL,NULL,0),(536,7,331,'Torres Del Country',1,NULL,NULL,0),(537,7,331,'Vergel Del Country',1,NULL,NULL,0),(538,7,398,'Santa Barbara Occidental',1,NULL,NULL,0),(539,7,398,'Campo Alegre',1,NULL,NULL,0),(540,7,398,'Molinos Del Norte',1,NULL,NULL,0),(541,7,398,'Multicentro',1,NULL,NULL,0),(542,7,398,'Navarra',1,NULL,NULL,0),(543,7,398,'Rincon Del Chico',1,NULL,NULL,0),(544,7,398,'San Patricio',1,NULL,NULL,0),(545,7,398,'Santa Barbara',1,NULL,NULL,0),(546,7,398,'Santa Barbara Central',1,NULL,NULL,0),(547,7,398,'Santa Bibiana',1,NULL,NULL,0),(548,7,398,'Santa Paula ',1,NULL,NULL,0),(549,7,338,'Chico Reservado',1,NULL,NULL,0),(550,7,338,'Bellavista',1,NULL,NULL,0),(551,7,338,'Chico Alto',1,NULL,NULL,0),(552,7,338,'El Nogal',1,NULL,NULL,0),(553,7,338,'El Refugio ',1,NULL,NULL,0),(554,7,338,'La Cabrera',1,NULL,NULL,0),(555,7,338,'Los Rosales',1,NULL,NULL,0),(556,7,338,'Seminario',1,NULL,NULL,0),(557,7,338,'Toscana',1,NULL,NULL,0),(558,7,394,'La Esperanza Nororiental',1,NULL,NULL,0),(559,7,394,'La Sureña',1,NULL,NULL,0),(560,7,394,'San Isidro',1,NULL,NULL,0),(561,7,394,'San Luis Altos Del Cabo',1,NULL,NULL,0),(562,7,380,'Bosque Calderon',1,NULL,NULL,0),(563,7,380,'Bosque Calderon Tejada',1,NULL,NULL,0),(564,7,380,'Chapinero Alto',1,NULL,NULL,0),(565,7,380,'El Castillo',1,NULL,NULL,0),(566,7,380,'El Paraiso',1,NULL,NULL,0),(567,7,380,'Emaus',1,NULL,NULL,0),(568,7,380,'Granada',1,NULL,NULL,0),(569,7,380,'Ingemar',1,NULL,NULL,0),(570,7,380,'Juan Xxiii',1,NULL,NULL,0),(571,7,380,'La Salle',1,NULL,NULL,0),(572,7,380,'Las Acacias',1,NULL,NULL,0),(573,7,380,'Los Olivos',1,NULL,NULL,0),(574,7,380,'Maria Cristina',1,NULL,NULL,0),(575,7,380,'Mariscal Sucre',1,NULL,NULL,0),(576,7,380,'Nueva Granada',1,NULL,NULL,0),(577,7,380,'Palomar',1,NULL,NULL,0),(578,7,380,'Pardo Rubio',1,NULL,NULL,0),(579,7,380,'San Martin De Porres ',1,NULL,NULL,0),(580,7,380,'Villa Anita',1,NULL,NULL,0),(581,7,380,'Villa Del Cerro ',1,NULL,NULL,0),(582,7,323,'Antiguo Country ',1,NULL,NULL,0),(583,7,323,'Chico Norte ',1,NULL,NULL,0),(584,7,323,'Chico Norte II',1,NULL,NULL,0),(585,7,323,'Chico Norte III',1,NULL,NULL,0),(586,7,323,'Chico Occidental',1,NULL,NULL,0),(587,7,323,'El Chico',1,NULL,NULL,0),(588,7,323,'El Retiro ',1,NULL,NULL,0),(589,7,323,'Espartillal',1,NULL,NULL,0),(590,7,323,'La Cabrera',1,NULL,NULL,0),(591,7,323,'Lago Gaitan',1,NULL,NULL,0),(592,7,323,'Porciuncula',1,NULL,NULL,0),(593,7,323,'Quinta Camacho',1,NULL,NULL,0),(594,7,322,'Cataluña',1,NULL,NULL,0),(595,7,322,'Chapinero Central',1,NULL,NULL,0),(596,7,322,'Chapinero Norte',1,NULL,NULL,0),(597,7,322,'Marly',1,NULL,NULL,0),(598,7,322,'Sucre',1,NULL,NULL,0),(599,7,390,'La Merced',1,NULL,NULL,0),(600,7,390,'Parque Central Bavaria',1,NULL,NULL,0),(601,7,390,'Sagrado Corazon',1,NULL,NULL,0),(602,7,390,'San Diego',1,NULL,NULL,0),(603,7,390,'San Martin',1,NULL,NULL,0),(604,7,390,'Torres Del Parque',1,NULL,NULL,0),(605,7,360,'Bosque Izquierdo',1,NULL,NULL,0),(606,7,360,'Germania',1,NULL,NULL,0),(607,7,360,'La Macarena',1,NULL,NULL,0),(608,7,360,'La Paz Centro',1,NULL,NULL,0),(609,7,360,'La Perseverancia',1,NULL,NULL,0),(610,7,366,'La Alameda',1,NULL,NULL,0),(611,7,366,'La Capuchina',1,NULL,NULL,0),(612,7,366,'La Veracruz',1,NULL,NULL,0),(613,7,366,'Las Nieves',1,NULL,NULL,0),(614,7,366,'Santa Ines',1,NULL,NULL,0),(615,7,363,'Las Cruces',1,NULL,NULL,0),(616,7,363,'San Bernardo',1,NULL,NULL,0),(617,7,371,'Atanasio Giradot',1,NULL,NULL,0),(618,7,371,'Cartagena',1,NULL,NULL,0),(619,7,371,'Egipto',1,NULL,NULL,0),(620,7,371,'Egipto Alto',1,NULL,NULL,0),(621,7,371,'El Balcon',1,NULL,NULL,0),(622,7,371,'El Consuelo',1,NULL,NULL,0),(623,7,371,'El Dorado',1,NULL,NULL,0),(624,7,371,'El Guavio',1,NULL,NULL,0),(625,7,371,'El Mirador',1,NULL,NULL,0),(626,7,371,'El Rocio',1,NULL,NULL,0),(627,7,371,'El Triunfo',1,NULL,NULL,0),(628,7,371,'Fabrica De Loza',1,NULL,NULL,0),(629,7,371,'Gran Colombia',1,NULL,NULL,0),(630,7,371,'La Peña',1,NULL,NULL,0),(631,7,371,'Los Laches',1,NULL,NULL,0),(632,7,371,'Lourdes',1,NULL,NULL,0),(633,7,371,'Ramirez',1,NULL,NULL,0),(634,7,371,'San Dionisio',1,NULL,NULL,0),(635,7,371,'Santa Rosa De Lima',1,NULL,NULL,0),(636,7,371,'Vitelma',1,NULL,NULL,0),(637,7,391,'Aguas Claras',1,NULL,NULL,0),(638,7,391,'Altos Del Zipa',1,NULL,NULL,0),(639,7,391,'Amapolas',1,NULL,NULL,0),(640,7,391,'Amapolas II',1,NULL,NULL,0),(642,7,391,'Bella Vista Sector Lucero',1,NULL,NULL,0),(643,7,391,'Bellavista Parte Baja',1,NULL,NULL,0),(644,7,391,'Bellavista Sur',1,NULL,NULL,0),(645,7,391,'Bosque De Los Alpes',1,NULL,NULL,0),(646,7,391,'Buenavista Suroriental',1,NULL,NULL,0),(648,7,391,'Cerros De San Vicente',1,NULL,NULL,0),(649,7,391,'Ciudad De Londres',1,NULL,NULL,0),(650,7,391,'Corinto',1,NULL,NULL,0),(651,7,391,'El Balcon De La Castaña',1,NULL,NULL,0),(652,7,391,'El Futuro',1,NULL,NULL,0),(653,7,391,'El Ramajal',1,NULL,NULL,0),(655,7,391,'Gran Colombia (Molinos De Oriente)',1,NULL,NULL,0),(656,7,391,'Horacio Orjuela',1,NULL,NULL,0),(657,7,391,'La Castaña',1,NULL,NULL,0),(658,7,391,'La Cecilia',1,NULL,NULL,0),(659,7,391,'La Gran Colombia ',1,NULL,NULL,0),(660,7,391,'La Herradura',1,NULL,NULL,0),(661,7,391,'Bello Horizonte',1,NULL,NULL,0),(662,7,391,'La Playa',1,NULL,NULL,0),(663,7,391,'La Roca',1,NULL,NULL,0),(664,7,391,'La Sagrada Familia',1,NULL,NULL,0),(665,7,391,'Las Acacias',1,NULL,NULL,0),(666,7,391,'Las Mercedes  ',1,NULL,NULL,0),(667,7,391,'Laureles Sur Oriental Ii Sector',1,NULL,NULL,0),(668,7,391,'Los Alpes  ',1,NULL,NULL,0),(669,7,391,'Los Alpes Futuro',1,NULL,NULL,0),(670,7,391,'Los Arrayanes Sector Santa Ines',1,NULL,NULL,0),(671,7,391,'Los Laureles Sur Oriental I Sec.',1,NULL,NULL,0),(672,7,391,'Macarena Los Alpes',1,NULL,NULL,0),(673,7,391,'Manantial',1,NULL,NULL,0),(674,7,391,'Manila',1,NULL,NULL,0),(675,7,391,'Miraflores',1,NULL,NULL,0),(676,7,391,'Molinos De Oriente',1,NULL,NULL,0),(677,7,391,'Montecarlo',1,NULL,NULL,0),(678,7,391,'Nueva España',1,NULL,NULL,0),(679,7,391,'Nueva España Parte Alta ',1,NULL,NULL,0),(680,7,391,'Ramajal',1,NULL,NULL,0),(681,7,391,'Rincon De La Victria-B/Vista',1,NULL,NULL,0),(682,7,391,'Sagrada Familia',1,NULL,NULL,0),(683,7,391,'San Blas',1,NULL,NULL,0),(685,7,391,'San Blas II Sector',1,NULL,NULL,0),(686,7,391,'San Cristobal Alto',1,NULL,NULL,0),(687,7,391,'San Cristobal Viejo',1,NULL,NULL,0),(688,7,391,'San Pedro',1,NULL,NULL,0),(689,7,391,'San Vicente',1,NULL,NULL,0),(694,7,391,'Santa Ines Sur',1,NULL,NULL,0),(695,7,391,'Terrazas De Oriente',1,NULL,NULL,0),(696,7,391,'Triangulo',1,NULL,NULL,0),(697,7,391,'Triangulo Alto',1,NULL,NULL,0),(698,7,391,'Triangulo Bajo',1,NULL,NULL,0),(699,7,391,'Vereda Altos De San Blas',1,NULL,NULL,0),(700,7,391,'Vitelma',1,NULL,NULL,0),(701,7,401,'Golconda',1,NULL,NULL,0),(702,7,401,'Primero De Mayo',1,NULL,NULL,0),(703,7,401,'Buenos Aires',1,NULL,NULL,0),(704,7,401,'Calvo Sur',1,NULL,NULL,0),(705,7,401,'Camino Viejo De San Cristobal',1,NULL,NULL,0),(706,7,401,'La Maria',1,NULL,NULL,0),(707,7,401,'Las Brisas',1,NULL,NULL,0),(708,7,401,'Los Dos Leones',1,NULL,NULL,0),(709,7,401,'Modelo Sur',1,NULL,NULL,0),(710,7,401,'Nariño Sur',1,NULL,NULL,0),(711,7,401,'Quinta Ramos',1,NULL,NULL,0),(712,7,401,'Rep. De Venezuela',1,NULL,NULL,0),(713,7,401,'San Cristobal Sur',1,NULL,NULL,0),(714,7,401,'San Javier',1,NULL,NULL,0),(716,7,401,'Santa Ana Sur',1,NULL,NULL,0),(717,7,401,'Sociego',1,NULL,NULL,0),(718,7,401,'Velodromo',1,NULL,NULL,0),(719,7,401,'Villa Albania',1,NULL,NULL,0),(720,7,401,'Villa Javier',1,NULL,NULL,0),(721,7,303,'Atenas',1,NULL,NULL,0),(722,7,303,'20 De Julio',1,NULL,NULL,0),(723,7,303,'Atenas I',1,NULL,NULL,0),(724,7,303,'Ayacucho',1,NULL,NULL,0),(726,7,303,'Barcelona Sur',1,NULL,NULL,0),(728,7,303,'Bello Horizonte',1,NULL,NULL,0),(729,7,303,'Bello Horizonte III Sector',1,NULL,NULL,0),(730,7,303,'Cordoba',1,NULL,NULL,0),(731,7,303,'El Angulo',1,NULL,NULL,0),(732,7,303,'El Encanto',1,NULL,NULL,0),(733,7,303,'Granada Sur ',1,NULL,NULL,0),(734,7,303,'Granada Sur III Sector',1,NULL,NULL,0),(735,7,303,'La Joyita',1,NULL,NULL,0),(736,7,303,'La Serafina',1,NULL,NULL,0),(737,7,303,'Las Lomas',1,NULL,NULL,0),(738,7,303,'Managua',1,NULL,NULL,0),(739,7,303,'Montebello',1,NULL,NULL,0),(742,7,303,'San Isidro Sur',1,NULL,NULL,0),(743,7,303,'San Luis',1,NULL,NULL,0),(744,7,303,'Sur America',1,NULL,NULL,0),(745,7,303,'Villa De Los Alpes',1,NULL,NULL,0),(747,7,303,'Villa Nataly',1,NULL,NULL,0),(748,7,359,'Altamira',1,NULL,NULL,0),(749,7,359,'Altamira Chiquita',1,NULL,NULL,0),(750,7,359,'Altos Del Poblado',1,NULL,NULL,0),(751,7,359,'Altos Del Virrey',1,NULL,NULL,0),(752,7,359,'Altos Del Zuque',1,NULL,NULL,0),(753,7,359,'Bellavista Parte Alta',1,NULL,NULL,0),(754,7,359,'Bellavista Sur Oriental',1,NULL,NULL,0),(755,7,359,'Buenos Aires',1,NULL,NULL,0),(756,7,359,'Ciudadela Santa Rosa',1,NULL,NULL,0),(757,7,359,'El Quindio',1,NULL,NULL,0),(758,7,359,'El Recodo-Republica De Canada',1,NULL,NULL,0),(759,7,359,'El Rodeo',1,NULL,NULL,0),(760,7,359,'La Colmena',1,NULL,NULL,0),(761,7,359,'La Gloria',1,NULL,NULL,0),(762,7,359,'La Gloria Baja',1,NULL,NULL,0),(764,7,359,'La Gloria Occidental',1,NULL,NULL,0),(765,7,359,'La Gloria Oriental',1,NULL,NULL,0),(766,7,359,'La Gloria San Miguel',1,NULL,NULL,0),(767,7,359,'La Grovana',1,NULL,NULL,0),(768,7,359,'La Victoria',1,NULL,NULL,0),(769,7,359,'La Victoria II Sector',1,NULL,NULL,0),(770,7,359,'La Victoria III Sector',1,NULL,NULL,0),(771,7,359,'Las Gaviotas',1,NULL,NULL,0),(773,7,359,'Las Guacamayas I',1,NULL,NULL,0),(774,7,359,'Las Guacamayas II',1,NULL,NULL,0),(775,7,359,'Las Guacamayas III',1,NULL,NULL,0),(776,7,359,'Las Lomas',1,NULL,NULL,0),(777,7,359,'Los Puentes',1,NULL,NULL,0),(778,7,359,'Malvinas     ',1,NULL,NULL,0),(779,7,359,'Miraflores',1,NULL,NULL,0),(780,7,359,'Moralva',1,NULL,NULL,0),(781,7,359,'Panorama (Antes Altamira)',1,NULL,NULL,0),(782,7,359,'Paseito III',1,NULL,NULL,0),(783,7,359,'Puente Colorado',1,NULL,NULL,0),(784,7,359,'Quindio  ',1,NULL,NULL,0),(786,7,359,'Quindio II',1,NULL,NULL,0),(787,7,359,'San Jose',1,NULL,NULL,0),(788,7,359,'San Jose Oriental I',1,NULL,NULL,0),(789,7,359,'San Jose Oriental II',1,NULL,NULL,0),(790,7,359,'San Jose Sur Oriental',1,NULL,NULL,0),(791,7,359,'San Martin De Loba I',1,NULL,NULL,0),(792,7,359,'San Martin De Loba II',1,NULL,NULL,0),(793,7,359,'San Martin Sur',1,NULL,NULL,0),(794,7,370,'Antioquia',1,NULL,NULL,0),(795,7,370,'Canada La Guira',1,NULL,NULL,0),(796,7,370,'Canada La Guira II Sector',1,NULL,NULL,0),(797,7,370,'Canada-San Luis',1,NULL,NULL,0),(798,7,370,'Chiguaza',1,NULL,NULL,0),(799,7,370,'Ciudad De Londres',1,NULL,NULL,0),(800,7,370,'El Paraiso  ',1,NULL,NULL,0),(801,7,370,'El Pinar',1,NULL,NULL,0),(802,7,370,'El Triunfo',1,NULL,NULL,0),(803,7,370,'Juan Rey',1,NULL,NULL,0),(804,7,370,'La Belleza',1,NULL,NULL,0),(805,7,370,'La Nueva Gloria',1,NULL,NULL,0),(806,7,370,'La Nueva Gloria II Sector',1,NULL,NULL,0),(807,7,370,'La Peninsula',1,NULL,NULL,0),(808,7,370,'La Sierra',1,NULL,NULL,0),(809,7,370,'Las Gaviotas',1,NULL,NULL,0),(810,7,370,'Los Libertadores',1,NULL,NULL,0),(811,7,370,'Los Libertadores S. El Tesoro',1,NULL,NULL,0),(812,7,370,'Los Libertadores S. La Colina',1,NULL,NULL,0),(813,7,370,'Los Libertadores S.San Ignacio',1,NULL,NULL,0),(814,7,370,'Los Libertadores S.San Isidro',1,NULL,NULL,0),(815,7,370,'Los Libertadores S.San Jose',1,NULL,NULL,0),(816,7,370,'Los Libertadores S.San Luis',1,NULL,NULL,0),(817,7,370,'Los Libertadores S.San Miguel',1,NULL,NULL,0),(818,7,370,'Los Libertadores, Bque Diamant, Triangulo',1,NULL,NULL,0),(819,7,370,'Los Pinares',1,NULL,NULL,0),(820,7,370,'Los Pinos',1,NULL,NULL,0),(821,7,370,'Los Puentes',1,NULL,NULL,0),(822,7,370,'Nueva Delly',1,NULL,NULL,0),(823,7,370,'Nueva Gloria',1,NULL,NULL,0),(824,7,370,'Nueva Roma',1,NULL,NULL,0),(825,7,370,'Nuevas Malvinas O El Triunfo',1,NULL,NULL,0),(826,7,370,'Republica Del Canada ',1,NULL,NULL,0),(827,7,370,'El Pinar',1,NULL,NULL,0),(828,7,370,'San Jacinto',1,NULL,NULL,0),(829,7,370,'San Manuel',1,NULL,NULL,0),(830,7,370,'San Rafael Sur Oriental',1,NULL,NULL,0),(831,7,370,'San Rafael Usme',1,NULL,NULL,0),(832,7,370,'Santa Rita I',1,NULL,NULL,0),(833,7,370,'Santa Rita II',1,NULL,NULL,0),(834,7,370,'Santa Rita III',1,NULL,NULL,0),(835,7,370,'Santa Rita Sur Oriental',1,NULL,NULL,0),(836,7,370,'Valparaiso',1,NULL,NULL,0),(837,7,370,'Villa Angelica Canada La Guira',1,NULL,NULL,0),(838,7,370,'Villa Aurora',1,NULL,NULL,0),(839,7,370,'Villa Del Cerro',1,NULL,NULL,0),(840,7,370,'Villabell',1,NULL,NULL,0),(841,7,370,'Yomasa',1,NULL,NULL,0),(842,7,370,'Villa Angelica',1,NULL,NULL,0),(843,7,370,'El Paraiso Sur Oriental I Sec.',1,NULL,NULL,0),(844,7,370,'El Paraiso Sur Oriental II Sec.',1,NULL,NULL,0),(845,7,370,'Juan Rey I',1,NULL,NULL,0),(846,7,370,'Juan Rey II',1,NULL,NULL,0),(847,7,370,'Villa Begonia',1,NULL,NULL,0),(848,7,411,'Condado De Santa Lucia',1,NULL,NULL,0),(849,7,411,'Condado De Santa Lucia II',1,NULL,NULL,0),(850,7,411,'Conjunto Residencial Nuevo Muzu',1,NULL,NULL,0),(851,7,411,'El Carmen',1,NULL,NULL,0),(852,7,411,'Escuela De Policia General Santander',1,NULL,NULL,0),(853,7,411,'Fatima',1,NULL,NULL,0),(854,7,411,'Isla Del Sol',1,NULL,NULL,0),(855,7,411,'Laguneta',1,NULL,NULL,0),(856,7,411,'Nuevo Muzu',1,NULL,NULL,0),(857,7,411,'Ontario',1,NULL,NULL,0),(858,7,411,'Parque Metropolitano El Tunal',1,NULL,NULL,0),(859,7,411,'Parque Real I',1,NULL,NULL,0),(860,7,411,'Parque Real II',1,NULL,NULL,0),(861,7,411,'Rincon De Muzu',1,NULL,NULL,0),(862,7,411,'Rincon De Nuevo Muzu',1,NULL,NULL,0),(863,7,411,'Rincon De Venecia',1,NULL,NULL,0),(864,7,411,'Samore',1,NULL,NULL,0),(865,7,411,'San Vicente',1,NULL,NULL,0),(866,7,411,'San Vicente De Ferrer',1,NULL,NULL,0),(867,7,411,'Santa Lucia',1,NULL,NULL,0),(868,7,411,'Tejar De Ontario',1,NULL,NULL,0),(869,7,411,'Ciudad Tunal',1,NULL,NULL,0),(870,7,411,'Venecia',1,NULL,NULL,0),(871,7,411,'Venecia Occidental',1,NULL,NULL,0),(872,7,411,'Villa Ximena',1,NULL,NULL,0),(873,7,409,'Abraham Lincon ',1,NULL,NULL,0),(874,7,409,'San Benito',1,NULL,NULL,0),(875,7,409,'San Carlos',1,NULL,NULL,0),(876,7,409,'Tunalito',1,NULL,NULL,0),(877,7,409,'Tunjuelito',1,NULL,NULL,0),(878,7,308,'Jardines Del Apogeo',1,NULL,NULL,0),(879,7,308,'El Motorista',1,NULL,NULL,0),(880,7,308,'Industrial',1,NULL,NULL,0),(881,7,308,'La Ilusion',1,NULL,NULL,0),(882,7,308,'Nuevo Chile',1,NULL,NULL,0),(883,7,308,'Olarte',1,NULL,NULL,0),(884,7,308,'Villas Del Rio',1,NULL,NULL,0),(885,7,313,'Amaruc',1,NULL,NULL,0),(886,7,313,'Berlin',1,NULL,NULL,0),(887,7,313,'Berlin De Bosa La Libertad III',1,NULL,NULL,0),(888,7,313,'Betania',1,NULL,NULL,0),(889,7,313,'Bosa Nova',1,NULL,NULL,0),(890,7,313,'Bosa Nova II Sector',1,NULL,NULL,0),(891,7,313,'Bosalinda (Hildebrando Olarte)',1,NULL,NULL,0),(892,7,313,'Brasil II Sector',1,NULL,NULL,0),(893,7,313,'Brasil II Segunda Etapa',1,NULL,NULL,0),(894,7,313,'Brasil Lopez Y Piñeros',1,NULL,NULL,0),(895,7,313,'Brasil Materas Acacias S.Jorge',1,NULL,NULL,0),(896,7,313,'Brasil Sector Barreto',1,NULL,NULL,0),(897,7,313,'Brasil Sector Portal Y Castillo',1,NULL,NULL,0),(898,7,313,'Brasilia II Sector',1,NULL,NULL,0),(899,7,313,'Brasilia III Sector',1,NULL,NULL,0),(900,7,313,'Brasilia I Sector',1,NULL,NULL,0),(901,7,313,'Campo Hermoso',1,NULL,NULL,0),(902,7,313,'Casa Nueva',1,NULL,NULL,0),(903,7,313,'Chico Sur',1,NULL,NULL,0),(904,7,313,'Chiicala',1,NULL,NULL,0),(905,7,313,'Ciudadela La Libertad II',1,NULL,NULL,0),(906,7,313,'Danubio',1,NULL,NULL,0),(907,7,313,'Danubio Azul I',1,NULL,NULL,0),(908,7,313,'Danubio II',1,NULL,NULL,0),(909,7,313,'Danubio III',1,NULL,NULL,0),(910,7,313,'Diamante Sur',1,NULL,NULL,0),(911,7,313,'Divino Niño',1,NULL,NULL,0),(912,7,313,'El Bosque De Bosa',1,NULL,NULL,0),(913,7,313,'El Cauce',1,NULL,NULL,0),(914,7,313,'El Diamante',1,NULL,NULL,0),(915,7,313,'El Jazmin Sector El Triangulo',1,NULL,NULL,0),(916,7,313,'El Libertador',1,NULL,NULL,0),(917,7,313,'El Libertador II',1,NULL,NULL,0),(918,7,313,'El Paradero',1,NULL,NULL,0),(919,7,313,'El Paraiso',1,NULL,NULL,0),(920,7,313,'El Portal De La Libertad',1,NULL,NULL,0),(921,7,313,'El Portal I Sector',1,NULL,NULL,0),(922,7,313,'El Portal II Sector',1,NULL,NULL,0),(923,7,313,'El Porvenir II Sector',1,NULL,NULL,0),(924,7,313,'El Porvenir III',1,NULL,NULL,0),(925,7,313,'El Porvenir Sector Brasil',1,NULL,NULL,0),(926,7,313,'El Progreso II Sector',1,NULL,NULL,0),(927,7,313,'El Recuerdo',1,NULL,NULL,0),(928,7,313,'El Recuerdo II',1,NULL,NULL,0),(929,7,313,'El Recuerdo San Bernardino',1,NULL,NULL,0),(930,7,313,'El Rincon De Bosa',1,NULL,NULL,0),(931,7,313,'El Rodeo',1,NULL,NULL,0),(932,7,313,'El Rubi',1,NULL,NULL,0),(933,7,313,'El Sauce',1,NULL,NULL,0),(934,7,313,'Escocia IX',1,NULL,NULL,0),(935,7,313,'Escocia V',1,NULL,NULL,0),(936,7,313,'Escocia VI Sector I',1,NULL,NULL,0),(937,7,313,'Escocia VI Sector II',1,NULL,NULL,0),(938,7,313,'Escocia Vi Sectores Iii',1,NULL,NULL,0),(939,7,313,'Escocia VII',1,NULL,NULL,0),(940,7,313,'Finca La Esperanza',1,NULL,NULL,0),(941,7,313,'Holanda',1,NULL,NULL,0),(942,7,313,'Holanda I Sector',1,NULL,NULL,0),(943,7,313,'Holanda II Sector',1,NULL,NULL,0),(944,7,313,'Holanda III Sector',1,NULL,NULL,0),(945,7,313,'Holanda Sector Caminito',1,NULL,NULL,0),(946,7,313,'Hortelanos De Escocia',1,NULL,NULL,0),(947,7,313,'Jorge Uribe Botero',1,NULL,NULL,0),(948,7,313,'La Concepcion',1,NULL,NULL,0),(949,7,313,'La Concepcion II Sector',1,NULL,NULL,0),(950,7,313,'La Dulcinea',1,NULL,NULL,0),(951,7,313,'La Esmeralda',1,NULL,NULL,0),(952,7,313,'La Esperanza I',1,NULL,NULL,0),(953,7,313,'La Esperanza II Sector',1,NULL,NULL,0),(954,7,313,'La Estanzuela',1,NULL,NULL,0),(955,7,313,'La Estanzuela II',1,NULL,NULL,0),(956,7,313,'La Florida Iv Sector',1,NULL,NULL,0),(957,7,313,'La Fontana De Bosa La Libertad',1,NULL,NULL,0),(958,7,313,'La Fontana',1,NULL,NULL,0),(959,7,313,'La Independencia',1,NULL,NULL,0),(961,7,313,'La Independencia II Sector',1,NULL,NULL,0),(962,7,313,'La Libertad ',1,NULL,NULL,0),(963,7,313,'La Libertad II',1,NULL,NULL,0),(964,7,313,'La Libertad III',1,NULL,NULL,0),(965,7,313,'La Libertad IV',1,NULL,NULL,0),(966,7,313,'La Libertad Sector Magnolia',1,NULL,NULL,0),(967,7,313,'La Magnolia II',1,NULL,NULL,0),(968,7,313,'La Maria ',1,NULL,NULL,0),(969,7,313,'La Palma',1,NULL,NULL,0),(970,7,313,'La Paz',1,NULL,NULL,0),(971,7,313,'La Paz II',1,NULL,NULL,0),(972,7,313,'La Paz III',1,NULL,NULL,0),(973,7,313,'La Paz San Ignacio Las Vegas',1,NULL,NULL,0),(974,7,313,'La Paz San Ignacio Sec La Esperanza',1,NULL,NULL,0),(975,7,313,'La Portada',1,NULL,NULL,0),(976,7,313,'La Portada II',1,NULL,NULL,0),(977,7,313,'La Portada III',1,NULL,NULL,0),(978,7,313,'La Portadita',1,NULL,NULL,0),(979,7,313,'La Veguita',1,NULL,NULL,0),(980,7,313,'La Veguita II',1,NULL,NULL,0),(981,7,313,'La Veguita IV',1,NULL,NULL,0),(982,7,313,'Las Margaritas I',1,NULL,NULL,0),(983,7,313,'Las Margaritas II',1,NULL,NULL,0),(984,7,313,'Las Margaritas III',1,NULL,NULL,0),(985,7,313,'Las Vegas',1,NULL,NULL,0),(986,7,313,'Los Heroes',1,NULL,NULL,0),(987,7,313,'Los Ocales',1,NULL,NULL,0),(988,7,313,'Los Sauces',1,NULL,NULL,0),(989,7,313,'Los Sauces Sector Cedro',1,NULL,NULL,0),(990,7,313,'Miami',1,NULL,NULL,0),(991,7,313,'New Jersey',1,NULL,NULL,0),(992,7,313,'Nuestra Señora De La Paz - La Esperanza',1,NULL,NULL,0),(993,7,313,'Nuestra Señora De La Paz - IV Sector',1,NULL,NULL,0),(994,7,313,'Nuestra Señora De La Paz - Villa Esmeralda',1,NULL,NULL,0),(995,7,313,'Nuestra Señora De La Paz - Y Otros',1,NULL,NULL,0),(996,7,313,'Nueva Escocia',1,NULL,NULL,0),(997,7,313,'Nueva Esperanza',1,NULL,NULL,0),(998,7,313,'Porvenir La Concepcion',1,NULL,NULL,0),(1001,7,313,'Potreritos',1,NULL,NULL,0),(1002,7,313,'San Antonio',1,NULL,NULL,0),(1003,7,313,'San Antonio De Bosa',1,NULL,NULL,0),(1004,7,313,'San Antonio De Escocia',1,NULL,NULL,0),(1005,7,313,'San Antonio De Escocia II',1,NULL,NULL,0),(1006,7,313,'San Bernardino',1,NULL,NULL,0),(1007,7,313,'San Bernardino Sector II',1,NULL,NULL,0),(1008,7,313,'San Bernardino Sector Protrerito',1,NULL,NULL,0),(1009,7,313,'San Bernardino Sector Villa Emma',1,NULL,NULL,0),(1010,7,313,'San Diego La Paz IV Sector',1,NULL,NULL,0),(1011,7,313,'Nuestra Señora De La Paz - San Fernando',1,NULL,NULL,0),(1012,7,313,'San Javier',1,NULL,NULL,0),(1013,7,313,'San Joaquin',1,NULL,NULL,0),(1014,7,313,'San Jorge',1,NULL,NULL,0),(1015,7,313,'San Jorge II',1,NULL,NULL,0),(1016,7,313,'San Juanito',1,NULL,NULL,0),(1017,7,313,'San Luis',1,NULL,NULL,0),(1018,7,313,'San Luis II',1,NULL,NULL,0),(1019,7,313,'San Martin',1,NULL,NULL,0),(1020,7,313,'San Pedro',1,NULL,NULL,0),(1021,7,313,'San Pedro II',1,NULL,NULL,0),(1022,7,313,'San Pedro II Sector A',1,NULL,NULL,0),(1023,7,313,'San Pedro Sector \"C\"',1,NULL,NULL,0),(1024,7,313,'Santa Ines',1,NULL,NULL,0),(1025,7,313,'Sauces II',1,NULL,NULL,0),(1026,7,313,'Siracuza ',1,NULL,NULL,0),(1027,7,313,'Siracuza II',1,NULL,NULL,0),(1028,7,313,'Tokio',1,NULL,NULL,0),(1029,7,313,'Vegas De Santana',1,NULL,NULL,0),(1030,7,313,'Vereda El Porvenir Sector Brasil',1,NULL,NULL,0),(1031,7,313,'Villa Carolina',1,NULL,NULL,0),(1032,7,313,'Villa Clemencia',1,NULL,NULL,0),(1033,7,313,'Villa Clemencia Sector Tierra Grata',1,NULL,NULL,0),(1034,7,313,'Villa Colombia',1,NULL,NULL,0),(1035,7,313,'Villa Colombia II',1,NULL,NULL,0),(1036,7,313,'Villa De Los Comuneros',1,NULL,NULL,0),(1037,7,313,'Villa De Suaita',1,NULL,NULL,0),(1038,7,313,'Villa Magda',1,NULL,NULL,0),(1039,7,313,'Villa Magnolia',1,NULL,NULL,0),(1040,7,313,'Villa Natalia',1,NULL,NULL,0),(1041,7,313,'Villa Nohora',1,NULL,NULL,0),(1042,7,313,'Villa Nohora II',1,NULL,NULL,0),(1043,7,313,'Villa Nohora III',1,NULL,NULL,0),(1044,7,313,'Villa Sonia I',1,NULL,NULL,0),(1045,7,313,'Villa Sonia II',1,NULL,NULL,0),(1046,7,313,'Villas Del Progreso',1,NULL,NULL,0),(1047,7,313,'Villas Del Velero',1,NULL,NULL,0),(1048,7,312,'Andalucia',1,NULL,NULL,0),(1049,7,312,'Andalucia II',1,NULL,NULL,0),(1050,7,312,'Antonia Santos',1,NULL,NULL,0),(1051,7,312,'Argelia',1,NULL,NULL,0),(1052,7,312,'Argelia II',1,NULL,NULL,0),(1053,7,312,'Bosa',1,NULL,NULL,0),(1054,7,312,'Bosques De Meryland',1,NULL,NULL,0),(1055,7,312,'Brasilia La Estacion',1,NULL,NULL,0),(1056,7,312,'Carlos Alban Holguin Nueva Granada',1,NULL,NULL,0),(1057,7,312,'Carlos Alban Sector Israelita',1,NULL,NULL,0),(1058,7,312,'Carlos Alban Sector Miraflores',1,NULL,NULL,0),(1059,7,312,'Carlos Galbán',1,NULL,NULL,0),(1060,7,312,'Charles De Gaulle',1,NULL,NULL,0),(1061,7,312,'Charles De Gaulle II',1,NULL,NULL,0),(1062,7,312,'Claretiano ',1,NULL,NULL,0),(1063,7,312,'El Jardin',1,NULL,NULL,0),(1064,7,312,'El Jardín San Eugenio',1,NULL,NULL,0),(1065,7,312,'El Libertador',1,NULL,NULL,0),(1066,7,312,'El Llanito',1,NULL,NULL,0),(1067,7,312,'El Llano (Sector Guzman)',1,NULL,NULL,0),(1069,7,312,'El Llano Sector Fandino',1,NULL,NULL,0),(1070,7,312,'El Palmar',1,NULL,NULL,0),(1071,7,312,'El Portal De Bosa',1,NULL,NULL,0),(1072,7,312,'El Porvenir',1,NULL,NULL,0),(1073,7,312,'El Progreso',1,NULL,NULL,0),(1074,7,312,'El Retazo',1,NULL,NULL,0),(1075,7,312,'El Toche',1,NULL,NULL,0),(1076,7,312,'El Triangulo Sector Materas',1,NULL,NULL,0),(1077,7,312,'Getsemani',1,NULL,NULL,0),(1078,7,312,'Grancolombiano I',1,NULL,NULL,0),(1079,7,312,'Grancolombiano II',1,NULL,NULL,0),(1081,7,312,'Gualoche',1,NULL,NULL,0),(1082,7,312,'Hermanos Barragan',1,NULL,NULL,0),(1083,7,312,'Humberto Valencia',1,NULL,NULL,0),(1084,7,312,'Humberto Valencia II',1,NULL,NULL,0),(1085,7,312,'Humberto Valencia III',1,NULL,NULL,0),(1086,7,312,'Islandia',1,NULL,NULL,0),(1087,7,312,'Islandia II',1,NULL,NULL,0),(1088,7,312,'Islandia III',1,NULL,NULL,0),(1089,7,312,'Islandia IV',1,NULL,NULL,0),(1090,7,312,'Israelita',1,NULL,NULL,0),(1091,7,312,'Jimenez De Quesada',1,NULL,NULL,0),(1092,7,312,'Jimenez De Quesada II Sector',1,NULL,NULL,0),(1093,7,312,'Jose Antonio Galan',1,NULL,NULL,0),(1094,7,312,'Jose Maria Carbonel I Sector',1,NULL,NULL,0),(1095,7,312,'Jose Maria Carbonel II Sector',1,NULL,NULL,0),(1096,7,312,'La Amistad',1,NULL,NULL,0),(1097,7,312,'La Aurora ',1,NULL,NULL,0),(1098,7,312,'La Azucena',1,NULL,NULL,0),(1102,7,312,'La Cruz De Terreros',1,NULL,NULL,0),(1103,7,312,'La Ele II Sector Los Laureles',1,NULL,NULL,0),(1104,7,312,'La Esmeralda',1,NULL,NULL,0),(1105,7,312,'La Esperanza De Tibanica',1,NULL,NULL,0),(1106,7,312,'La Estacion',1,NULL,NULL,0),(1109,7,312,'La Palestina I',1,NULL,NULL,0),(1110,7,312,'La Primavera',1,NULL,NULL,0),(1111,7,312,'La Riviera II',1,NULL,NULL,0),(1112,7,312,'La Sultana',1,NULL,NULL,0),(1113,7,312,'Las Margaritas',1,NULL,NULL,0),(1114,7,312,'Las Soltanas',1,NULL,NULL,0),(1115,7,312,'Laureles III',1,NULL,NULL,0),(1116,7,312,'Laureles La Estacion',1,NULL,NULL,0),(1117,7,312,'Llano Oriental',1,NULL,NULL,0),(1118,7,312,'Llanos De Bosa',1,NULL,NULL,0),(1119,7,312,'Manzanares',1,NULL,NULL,0),(1120,7,312,'Miraflores II Sector',1,NULL,NULL,0),(1121,7,312,'Mitrani',1,NULL,NULL,0),(1122,7,312,'Naranjos El Retazo ',1,NULL,NULL,0),(1123,7,312,'Nicolas Escobar',1,NULL,NULL,0),(1124,7,312,'Nueva Granada',1,NULL,NULL,0),(1126,7,312,'Nueva Granada II Sector',1,NULL,NULL,0),(1127,7,312,'Nueva Granada V Sector',1,NULL,NULL,0),(1128,7,312,'Pablo VI',1,NULL,NULL,0),(1129,7,312,'Palestina',1,NULL,NULL,0),(1130,7,312,'Paso Ancho',1,NULL,NULL,0),(1131,7,312,'Piamonte I Etapa',1,NULL,NULL,0),(1132,7,312,'Primavera Sur',1,NULL,NULL,0),(1133,7,312,'Providencia',1,NULL,NULL,0),(1134,7,312,'San Eugenio',1,NULL,NULL,0),(1135,7,312,'San Eugenio II',1,NULL,NULL,0),(1136,7,312,'San José Los Naranjos',1,NULL,NULL,0),(1137,7,312,'San Judas',1,NULL,NULL,0),(1138,7,312,'San Pablo I Sector',1,NULL,NULL,0),(1139,7,312,'San Pablo II Sector',1,NULL,NULL,0),(1140,7,312,'San Pedro',1,NULL,NULL,0),(1141,7,312,'Santa Lucia',1,NULL,NULL,0),(1142,7,312,'Sub Santa Lucia',1,NULL,NULL,0),(1143,7,312,'Sub Triangulo Las Materas',1,NULL,NULL,0),(1144,7,312,'Sub Urbanización Claretiana',1,NULL,NULL,0),(1145,7,312,'Tierra Gratis',1,NULL,NULL,0),(1146,7,312,'Urbanización Acuarela I',1,NULL,NULL,0),(1147,7,312,'Urbanización Acuarela II',1,NULL,NULL,0),(1148,7,312,'Urbanización Tanque De Bosa',1,NULL,NULL,0),(1149,7,312,'Verd. Sector San José',1,NULL,NULL,0),(1150,7,312,'Villa Anay',1,NULL,NULL,0),(1151,7,312,'Villa Anni (Bosa Naranjos)',1,NULL,NULL,0),(1152,7,312,'Villa Bosa',1,NULL,NULL,0),(1153,7,312,'Villa Nohora',1,NULL,NULL,0),(1154,7,312,'Xochimilco',1,NULL,NULL,0),(1155,7,336,'Caldas',1,NULL,NULL,0),(1156,7,336,'Antonio Nariño',1,NULL,NULL,0),(1157,7,336,'Campo Hermoso',1,NULL,NULL,0),(1158,7,336,'Cañaveralejo',1,NULL,NULL,0),(1159,7,336,'El Anhelo',1,NULL,NULL,0),(1160,7,336,'El Corzo',1,NULL,NULL,0),(1161,7,336,'El Porvenir',1,NULL,NULL,0),(1162,7,336,'El Porvenir III',1,NULL,NULL,0),(1163,7,336,'El Porvenir Parcela 23',1,NULL,NULL,0),(1164,7,336,'El Porvenir San Luis',1,NULL,NULL,0),(1165,7,336,'El Porvenir Sector Inducas',1,NULL,NULL,0),(1166,7,336,'El Recuerdo',1,NULL,NULL,0),(1167,7,336,'El Recuerdo De Santa Fe',1,NULL,NULL,0),(1168,7,336,'El Regalo',1,NULL,NULL,0),(1169,7,336,'El Regalo II',1,NULL,NULL,0),(1170,7,336,'La Arboleda',1,NULL,NULL,0),(1171,7,336,'La Cabaña',1,NULL,NULL,0),(1172,7,336,'La Granjita',1,NULL,NULL,0),(1173,7,336,'La Suerte',1,NULL,NULL,0),(1174,7,336,'La Union',1,NULL,NULL,0),(1175,7,336,'Las Margaritas',1,NULL,NULL,0),(1176,7,336,'Los Centauros',1,NULL,NULL,0),(1177,7,336,'Osorio X',1,NULL,NULL,0),(1178,7,336,'Osorio XIII',1,NULL,NULL,0),(1179,7,336,'Parcela El Porvenir',1,NULL,NULL,0),(1180,7,336,'San Bernardino II',1,NULL,NULL,0),(1181,7,336,'San Miguel',1,NULL,NULL,0),(1182,7,336,'San Pablo',1,NULL,NULL,0),(1183,7,336,'Santa Barbara',1,NULL,NULL,0),(1184,7,336,'Santa Fe',1,NULL,NULL,0),(1185,7,336,'Santa Fe I y II',1,NULL,NULL,0),(1186,7,336,'Santa Fe III',1,NULL,NULL,0),(1188,7,336,'Santa Isabel',1,NULL,NULL,0),(1189,7,336,'Santafe De Bosa',1,NULL,NULL,0),(1190,7,336,'Urbanizacion Caldas',1,NULL,NULL,0),(1191,7,336,'Villa Alegre',1,NULL,NULL,0),(1192,7,336,'Villa Alegria',1,NULL,NULL,0),(1193,7,336,'Villa Esmeralda',1,NULL,NULL,0),(1194,7,336,'Villa Karen',1,NULL,NULL,0),(1195,7,407,'El Matorral',1,NULL,NULL,0),(1196,7,407,'El Matorral De San Bernardino',1,NULL,NULL,0),(1197,7,407,'El Triunfo ',1,NULL,NULL,0),(1198,7,407,'El Triunfo De San Bernardino',1,NULL,NULL,0),(1199,7,407,'La Vega De San Bernardino Bajo',1,NULL,NULL,0),(1200,7,407,'Potreritos',1,NULL,NULL,0),(1201,7,407,'San Bernardino Sector Potrerito',1,NULL,NULL,0),(1202,7,407,'San Bernardino XIX',1,NULL,NULL,0),(1203,7,407,'San Bernardino XVI',1,NULL,NULL,0),(1204,7,407,'San Bernardino XVII',1,NULL,NULL,0),(1205,7,407,'San Bernardino XVIII',1,NULL,NULL,0),(1206,7,407,'San Bernardino XXII',1,NULL,NULL,0),(1207,7,407,'San Bernardino XXV',1,NULL,NULL,0),(1208,7,307,'Agrupacion Pio X ',1,NULL,NULL,0),(1209,7,307,'Agrupacion Multifamiliar Villa Emilia',1,NULL,NULL,0),(1210,7,307,'Alferez Real ',1,NULL,NULL,0),(1211,7,307,'Americas Central',1,NULL,NULL,0),(1212,7,307,'Americas Occidental',1,NULL,NULL,0),(1213,7,307,'Antiguo Hipodromo De Techo',1,NULL,NULL,0),(1214,7,307,'Carvajal II Sector',1,NULL,NULL,0),(1215,7,307,'Centroamericas ',1,NULL,NULL,0),(1216,7,307,'Ciudad Kennedy',1,NULL,NULL,0),(1217,7,307,'El Rincon De Mandalay ',1,NULL,NULL,0),(1218,7,307,'Floresta Sur',1,NULL,NULL,0),(1219,7,307,'Fundadores',1,NULL,NULL,0),(1220,7,307,'Glorieta De Las Americas ',1,NULL,NULL,0),(1221,7,307,'Hipotecho  ',1,NULL,NULL,0),(1222,7,307,'Igualdad I Sector',1,NULL,NULL,0),(1223,7,307,'Igualdad II Sector',1,NULL,NULL,0),(1224,7,307,'La Floresta',1,NULL,NULL,0),(1225,7,307,'La Igualdad',1,NULL,NULL,0),(1226,7,307,'La Llanura',1,NULL,NULL,0),(1227,7,307,'La Llanura Manzana P',1,NULL,NULL,0),(1228,7,307,'Las Americas',1,NULL,NULL,0),(1229,7,307,'Las Americas Sector Galan ',1,NULL,NULL,0),(1230,7,307,'Los Sauces',1,NULL,NULL,0),(1231,7,307,'Mandalay II Sector',1,NULL,NULL,0),(1232,7,307,'Mandalay I Sector',1,NULL,NULL,0),(1233,7,307,'Marsella III Sector',1,NULL,NULL,0),(1234,7,307,'Multifamiliares Villa Adriana',1,NULL,NULL,0),(1235,7,307,'Nueva Marsella',1,NULL,NULL,0),(1236,7,307,'Provivienda Oriental',1,NULL,NULL,0),(1237,7,307,'Santa Rosa De Carvajal ',1,NULL,NULL,0),(1238,7,307,'Urbanización Los Laureles (Sauces-Robles)',1,NULL,NULL,0),(1239,7,307,'Villa Adriana',1,NULL,NULL,0),(1240,7,307,'Villa Claudia',1,NULL,NULL,0),(1241,7,319,'Agrupacion De Vivienda Talavera',1,NULL,NULL,0),(1242,7,319,'Alq. De La Fragua Sector El Paraiso',1,NULL,NULL,0),(1243,7,319,'Alquerias De La Fragua',1,NULL,NULL,0),(1246,7,319,'Bombay',1,NULL,NULL,0),(1247,7,319,'Carimagua I Sector',1,NULL,NULL,0),(1248,7,319,'Carvajal ',1,NULL,NULL,0),(1249,7,319,'Carvajal Osorio',1,NULL,NULL,0),(1250,7,319,'Carvajal Techo I Sector',1,NULL,NULL,0),(1251,7,319,'Condado El Rey',1,NULL,NULL,0),(1252,7,319,'Delicias',1,NULL,NULL,0),(1253,7,319,'Desarrollo Nueva York',1,NULL,NULL,0),(1254,7,319,'El Pencil',1,NULL,NULL,0),(1255,7,319,'El Progreso I y II Sector',1,NULL,NULL,0),(1256,7,319,'El Triangulo',1,NULL,NULL,0),(1257,7,319,'Floralia I Y Ii Sector',1,NULL,NULL,0),(1258,7,319,'Gerona',1,NULL,NULL,0),(1259,7,319,'Guadalupe',1,NULL,NULL,0),(1260,7,319,'La Campiña',1,NULL,NULL,0),(1261,7,319,'La Chucua',1,NULL,NULL,0),(1262,7,319,'Las Torres ',1,NULL,NULL,0),(1263,7,319,'Los Cristales',1,NULL,NULL,0),(1264,7,319,'Lucerna',1,NULL,NULL,0),(1265,7,319,'Milenta',1,NULL,NULL,0),(1266,7,319,'Multifamiliar Carimagua',1,NULL,NULL,0),(1267,7,319,'Nueva York',1,NULL,NULL,0),(1268,7,319,'Provivienda',1,NULL,NULL,0),(1269,7,319,'Provivienda Occidental',1,NULL,NULL,0),(1270,7,319,'Salvador Allende ',1,NULL,NULL,0),(1271,7,319,'San Andres',1,NULL,NULL,0),(1272,7,319,'San Andres II Sector',1,NULL,NULL,0),(1273,7,319,'Super Manzana 6A',1,NULL,NULL,0),(1274,7,319,'Tayrona Comercial',1,NULL,NULL,0),(1275,7,319,'Urbanización Nueva Delicias',1,NULL,NULL,0),(1276,7,319,'Urbanización Renania (Antes La Chucua)',1,NULL,NULL,0),(1277,7,319,'Urbanizacion Carvajal',1,NULL,NULL,0),(1278,7,319,'Urbanizacion Las Delicias',1,NULL,NULL,0),(1279,7,319,'Valencia La Chucua',1,NULL,NULL,0),(1280,7,319,'Villa Nueva',1,NULL,NULL,0),(1281,7,321,'Aloha Sector Norte',1,NULL,NULL,0),(1282,7,321,'Agrupacion De Vivienda Pio Xii ',1,NULL,NULL,0),(1283,7,321,'Andalucia',1,NULL,NULL,0),(1284,7,321,'Andalucia II Sector',1,NULL,NULL,0),(1285,7,321,'Bavaria Techo',1,NULL,NULL,0),(1286,7,321,'Bosques De Castilla',1,NULL,NULL,0),(1287,7,321,'Ciudad Don Bosco',1,NULL,NULL,0),(1288,7,321,'Ciudad Favidi',1,NULL,NULL,0),(1289,7,321,'Ciudad Techo I',1,NULL,NULL,0),(1290,7,321,'El Castillo',1,NULL,NULL,0),(1291,7,321,'El Condado De La Paz',1,NULL,NULL,0),(1292,7,321,'El Portal De Las Americas',1,NULL,NULL,0),(1293,7,321,'El Rincon De Castilla',1,NULL,NULL,0),(1294,7,321,'El Rincon De Los Angeles ',1,NULL,NULL,0),(1295,7,321,'El Tintal',1,NULL,NULL,0),(1296,7,321,'El Vergel',1,NULL,NULL,0),(1297,7,321,'El Vergel Lote 4',1,NULL,NULL,0),(1298,7,321,'El Vergel Occidental',1,NULL,NULL,0),(1299,7,321,'Lagos De Castilla ',1,NULL,NULL,0),(1300,7,321,'Las Dos Avenidas I Etapa',1,NULL,NULL,0),(1301,7,321,'Las Dos Avenidas II Etapa',1,NULL,NULL,0),(1302,7,321,'Monterrey',1,NULL,NULL,0),(1303,7,321,'Multifamiliares El Ferrol',1,NULL,NULL,0),(1304,7,321,'Nuestra Señora De La Paz',1,NULL,NULL,0),(1305,7,321,'Osorio',1,NULL,NULL,0),(1306,7,321,'Oviedo',1,NULL,NULL,0),(1307,7,321,'Pio XII',1,NULL,NULL,0),(1308,7,321,'San Jose Occidental',1,NULL,NULL,0),(1309,7,321,'San Juan Del Castillo',1,NULL,NULL,0),(1310,7,321,'Santa Catalina Sector I Y II',1,NULL,NULL,0),(1311,7,321,'Santa Cecilia',1,NULL,NULL,0),(1312,7,321,'Urbanización Castilla',1,NULL,NULL,0),(1313,7,321,'Urbanización Castilla Los Madriles',1,NULL,NULL,0),(1314,7,321,'Urbanizacion Bavaria',1,NULL,NULL,0),(1315,7,321,'Urbanizacion Castilla La Nueva',1,NULL,NULL,0),(1316,7,321,'Urbanizacion Castilla Los Mandriles',1,NULL,NULL,0),(1317,7,321,'Urbanizacion Castilla Real',1,NULL,NULL,0),(1318,7,321,'Urbanizacion Castilla Reservado',1,NULL,NULL,0),(1319,7,321,'Urbanizacion Catania',1,NULL,NULL,0),(1320,7,321,'Urbanizacion Catania Castilla',1,NULL,NULL,0),(1321,7,321,'Urbanizacion Pio',1,NULL,NULL,0),(1323,7,321,'Valladolid',1,NULL,NULL,0),(1324,7,321,'Villa Alsacia',1,NULL,NULL,0),(1325,7,321,'Villa Castilla',1,NULL,NULL,0),(1326,7,321,'Villa Galante',1,NULL,NULL,0),(1327,7,321,'Villa Liliana ',1,NULL,NULL,0),(1328,7,321,'Villa Mariana',1,NULL,NULL,0),(1329,7,321,'Vision De Colombia',1,NULL,NULL,0),(1330,7,353,'Abraham Lincoln ',1,NULL,NULL,0),(1331,7,353,'Agrupación Francisco Jose De Calda',1,NULL,NULL,0),(1332,7,353,'Agrupacion De Vivienda El Paraiso',1,NULL,NULL,0),(1333,7,353,'Casa Blanca I Etapa',1,NULL,NULL,0),(1334,7,353,'Casa Blanca II Etapa',1,NULL,NULL,0),(1335,7,353,'Centro Civico Ciudad Kennedy',1,NULL,NULL,0),(1336,7,353,'Ciudad Kennedy Central',1,NULL,NULL,0),(1337,7,353,'Ciudad Kennedy Norte',1,NULL,NULL,0),(1338,7,353,'Ciudad Kennedy Occidental',1,NULL,NULL,0),(1339,7,353,'Ciudad Kennedy Oriental',1,NULL,NULL,0),(1340,7,353,'Ciudad Kennedy Super Mz. 10',1,NULL,NULL,0),(1341,7,353,'Ciudad Kennedy Super Mz. 13',1,NULL,NULL,0),(1342,7,353,'Ciudad Kennedy Sur',1,NULL,NULL,0),(1343,7,353,'Conjunto Residencia Manuel Mejia',1,NULL,NULL,0),(1344,7,353,'El Descanso',1,NULL,NULL,0),(1345,7,353,'Kennedy Norte Super Mz.11',1,NULL,NULL,0),(1346,7,353,'Kennedy Occidental Mz. 14',1,NULL,NULL,0),(1347,7,353,'Kennedy Occidental Mz.15',1,NULL,NULL,0),(1348,7,353,'Kennedy Oriental Super  Mz.7',1,NULL,NULL,0),(1349,7,353,'Kennedy Oriental Super Mz. 3',1,NULL,NULL,0),(1350,7,353,'Kennedy Oriental Super Mz. 6',1,NULL,NULL,0),(1351,7,353,'Kennedy Oriental Super Mz.2',1,NULL,NULL,0),(1352,7,353,'Kennedy Oriental Super Mz.5',1,NULL,NULL,0),(1353,7,353,'Kennedy Supermanzana I',1,NULL,NULL,0),(1354,7,353,'La Giraldilla',1,NULL,NULL,0),(1355,7,353,'La Giraldilla II',1,NULL,NULL,0),(1356,7,353,'Miraflores Kennedy',1,NULL,NULL,0),(1357,7,353,'Multifamiliar Techo',1,NULL,NULL,0),(1358,7,353,'Nuevo Kennedy',1,NULL,NULL,0),(1359,7,353,'Nuevo. Kennedy El Descanso',1,NULL,NULL,0),(1360,7,353,'Onasis',1,NULL,NULL,0),(1361,7,353,'Pastrana',1,NULL,NULL,0),(1362,7,353,'Supermanzana 16',1,NULL,NULL,0),(1363,7,353,'Supermanzana 9B',1,NULL,NULL,0),(1364,7,353,'Techo',1,NULL,NULL,0),(1365,7,353,'Unidad Residencial Ayacucho 2 S.Mz',1,NULL,NULL,0),(1366,7,353,'Urbanización Kennedy Super Mz.8',1,NULL,NULL,0),(1367,7,353,'Urbanización Mandalay Etapa C Zona 73 ',1,NULL,NULL,0),(1368,7,353,'Urbanizacion Arbolete Casablanca',1,NULL,NULL,0),(1369,7,353,'Urbanizacion Banderas',1,NULL,NULL,0),(1370,7,353,'Urbanizacion Experimental Kennedy',1,NULL,NULL,0),(1371,7,353,'Urbanizacion Sinai',1,NULL,NULL,0),(1372,7,405,'Acip',1,NULL,NULL,0),(1373,7,405,'Alameda De Timiza',1,NULL,NULL,0),(1374,7,405,'Alfonso Montaña ',1,NULL,NULL,0),(1375,7,405,'Berlin',1,NULL,NULL,0),(1376,7,405,'Boita',1,NULL,NULL,0),(1377,7,405,'Boita I Sector',1,NULL,NULL,0),(1378,7,405,'Boita II Sector',1,NULL,NULL,0),(1379,7,405,'Casa Loma',1,NULL,NULL,0),(1380,7,405,'Catalina',1,NULL,NULL,0),(1381,7,405,'Catalina II',1,NULL,NULL,0),(1382,7,405,'El Comité',1,NULL,NULL,0),(1383,7,405,'El Jordan',1,NULL,NULL,0),(1384,7,405,'El Jordan i Y III',1,NULL,NULL,0),(1385,7,405,'El Palenque',1,NULL,NULL,0),(1386,7,405,'El Porvenir II Sector',1,NULL,NULL,0),(1387,7,405,'El Porvenir Mz. A',1,NULL,NULL,0),(1388,7,405,'El Rubi',1,NULL,NULL,0),(1389,7,405,'Jacqueline',1,NULL,NULL,0),(1390,7,405,'Juan Pablo I',1,NULL,NULL,0),(1391,7,405,'La Cecilia',1,NULL,NULL,0),(1392,7,405,'La Unidad',1,NULL,NULL,0),(1393,7,405,'Lago Timiza I Y II Etapa',1,NULL,NULL,0),(1394,7,405,'Las Luces',1,NULL,NULL,0),(1395,7,405,'Morabia Ii',1,NULL,NULL,0),(1396,7,405,'Nueva Timiza',1,NULL,NULL,0),(1398,7,405,'Onassis',1,NULL,NULL,0),(1399,7,405,'Pastrana',1,NULL,NULL,0),(1400,7,405,'Pastranita II Sector',1,NULL,NULL,0),(1401,7,405,'Perpetuo Socorro',1,NULL,NULL,0),(1402,7,405,'Perpetuo Socorro II',1,NULL,NULL,0),(1403,7,405,'Prados De Kennedy',1,NULL,NULL,0),(1404,7,405,'Renania Urapanes',1,NULL,NULL,0),(1405,7,405,'Roma',1,NULL,NULL,0),(1406,7,405,'Roma Ii (Urb. Bertha Hernandez De Ospina)',1,NULL,NULL,0),(1407,7,405,'Sagrado Corazon',1,NULL,NULL,0),(1408,7,405,'San Martin De Porres',1,NULL,NULL,0),(1409,7,405,'Santa Catalina',1,NULL,NULL,0),(1410,7,405,'Timiza',1,NULL,NULL,0),(1411,7,405,'Tonoli ',1,NULL,NULL,0),(1412,7,405,'Tocarema',1,NULL,NULL,0),(1413,7,405,'Tundama',1,NULL,NULL,0),(1414,7,405,'Urbanización Bertha Hernandez De Ospina',1,NULL,NULL,0),(1415,7,405,'Urbanización Catalina',1,NULL,NULL,0),(1416,7,405,'Urbanización El Parque',1,NULL,NULL,0),(1417,7,405,'Urbanizacion Santa Luisa',1,NULL,NULL,0),(1418,7,405,'Vasconia Ii',1,NULL,NULL,0),(1419,7,405,'Villa De Los Sauces',1,NULL,NULL,0),(1420,7,405,'Villa Rica',1,NULL,NULL,0),(1421,7,406,'Santa Paz-Santa Elvira',1,NULL,NULL,0),(1422,7,406,'Vereda El Tintal',1,NULL,NULL,0),(1423,7,316,'Urbanizacion Unir Uno (Predio Calandaima)',1,NULL,NULL,0),(1424,7,316,'Calandaima',1,NULL,NULL,0),(1425,7,316,'Conjunto Residencial Prados De Castilla I',1,NULL,NULL,0),(1426,7,316,'Conjunto Residencial Prados De Castilla II',1,NULL,NULL,0),(1427,7,316,'Conjunto Residencial Prados De Castilla III',1,NULL,NULL,0),(1428,7,316,'Galan',1,NULL,NULL,0),(1429,7,316,'Osorio',1,NULL,NULL,0),(1430,7,316,'Santa Fe Del Tintal',1,NULL,NULL,0),(1431,7,316,'Tintala',1,NULL,NULL,0),(1432,7,330,'Amparo Cañizares',1,NULL,NULL,0),(1433,7,330,'Chucua De La Vaca ',1,NULL,NULL,0),(1434,7,330,'El Amparo',1,NULL,NULL,0),(1435,7,330,'El Llanito',1,NULL,NULL,0),(1436,7,330,'El Olivo',1,NULL,NULL,0),(1437,7,330,'El Portal De Patio Bonito',1,NULL,NULL,0),(1438,7,330,'El Saucedal',1,NULL,NULL,0),(1439,7,330,'La Concordia ',1,NULL,NULL,0),(1440,7,330,'La Esperanza',1,NULL,NULL,0),(1441,7,330,'La Maria',1,NULL,NULL,0),(1442,7,330,'Llano Grande',1,NULL,NULL,0),(1443,7,330,'Maria Paz ',1,NULL,NULL,0),(1444,7,330,'Pinar Del Rio',1,NULL,NULL,0),(1445,7,330,'Pinar Del Rio Ii',1,NULL,NULL,0),(1446,7,330,'San Carlos',1,NULL,NULL,0),(1447,7,330,'Villa De La Loma',1,NULL,NULL,0),(1448,7,330,'Villa De La Loma Ii Sector Mz.31 Y 32',1,NULL,NULL,0),(1449,7,330,'Villa De La Torre',1,NULL,NULL,0),(1450,7,330,'Villa Emilia, Amparo Ii Sector',1,NULL,NULL,0),(1451,7,330,'Villa Nelly ',1,NULL,NULL,0),(1452,7,330,'Villa Nelly - Los Alisos',1,NULL,NULL,0),(1453,7,330,'Vista Hermosa',1,NULL,NULL,0),(1454,7,346,'Alfonso Lopez Michelsen',1,NULL,NULL,0),(1455,7,346,'Britalita ',1,NULL,NULL,0),(1456,7,346,'Calarca',1,NULL,NULL,0),(1457,7,346,'Calarca Ii',1,NULL,NULL,0),(1458,7,346,'Casa Blanca Sur',1,NULL,NULL,0),(1459,7,346,'Class',1,NULL,NULL,0),(1460,7,346,'El Almenar',1,NULL,NULL,0),(1461,7,346,'El Carmelo',1,NULL,NULL,0),(1462,7,346,'Gran Britalia',1,NULL,NULL,0),(1463,7,346,'La Esperanza',1,NULL,NULL,0),(1464,7,346,'La Maria',1,NULL,NULL,0),(1465,7,346,'Pastranita I Sector',1,NULL,NULL,0),(1466,7,346,'Santa Maria De Kennedy',1,NULL,NULL,0),(1467,7,346,'Vegas De Santa Ana',1,NULL,NULL,0),(1468,7,346,'Villa Andrea',1,NULL,NULL,0),(1469,7,346,'Villa Anita',1,NULL,NULL,0),(1470,7,346,'Villa Clemencia Sector Villa Grata',1,NULL,NULL,0),(1471,7,346,'Villa Nelly',1,NULL,NULL,0),(1472,7,346,'Villa Zarzamora',1,NULL,NULL,0),(1473,7,346,'Villas De Kennedy',1,NULL,NULL,0),(1474,7,385,'Altamar',1,NULL,NULL,0),(1475,7,385,'Avenida Cundinamarca',1,NULL,NULL,0),(1476,7,385,'Barranquillita',1,NULL,NULL,0),(1477,7,385,'Bellavista',1,NULL,NULL,0),(1478,7,385,'Campo Hermoso',1,NULL,NULL,0),(1479,7,385,'Ciudad De Cali',1,NULL,NULL,0),(1480,7,385,'Ciudad Galan',1,NULL,NULL,0),(1481,7,385,'Ciudad Granada',1,NULL,NULL,0),(1482,7,385,'Dindalito',1,NULL,NULL,0),(1483,7,385,'El Paraiso',1,NULL,NULL,0),(1484,7,385,'El Patio Iii Sector',1,NULL,NULL,0),(1485,7,385,'El Rosario',1,NULL,NULL,0),(1486,7,385,'El Rosario Iii',1,NULL,NULL,0),(1487,7,385,'El Saucedal',1,NULL,NULL,0),(1488,7,385,'El Triunfo',1,NULL,NULL,0),(1489,7,385,'Horizonte Occidente',1,NULL,NULL,0),(1490,7,385,'Jazmin Occidental',1,NULL,NULL,0),(1491,7,385,'La Rivera   ',1,NULL,NULL,0),(1492,7,385,'La Rivera Ii Sector',1,NULL,NULL,0),(1493,7,385,'Las Acacias',1,NULL,NULL,0),(1494,7,385,'Las Brisas',1,NULL,NULL,0),(1495,7,385,'Las Palmeras',1,NULL,NULL,0),(1496,7,385,'Las Palmitas',1,NULL,NULL,0),(1497,7,385,'Las Vegas',1,NULL,NULL,0),(1498,7,385,'Los Almendros',1,NULL,NULL,0),(1499,7,385,'Nueva Esperanza ',1,NULL,NULL,0),(1500,7,385,'Parques Del Tintal (Campo Alegre Londoño)',1,NULL,NULL,0),(1502,7,385,'Patio Bonito II Sector',1,NULL,NULL,0),(1503,7,385,'Puente La Vega',1,NULL,NULL,0),(1504,7,385,'San Dionisio',1,NULL,NULL,0),(1505,7,385,'San Marino',1,NULL,NULL,0),(1506,7,385,'Santa Monica',1,NULL,NULL,0),(1507,7,385,'Sector Ii Altamar',1,NULL,NULL,0),(1508,7,385,'Sumapaz',1,NULL,NULL,0),(1509,7,385,'Tayrona ',1,NULL,NULL,0),(1510,7,385,'Tintalito',1,NULL,NULL,0),(1511,7,385,'Tintalito Ii',1,NULL,NULL,0),(1512,7,385,'Tocarema',1,NULL,NULL,0),(1513,7,385,'Urbanizacion Dindalito I Etapa',1,NULL,NULL,0),(1514,7,385,'Villa Alexandra',1,NULL,NULL,0),(1515,7,385,'Villa Andres',1,NULL,NULL,0),(1516,7,385,'Villa Hermosa',1,NULL,NULL,0),(1517,7,385,'Villa Mendoza',1,NULL,NULL,0),(1518,7,365,'Las Margaritas',1,NULL,NULL,0),(1519,7,365,'Osorio Xi',1,NULL,NULL,0),(1520,7,365,'Osorio Xii',1,NULL,NULL,0),(1521,7,310,'Aloha ',1,NULL,NULL,0),(1522,7,310,'Alsacia',1,NULL,NULL,0),(1523,7,310,'Aticos De Las Americas',1,NULL,NULL,0),(1524,7,310,'Cooperativa De Suboficiales',1,NULL,NULL,0),(1525,7,310,'El Condado De La Paz',1,NULL,NULL,0),(1526,7,310,'Los Pinos De Marsella',1,NULL,NULL,0),(1527,7,310,'Lucitania',1,NULL,NULL,0),(1528,7,310,'Marsella  ',1,NULL,NULL,0),(1529,7,310,'Marsella Sector Norte I Y Ii Etapa',1,NULL,NULL,0),(1530,7,310,'Multifamiliares La Paz El Ferrol',1,NULL,NULL,0),(1531,7,310,'Nuestra Señora De La Paz',1,NULL,NULL,0),(1532,7,310,'San Jose Occidental',1,NULL,NULL,0),(1533,7,310,'Unidad Oviedo',1,NULL,NULL,0),(1534,7,310,'Urbanizacion Bavaria',1,NULL,NULL,0),(1535,7,310,'Villa Alsacia',1,NULL,NULL,0),(1536,7,342,'Arabia',1,NULL,NULL,0),(1537,7,342,'Atahualpa',1,NULL,NULL,0),(1538,7,342,'Bahia Solano',1,NULL,NULL,0),(1539,7,342,'Batavia ',1,NULL,NULL,0),(1540,7,342,'Belen ',1,NULL,NULL,0),(1541,7,342,'Betania',1,NULL,NULL,0),(1542,7,342,'Centenario',1,NULL,NULL,0),(1543,7,342,'Cofradia ',1,NULL,NULL,0),(1544,7,342,'El Carmen ',1,NULL,NULL,0),(1545,7,342,'El Cuco',1,NULL,NULL,0),(1546,7,342,'El Cuco (La Estancia)',1,NULL,NULL,0),(1547,7,342,'El Guadual',1,NULL,NULL,0),(1548,7,342,'El Jordan',1,NULL,NULL,0),(1549,7,342,'El Pedregal',1,NULL,NULL,0),(1550,7,342,'El Rubi',1,NULL,NULL,0),(1551,7,342,'El Tapete',1,NULL,NULL,0),(1552,7,342,'Ferrocaja',1,NULL,NULL,0),(1553,7,342,'Flandes',1,NULL,NULL,0),(1554,7,342,'Fontibon Centro ',1,NULL,NULL,0),(1555,7,342,'La Cabana',1,NULL,NULL,0),(1556,7,342,'La Giralda ',1,NULL,NULL,0),(1557,7,342,'La Laguna',1,NULL,NULL,0),(1558,7,342,'Las Flores',1,NULL,NULL,0),(1559,7,342,'Palestina',1,NULL,NULL,0),(1560,7,342,'Rincon Santo',1,NULL,NULL,0),(1561,7,342,'Salamanca',1,NULL,NULL,0),(1562,7,342,'San Pedro Los Robles',1,NULL,NULL,0),(1563,7,342,'Torcoroma',1,NULL,NULL,0),(1564,7,342,'Unidad Residencial Montecarlo ',1,NULL,NULL,0),(1565,7,342,'Valle Verde ',1,NULL,NULL,0),(1566,7,342,'Veracruz',1,NULL,NULL,0),(1567,7,342,'Versalles ',1,NULL,NULL,0),(1568,7,342,'Villa Beatriz',1,NULL,NULL,0),(1569,7,342,'Villa Carmenza ',1,NULL,NULL,0),(1570,7,342,'Villemar',1,NULL,NULL,0),(1571,7,343,'Ambalema',1,NULL,NULL,0),(1572,7,343,'Bohios',1,NULL,NULL,0),(1573,7,343,'El Portal',1,NULL,NULL,0),(1574,7,343,'El Refugio',1,NULL,NULL,0),(1575,7,343,'El Triangulo',1,NULL,NULL,0),(1576,7,343,'Florencia',1,NULL,NULL,0),(1577,7,343,'Jerico',1,NULL,NULL,0),(1578,7,343,'La Aldea',1,NULL,NULL,0),(1579,7,343,'La Estacion',1,NULL,NULL,0),(1580,7,343,'La Perla',1,NULL,NULL,0),(1581,7,343,'La Zelfita',1,NULL,NULL,0),(1582,7,343,'Las Brisas',1,NULL,NULL,0),(1583,7,343,'Prados De La Alameda',1,NULL,NULL,0),(1584,7,343,'Puente Grande',1,NULL,NULL,0),(1585,7,343,'San Pablo',1,NULL,NULL,0),(1586,7,343,'Selva Dorada',1,NULL,NULL,0),(1587,7,343,'Villa Liliana',1,NULL,NULL,0),(1588,7,413,'Moravia',1,NULL,NULL,0),(1589,7,413,'Kazandra',1,NULL,NULL,0),(1590,7,327,'Carlos Lleras',1,NULL,NULL,0),(1591,7,327,'La Esperanza Norte',1,NULL,NULL,0),(1592,7,327,'Salitre Nor - Occidental',1,NULL,NULL,0),(1593,7,327,'Sausalito',1,NULL,NULL,0),(1594,7,348,'El Franco',1,NULL,NULL,0),(1595,7,348,'Granjas De Techo',1,NULL,NULL,0),(1596,7,348,'Montevideo',1,NULL,NULL,0),(1597,7,348,'Paraiso Bavaria',1,NULL,NULL,0),(1598,7,348,'Vision Semindustrial',1,NULL,NULL,0),(1599,7,376,'Bosque De Modelia',1,NULL,NULL,0),(1600,7,376,'Baleares',1,NULL,NULL,0),(1601,7,376,'Capellania',1,NULL,NULL,0),(1602,7,376,'El Rincon De Modelia',1,NULL,NULL,0),(1603,7,376,'Fuentes Del Dorado',1,NULL,NULL,0),(1604,7,376,'La Esperanza',1,NULL,NULL,0),(1605,7,376,'Mallorca',1,NULL,NULL,0),(1606,7,376,'Modelia  ',1,NULL,NULL,0),(1607,7,376,'Modelia Occidental',1,NULL,NULL,0),(1608,7,376,'Santa Cecilia',1,NULL,NULL,0),(1609,7,376,'Tarragona',1,NULL,NULL,0),(1610,7,318,'El Jardin ',1,NULL,NULL,0),(1611,7,318,'La Rosita',1,NULL,NULL,0),(1612,7,318,'Puerta De Teja',1,NULL,NULL,0),(1613,7,318,'San Jose',1,NULL,NULL,0),(1614,7,318,'Veracruz',1,NULL,NULL,0),(1615,7,304,'El Bogotano',1,NULL,NULL,0),(1616,7,364,'Acapulco',1,NULL,NULL,0),(1617,7,364,'Bellavista Occidental',1,NULL,NULL,0),(1618,7,364,'Bonanza',1,NULL,NULL,0),(1619,7,364,'Bosque Popular',1,NULL,NULL,0),(1620,7,364,'Cataluña',1,NULL,NULL,0),(1621,7,364,'Ciudad De Honda',1,NULL,NULL,0),(1622,7,364,'El Dorado San Joaquin',1,NULL,NULL,0),(1623,7,364,'El Guali',1,NULL,NULL,0),(1624,7,364,'El Laurel',1,NULL,NULL,0),(1625,7,364,'El Paseo',1,NULL,NULL,0),(1626,7,364,'Estrada',1,NULL,NULL,0),(1627,7,364,'La Cabaña',1,NULL,NULL,0),(1628,7,364,'La Estradita ',1,NULL,NULL,0),(1629,7,364,'La Europa',1,NULL,NULL,0),(1630,7,364,'La Marcela',1,NULL,NULL,0),(1631,7,364,'La Reliquia',1,NULL,NULL,0),(1632,7,364,'Las Ferias ',1,NULL,NULL,0),(1633,7,364,'Metropolis',1,NULL,NULL,0),(1634,7,364,'Palo Blanco',1,NULL,NULL,0),(1635,7,364,'San Joaquín',1,NULL,NULL,0),(1636,7,364,'Santo Domingo',1,NULL,NULL,0),(1637,7,375,'Andalucia',1,NULL,NULL,0),(1638,7,375,'Bochica',1,NULL,NULL,0),(1639,7,375,'Ciudad Bachue',1,NULL,NULL,0),(1640,7,375,'Copetroco La Tropical',1,NULL,NULL,0),(1641,7,375,'El Portal Del Rio',1,NULL,NULL,0),(1642,7,375,'La Española',1,NULL,NULL,0),(1643,7,375,'La Palestina',1,NULL,NULL,0),(1644,7,375,'La Serena',1,NULL,NULL,0),(1645,7,375,'Los Cerecitos',1,NULL,NULL,0),(1646,7,375,'Los Cerezos',1,NULL,NULL,0),(1647,7,375,'Luis Carlos Galan',1,NULL,NULL,0),(1648,7,375,'Meissen - Sidauto',1,NULL,NULL,0),(1649,7,375,'Minuto De Dios',1,NULL,NULL,0),(1650,7,375,'Morisco',1,NULL,NULL,0),(1651,7,375,'Paris Gaitan',1,NULL,NULL,0),(1652,7,375,'Primavera Norte',1,NULL,NULL,0),(1653,7,375,'Quirigua  ',1,NULL,NULL,0),(1654,7,314,'Boyaca',1,NULL,NULL,0),(1655,7,314,'El Carmelo',1,NULL,NULL,0),(1656,7,314,'El Refugio',1,NULL,NULL,0),(1657,7,314,'Florencia',1,NULL,NULL,0),(1658,7,314,'Florida Blanca',1,NULL,NULL,0),(1659,7,314,'La Almeria',1,NULL,NULL,0),(1660,7,314,'La Granja',1,NULL,NULL,0),(1661,7,314,'La Soledad Norte',1,NULL,NULL,0),(1662,7,314,'Los Pinos Florencia',1,NULL,NULL,0),(1663,7,314,'Maratu',1,NULL,NULL,0),(1664,7,314,'Paris',1,NULL,NULL,0),(1665,7,314,'Santa Helenita',1,NULL,NULL,0),(1666,7,314,'Santa Maria Del Lago',1,NULL,NULL,0),(1667,7,314,'Santa Rosita',1,NULL,NULL,0),(1668,7,314,'Tabora',1,NULL,NULL,0),(1669,7,314,'Veracruz',1,NULL,NULL,0),(1670,7,314,'Zarzamora',1,NULL,NULL,0),(1671,7,399,'El Encanto',1,NULL,NULL,0),(1672,7,399,'El Lujan',1,NULL,NULL,0),(1673,7,399,'El Real',1,NULL,NULL,0),(1674,7,399,'Los Monjes',1,NULL,NULL,0),(1675,7,399,'Normandia',1,NULL,NULL,0),(1676,7,399,'Normandia Occidental',1,NULL,NULL,0),(1677,7,399,'San Ignacio',1,NULL,NULL,0),(1678,7,399,'San Marcos',1,NULL,NULL,0),(1679,7,399,'Santa Cecilia',1,NULL,NULL,0),(1680,7,399,'Villa Luz',1,NULL,NULL,0),(1681,7,311,'Bochica Ii',1,NULL,NULL,0),(1682,7,311,'Bolivia',1,NULL,NULL,0),(1683,7,311,'Ciudadela Colsubsidio',1,NULL,NULL,0),(1684,7,311,'El Cortijo',1,NULL,NULL,0),(1685,7,311,'El Dorado',1,NULL,NULL,0),(1686,7,345,'Bosques De Mariana',1,NULL,NULL,0),(1687,7,345,'Alamos',1,NULL,NULL,0),(1688,7,345,'Alamos Norte',1,NULL,NULL,0),(1689,7,345,'El Cedro',1,NULL,NULL,0),(1690,7,345,'Garces Navas',1,NULL,NULL,0),(1691,7,345,'Los Angeles',1,NULL,NULL,0),(1692,7,345,'Molinos De Viento',1,NULL,NULL,0),(1693,7,345,'Plazuelas Del Virrey',1,NULL,NULL,0),(1694,7,345,'San Basilio',1,NULL,NULL,0),(1695,7,345,'Santa Monica ',1,NULL,NULL,0),(1696,7,345,'Villa Amalia',1,NULL,NULL,0),(1697,7,345,'Villas De Granada',1,NULL,NULL,0),(1698,7,345,'Villas De Madrigal',1,NULL,NULL,0),(1699,7,345,'Villas El Dorado San Antonio',1,NULL,NULL,0),(1700,7,341,'Alameda ',1,NULL,NULL,0),(1701,7,341,'Danubio Centauros',1,NULL,NULL,0),(1702,7,341,'El Cedro',1,NULL,NULL,0),(1703,7,341,'El Mirador',1,NULL,NULL,0),(1704,7,341,'El Muelle  ',1,NULL,NULL,0),(1705,7,341,'El Palmar',1,NULL,NULL,0),(1706,7,341,'El Triangulo',1,NULL,NULL,0),(1707,7,341,'El Verdun',1,NULL,NULL,0),(1708,7,341,'Engativa Centro',1,NULL,NULL,0),(1709,7,341,'Granjas El Dorado',1,NULL,NULL,0),(1710,7,341,'La Cabaña',1,NULL,NULL,0),(1711,7,341,'La Esperanza',1,NULL,NULL,0),(1712,7,341,'La Faena',1,NULL,NULL,0),(1713,7,341,'La Riviera',1,NULL,NULL,0),(1714,7,341,'La Tortigua ',1,NULL,NULL,0),(1715,7,341,'Las Mercedes',1,NULL,NULL,0),(1716,7,341,'Las Palmas',1,NULL,NULL,0),(1717,7,341,'Linterama',1,NULL,NULL,0),(1718,7,341,'Los Laureles',1,NULL,NULL,0),(1719,7,341,'Los Laureles Sabanas El Dorado',1,NULL,NULL,0),(1720,7,341,'Marandu',1,NULL,NULL,0),(1721,7,341,'Porvenir',1,NULL,NULL,0),(1722,7,341,'Puerto Amor Playas Del Jaboque',1,NULL,NULL,0),(1723,7,341,'San Antonio Norte',1,NULL,NULL,0),(1724,7,341,'San Basilio',1,NULL,NULL,0),(1725,7,341,'San Jose Obrero',1,NULL,NULL,0),(1726,7,341,'Santa Librada',1,NULL,NULL,0),(1727,7,341,'Villa Claver I Y Ii',1,NULL,NULL,0),(1728,7,341,'Villa Constanza',1,NULL,NULL,0),(1729,7,341,'Villa El Dorado Norte',1,NULL,NULL,0),(1730,7,341,'Villa Gladys ',1,NULL,NULL,0),(1731,7,341,'Villa Mary',1,NULL,NULL,0),(1732,7,341,'Villa Sandra',1,NULL,NULL,0),(1733,7,341,'Villa Teresita',1,NULL,NULL,0),(1734,7,341,'Villas El Dorado San Antonio Ii Sector',1,NULL,NULL,0),(1735,7,341,'Viña Del Mar',1,NULL,NULL,0),(1736,7,351,'El Salitre Luis Maria Fernandez',1,NULL,NULL,0),(1737,7,305,'San Ignacio',1,NULL,NULL,0),(1738,7,305,'Los Alamos',1,NULL,NULL,0),(1739,7,354,'La Academia',1,NULL,NULL,0),(1740,7,349,'Guaymaral',1,NULL,NULL,0),(1741,7,349,'Conejera',1,NULL,NULL,0),(1742,7,396,'Gibraltar',1,NULL,NULL,0),(1743,7,396,'Guicani',1,NULL,NULL,0),(1744,7,396,'Mirandela',1,NULL,NULL,0),(1745,7,396,'Nueva Zelandia',1,NULL,NULL,0),(1746,7,396,'Oikos',1,NULL,NULL,0),(1747,7,396,'San Felipe',1,NULL,NULL,0),(1748,7,396,'San Jose De Bavaria',1,NULL,NULL,0),(1749,7,396,'Santa Catalina',1,NULL,NULL,0),(1750,7,396,'Tejares Del Norte',1,NULL,NULL,0),(1751,7,396,'Villa Nova ',1,NULL,NULL,0),(1752,7,396,'Villa Del Prado',1,NULL,NULL,0),(1753,7,396,'Villa Lucy',1,NULL,NULL,0),(1754,7,315,'Britalia',1,NULL,NULL,0),(1755,7,315,'Britalia San Diego',1,NULL,NULL,0),(1756,7,315,'Calima Norte',1,NULL,NULL,0),(1757,7,315,'Cantagallo',1,NULL,NULL,0),(1758,7,315,'Cantalejo',1,NULL,NULL,0),(1759,7,315,'El Paraiso De Los 12 Apostoles',1,NULL,NULL,0),(1760,7,315,'Gilmar',1,NULL,NULL,0),(1761,7,315,'Granada Norte',1,NULL,NULL,0),(1762,7,315,'Granjas De Namur',1,NULL,NULL,0),(1763,7,315,'La Chocita',1,NULL,NULL,0),(1764,7,315,'Los Eliseos',1,NULL,NULL,0),(1765,7,315,'Pijao De Oro',1,NULL,NULL,0),(1766,7,315,'Portales Del Norte',1,NULL,NULL,0),(1767,7,315,'San Ciprano',1,NULL,NULL,0),(1768,7,315,'Villa Delia',1,NULL,NULL,0),(1769,7,315,'Villa Delia-Britalia Norte',1,NULL,NULL,0),(1770,7,315,'Vista Bella',1,NULL,NULL,0),(1771,7,337,'Alcala',1,NULL,NULL,0),(1772,7,337,'Atabanza',1,NULL,NULL,0),(1773,7,337,'Bernal Y Forero',1,NULL,NULL,0),(1774,7,337,'Cacigua',1,NULL,NULL,0),(1775,7,337,'Canodromo',1,NULL,NULL,0),(1776,7,337,'La Sultana',1,NULL,NULL,0),(1777,7,337,'Libertadores',1,NULL,NULL,0),(1778,7,337,'Los Prados De La Sultana',1,NULL,NULL,0),(1779,7,337,'Madeira',1,NULL,NULL,0),(1780,7,337,'Manuela Arluz',1,NULL,NULL,0),(1781,7,337,'Mazuren',1,NULL,NULL,0),(1782,7,337,'Niza IX',1,NULL,NULL,0),(1783,7,337,'Prado Pinzon',1,NULL,NULL,0),(1784,7,337,'Prado Sur',1,NULL,NULL,0),(1785,7,337,'Prado Veraniego',1,NULL,NULL,0),(1786,7,337,'Prado Veraniego Norte',1,NULL,NULL,0),(1787,7,337,'Prado Veraniego Sur',1,NULL,NULL,0),(1788,7,337,'San Jose De Spring',1,NULL,NULL,0),(1789,7,337,'San Jose Del Prado',1,NULL,NULL,0),(1790,7,337,'Santa Helena',1,NULL,NULL,0),(1791,7,337,'Tarragona',1,NULL,NULL,0),(1792,7,337,'Tierra Linda',1,NULL,NULL,0),(1793,7,337,'Victoria Norte',1,NULL,NULL,0),(1794,7,337,'Villa Morena',1,NULL,NULL,0),(1795,7,355,'Alhambra',1,NULL,NULL,0),(1796,7,355,'Batan',1,NULL,NULL,0),(1797,7,355,'El Recreo De Los Frailes',1,NULL,NULL,0),(1798,7,355,'Estoril',1,NULL,NULL,0),(1799,7,355,'Ilarco',1,NULL,NULL,0),(1800,7,355,'Malibu',1,NULL,NULL,0),(1801,7,355,'Monaco',1,NULL,NULL,0),(1802,7,355,'Pasadena',1,NULL,NULL,0),(1803,7,355,'Puente Largo',1,NULL,NULL,0),(1804,7,320,'Atenas',1,NULL,NULL,0),(1805,7,320,'Calatayud',1,NULL,NULL,0),(1806,7,320,'Casa Blanca I',1,NULL,NULL,0),(1807,7,320,'Casa Blanca Ii',1,NULL,NULL,0),(1808,7,320,'Casa Blanca Sec El Plan',1,NULL,NULL,0),(1809,7,320,'Casa Blanca Sec La Gruta',1,NULL,NULL,0),(1810,7,320,'Casa Blanca Suba',1,NULL,NULL,0),(1811,7,320,'Del Monte',1,NULL,NULL,0),(1812,7,320,'El Velero',1,NULL,NULL,0),(1813,7,320,'Escuela De Carabineros',1,NULL,NULL,0),(1814,7,379,'Calatrava',1,NULL,NULL,0),(1815,7,379,'Campania',1,NULL,NULL,0),(1816,7,379,'Ciudad Jardin Norte',1,NULL,NULL,0),(1817,7,379,'La Colina Campestre',1,NULL,NULL,0),(1818,7,379,'Colinas De Suba',1,NULL,NULL,0),(1819,7,379,'Cordoba',1,NULL,NULL,0),(1820,7,379,'Covadonga',1,NULL,NULL,0),(1821,7,379,'Gratamira',1,NULL,NULL,0),(1822,7,379,'Iberia',1,NULL,NULL,0),(1823,7,379,'Lagos De Cordoba',1,NULL,NULL,0),(1824,7,379,'Las Villas',1,NULL,NULL,0),(1825,7,379,'Lindaraja',1,NULL,NULL,0),(1826,7,379,'Niza',1,NULL,NULL,0),(1827,7,379,'Niza Norte',1,NULL,NULL,0),(1828,7,379,'Niza Suba',1,NULL,NULL,0),(1829,7,379,'Niza VIII',1,NULL,NULL,0),(1830,7,379,'Prado Jardin',1,NULL,NULL,0),(1831,7,379,'Provenza',1,NULL,NULL,0),(1832,7,379,'Rincon De Iberia',1,NULL,NULL,0),(1833,7,379,'Sotileza',1,NULL,NULL,0),(1834,7,358,'Andes Norte',1,NULL,NULL,0),(1835,7,358,'Club De Los Lagartos',1,NULL,NULL,0),(1836,7,358,'Coasmedas',1,NULL,NULL,0),(1837,7,358,'Julio Florez',1,NULL,NULL,0),(1838,7,358,'La Alborada',1,NULL,NULL,0),(1839,7,358,'La Floresta Norte',1,NULL,NULL,0),(1840,7,358,'Morato',1,NULL,NULL,0),(1841,7,358,'Nuevo Monterrey',1,NULL,NULL,0),(1842,7,358,'Pontevedra',1,NULL,NULL,0),(1843,7,358,'Potosi',1,NULL,NULL,0),(1844,7,358,'Santa Rosa',1,NULL,NULL,0),(1845,7,358,'San Nicolas',1,NULL,NULL,0),(1846,7,358,'Teusaca',1,NULL,NULL,0),(1847,7,402,'Acacias',1,NULL,NULL,0),(1848,7,402,'Alaska',1,NULL,NULL,0),(1849,7,402,'Alcazar De Suba',1,NULL,NULL,0),(1850,7,402,'Almendros Norte',1,NULL,NULL,0),(1851,7,402,'Alto De La Toma',1,NULL,NULL,0),(1852,7,402,'Bosques De San Jorge',1,NULL,NULL,0),(1853,7,402,'Campanela',1,NULL,NULL,0),(1854,7,402,'El Pencil Barrio El Salitre',1,NULL,NULL,0),(1855,7,402,'El Pinar',1,NULL,NULL,0),(1856,7,402,'El Pino',1,NULL,NULL,0),(1857,7,402,'El Portico',1,NULL,NULL,0),(1858,7,402,'El Salitre ',1,NULL,NULL,0),(1859,7,402,'Java ',1,NULL,NULL,0),(1860,7,402,'La Campiña',1,NULL,NULL,0),(1861,7,402,'La Fontana',1,NULL,NULL,0),(1862,7,402,'Las Orquideas',1,NULL,NULL,0),(1863,7,402,'Londres',1,NULL,NULL,0),(1864,7,402,'Miraflores',1,NULL,NULL,0),(1865,7,402,'Monarcas',1,NULL,NULL,0),(1866,7,402,'Navetas',1,NULL,NULL,0),(1867,7,402,'Pinar De Suba',1,NULL,NULL,0),(1868,7,402,'Pinos De Lombardia',1,NULL,NULL,0),(1869,7,402,'Portal De Las Mercedes',1,NULL,NULL,0),(1870,7,402,'Pradera De Suba',1,NULL,NULL,0),(1871,7,402,'Prados De Suba',1,NULL,NULL,0),(1872,7,402,'Prados Del Salitre',1,NULL,NULL,0),(1873,7,402,'Rincon De Santa Ines',1,NULL,NULL,0),(1874,7,402,'San Francisco',1,NULL,NULL,0),(1875,7,402,'Santa Isabel',1,NULL,NULL,0),(1876,7,402,'Suba Centro',1,NULL,NULL,0),(1877,7,402,'Tuna Alta',1,NULL,NULL,0),(1878,7,402,'Tuna Baja',1,NULL,NULL,0),(1879,7,402,'Turingia',1,NULL,NULL,0),(1880,7,402,'Vereda Suba Cerros',1,NULL,NULL,0),(1881,7,402,'Villa Del Campo  ',1,NULL,NULL,0),(1882,7,402,'Villa Esperanza',1,NULL,NULL,0),(1883,7,402,'Villa Hermosa',1,NULL,NULL,0),(1884,7,402,'Villa Susana',1,NULL,NULL,0),(1885,7,339,'Alcaparros',1,NULL,NULL,0),(1886,7,339,'Almirante Colon',1,NULL,NULL,0),(1887,7,339,'Almonacid',1,NULL,NULL,0),(1888,7,339,'Altos De Chozica',1,NULL,NULL,0),(1889,7,339,'Altos De La Esperanza',1,NULL,NULL,0),(1890,7,339,'Amberes',1,NULL,NULL,0),(1891,7,339,'Antonio Granados',1,NULL,NULL,0),(1892,7,339,'Arrayanes',1,NULL,NULL,0),(1893,7,339,'Aures',1,NULL,NULL,0),(1894,7,339,'Bochalema',1,NULL,NULL,0),(1895,7,339,'Catalina',1,NULL,NULL,0),(1896,7,339,'Ciudad Hunza',1,NULL,NULL,0),(1897,7,339,'Costa Azul',1,NULL,NULL,0),(1898,7,339,'Costa Rica',1,NULL,NULL,0),(1899,7,339,'El Aguinaldo',1,NULL,NULL,0),(1900,7,339,'El Arenal',1,NULL,NULL,0),(1901,7,339,'El Carmen',1,NULL,NULL,0),(1902,7,339,'El Cerezo',1,NULL,NULL,0),(1903,7,339,'El Condor',1,NULL,NULL,0),(1904,7,339,'El Jordan La Esperanza',1,NULL,NULL,0),(1905,7,339,'El Poa',1,NULL,NULL,0),(1906,7,339,'El Naranjal',1,NULL,NULL,0),(1907,7,339,'El Ocal',1,NULL,NULL,0),(1908,7,339,'El Palmar',1,NULL,NULL,0),(1909,7,339,'El Portico',1,NULL,NULL,0),(1910,7,339,'El Progreso',1,NULL,NULL,0),(1911,7,339,'El Refugio De Suba ',1,NULL,NULL,0),(1912,7,339,'Ciudadela Cafam',1,NULL,NULL,0),(1913,7,339,'El Rubi',1,NULL,NULL,0),(1914,7,339,'El Tabor',1,NULL,NULL,0),(1915,7,339,'Gloria Lara De Echeverri',1,NULL,NULL,0),(1916,7,339,'Guillermo Nuñez',1,NULL,NULL,0),(1917,7,339,'Jaime Bermeo',1,NULL,NULL,0),(1918,7,339,'Japon',1,NULL,NULL,0),(1919,7,339,'Java Ii Sector ',1,NULL,NULL,0),(1920,7,339,'La Aguadita',1,NULL,NULL,0),(1921,7,339,'La Alameda',1,NULL,NULL,0),(1922,7,339,'La Aurora',1,NULL,NULL,0),(1923,7,339,'La Chucua',1,NULL,NULL,0),(1924,7,339,'La Esmeralda',1,NULL,NULL,0),(1925,7,339,'La Esperanza (Calle 131A)',1,NULL,NULL,0),(1926,7,339,'La Estanzuela',1,NULL,NULL,0),(1927,7,339,'La Flor',1,NULL,NULL,0),(1928,7,339,'La Flora',1,NULL,NULL,0),(1929,7,339,'La Manuelita ',1,NULL,NULL,0),(1930,7,339,'La Palma',1,NULL,NULL,0),(1931,7,339,'La Trinitaria',1,NULL,NULL,0),(1932,7,339,'Lago De Suba',1,NULL,NULL,0),(1933,7,339,'Las Flores',1,NULL,NULL,0),(1934,7,339,'Lombardia',1,NULL,NULL,0),(1935,7,339,'Los Arrayanes',1,NULL,NULL,0),(1936,7,339,'Los Naranjos',1,NULL,NULL,0),(1937,7,339,'Los Nogales',1,NULL,NULL,0),(1938,7,339,'Naranjos Altos',1,NULL,NULL,0),(1939,7,339,'Nuevo Corinto',1,NULL,NULL,0),(1940,7,339,'Palma Aldea',1,NULL,NULL,0),(1941,7,339,'Potrerillo',1,NULL,NULL,0),(1942,7,339,'Potrerillos De Suba',1,NULL,NULL,0),(1943,7,339,'Prados De Santa Barbara',1,NULL,NULL,0),(1944,7,339,'Puerta Del Sol',1,NULL,NULL,0),(1945,7,339,'Rincon De Suba',1,NULL,NULL,0),(1946,7,339,'Rincon El Condor',1,NULL,NULL,0),(1947,7,339,'Rincon Escuela',1,NULL,NULL,0),(1948,7,339,'Riobamba',1,NULL,NULL,0),(1949,7,339,'Rodrigo Lara Bonilla',1,NULL,NULL,0),(1950,7,339,'San Cayetano',1,NULL,NULL,0),(1951,7,339,'San Isidro Norte',1,NULL,NULL,0),(1952,7,339,'San Jorge',1,NULL,NULL,0),(1953,7,339,'San Miguel Tibabuyes',1,NULL,NULL,0),(1954,7,339,'San Pedro',1,NULL,NULL,0),(1955,7,339,'Santa Ana De Suba',1,NULL,NULL,0),(1956,7,339,'Santa Barbara Tibabuyes',1,NULL,NULL,0),(1957,7,339,'Santa Ines - Santa Helena',1,NULL,NULL,0),(1958,7,339,'Taberin',1,NULL,NULL,0),(1959,7,339,'Telecom Arrayanes',1,NULL,NULL,0),(1960,7,339,'Teusaquillo De Suba',1,NULL,NULL,0),(1961,7,339,'Tibabuyes ',1,NULL,NULL,0),(1962,7,339,'Villa Alexandra',1,NULL,NULL,0),(1963,7,339,'Villa Catalina',1,NULL,NULL,0),(1964,7,339,'Villa Elisa',1,NULL,NULL,0),(1965,7,339,'Villa Maria',1,NULL,NULL,0),(1966,7,339,'Villas Del Rincon',1,NULL,NULL,0),(1967,7,404,'Atenas',1,NULL,NULL,0),(1968,7,404,'Berlin',1,NULL,NULL,0),(1969,7,404,'Bilbao',1,NULL,NULL,0),(1970,7,404,'Cañiza I,II Y III',1,NULL,NULL,0),(1971,7,404,'Carolina Ii Y Iii',1,NULL,NULL,0),(1972,7,404,'El Cedro',1,NULL,NULL,0),(1973,7,404,'Compartir',1,NULL,NULL,0),(1974,7,404,'La Gaitana',1,NULL,NULL,0),(1975,7,404,'La Isabela',1,NULL,NULL,0),(1976,7,404,'Lisboa',1,NULL,NULL,0),(1977,7,404,'Los Nogales De Tibabuyes',1,NULL,NULL,0),(1978,7,404,'Miramar',1,NULL,NULL,0),(1979,7,404,'Nueva Tibabuyes',1,NULL,NULL,0),(1980,7,404,'Nuevo Corinto Sector E',1,NULL,NULL,0),(1981,7,404,'Prados De Santa Barbara',1,NULL,NULL,0),(1982,7,404,'Rincon De Boyaca',1,NULL,NULL,0),(1983,7,404,'Sabana De Tibabuyes  ',1,NULL,NULL,0),(1984,7,404,'San Carlos De Suba',1,NULL,NULL,0),(1985,7,404,'San Carlos De Tibabuyes',1,NULL,NULL,0),(1986,7,404,'San Pedro De Tibabuyes',1,NULL,NULL,0),(1987,7,404,'Santa Cecilia  ',1,NULL,NULL,0),(1988,7,404,'Santa Rita',1,NULL,NULL,0),(1989,7,404,'Tibabuyes Universal',1,NULL,NULL,0),(1990,7,404,'Toscana',1,NULL,NULL,0),(1991,7,404,'Vereda Suba Rincon',1,NULL,NULL,0),(1992,7,404,'Vereda Tibabuyes',1,NULL,NULL,0),(1993,7,404,'Verona',1,NULL,NULL,0),(1994,7,404,'Villa Cindy',1,NULL,NULL,0),(1995,7,404,'Villa De Las Flores',1,NULL,NULL,0),(1996,7,404,'Villa Gloria',1,NULL,NULL,0),(1997,7,404,'Villa Gloria I',1,NULL,NULL,0),(1998,7,368,'Villa Calazanz',1,NULL,NULL,0),(1999,7,368,'Conjunto Residencial Calla 100',1,NULL,NULL,0),(2000,7,368,'Entrerrios',1,NULL,NULL,0),(2001,7,368,'Escuela Militar',1,NULL,NULL,0),(2002,7,368,'La Castellana',1,NULL,NULL,0),(2003,7,368,'La Patria',1,NULL,NULL,0),(2004,7,368,'Los Andes',1,NULL,NULL,0),(2005,7,368,'Rionegro',1,NULL,NULL,0),(2006,7,368,'Urbanizacion San Martin',1,NULL,NULL,0),(2007,7,368,'Vizcaya ',1,NULL,NULL,0),(2008,7,334,'12 De Octubre',1,NULL,NULL,0),(2009,7,334,'Jorge Eliecer Gaitan',1,NULL,NULL,0),(2010,7,334,'Jose Joaquin Vargas',1,NULL,NULL,0),(2011,7,334,'La Libertad',1,NULL,NULL,0),(2012,7,334,'Entre Rios',1,NULL,NULL,0),(2013,7,334,'Rincon Del Salitre',1,NULL,NULL,0),(2014,7,334,'El Labrador',1,NULL,NULL,0),(2015,7,334,'Metropolis',1,NULL,NULL,0),(2016,7,334,'Popular Modelo',1,NULL,NULL,0),(2017,7,334,'San Fernando',1,NULL,NULL,0),(2018,7,334,'San Fernando Occidental',1,NULL,NULL,0),(2019,7,334,'San Miguel',1,NULL,NULL,0),(2020,7,334,'Simon Bolivar',1,NULL,NULL,0),(2021,7,367,'11 De Noviembre',1,NULL,NULL,0),(2022,7,367,'Alcazares Norte',1,NULL,NULL,0),(2023,7,367,'Baquero',1,NULL,NULL,0),(2024,7,367,'Benjamin Herrera',1,NULL,NULL,0),(2025,7,367,'Chapinero Noroccidental',1,NULL,NULL,0),(2026,7,367,'Colombia',1,NULL,NULL,0),(2027,7,367,'Concepcion Norte',1,NULL,NULL,0),(2028,7,367,'Juan Xxiii',1,NULL,NULL,0),(2029,7,367,'La Aurora',1,NULL,NULL,0),(2030,7,367,'La Esperanza',1,NULL,NULL,0),(2031,7,367,'La Merced Norte',1,NULL,NULL,0),(2032,7,367,'La Paz',1,NULL,NULL,0),(2033,7,367,'Los Alcazares',1,NULL,NULL,0),(2034,7,367,'Muequeta',1,NULL,NULL,0),(2035,7,367,'Polo Club',1,NULL,NULL,0),(2036,7,367,'Quinta Mutis',1,NULL,NULL,0),(2037,7,367,'Rafael Uribe',1,NULL,NULL,0),(2038,7,367,'San Felipe',1,NULL,NULL,0),(2039,7,367,'Santa Sofia',1,NULL,NULL,0),(2040,7,367,'Siete De Agosto',1,NULL,NULL,0),(2041,7,382,'El Rosario',1,NULL,NULL,0),(2042,7,344,'Banco Central',1,NULL,NULL,0),(2043,7,344,'Alfonso Lopez',1,NULL,NULL,0),(2044,7,344,'Belalcazar',1,NULL,NULL,0),(2045,7,344,'Campin',1,NULL,NULL,0),(2046,7,344,'Chapinero Occidental',1,NULL,NULL,0),(2047,7,344,'Galerias',1,NULL,NULL,0),(2048,7,344,'San Luis',1,NULL,NULL,0),(2049,7,403,'Armenia',1,NULL,NULL,0),(2050,7,403,'Estrella',1,NULL,NULL,0),(2051,7,403,'La Magdalena',1,NULL,NULL,0),(2052,7,403,'La Soledad',1,NULL,NULL,0),(2053,7,403,'Las Americas',1,NULL,NULL,0),(2054,7,403,'Palermo',1,NULL,NULL,0),(2055,7,403,'Quesada',1,NULL,NULL,0),(2056,7,403,'Santa Teresita',1,NULL,NULL,0),(2057,7,403,'Teusaquillo',1,NULL,NULL,0),(2058,7,383,'El Salitre',1,NULL,NULL,0),(2059,7,356,'La Esmeralda',1,NULL,NULL,0),(2060,7,356,'Nicolas De Federman',1,NULL,NULL,0),(2061,7,356,'Nuevo Campin',1,NULL,NULL,0),(2062,7,356,'Pablo Vi  ',1,NULL,NULL,0),(2063,7,356,'Quirinal',1,NULL,NULL,0),(2064,7,356,'Rafael Nuñez',1,NULL,NULL,0),(2065,7,387,'Acevedo Tejada',1,NULL,NULL,0),(2066,7,387,'Cama Vieja',1,NULL,NULL,0),(2067,7,387,'Centro Nariño',1,NULL,NULL,0),(2068,7,387,'El Recuerdo',1,NULL,NULL,0),(2069,7,387,'Gran America',1,NULL,NULL,0),(2070,7,387,'Quinta Paredes',1,NULL,NULL,0),(2071,7,328,'Ciudad Salitre Sur-Oriental',1,NULL,NULL,0),(2072,7,328,'Ciudad Salitre Nor-Oriental',1,NULL,NULL,0),(2073,7,400,'Eduardo Santos ',1,NULL,NULL,0),(2074,7,400,'El Progreso',1,NULL,NULL,0),(2075,7,400,'El Vergel',1,NULL,NULL,0),(2076,7,400,'Santa Isabel',1,NULL,NULL,0),(2077,7,400,'Veraguas',1,NULL,NULL,0),(2078,7,361,'Colseguros',1,NULL,NULL,0),(2079,7,361,'El Liston',1,NULL,NULL,0),(2080,7,361,'Florida',1,NULL,NULL,0),(2081,7,361,'La Estanzuela',1,NULL,NULL,0),(2082,7,361,'La Favorita',1,NULL,NULL,0),(2083,7,361,'La Pepita',1,NULL,NULL,0),(2084,7,361,'La Sabana ',1,NULL,NULL,0),(2085,7,361,'Paloquemao',1,NULL,NULL,0),(2086,7,361,'Panamericano',1,NULL,NULL,0),(2087,7,361,'Ricaurte',1,NULL,NULL,0),(2088,7,361,'Samper Mendoza',1,NULL,NULL,0),(2089,7,361,'San Fason',1,NULL,NULL,0),(2090,7,361,'San Victorino',1,NULL,NULL,0),(2091,7,361,'Santa Fe',1,NULL,NULL,0),(2092,7,361,'Usatama',1,NULL,NULL,0),(2093,7,361,'Voto Nacional',1,NULL,NULL,0),(2094,7,325,'Caracas',1,NULL,NULL,0),(2095,7,325,'Ciudad Berna',1,NULL,NULL,0),(2096,7,325,'Ciudad Jardin Sur',1,NULL,NULL,0),(2097,7,325,'La Hortua',1,NULL,NULL,0),(2098,7,325,'Policarpa',1,NULL,NULL,0),(2099,7,325,'Sevilla',1,NULL,NULL,0),(2100,7,389,'Eduardo Frei',1,NULL,NULL,0),(2101,7,389,'La Fragua',1,NULL,NULL,0),(2102,7,389,'La Fraguita',1,NULL,NULL,0),(2103,7,389,'Luna Park',1,NULL,NULL,0),(2104,7,389,'Restrepo',1,NULL,NULL,0),(2105,7,389,'Restrepo Occidental',1,NULL,NULL,0),(2106,7,389,'San Antonio',1,NULL,NULL,0),(2107,7,389,'San Jorge Central Ii Sector',1,NULL,NULL,0),(2108,7,389,'Santander',1,NULL,NULL,0),(2109,7,389,'Santander Sur',1,NULL,NULL,0),(2110,7,389,'Sena',1,NULL,NULL,0),(2111,7,389,'Villa Mayor Oriental',1,NULL,NULL,0),(2112,7,326,'La Guaca',1,NULL,NULL,0),(2113,7,326,'Bochica',1,NULL,NULL,0),(2114,7,326,'Carabelas',1,NULL,NULL,0),(2115,7,326,'Ciudad Montes',1,NULL,NULL,0),(2116,7,326,'El Sol',1,NULL,NULL,0),(2117,7,326,'Jazmin',1,NULL,NULL,0),(2118,7,326,'Jorge Gaitan Cortes',1,NULL,NULL,0),(2119,7,326,'La Asuncion',1,NULL,NULL,0),(2120,7,326,'La Camelia',1,NULL,NULL,0),(2121,7,326,'Los Comuneros',1,NULL,NULL,0),(2122,7,326,'Ponderosa',1,NULL,NULL,0),(2123,7,326,'Primavera  ',1,NULL,NULL,0),(2124,7,326,'Remanso   ',1,NULL,NULL,0),(2125,7,326,'San Eusebio',1,NULL,NULL,0),(2126,7,326,'Santa Matilde',1,NULL,NULL,0),(2127,7,326,'Tibana',1,NULL,NULL,0),(2128,7,326,'Torremolinos',1,NULL,NULL,0),(2129,7,326,'Villa Ines',1,NULL,NULL,0),(2130,7,326,'Urbanizacion Corkidi',1,NULL,NULL,0),(2131,7,326,'Santa Isabel Occidental',1,NULL,NULL,0),(2132,7,378,'Alcala',1,NULL,NULL,0),(2133,7,378,'Alqueria',1,NULL,NULL,0),(2134,7,378,'Autopista Muzu  ',1,NULL,NULL,0),(2135,7,378,'La Coruña',1,NULL,NULL,0),(2136,7,378,'Los Sauces',1,NULL,NULL,0),(2137,7,378,'Muzu',1,NULL,NULL,0),(2138,7,378,'Ospina Perez',1,NULL,NULL,0),(2139,7,378,'Santa Rita',1,NULL,NULL,0),(2140,7,378,'Tejar',1,NULL,NULL,0),(2141,7,378,'Villa Del Rosario',1,NULL,NULL,0),(2142,7,378,'Villa Sonia',1,NULL,NULL,0),(2143,7,397,'Barcelona',1,NULL,NULL,0),(2144,7,397,'Brisas Del Galan',1,NULL,NULL,0),(2145,7,397,'Brasilia',1,NULL,NULL,0),(2146,7,397,'Camelia Sur',1,NULL,NULL,0),(2147,7,397,'Colon  ',1,NULL,NULL,0),(2148,7,397,'Galan',1,NULL,NULL,0),(2149,7,397,'La Pradera',1,NULL,NULL,0),(2150,7,397,'La Trinidad',1,NULL,NULL,0),(2151,7,397,'El Arpay La Lira ',1,NULL,NULL,0),(2152,7,397,'Milenta',1,NULL,NULL,0),(2153,7,397,'San Francisco',1,NULL,NULL,0),(2154,7,397,'San Gabriel',1,NULL,NULL,0),(2155,7,397,'San Rafael  ',1,NULL,NULL,0),(2156,7,397,'San Rafael Industrial',1,NULL,NULL,0),(2157,7,414,'Cundinamarca',1,NULL,NULL,0),(2158,7,414,'El Ejido',1,NULL,NULL,0),(2159,7,414,'Gorgonzola',1,NULL,NULL,0),(2160,7,414,'Industrial Centenario',1,NULL,NULL,0),(2161,7,414,'La Florida Occidental',1,NULL,NULL,0),(2162,7,414,'Los Ejidos',1,NULL,NULL,0),(2163,7,414,'Pensilvania',1,NULL,NULL,0),(2164,7,386,'Batallon Caldas',1,NULL,NULL,0),(2165,7,386,'Centro Industrial',1,NULL,NULL,0),(2166,7,386,'Ortezal',1,NULL,NULL,0),(2167,7,386,'Puente Aranda',1,NULL,NULL,0),(2168,7,386,'Salazar Gomez',1,NULL,NULL,0),(2169,7,317,'Nueva Santa Fe De Bogota',1,NULL,NULL,0),(2170,7,317,'Belen',1,NULL,NULL,0),(2171,7,317,'Candelaria',1,NULL,NULL,0),(2172,7,317,'Centro Administrativo',1,NULL,NULL,0),(2173,7,317,'La Catedral',1,NULL,NULL,0),(2174,7,317,'La Concordia',1,NULL,NULL,0),(2175,7,317,'Las Aguas',1,NULL,NULL,0),(2176,7,317,'Sta Barbara',1,NULL,NULL,0),(2177,7,395,'Gustavo Restrepo',1,NULL,NULL,0),(2178,7,395,'Hospital San Carlos',1,NULL,NULL,0),(2179,7,395,'San Jose Sur',1,NULL,NULL,0),(2180,7,395,'San Luis',1,NULL,NULL,0),(2181,7,395,'Sociego Sur',1,NULL,NULL,0),(2182,7,388,'Bravo Paez',1,NULL,NULL,0),(2183,7,388,'Centenario',1,NULL,NULL,0),(2184,7,388,'Claret',1,NULL,NULL,0),(2185,7,388,'Ingles',1,NULL,NULL,0),(2186,7,388,'Libertador',1,NULL,NULL,0),(2187,7,388,'Murillo Toro',1,NULL,NULL,0),(2188,7,388,'Olaya',1,NULL,NULL,0),(2189,7,388,'Quiroga ',1,NULL,NULL,0),(2190,7,388,'Quiroga Central',1,NULL,NULL,0),(2191,7,388,'Quiroga Sur',1,NULL,NULL,0),(2192,7,388,'Santa Lucia',1,NULL,NULL,0),(2193,7,388,'Santiago Perez',1,NULL,NULL,0),(2194,7,388,'Villa Mayor ',1,NULL,NULL,0),(2195,7,373,'Carmen Del Sol',1,NULL,NULL,0),(2196,7,373,'Bravo Paez',1,NULL,NULL,0),(2197,7,373,'Carmen Del Sol I Sector',1,NULL,NULL,0),(2198,7,373,'Centenario',1,NULL,NULL,0),(2199,7,373,'Claret',1,NULL,NULL,0),(2200,7,373,'El Recuerdo San Jorge Alto',1,NULL,NULL,0),(2201,7,373,'El Triunfo  ',1,NULL,NULL,0),(2202,7,373,'El Triunfo Sur',1,NULL,NULL,0),(2203,7,373,'Granjas San Pablo',1,NULL,NULL,0),(2204,7,373,'Granjas Santa Sofia',1,NULL,NULL,0),(2205,7,373,'Ingles',1,NULL,NULL,0),(2206,7,373,'La Resurreccion ',1,NULL,NULL,0),(2207,7,373,'Las Colinas ',1,NULL,NULL,0),(2208,7,373,'Las Lomas',1,NULL,NULL,0),(2209,7,373,'Libertador',1,NULL,NULL,0),(2210,7,373,'Luis Lopez De Mesa',1,NULL,NULL,0),(2211,7,373,'Marco Fidel Suarez',1,NULL,NULL,0),(2212,7,373,'Marco Fidel Suarez La Cañada',1,NULL,NULL,0),(2213,7,373,'Murillo Toro',1,NULL,NULL,0),(2214,7,373,'Olaya ',1,NULL,NULL,0),(2215,7,373,'Resurreccion',1,NULL,NULL,0),(2216,7,373,'Rio De Janeiro El Pesebre',1,NULL,NULL,0),(2217,7,373,'San Jorge Sur',1,NULL,NULL,0),(2218,7,373,'San Jorge-Gloria Gaitan',1,NULL,NULL,0),(2219,7,373,'San Juanito',1,NULL,NULL,0),(2220,7,373,'San Justino',1,NULL,NULL,0),(2221,7,373,'Santa Luicia',1,NULL,NULL,0),(2222,7,373,'Santiago Perez',1,NULL,NULL,0),(2223,7,373,'Terrazas De San Jorge',1,NULL,NULL,0),(2224,7,373,'Villa Mayor',1,NULL,NULL,0),(2225,7,374,'Antonio Morales Galavis',1,NULL,NULL,0),(2226,7,374,'Arboleda Sur',1,NULL,NULL,0),(2227,7,374,'Callejon Santa Barbara',1,NULL,NULL,0),(2228,7,374,'Cerros De Oriente',1,NULL,NULL,0),(2229,7,374,'Danubio Del Sur',1,NULL,NULL,0),(2230,7,374,'El Consuelo',1,NULL,NULL,0),(2231,7,374,'El Mirador Sur I Y Ii',1,NULL,NULL,0),(2232,7,374,'El Pensil',1,NULL,NULL,0),(2233,7,374,'El Playon',1,NULL,NULL,0),(2234,7,374,'El Puerto La Loma De San Carlos',1,NULL,NULL,0),(2235,7,374,'El Rosal',1,NULL,NULL,0),(2236,7,374,'El Socorro',1,NULL,NULL,0),(2237,7,374,'Govaroba',1,NULL,NULL,0),(2238,7,374,'Govaroba Ii',1,NULL,NULL,0),(2239,7,374,'Guiparma',1,NULL,NULL,0),(2240,7,374,'La Esperanza',1,NULL,NULL,0),(2241,7,374,'La Merced Sur',1,NULL,NULL,0),(2242,7,374,'La Merced Sur San Ignacio',1,NULL,NULL,0),(2243,7,374,'La Picota',1,NULL,NULL,0),(2244,7,374,'La Playa',1,NULL,NULL,0),(2245,7,374,'La Providencia Media',1,NULL,NULL,0),(2246,7,374,'Los Chircales',1,NULL,NULL,0),(2247,7,374,'Los Molinos',1,NULL,NULL,0),(2248,7,374,'Marco Fidel Suarez',1,NULL,NULL,0),(2249,7,374,'Marruecos',1,NULL,NULL,0),(2250,7,374,'Mirador De Marrocos',1,NULL,NULL,0),(2251,7,374,'Mirador Los Molinos Ii Sector',1,NULL,NULL,0),(2252,7,374,'Molinos Del Sur',1,NULL,NULL,0),(2253,7,374,'Nuevo Pensilvania Sur',1,NULL,NULL,0),(2254,7,374,'Playon La Playita Iii',1,NULL,NULL,0),(2255,7,374,'Pradera Sur',1,NULL,NULL,0),(2256,7,374,'Principe De Bochica',1,NULL,NULL,0),(2257,7,374,'Puente De San Bernado',1,NULL,NULL,0),(2258,7,374,'Puerto Rico',1,NULL,NULL,0),(2259,7,374,'Socorro Iii Sector',1,NULL,NULL,0),(2260,7,374,'Villa Del Sol',1,NULL,NULL,0),(2261,7,374,'Villa Gladys',1,NULL,NULL,0),(2262,7,374,'Villa Morales',1,NULL,NULL,0),(2263,7,374,'Villas  Del Recuerdo',1,NULL,NULL,0),(2264,7,333,'Antonio Morales Ii',1,NULL,NULL,0),(2265,7,333,'Buenos.Aires La Esp.Parc. La Fisc',1,NULL,NULL,0),(2266,7,333,'Diana Turbay',1,NULL,NULL,0),(2267,7,333,'Diana Turbay Arrayanes',1,NULL,NULL,0),(2268,7,333,'Diana Turbay Cultivos',1,NULL,NULL,0),(2269,7,333,'El Bosque De Los Molinos (San Justin',1,NULL,NULL,0),(2270,7,333,'El Portal',1,NULL,NULL,0),(2271,7,333,'El Portal Ii Sector',1,NULL,NULL,0),(2272,7,333,'La Esperanza Alta',1,NULL,NULL,0),(2273,7,333,'La Marqueza',1,NULL,NULL,0),(2274,7,333,'La Paz',1,NULL,NULL,0),(2275,7,333,'La Paz  ( El Cebadal)',1,NULL,NULL,0),(2276,7,333,'La Picota Oriental',1,NULL,NULL,0),(2277,7,333,'La Reconquista',1,NULL,NULL,0),(2278,7,333,'La Reconquista  (Villa Esther)',1,NULL,NULL,0),(2279,7,333,'Los Arrayanes Ii',1,NULL,NULL,0),(2280,7,333,'Los Puentes',1,NULL,NULL,0),(2281,7,333,'Palermo Sur',1,NULL,NULL,0),(2282,7,333,'Palermo Sur  - Brisas',1,NULL,NULL,0),(2283,7,333,'Palermo Sur ( El Triangulo)',1,NULL,NULL,0),(2284,7,333,'Palermo Sur Los Arrayanes',1,NULL,NULL,0),(2285,7,333,'Palermo Sur Oswaldo Gomez',1,NULL,NULL,0),(2286,7,333,'Palermo Sur San Marcos',1,NULL,NULL,0),(2287,7,333,'Palermo Sur Sana Fonseca',1,NULL,NULL,0),(2288,7,333,'San Agustin',1,NULL,NULL,0),(2289,7,333,'San Agustin Ii Sector',1,NULL,NULL,0),(2290,7,333,'Serrania - Sector Cultivos',1,NULL,NULL,0),(2291,7,335,'Central De Mezclas',1,NULL,NULL,0),(2292,7,335,'Las Manas',1,NULL,NULL,0),(2293,7,335,'Mochuelo Oriental',1,NULL,NULL,0),(2294,7,335,'Vereda El Pedregal - La Lira',1,NULL,NULL,0),(2295,7,335,'Villa Jaqui',1,NULL,NULL,0),(2296,7,377,'Barranquitos ',1,NULL,NULL,0),(2297,7,377,'Brazuelos Santo Domingo',1,NULL,NULL,0),(2298,7,377,'Esmeralda',1,NULL,NULL,0),(2299,7,377,'Lagunitas',1,NULL,NULL,0),(2300,7,377,'Paticos',1,NULL,NULL,0),(2301,7,377,'El Mochuelo Ii',1,NULL,NULL,0),(2302,7,309,'Urbanizacion Guaitiquia',1,NULL,NULL,0),(2303,7,309,'Arborizadora Baja',1,NULL,NULL,0),(2304,7,309,'Atlanta',1,NULL,NULL,0),(2305,7,309,'Coruña',1,NULL,NULL,0),(2306,7,309,'El Chircal Sur',1,NULL,NULL,0),(2307,7,309,'El Esquinero',1,NULL,NULL,0),(2308,7,309,'La Playa',1,NULL,NULL,0),(2309,7,309,'La Playa Ii',1,NULL,NULL,0),(2310,7,309,'Madelena',1,NULL,NULL,0),(2311,7,309,'Rafel Escamilla',1,NULL,NULL,0),(2312,7,309,'Santa Helena ',1,NULL,NULL,0),(2313,7,309,'Santa Rosa Sur',1,NULL,NULL,0),(2314,7,309,'Urbanizacion Protecho Bogota ',1,NULL,NULL,0),(2315,7,309,'Urbanizacion Atlanta',1,NULL,NULL,0),(2316,7,309,'Urbanizacion Casa Larga',1,NULL,NULL,0),(2317,7,309,'Urbanizacion La Coruña',1,NULL,NULL,0),(2318,7,309,'Villa Helena',1,NULL,NULL,0),(2319,7,393,'Acacia Iii Parte Baja',1,NULL,NULL,0),(2320,7,393,'Acacias Sur',1,NULL,NULL,0),(2321,7,393,'Candelaria La Nueva',1,NULL,NULL,0),(2322,7,393,'Colmena',1,NULL,NULL,0),(2323,7,393,'Colmena Iii',1,NULL,NULL,0),(2324,7,393,'Gibraltar I Y Ii',1,NULL,NULL,0),(2325,7,393,'Juan J. Rondon - La Casona',1,NULL,NULL,0),(2326,7,393,'Juan Jose Rondon',1,NULL,NULL,0),(2327,7,393,'Las Acacias',1,NULL,NULL,0),(2328,7,393,'Millan Los Sauces',1,NULL,NULL,0),(2329,7,393,'Puerta Al Llano',1,NULL,NULL,0),(2330,7,393,'San Fernando',1,NULL,NULL,0),(2331,7,393,'San Francisco',1,NULL,NULL,0),(2332,7,393,'San Luis ',1,NULL,NULL,0),(2333,7,393,'Santa Ines La Acacia',1,NULL,NULL,0),(2334,7,393,'Sauces - Hortalizas- Recuerdo',1,NULL,NULL,0),(2335,7,393,'Candelaria La Nueva',1,NULL,NULL,0),(2336,7,393,'Villas De Bolivar',1,NULL,NULL,0),(2337,7,372,'Acacia Iv',1,NULL,NULL,0),(2338,7,372,'Alfa',1,NULL,NULL,0),(2339,7,372,'Altos De Jalisco',1,NULL,NULL,0),(2340,7,372,'Alvaro Bernal Segura',1,NULL,NULL,0),(2341,7,372,'Bella Flor',1,NULL,NULL,0),(2342,7,372,'Bella Flor Sur',1,NULL,NULL,0),(2343,7,372,'Bella Vista Lucero Alto',1,NULL,NULL,0),(2344,7,372,'Brisas Del Volador',1,NULL,NULL,0),(2345,7,372,'Buenavista Sector A',1,NULL,NULL,0),(2346,7,372,'Ciudad Milagros',1,NULL,NULL,0),(2347,7,372,'Compartir',1,NULL,NULL,0),(2348,7,372,'Cordillera Sur',1,NULL,NULL,0),(2349,7,372,'Domingo Lain I',1,NULL,NULL,0),(2350,7,372,'Domingo Lain Ii - El Bosque',1,NULL,NULL,0),(2351,7,372,'Domingo Lain Iii',1,NULL,NULL,0),(2352,7,372,'El Bosque',1,NULL,NULL,0),(2353,7,372,'El Castillo',1,NULL,NULL,0),(2354,7,372,'El Mirador',1,NULL,NULL,0),(2355,7,372,'El Paraiso',1,NULL,NULL,0),(2356,7,372,'El Satelite',1,NULL,NULL,0),(2357,7,372,'El Triunfo Sur',1,NULL,NULL,0),(2358,7,372,'Estrella Del Sur',1,NULL,NULL,0),(2359,7,372,'Florida Del Sur',1,NULL,NULL,0),(2360,7,372,'Gibraltar  Sur',1,NULL,NULL,0),(2361,7,372,'Gibraltar I Y Ii',1,NULL,NULL,0),(2362,7,372,'Juan Pablo Ii',1,NULL,NULL,0),(2363,7,372,'La Alameda',1,NULL,NULL,0),(2364,7,372,'La Alameda Ii Sector',1,NULL,NULL,0),(2365,7,372,'La Cabaña',1,NULL,NULL,0),(2366,7,372,'La Escala Iii',1,NULL,NULL,0),(2367,7,372,'La Esmeralda Sur',1,NULL,NULL,0),(2368,7,372,'La Estrella Sector Lagos ',1,NULL,NULL,0),(2369,7,372,'La Torre',1,NULL,NULL,0),(2370,7,372,'Las Delicias Del Sur',1,NULL,NULL,0),(2371,7,372,'Las Manitas',1,NULL,NULL,0),(2372,7,372,'Las Manitas Ii Sector',1,NULL,NULL,0),(2373,7,372,'Los Alpes',1,NULL,NULL,0),(2374,7,372,'Los Andes Sector 5 Nutibara',1,NULL,NULL,0),(2375,7,372,'Lucero Alto',1,NULL,NULL,0),(2376,7,372,'Lucero Bajo Corporacion San Isidro',1,NULL,NULL,0),(2377,7,372,'Lucero Bajo Sect.  La Conquista',1,NULL,NULL,0),(2378,7,372,'Lucero Medio',1,NULL,NULL,0),(2379,7,372,'Lucero Sur Bajo',1,NULL,NULL,0),(2380,7,372,'Marandu',1,NULL,NULL,0),(2381,7,372,'Meissen',1,NULL,NULL,0),(2382,7,372,'Mexico',1,NULL,NULL,0),(2383,7,372,'Mirador Nutibara',1,NULL,NULL,0),(2384,7,372,'Naciones Unidas - Chaparro',1,NULL,NULL,0),(2385,7,372,'Naciones Unidas - Sta Rosa',1,NULL,NULL,0),(2386,7,372,'Nueva Colombia',1,NULL,NULL,0),(2387,7,372,'Rocio Altos Del Sur',1,NULL,NULL,0),(2388,7,372,'San Luis Altos De Jalisco',1,NULL,NULL,0),(2389,7,372,'Tabor-Altaloma',1,NULL,NULL,0),(2390,7,372,'Tierra Linda',1,NULL,NULL,0),(2391,7,372,'Urbanizacion Compartir',1,NULL,NULL,0),(2392,7,372,'Urbanizacion El Preciso',1,NULL,NULL,0),(2393,7,372,'Urbanizacion Kalamary',1,NULL,NULL,0),(2394,7,372,'Urbanizacion La Alameda',1,NULL,NULL,0),(2395,7,372,'Urbanizacion La Escala',1,NULL,NULL,0),(2396,7,372,'Urbanizacion Las Quintas Del Sur',1,NULL,NULL,0),(2397,7,372,'Urbanizcion La Serrania Del Sur',1,NULL,NULL,0),(2398,7,372,'Villa Gloria',1,NULL,NULL,0),(2399,7,372,'Villa Gloria-Las Manitas',1,NULL,NULL,0),(2400,7,372,'Villas Del Diamante',1,NULL,NULL,0),(2401,7,372,'Villas Del Progreso',1,NULL,NULL,0),(2402,7,372,'Vista Hermosa ',1,NULL,NULL,0),(2403,7,372,'Vista Hermosa Mz.77A,79A,81A,82,82A,84A',1,NULL,NULL,0),(2404,7,372,'Vista Hermosa Sector Capri',1,NULL,NULL,0),(2405,7,372,'Vista Hermosa Sector San Carlos Y El Triangul',1,NULL,NULL,0),(2406,7,340,'Acapulco I',1,NULL,NULL,0),(2407,7,340,'Arabia',1,NULL,NULL,0),(2408,7,340,'Bogota Sector Tequendama',1,NULL,NULL,0),(2409,7,340,'Bogota Sur- La Esperanza',1,NULL,NULL,0),(2410,7,340,'Buenos Aires',1,NULL,NULL,0),(2411,7,340,'Buenos Aires Ii ',1,NULL,NULL,0),(2412,7,340,'Buenos Aires Iii Sector',1,NULL,NULL,0),(2413,7,340,'Casa De Teja',1,NULL,NULL,0),(2414,7,340,'Cedritos Del Sur',1,NULL,NULL,0),(2415,7,340,'Divino Niño',1,NULL,NULL,0),(2416,7,340,'El Consuelo',1,NULL,NULL,0),(2417,7,340,'El Minuto De Maria',1,NULL,NULL,0),(2418,7,340,'El Mochuelo',1,NULL,NULL,0),(2419,7,340,'El Recuerdo Sur',1,NULL,NULL,0),(2420,7,340,'El Reflejo Ii',1,NULL,NULL,0),(2421,7,340,'El Tesorito',1,NULL,NULL,0),(2422,7,340,'El Tesoro',1,NULL,NULL,0),(2423,7,340,'Eltrigal',1,NULL,NULL,0),(2424,7,340,'Florida Sur Alto',1,NULL,NULL,0),(2425,7,340,'Ines Elvira',1,NULL,NULL,0),(2426,7,340,'La Cumbre (Antes El Recuerdo Sur)',1,NULL,NULL,0),(2427,7,340,'Los Duques',1,NULL,NULL,0),(2428,7,340,'Minuto De Maria',1,NULL,NULL,0),(2429,7,340,'Monterrey',1,NULL,NULL,0),(2430,7,340,'Ocho De Diciembre',1,NULL,NULL,0),(2431,7,340,'Parcelacion Bogota',1,NULL,NULL,0),(2432,7,340,'Potreritos',1,NULL,NULL,0),(2433,7,340,'Quiba',1,NULL,NULL,0),(2434,7,340,'Quiba Urbano',1,NULL,NULL,0),(2435,7,340,'Republica De Venezuela',1,NULL,NULL,0),(2436,7,340,'Republica Del Canada',1,NULL,NULL,0),(2437,7,340,'Rincon Del Diamante ',1,NULL,NULL,0),(2438,7,340,'San Joaquin El Vaticano',1,NULL,NULL,0),(2439,7,340,'San Joaquin Vaticano-Galpon',1,NULL,NULL,0),(2440,7,340,'San Joaquin Vaticano-Vergel',1,NULL,NULL,0),(2441,7,340,'San Rafael Sur',1,NULL,NULL,0),(2442,7,340,'Sotavento',1,NULL,NULL,0),(2443,7,340,'Urbanizacion Buena Vista',1,NULL,NULL,0),(2444,7,340,'Urbanizacion Cerros Del Sur',1,NULL,NULL,0),(2445,7,340,'Urbanizacion Chicala',1,NULL,NULL,0),(2446,7,340,'Urbanizacion El Limonar',1,NULL,NULL,0),(2447,7,340,'Urbanizacion Mirador De San Carlos',1,NULL,NULL,0),(2448,7,340,'Urbanizacion Urapanes Del Sur',1,NULL,NULL,0),(2449,7,340,'Villa Diana Lopez',1,NULL,NULL,0),(2450,7,340,'Villas De San Joaquin',1,NULL,NULL,0),(2451,7,350,'Bella Estancia',1,NULL,NULL,0),(2452,7,350,'Barlovento',1,NULL,NULL,0),(2453,7,350,'Bonanza Sur',1,NULL,NULL,0),(2454,7,350,'Caracoli',1,NULL,NULL,0),(2455,7,350,'Casa Loma Ii',1,NULL,NULL,0),(2456,7,350,'Casagrande ',1,NULL,NULL,0),(2457,7,350,'Casaloma',1,NULL,NULL,0),(2458,7,350,'Casavianca',1,NULL,NULL,0),(2459,7,350,'Conjunto Residencial La Valvanera',1,NULL,NULL,0),(2460,7,350,'Cooperativa Ismael Perdomo',1,NULL,NULL,0),(2461,7,350,'El Cerro Del Diamante',1,NULL,NULL,0),(2462,7,350,'El Ensueño',1,NULL,NULL,0),(2463,7,350,'El Peñon Del Cortijo',1,NULL,NULL,0),(2464,7,350,'El Porvenir De La Estancia ',1,NULL,NULL,0),(2465,7,350,'El Porvenir Ii Etapa',1,NULL,NULL,0),(2466,7,350,'El Porvenir Zona C',1,NULL,NULL,0),(2467,7,350,'El Rincon Del Porvenir',1,NULL,NULL,0),(2468,7,350,'El Rosal',1,NULL,NULL,0),(2469,7,350,'Espinos I',1,NULL,NULL,0),(2470,7,350,'Espinos Iii Sector',1,NULL,NULL,0),(2471,7,350,'Galicia',1,NULL,NULL,0),(2472,7,350,'Ismael Perdomo',1,NULL,NULL,0),(2473,7,350,'La Carbonera',1,NULL,NULL,0),(2474,7,350,'La Carbonera Ii',1,NULL,NULL,0),(2475,7,350,'La Estancia ',1,NULL,NULL,0),(2476,7,350,'La Primavera',1,NULL,NULL,0),(2477,7,350,'La Union - Divino Niño',1,NULL,NULL,0),(2478,7,350,'Los Tres Reyes - I Etapa',1,NULL,NULL,0),(2479,7,350,'Maria Cano',1,NULL,NULL,0),(2480,7,350,'Mirador De La Estancia',1,NULL,NULL,0),(2481,7,350,'Mirador De La Primavera',1,NULL,NULL,0),(2482,7,350,'Peñon Del Cortijo Iii Sector ',1,NULL,NULL,0),(2483,7,350,'Perdomo Alto',1,NULL,NULL,0),(2484,7,350,'Primavera Sur-Occ. ',1,NULL,NULL,0),(2485,7,350,'Proyecto Rafael Escamilla',1,NULL,NULL,0),(2486,7,350,'Rincon De Galicia',1,NULL,NULL,0),(2487,7,350,'Rincon De La Estancia',1,NULL,NULL,0),(2488,7,350,'Rincon De La Valvanera',1,NULL,NULL,0),(2489,7,350,'San Antonio Del Mirador',1,NULL,NULL,0),(2490,7,350,'San Isidro',1,NULL,NULL,0),(2491,7,350,'San Isidro Ii',1,NULL,NULL,0),(2492,7,350,'San Isidro Sector Carboneras',1,NULL,NULL,0),(2493,7,350,'San Isidro Sector Cerrito I',1,NULL,NULL,0),(2494,7,350,'San Isidro Sector Cerrito Ii',1,NULL,NULL,0),(2495,7,350,'San Isidro Sector Cerrito Iii',1,NULL,NULL,0),(2496,7,350,'San Rafael  Del Alto De La Estancia',1,NULL,NULL,0),(2497,7,350,'Santa Viviana ',1,NULL,NULL,0),(2498,7,350,'Santa Viviana - Sect.Vista Hermosa',1,NULL,NULL,0),(2499,7,350,'Santo Domingo',1,NULL,NULL,0),(2500,7,350,'Sierra Morena',1,NULL,NULL,0),(2501,7,350,'Tres Reyes Ii Sector',1,NULL,NULL,0),(2502,7,350,'Urb. Balmoral Rincon De La Valvanera',1,NULL,NULL,0),(2503,7,350,'Urb. El Arroyuelo-Predio El Almacen',1,NULL,NULL,0),(2504,7,350,'Urb. El Ensueño',1,NULL,NULL,0),(2505,7,350,'Urb. Rincon De La Valvanera Mz.7',1,NULL,NULL,0),(2506,7,350,'Urbanizacion Balmoral Ii',1,NULL,NULL,0),(2507,7,350,'Urbanizacion Barlovento',1,NULL,NULL,0),(2508,7,350,'Urbanizacion Calabria',1,NULL,NULL,0),(2509,7,350,'Urbanizacion Galicia',1,NULL,NULL,0),(2510,7,350,'Urbanizacion India Catalina',1,NULL,NULL,0),(2511,7,350,'Urbanizacion La Estancia',1,NULL,NULL,0),(2512,7,350,'Urbanizacion La Llanada',1,NULL,NULL,0),(2513,7,350,'Urbanizacion La Riviera Del Sur',1,NULL,NULL,0),(2514,7,350,'Urbanizacion Las Huertas',1,NULL,NULL,0),(2515,7,350,'Urbanizacion Peñon Del Cortijo',1,NULL,NULL,0),(2516,7,352,'Arborizadora Alta',1,NULL,NULL,0),(2517,7,352,'Bellavista',1,NULL,NULL,0),(2518,7,352,'Empresa Comunitaria Manuela Beltran',1,NULL,NULL,0),(2519,7,352,'Florida Sur Alto',1,NULL,NULL,0),(2520,7,352,'Jerusalen',1,NULL,NULL,0),(2521,7,352,'Jerusalen Sector Bellavista - La Y',1,NULL,NULL,0),(2522,7,352,'Jerusalen Sector El Plan',1,NULL,NULL,0),(2523,7,352,'Jerusalen Sector La Isla',1,NULL,NULL,0),(2524,7,352,'Jerusalen Sector Las Brisas',1,NULL,NULL,0),(2525,7,352,'Jerusalen Sector Media Loma',1,NULL,NULL,0),(2526,7,352,'Jerusalen Sector Nueva Argentina',1,NULL,NULL,0),(2527,7,352,'Jerusalen Sector Paraiso',1,NULL,NULL,0),(2528,7,352,'Jerusalen Sector Plan Canteras',1,NULL,NULL,0),(2529,7,352,'Jerusalen Sector Potosi',1,NULL,NULL,0),(2530,7,352,'Jerusalen Sector Pradera - La Esperanza',1,NULL,NULL,0),(2531,7,352,'Jerusalen Sector Santa Rosita - Las Vegas',1,NULL,NULL,0),(2532,7,352,'Jerusalen Sector Tanque Laguna',1,NULL,NULL,0),(2533,7,352,'La Pradera',1,NULL,NULL,0),(2534,7,352,'Las Brisas',1,NULL,NULL,0),(2535,7,352,'Las Vegas De Potosi',1,NULL,NULL,0),(2536,7,352,'Potosi',1,NULL,NULL,0),(2537,7,352,'Urb. Bosques De Candelaria',1,NULL,NULL,0),(2538,7,352,'Urb. Candelaria La Nueva Ii Sector',1,NULL,NULL,0),(2539,7,352,'Urbanizacion La Milagrosa',1,NULL,NULL,0),(2540,7,352,'Verona',1,NULL,NULL,0),(2541,7,352,'Villa Candelaria Antes San Simon I, Ii Etapa',1,NULL,NULL,0),(2542,7,352,'Villas De Bolivar',1,NULL,NULL,0),(2543,7,357,'Buenos Aires',1,NULL,NULL,0),(2544,7,357,'Costa Rica',1,NULL,NULL,0),(2545,7,357,'Doña Liliana',1,NULL,NULL,0),(2546,7,357,'El Bosque Km. 11',1,NULL,NULL,0),(2547,7,357,'Juan Jose Rondon',1,NULL,NULL,0),(2548,7,357,'Juan Jose Rondon Ii Sector',1,NULL,NULL,0),(2549,7,357,'Juan Rey Sur',1,NULL,NULL,0),(2550,7,357,'La Cabaña',1,NULL,NULL,0),(2551,7,357,'La Esperanza',1,NULL,NULL,0),(2552,7,357,'La Flora Parcelacion San Pedro',1,NULL,NULL,0),(2553,7,357,'Las Violetas',1,NULL,NULL,0),(2554,7,357,'Los Arrayanes',1,NULL,NULL,0),(2555,7,357,'Los Soches',1,NULL,NULL,0),(2556,7,357,'Parcelacion San Pedro ',1,NULL,NULL,0),(2557,7,357,'Tihuaque',1,NULL,NULL,0),(2558,7,357,'Union',1,NULL,NULL,0),(2559,7,357,'Villa Diana',1,NULL,NULL,0),(2560,7,357,'Villa Rosita',1,NULL,NULL,0),(2561,7,332,'Alaska',1,NULL,NULL,0),(2562,7,332,'Arrayanes',1,NULL,NULL,0),(2563,7,332,'Danubio Azul',1,NULL,NULL,0),(2564,7,332,'Daza Sector Ii',1,NULL,NULL,0),(2565,7,332,'Duitama',1,NULL,NULL,0),(2566,7,332,'El Porvenir',1,NULL,NULL,0),(2567,7,332,'El Porvenir Ii Sector',1,NULL,NULL,0),(2568,7,332,'Fiscala Ii La Fortuna',1,NULL,NULL,0),(2569,7,332,'Fiscala Sector Centro ',1,NULL,NULL,0),(2570,7,332,'La Fiscala Los Tres Laureles',1,NULL,NULL,0),(2571,7,332,'La Fiscala Lote 16',1,NULL,NULL,0),(2572,7,332,'La Fiscala Lote 16A',1,NULL,NULL,0),(2573,7,332,'La Fiscala Sector Centro',1,NULL,NULL,0),(2574,7,332,'La Fiscala Sector Daza',1,NULL,NULL,0),(2575,7,332,'La Fiscala Sector Norte',1,NULL,NULL,0),(2576,7,332,'La Fiscala Sector Rodriguez',1,NULL,NULL,0),(2577,7,332,'La Morena I ',1,NULL,NULL,0),(2578,7,332,'La Morena Ii',1,NULL,NULL,0),(2579,7,332,'La Morena Ii (Sector Villa Sandra) ',1,NULL,NULL,0),(2580,7,332,'Morena Ii Sector Villa Sandra',1,NULL,NULL,0),(2581,7,332,'Nueva Esperanza',1,NULL,NULL,0),(2582,7,332,'San Martin',1,NULL,NULL,0),(2583,7,332,'Villa Neiza',1,NULL,NULL,0),(2584,7,332,'Picota Sur ',1,NULL,NULL,0),(2585,7,332,'Porvenir',1,NULL,NULL,0),(2586,7,347,'Almirante Padilla',1,NULL,NULL,0),(2587,7,347,'Altos Del Pino',1,NULL,NULL,0),(2588,7,347,'Arizona',1,NULL,NULL,0),(2589,7,347,'Barranquillita',1,NULL,NULL,0),(2590,7,347,'Benjamin Uribe',1,NULL,NULL,0),(2591,7,347,'Betania',1,NULL,NULL,0),(2592,7,347,'Betania Ii',1,NULL,NULL,0),(2593,7,347,'Bolonia*',1,NULL,NULL,0),(2594,7,347,'Bulevar Del Sur',1,NULL,NULL,0),(2595,7,347,'Casa Loma Ii',1,NULL,NULL,0),(2596,7,347,'Casa Rey',1,NULL,NULL,0),(2597,7,347,'Casaloma',1,NULL,NULL,0),(2598,7,347,'Compostela I',1,NULL,NULL,0),(2599,7,347,'Compostela Ii',1,NULL,NULL,0),(2600,7,347,'Compostela Iii',1,NULL,NULL,0),(2601,7,347,'El Bosque  ',1,NULL,NULL,0),(2602,7,347,'El Cortijo',1,NULL,NULL,0),(2603,7,347,'El Curubo',1,NULL,NULL,0),(2604,7,347,'El Jordan',1,NULL,NULL,0),(2605,7,347,'El Nevado',1,NULL,NULL,0),(2606,7,347,'El Pedregal',1,NULL,NULL,0),(2607,7,347,'El Recuerdo Sur',1,NULL,NULL,0),(2608,7,347,'El Refugio',1,NULL,NULL,0),(2609,7,347,'El Refugio Sector Santa Librada',1,NULL,NULL,0),(2610,7,347,'El Rosal-Mirador',1,NULL,NULL,0),(2611,7,347,'El Rubi Ii Sector',1,NULL,NULL,0),(2612,7,347,'Gran Yomasa I',1,NULL,NULL,0),(2613,7,347,'Gran Yomasa Ii Sector',1,NULL,NULL,0),(2614,7,347,'La Andrea',1,NULL,NULL,0),(2615,7,347,'La Aurora ',1,NULL,NULL,0),(2616,7,347,'La Cabaña',1,NULL,NULL,0),(2617,7,347,'La Esperanza',1,NULL,NULL,0),(2618,7,347,'La Fortaleza',1,NULL,NULL,0),(2619,7,347,'La Regadera Km. 11',1,NULL,NULL,0),(2620,7,347,'La Regadera Sur',1,NULL,NULL,0),(2621,7,347,'Las Granjas De San Pedro (Santa Librada)',1,NULL,NULL,0),(2622,7,347,'Las Viviendas',1,NULL,NULL,0),(2623,7,347,'Los Tejares Sur Ii Sector',1,NULL,NULL,0),(2624,7,347,'Nuevo San Andres De Los Altos ',1,NULL,NULL,0),(2625,7,347,'Olivares',1,NULL,NULL,0),(2626,7,347,'Salazar Salazar',1,NULL,NULL,0),(2627,7,347,'San Andres Alto',1,NULL,NULL,0),(2628,7,347,'San Felipe',1,NULL,NULL,0),(2629,7,347,'San Isidro Sur',1,NULL,NULL,0),(2630,7,347,'San Juan Bautista',1,NULL,NULL,0),(2631,7,347,'San Juan I Sector',1,NULL,NULL,0),(2632,7,347,'San Juan Ii Sector',1,NULL,NULL,0),(2633,7,347,'San Juan Ii Y Iii Sector',1,NULL,NULL,0),(2634,7,347,'San Librada Los Tejares',1,NULL,NULL,0),(2635,7,347,'San Luis',1,NULL,NULL,0),(2636,7,347,'San Pablo',1,NULL,NULL,0),(2637,7,347,'Santa Librada',1,NULL,NULL,0),(2638,7,347,'Santa Librada La Esperanza',1,NULL,NULL,0),(2639,7,347,'Santa Librada La Sureña',1,NULL,NULL,0),(2640,7,347,'Santa Librada Los Tejares (Gran Yomasa) ',1,NULL,NULL,0),(2641,7,347,'Santa Librada Norte',1,NULL,NULL,0),(2642,7,347,'Santa Librada S. San Bernardino',1,NULL,NULL,0),(2643,7,347,'Santa Librada S. San Francisco',1,NULL,NULL,0),(2644,7,347,'Santa Librada Salazar Salazar',1,NULL,NULL,0),(2645,7,347,'Santa Librada Sector La Peña',1,NULL,NULL,0),(2646,7,347,'Santa Marta Ii Sector',1,NULL,NULL,0),(2647,7,347,'Santa Martha',1,NULL,NULL,0),(2648,7,347,'Santa Martha Ii',1,NULL,NULL,0),(2649,7,347,'Sierra Morena',1,NULL,NULL,0),(2650,7,347,'Tenerife Ii Sector ',1,NULL,NULL,0),(2651,7,347,'Urb. Costa Rica Barrio San Andres De Los Alto',1,NULL,NULL,0),(2652,7,347,'Urbanizacion Brasilia Ii Sector ',1,NULL,NULL,0),(2653,7,347,'Urbanizacion Brasilia Sur ',1,NULL,NULL,0),(2654,7,347,'Urbanizacion Cartagena ',1,NULL,NULL,0),(2655,7,347,'Urbanizacion La Andrea ',1,NULL,NULL,0),(2656,7,347,'Urbanizacion La Aurora Ii Etapa ',1,NULL,NULL,0),(2657,7,347,'Urbanizacion Miravalle ',1,NULL,NULL,0),(2658,7,347,'Urbanizacion Tequendama ',1,NULL,NULL,0),(2659,7,347,'Vianey',1,NULL,NULL,0),(2660,7,347,'Villa Alejandria',1,NULL,NULL,0),(2661,7,347,'Villa Nelly',1,NULL,NULL,0),(2662,7,347,'Villas De Santa Isabel-P.Entre Nubes',1,NULL,NULL,0),(2663,7,347,'Villas Del Eden',1,NULL,NULL,0),(2664,7,347,'Yomasita',1,NULL,NULL,0),(2665,7,329,'Alfonso Lopez Sector Charala',1,NULL,NULL,0),(2666,7,329,'Antonio Jose De Sucre',1,NULL,NULL,0),(2667,7,329,'Antonio Jose De Sucre I',1,NULL,NULL,0),(2668,7,329,'Antonio Jose De Sucre Ii',1,NULL,NULL,0),(2669,7,329,'Antonio Jose De Sucre Iii',1,NULL,NULL,0),(2670,7,329,'Bellavista Alta',1,NULL,NULL,0),(2671,7,329,'Bellavista Ii Sector',1,NULL,NULL,0),(2672,7,329,'Bosque El Limonar',1,NULL,NULL,0),(2673,7,329,'Bosque El Limonar Ii Sector',1,NULL,NULL,0),(2674,7,329,'Brazuelos',1,NULL,NULL,0),(2675,7,329,'Brazuelos Occidental*',1,NULL,NULL,0),(2676,7,329,'Brazuelos Sector El Paraiso',1,NULL,NULL,0),(2677,7,329,'Brazuelos Sector La Esmeralda',1,NULL,NULL,0),(2678,7,329,'Centro Educativo San Jose ',1,NULL,NULL,0),(2679,7,329,'Chapinerito',1,NULL,NULL,0),(2680,7,329,'Chico Sur',1,NULL,NULL,0),(2681,7,329,'Chico Sur Ii Sector',1,NULL,NULL,0),(2682,7,329,'Ciudadela Canta Rana I, Ii, Iii Sector ',1,NULL,NULL,0),(2683,7,329,'Comuneros',1,NULL,NULL,0),(2684,7,329,'El Brillante',1,NULL,NULL,0),(2685,7,329,'El Espino',1,NULL,NULL,0),(2686,7,329,'El Mortiño',1,NULL,NULL,0),(2687,7,329,'El Rubi',1,NULL,NULL,0),(2688,7,329,'El Tuno',1,NULL,NULL,0),(2689,7,329,'El Uval',1,NULL,NULL,0),(2690,7,329,'El Virrey Ultima Etapa',1,NULL,NULL,0),(2691,7,329,'Finca La Esperanza',1,NULL,NULL,0),(2692,7,329,'La Esmeralda El Recuerdo',1,NULL,NULL,0),(2693,7,329,'La Esperanza Km. 10',1,NULL,NULL,0),(2694,7,329,'Las Brisas',1,NULL,NULL,0),(2695,7,329,'Las Flores',1,NULL,NULL,0),(2696,7,329,'Las Mercedes',1,NULL,NULL,0),(2697,7,329,'Lorenzo Alcantuz I Sector',1,NULL,NULL,0),(2698,7,329,'Lorenzo Alcantuz Ii Sector',1,NULL,NULL,0),(2699,7,329,'Los Altos Del Brazuelo',1,NULL,NULL,0),(2700,7,329,'Marichuela Iii Sector (Cafam Ii S.)',1,NULL,NULL,0),(2701,7,329,'Monteblanco',1,NULL,NULL,0),(2702,7,329,'Montevideo',1,NULL,NULL,0),(2703,7,329,'Nuevo San Luis',1,NULL,NULL,0),(2704,7,329,'San Joaquin El Uval',1,NULL,NULL,0),(2705,7,329,'Sector Granjas De San Pedro',1,NULL,NULL,0),(2706,7,329,'Tenerife',1,NULL,NULL,0),(2707,7,329,'Tenerife Ii Sector',1,NULL,NULL,0),(2708,7,329,'Urbanizacion Chuniza I ',1,NULL,NULL,0),(2709,7,329,'Urbanizacion Jaron Monte Rubio ',1,NULL,NULL,0),(2710,7,329,'Urbanizacion Jaron Monte Rubio Ii',1,NULL,NULL,0),(2711,7,329,'Urbanizacion Jaron Monte Rubio Iii',1,NULL,NULL,0),(2712,7,329,'Urbanizacion Libano ',1,NULL,NULL,0),(2713,7,329,'Urbanizacion Marichuela',1,NULL,NULL,0),(2714,7,329,'Usminia',1,NULL,NULL,0),(2715,7,329,'Villa Alemania',1,NULL,NULL,0),(2716,7,329,'Villa Alemania Ii Sector',1,NULL,NULL,0),(2717,7,329,'Villa Anita Sur ',1,NULL,NULL,0),(2718,7,329,'Villa Israel ',1,NULL,NULL,0),(2719,7,329,'Villa Israel Ii ',1,NULL,NULL,0),(2720,7,306,'Alfonso Lopez Sector Buenos Aires ',1,NULL,NULL,0),(2721,7,306,'Alfonso Lopez Sector Charala ',1,NULL,NULL,0),(2722,7,306,'Alfonso Lopez Sector El Progreso ',1,NULL,NULL,0),(2723,7,306,'Brisas Del Llano ',1,NULL,NULL,0),(2724,7,306,'El Nuevo Portal',1,NULL,NULL,0),(2725,7,306,'El Paraiso ',1,NULL,NULL,0),(2726,7,306,'El Portal Del Divino',1,NULL,NULL,0),(2727,7,306,'El Portal Ii Etapa ',1,NULL,NULL,0),(2728,7,306,'El Progreso Usme',1,NULL,NULL,0),(2729,7,306,'El Refugio I Y Ii ',1,NULL,NULL,0),(2730,7,306,'El Triangulo ',1,NULL,NULL,0),(2731,7,306,'El Uval ',1,NULL,NULL,0),(2732,7,306,'El Uval Ii Sector ',1,NULL,NULL,0),(2733,7,306,'La Huerta ',1,NULL,NULL,0),(2734,7,306,'La Orquidea Usme',1,NULL,NULL,0),(2735,7,306,'La Reforma',1,NULL,NULL,0),(2736,7,306,'Nuevo Porvenir (59)',1,NULL,NULL,0),(2737,7,306,'Nuevo Progreso-El Progreso Ii Sector ',1,NULL,NULL,0),(2738,7,306,'Portal De La Vega ',1,NULL,NULL,0),(2739,7,306,'Portal De Oriente ',1,NULL,NULL,0),(2740,7,306,'Portal Del Divino ',1,NULL,NULL,0),(2741,7,306,'Puerta Al Llano ',1,NULL,NULL,0),(2742,7,306,'Puerta Al Llano Ii',1,NULL,NULL,0),(2743,7,306,'Refugio I',1,NULL,NULL,0),(2744,7,306,'Villa Hermosa ',1,NULL,NULL,0),(2745,7,381,'Arrayanes',1,NULL,NULL,0),(2746,7,381,'Bolonia',1,NULL,NULL,0),(2747,7,381,'El Bosque Central',1,NULL,NULL,0),(2748,7,381,'El Nuevo Portal Ii',1,NULL,NULL,0),(2749,7,381,'El Refugio I',1,NULL,NULL,0),(2750,7,381,'La Esperanza Sur',1,NULL,NULL,0),(2751,7,381,'Los Olivares',1,NULL,NULL,0),(2752,7,381,'Pepinitos',1,NULL,NULL,0),(2753,7,381,'Tocaimita Oriental',1,NULL,NULL,0),(2754,7,381,'Tocaimita Sur',1,NULL,NULL,0),(2755,7,324,'Ciudadela El Oasis',1,NULL,NULL,0),(2756,7,324,'Brisas Del Llano',1,NULL,NULL,0),(2757,7,324,'Centro Usme',1,NULL,NULL,0),(2758,7,324,'El Bosque Km 11',1,NULL,NULL,0),(2759,7,324,'El Oasis',1,NULL,NULL,0),(2760,7,324,'El Pedregal La Lira ',1,NULL,NULL,0),(2761,7,324,'El Salteador',1,NULL,NULL,0),(2762,7,324,'La Maria',1,NULL,NULL,0),(2763,4,250,'MEDELLIN',1,NULL,NULL,0),(2765,4,271,'CUCUTA',1,NULL,NULL,0),(2766,4,276,'BUCARAMANGA',1,NULL,NULL,0);

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perfil_id` int(11) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `nombre_usuario` varchar(45) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `administrador` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_registro` datetime DEFAULT NULL,
  `codigo_activacion` tinytext,
  `recuperar_password` text,
  `fecha_creacion` datetime DEFAULT NULL,
  `autenticado` int(11) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `numero_documento` varchar(45) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `cargo_id` int(11) DEFAULT NULL,
  `informa_a_id` int(11) DEFAULT NULL,
  `fecha_vinculacion` date DEFAULT NULL,
  `registro_vacaciones` text,
  `fecha_retiro` date DEFAULT NULL,
  `carpeta_t_h` varchar(145) DEFAULT NULL,
  `arl_id` int(11) DEFAULT NULL,
  `eps_id` int(11) DEFAULT NULL,
  `afp_id` int(11) DEFAULT NULL,
  `tipo_contrato_id` int(11) DEFAULT NULL,
  `persona_contacto` varchar(145) DEFAULT NULL,
  `celular_contacto` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_perfil1_idx` (`perfil_id`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

insert  into `usuario`(`id`,`perfil_id`,`nombres`,`apellidos`,`nombre_usuario`,`correo`,`administrador`,`fecha_registro`,`codigo_activacion`,`recuperar_password`,`fecha_creacion`,`autenticado`,`avatar`,`fecha_modificacion`,`activo`,`eliminado`,`numero_documento`,`area_id`,`cargo_id`,`informa_a_id`,`fecha_vinculacion`,`registro_vacaciones`,`fecha_retiro`,`carpeta_t_h`,`arl_id`,`eps_id`,`afp_id`,`tipo_contrato_id`,`persona_contacto`,`celular_contacto`) values (1,1,'Administrador','Sistema 360','admin','jesus.ramos@soluciones360grados.com',1,NULL,NULL,NULL,'2015-05-12 00:00:00',0,'admin_1.jpg','2016-10-14 11:39:43',1,0,'45454512313',NULL,NULL,NULL,'2016-09-08','Registro Vacaciones',NULL,NULL,102,120,112,124,'Datos Personales','34534612312'),(5,1,'Javier','López','javier.lopez','crmloar@gmail.com',0,NULL,NULL,NULL,'2016-09-25 22:15:29',NULL,'javier.lopez_5.png','2016-10-04 21:04:43',1,0,'74381474',NULL,NULL,NULL,'2016-09-25',NULL,'2016-09-29','http://hola.com',101,117,111,124,'Natalia Ariza','3115115121'),(7,1,'ALEXANDRA','CASTRO','comercial','comercial@audiovisuales.in',0,NULL,NULL,NULL,'2016-11-02 20:09:20',NULL,NULL,NULL,1,0,'52491009',NULL,NULL,NULL,'1996-01-01',NULL,NULL,NULL,108,118,113,124,'Rodolfo Caicedo','3157029660');

/*Table structure for table `view_categoria` */

DROP TABLE IF EXISTS `view_categoria`;

/*!50001 DROP VIEW IF EXISTS `view_categoria` */;
/*!50001 DROP TABLE IF EXISTS `view_categoria` */;

/*!50001 CREATE TABLE  `view_categoria`(
 `id` varchar(71) ,
 `id_general` varchar(11) ,
 `activo` varchar(29) ,
 `categoria_padre` varchar(333)
)*/;

/*Table structure for table `view_ubicacion` */

DROP TABLE IF EXISTS `view_ubicacion`;

/*!50001 DROP VIEW IF EXISTS `view_ubicacion` */;
/*!50001 DROP TABLE IF EXISTS `view_ubicacion` */;

/*!50001 CREATE TABLE  `view_ubicacion`(
 `id` varchar(59) ,
 `ubicacion` varchar(189) ,
 `nombre_barrio` varchar(45)
)*/;

/*Table structure for table `vista_ubicacion` */

DROP TABLE IF EXISTS `vista_ubicacion`;

/*!50001 DROP VIEW IF EXISTS `vista_ubicacion` */;
/*!50001 DROP TABLE IF EXISTS `vista_ubicacion` */;

/*!50001 CREATE TABLE  `vista_ubicacion`(
 `id` varchar(59) ,
 `ubicacion` varchar(189) ,
 `nombre_barrio` varchar(45)
)*/;

/*View structure for view view_categoria */

/*!50001 DROP TABLE IF EXISTS `view_categoria` */;
/*!50001 DROP VIEW IF EXISTS `view_categoria` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`desarrollo`@`%` SQL SECURITY DEFINER VIEW `view_categoria` AS (select concat(ifnull(concat(`c7`.`id`),''),ifnull(concat('-',`c6`.`id`),''),ifnull(concat('-',`c5`.`id`),''),ifnull(concat('-',`c4`.`id`),''),ifnull(concat('-',`c3`.`id`),''),ifnull(concat('-',`c2`.`id`),'')) AS `id`,ifnull(concat(`c7`.`id`),'') AS `id_general`,concat(ifnull(concat(`c7`.`activo`),''),ifnull(concat('-',`c6`.`activo`),''),ifnull(concat('-',`c5`.`activo`),''),ifnull(concat('-',`c4`.`activo`),''),ifnull(concat('-',`c3`.`activo`),''),ifnull(concat('-',`c2`.`activo`),'')) AS `activo`,concat(ifnull(concat(`c7`.`referencia`),''),ifnull(concat(' - ',`c6`.`referencia`),''),ifnull(concat(' - ',`c5`.`referencia`),''),ifnull(concat(' - ',`c4`.`referencia`),''),ifnull(concat(' - ',`c3`.`referencia`),''),ifnull(concat(' - ',`c2`.`referencia`),''),ifnull(concat(' - ',`c1`.`referencia`),'')) AS `categoria_padre` from (`categoria` `c7` left join (`categoria` `c6` left join (`categoria` `c5` left join (`categoria` `c4` left join (`categoria` `c3` left join (`categoria` `c2` left join `categoria` `c1` on(((`c2`.`categoria_padre_id` = `c1`.`id`) and (`c1`.`activo` = 1)))) on(((`c3`.`categoria_padre_id` = `c2`.`id`) and (`c2`.`activo` = 1)))) on(((`c4`.`categoria_padre_id` = `c3`.`id`) and (`c3`.`activo` = 1)))) on((`c5`.`categoria_padre_id` = `c4`.`id`))) on((`c6`.`categoria_padre_id` = `c5`.`id`))) on((`c7`.`categoria_padre_id` = `c6`.`id`))) where (not((concat(ifnull(concat(`c7`.`activo`),''),ifnull(concat('-',`c6`.`activo`),''),ifnull(concat('-',`c5`.`activo`),''),ifnull(concat('-',`c4`.`activo`),''),ifnull(concat('-',`c3`.`activo`),''),ifnull(concat('-',`c2`.`activo`),'')) like '%0%')))) */;

/*View structure for view view_ubicacion */

/*!50001 DROP TABLE IF EXISTS `view_ubicacion` */;
/*!50001 DROP VIEW IF EXISTS `view_ubicacion` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_ubicacion` AS (select concat(ifnull(concat(`u2`.`id`),''),ifnull(concat('-',`u3`.`id`),''),ifnull(concat('-',`u4`.`id`),''),ifnull(concat('-',`u5`.`id`),''),ifnull(concat('-',`u7`.`id`),'')) AS `id`,concat(ifnull(concat(`u3`.`nombre`),''),ifnull(concat(' - ',`u4`.`nombre`),''),ifnull(concat(' - ',`u5`.`nombre`),''),ifnull(concat(' - ',`u7`.`nombre`),'')) AS `ubicacion`,`u7`.`nombre` AS `nombre_barrio` from ((((((`ubicacion` `u` join `ubicacion` `u2` on((`u2`.`ubicacion_padre_id` = `u`.`id`))) join `ubicacion` `u3` on((`u3`.`ubicacion_padre_id` = `u2`.`id`))) left join `ubicacion` `u4` on((`u4`.`ubicacion_padre_id` = `u3`.`id`))) left join `ubicacion` `u5` on((`u5`.`ubicacion_padre_id` = `u4`.`id`))) left join `ubicacion` `u6` on((`u6`.`ubicacion_padre_id` = `u5`.`id`))) left join `ubicacion` `u7` on((`u7`.`ubicacion_padre_id` = `u6`.`id`)))) */;

/*View structure for view vista_ubicacion */

/*!50001 DROP TABLE IF EXISTS `vista_ubicacion` */;
/*!50001 DROP VIEW IF EXISTS `vista_ubicacion` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`s360`@`%` SQL SECURITY DEFINER VIEW `vista_ubicacion` AS (select concat(ifnull(concat(`u2`.`id`),''),ifnull(concat('-',`u3`.`id`),''),ifnull(concat('-',`u4`.`id`),''),ifnull(concat('-',`u5`.`id`),''),ifnull(concat('-',`u7`.`id`),'')) AS `id`,concat(ifnull(concat(`u3`.`nombre`),''),ifnull(concat(' - ',`u4`.`nombre`),''),ifnull(concat(' - ',`u5`.`nombre`),''),ifnull(concat(' - ',`u7`.`nombre`),'')) AS `ubicacion`,`u7`.`nombre` AS `nombre_barrio` from ((((((`ubicacion` `u` join `ubicacion` `u2` on((`u2`.`ubicacion_padre_id` = `u`.`id`))) join `ubicacion` `u3` on((`u3`.`ubicacion_padre_id` = `u2`.`id`))) join `ubicacion` `u4` on((`u4`.`ubicacion_padre_id` = `u3`.`id`))) left join `ubicacion` `u5` on((`u5`.`ubicacion_padre_id` = `u4`.`id`))) left join `ubicacion` `u6` on((`u6`.`ubicacion_padre_id` = `u5`.`id`))) left join `ubicacion` `u7` on((`u7`.`ubicacion_padre_id` = `u6`.`id`)))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
