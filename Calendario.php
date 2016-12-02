<?php
// I know there are probably better ways to do this, but this accomplishes what I needed it to do.
// Fetch vars. In this case, they're being pulled via the URL.

function sumar_restar_horas($fechaInicial, $tiempo, $tipo, $operacion) {

      if (empty($fechaInicial)) {
         $fechaInicial = date('Y-m-d H:i');
      }
     
      if ($tipo == "dias") {
         $fechaFin = strtotime($operacion . $tiempo . ' day', strtotime($fechaInicial));
      } else if ($tipo == "horas") {
         $fechaFin = strtotime($operacion . $tiempo . ' hour', strtotime($fechaInicial));
      } else if ($tipo == "minutos") {
         $fechaFin = strtotime($operacion . $tiempo . ' minute', strtotime($fechaInicial));
      } else if ($tipo == "segundos") {
         $fechaFin = strtotime($operacion . $tiempo . ' second', strtotime($fechaInicial));
      }

      return date('Y-m-d H:i:s', $fechaFin);
   }

$link = mysql_connect('bihispano.com', 'desarrollo', 'desarroll0')
    or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('nicecrm_soluciones_audiovisiales') or die('No se pudo seleccionar la base de datos');

$query = "SELECT 
  id,
  nombre,
  descripcion,
  fecha_inicio AS fi,
  fecha_fin AS ff,
  hora_inicio AS hi,
  hora_fin AS hf 
FROM
  `actividad` 
WHERE usuario_id = ". $_GET['usuario'];

$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());

$ical = 'BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VTIMEZONE
TZID:America/Bogota
X-LIC-LOCATION:America/Bogota
END:VTIMEZONE
CALSCALE:GREGORIAN
';
$z='Z';
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
   $fechaInicio = $line['fi'] . ' '. $line['hi'];
   $fechaConvertidaInicio = explode(" ", sumar_restar_horas($fechaInicio, 5 , 'horas', '+'));
   $fechaFin = $line['ff'] . ' '. $line['hf'];
   $fechaConvertidaFin = explode(" ", sumar_restar_horas($fechaFin, 5 , 'horas', '+'));
   $fechai=explode("-", $fechaConvertidaInicio[0]);
   $fechaf=explode("-", $fechaConvertidaFin[0]);
   $horai=explode(":", $fechaConvertidaInicio[1]);
   $horaf=explode(":", $fechaConvertidaFin[1]);
   $ical .= 'BEGIN:VEVENT
';
   $ical .= 'DTEND:'.$fechaf[0].''.$fechaf[1].''.$fechaf[2].'T'.$horaf[0].''.$horaf[1].''.$horaf[2].''.$z.'
';
   $ical .= 'UID:' . md5($line['id']) .'
';
   $ical .= 'DTSTAMP:' . time() . '
';
   $ical .= 'LOCATION:' . addslashes('Bogota') . '
';
   $ical .= 'DESCRIPTION:' . addslashes($line['descripcion']) . '
';
   $ical .= 'URL;VALUE=URI: http://localhost/soluciones_audiovisuales/index.php?modulo=actividades&accion=editar&registro=' . $line['id'] . '
';
   $ical .= 'SUMMARY:' . addslashes($line['nombre']) . '
';
   $ical .= 'DTSTART:'.$fechai[0].''.$fechai[1].''.$fechai[2].'T'.$horai[0].''.$horai[1].''.$horai[2].''.$z.'
';
   $ical .= 'END:VEVENT
';
 
}

//	'datestart' => '20161018\T121030',
//	'dateend' => '20161018\T131030',
// Convert times to iCalendar format. They require a block for yyyymmdd and then another block
// for the time, which is in hhiiss. Both of those blocks are separated by a "T". The Z is
// declared at the end for UTC time, but shouldn't be included in the date conversion.
// iCal date format: yyyymmddThhiissZ
// PHP equiv format: Ymd\This
// Build the ics file

$ical .= 'END:VCALENDAR';


//set correct content-type-header
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=mohawk-event.ics');
echo $ical;