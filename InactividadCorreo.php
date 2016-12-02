<?php

function tiempoTranscurrido($fecha) {

    $hasta = date('Y-m-d H:i:s');
    $desde = $fecha;
    $datetime1 = new DateTime($desde);
    $datetime2 = new DateTime($hasta);
    # obtenemos la diferencia entre las dos fechas
    $interval = $datetime2->diff($datetime1);
    return $interval;
  }
  
require_once 'base/librerias/php/php-mailer/class.phpmailer.php';
// Conectando, seleccionando la base de datos
$link = mysql_connect('bihispano.com', 'desarrollo', 'desarroll0')
    or die('No se pudo conectar: ' . mysql_error());
echo 'Connected successfully';
mysql_select_db('nicecrm_soluciones_audiovisiales') or die('No se pudo seleccionar la base de datos');
$query = "SELECT 
  `contacto`.`id`,
  `actividad`.`id` AS bandera,
  IFNULL(
    `actividad`.`id`,
    `contacto`.`fecha_creacion`
  ) AS Fecha_inicio,
  CONCAT(
    `contacto`.`nombres`,
    ' ',
    `contacto`.`apellidos`
  ) AS Nombre_Contacto,
  CONCAT(
    `usuario`.`nombres`,
    ' ',
    `usuario`.`apellidos`
  ) AS Nombre_Asesor,
  `usuario`.`correo`,
  IFNULL(
    MAX(
      `actividad`.`fecha_modificacion`
    ),
    MAX(`actividad`.`fecha_creacion`)
  ) AS Fecha 
FROM
  `contacto` 
  LEFT JOIN `contacto_actividad` 
    ON contacto.`id` = `contacto_actividad`.`contacto_id` 
  LEFT JOIN `actividad` 
    ON `contacto_actividad`.`actividad_id` = `actividad`.`id` 
  INNER JOIN `usuario` 
    ON `contacto`.`asesor_id` = `usuario`.`id` 
GROUP BY contacto.`id` 
ORDER BY `actividad`.`fecha_creacion` DESC";

$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());

// Construir el correo en HTML
echo "";
$correos = array();

while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
  if($line['bandera'] == ''){
      $tiempo = tiempoTranscurrido($line['Fecha_inicio']); 
   }
   else{
      $tiempo = tiempoTranscurrido($line['Fecha']); 
   }
   if($tiempo->days > 15) {
   $registro = "<tr>";
   $index = $line['correo'].'-'.$line['Nombre_Asesor'];
   
   $line['tiempo'] = $tiempo->days;
   $registro .= '<td><a href="http://localhost/soluciones_audiovisuales/index.php?modulo=contactos&accion=editar&registro='.$line['id'].'">'.$line['Nombre_Contacto'].'</a></td>';
   $registro .= '<td style="text-align: center;">'.$line['tiempo'].'</td>';
   $registro .= "</tr>";
   $correos[$index] .= $registro; }
}
//die(print_r($correos));
$body = '';

foreach($correos as $key => $value){
   $bandera = 0;
  $datos = explode("-", $key);
  $body = '<div style="position: relative; display: block; margin: 0px auto; width: 700px; border: 1px #007BA6 solid;">
    <h3 style="display: block; text-align: center; color: #FFFFFF; background-color: #007BA6; padding: 10px 0px; margin: 0px;">
        Recordatorio de Inactividad
    </h3>
    <div style="padding: 10px; width: 95%; ">

      <p>Estim@ '.$datos[1].' estos son los contactos que tienen mas de 15 dias de inactividad en el sistema:</p><br><br><table width="80%" style="font-size: 15px;"><tr style="font-weight: bold;"><td>Nombre del Contacto</td><td style="text-align: center;">Inactividad (Días)</td></tr>'.$value.'</table>
      
    <br>';
     
try {
    $mail = new PHPMailer(true);
    $mail->IsMail();
    $mail->SMTPDebug = 0;
    $mail->CharSet = "UTF-8";
    $mail->Mailer = "smtp";
    $mail->Port = 587;
    $mail->Host = "smtp.powweb.com";
    $mail->SMTPAuth = true;
    $mail->Username = "jesus.ramos@soluciones360.co"; 
    $mail->Password = "Jesus1234";
    $mail->FromName = "Soluciones Audiovisuales";
    $mail->Timeout=30;
    $mail->isHTML(true);
    $mail->From = "Noreply@SolucionesAudiovisuales.com";
    $mail->Subject = 'Recordatorio de Inactividad';
    $mail->Body = $body;
    $mail->AddAddress($datos[0]);
    $mail->Send();
} catch (Exception $e) {
    echo $e->getMessage();
}
}
// Liberar resultados
mysql_free_result($result);

// Cerrar la conexión
mysql_close($link);

