<?php

require_once 'base/librerias/php/php-mailer/class.phpmailer.php';
// Conectando, seleccionando la base de datos
$link = mysql_connect('bihispano.com', 'desarrollo', 'desarroll0')
    or die('No se pudo conectar: ' . mysql_error());
echo 'Connected successfully';
mysql_select_db('nicecrm_soluciones_audiovisiales') or die('No se pudo seleccionar la base de datos');

$query = "SELECT 
  cp.nombre_empresa AS Nombre_empresa,
  cp.nombres AS Nombre_cliente,
  cp.apellidos AS Apellido_cliente,
  cp.fecha_nacimiento AS Fecha_nacimiento,
  co.correo AS Correo,
(SELECT 
  t.`numero` 
FROM
  cliente_potencial_telefono AS ct 
  INNER JOIN nicecrm_soluciones_audiovisiales.telefono AS t 
    ON ct.telefono_id = t.id 
WHERE ct.cliente_potencial_id = cp.id 
LIMIT 0, 1) AS Telefono,

  u.id AS Id_asesor,
  u.nombres AS Nombre_asesor,
  u.apellidos AS Apellido_asesor,
  u.correo AS Correo_asesor
FROM
  nicecrm_soluciones_audiovisiales.cliente_potencial AS cp 
  
  INNER JOIN nicecrm_soluciones_audiovisiales.usuario AS u 
    ON cp.asesor_id = u.id 
  LEFT JOIN nicecrm_soluciones_audiovisiales.cliente_potencial_correo AS cc 
    ON cp.id = cc.cliente_potencial_id 
  LEFT JOIN nicecrm_soluciones_audiovisiales.correo AS co 
    ON cc.correo_id = co.id AND co.principal = 1 
  
WHERE cp.fecha_nacimiento BETWEEN CONCAT(
    '2016-',
    IF(
      MONTH(CURRENT_DATE) < 10,
      CONCAT('0', MONTH(CURRENT_DATE)),
      MONTH(CURRENT_DATE)
    ),
    '-',
    DAY(CURRENT_DATE)
  ) 
  AND DATE_ADD(
    CONCAT(
      '2016-',
      IF(
        MONTH(CURRENT_DATE) < 10,
        CONCAT('0', MONTH(CURRENT_DATE)),
        MONTH(CURRENT_DATE)
      ),
      '-',
      DAY(CURRENT_DATE)
    ),
    INTERVAL 7 DAY
  ) 
  AND cp.activo = 1 
  AND cp.convertido = 0 
ORDER BY fecha_nacimiento ASC ";

$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());

$query2 = "SELECT 
  c.nombre_comercial,
  co.nombres AS Nombre_cliente,
  co.apellidos AS Apellido_cliente,
  co.fecha_nacimiento AS Fecha_nacimiento,
  cor.correo AS Correo,
  (SELECT 
    t.`numero` 
  FROM
    contacto_telefono AS ct 
    INNER JOIN nicecrm_soluciones_audiovisiales.telefono AS t 
      ON ct.telefono_id = t.id 
  WHERE ct.contacto_id = co.id 
  LIMIT 0, 1) AS Telefono,
  u.id AS Id_asesor,
  u.nombres AS Nombre_asesor,
  u.apellidos AS Apellido_asesor,
  u.correo AS Correo_asesor 
FROM
  nicecrm_soluciones_audiovisiales.contacto AS co 
  INNER JOIN nicecrm_soluciones_audiovisiales.usuario AS u 
    ON co.asesor_id = u.id 
  INNER JOIN nicecrm_soluciones_audiovisiales.cuenta AS c 
    ON co.cuenta_id = c.id 
  LEFT JOIN nicecrm_soluciones_audiovisiales.contacto_correo AS cc 
    ON co.id = cc.contacto_id 
  LEFT JOIN nicecrm_soluciones_audiovisiales.correo AS cor 
    ON cc.correo_id = cor.id 
    AND cor.principal = 1 
WHERE co.fecha_nacimiento BETWEEN CONCAT(
    '2016-',
    IF(
      MONTH(CURRENT_DATE) < 10,
      CONCAT('0', MONTH(CURRENT_DATE)),
      MONTH(CURRENT_DATE)
    ),
    '-',
    DAY(CURRENT_DATE)
  ) 
  AND DATE_ADD(
    CONCAT(
      '2016-',
      IF(
        MONTH(CURRENT_DATE) < 10,
        CONCAT('0', MONTH(CURRENT_DATE)),
        MONTH(CURRENT_DATE)
      ),
      '-',
      DAY(CURRENT_DATE)
    ),
    INTERVAL 7 DAY
  ) 
  AND co.activo = 1 
ORDER BY fecha_nacimiento ASC ";

$result2 = mysql_query($query2) or die('Consulta fallida: ' . mysql_error());

// Construir el correo en HTML
echo "";
$correos = array();
$correos2 = array();


while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
  $registro = "\t<tr>\n";
   $index = $line['Correo_asesor'].'-'.$line['Nombre_asesor'].' '.$line['Apellido_asesor'];
   unset($line['Id_asesor']);
   unset($line['Correo_asesor']);
   unset($line['Nombre_asesor']);
   unset($line['Apellido_asesor']);
   $fecha = explode("-", $line['Fecha_nacimiento']);
   $line['Fecha_nacimiento'] = $fecha[2].'-'.$fecha[1];
   foreach ($line as $col_value) {
      $registro .= "\t\t<td>$col_value</td>\n";
   }
   $registro .= "\t</tr>\n";
   $correos[$index] .= $registro;
}
while ($line = mysql_fetch_array($result2, MYSQL_ASSOC)) {
  $registro = "\t<tr>\n";
   $index = $line['Correo_asesor'].'-'.$line['Nombre_asesor'].' '.$line['Apellido_asesor'];
   unset($line['Id_asesor']);
   unset($line['Correo_asesor']);
   unset($line['Nombre_asesor']);
   unset($line['Apellido_asesor']);
   $fecha = explode("-", $line['Fecha_nacimiento']);
   $line['Fecha_nacimiento'] = $fecha[2].'-'.$fecha[1];
   foreach ($line as $col_value) {
      $registro .= "\t\t<td>$col_value</td>\n";
   }
   $registro .= "\t</tr>\n";
   $correos2[$index] .= $registro;
}
$body = '';
foreach($correos as $key => $value){
   $bandera = 0;
   foreach($correos2 as $key2 => $value2) {
      if($key === $key2) {
      $bandera++;
  $datos = explode("-", $key);
  $body = '<div style="position: relative; display: block; margin: 0px auto; width: 800px; border: 1px #007BA6 solid;">
    <h2 style="display: block; text-align: center; color: #FFFFFF; background-color: #007BA6; padding: 10px 0px; margin: 0px;">
        Recordatorio de Cumpleaños
    </h2>
    <div style="padding: 10px; width: 95%; ">

      <p>Estim@ '.$datos[1].' estos son los cumpleaños para la semana en curso:</p><br><h3>Clientes Potenciales:</h3><br><table width="100%"><tr style="font-weight: bold;"><td>Empresa</td><td>Nombre</td><td>Apellido</td><td>Cumpleaños</td><td>Correo</td><td>Telefono</td></tr>'.$value.'</table>
      
    <br>';
  $body .= '<h3>Contactos:</h3><br>'
          . '<table width="100%"><tr style="font-weight: bold;"><td>Empresa</td><td>Nombre</td><td>Apellido</td><td>Cumpleaños</td><td>Correo</td><td>Telefono</td></tr>'.$value2.'</table>
       
        <br />

        <br />
    </div>
</div>';
  
      }
      }
      if($bandera == 0){
         $datos = explode("-", $key);
         $body = '<div style="position: relative; display: block; margin: 0px auto; width: 800px; border: 1px #007BA6 solid;">
    <h2 style="display: block; text-align: center; color: #FFFFFF; background-color: #007BA6; padding: 10px 0px; margin: 0px;">
        Recordatorio de Cumpleaños de Clientes Potenciales
    </h2>
    <div style="padding: 10px; width: 95%; ">

      <p>Estim@ '.$datos[1].' estos son los cumpleaños para la semana en curso:</p><h3>Clientes Potenciales:</h3><br> <table width="100%"><tr style="font-weight: bold;"><td>Empresa</td><td>Nombre</td><td>Apellido</td><td>Cumpleaños</td><td>Correo</td><td>Telefono</td></tr>'.$value.'</table>
       
        <br />

        <br />
    </div>
</div><br>';
      }
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

foreach($correos2 as $key4 => $value2) {
         $bandera2 = 0;
         foreach($correos as $key3 => $value){
            if($key3 == $key4) {
               die($key4);
               $bandera2++;}
         }
            if($bandera2 == 0){
       $datos = explode("-", $key4);
         $body = '<div style="position: relative; display: block; margin: 0px auto; width: 800px; border: 1px #007BA6 solid;">
    <h2 style="display: block; text-align: center; color: #FFFFFF; background-color: #007BA6; padding: 10px 0px; margin: 0px;">
        Recordatorio de Cumpleaños
    </h2>
    <div style="padding: 10px; width: 95%; ">

      <p>Estim@ '.$datos[1].' estos son los cumpleaños para la semana en curso:</p><h3>Clientes Potenciales:</h3><br> <table width="100%"><tr style="font-weight: bold;"><td>Empresa</td><td>Nombre</td><td>Apellido</td><td>Cumpleaños</td><td>Correo</td><td>Telefono</td></tr>'.$value2.'</table>
       
        <br />

        <br />
    </div>
</div><br>';
            
         
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
}
// Liberar resultados
mysql_free_result($result);
mysql_free_result($result2);

// Cerrar la conexión
mysql_close($link);
