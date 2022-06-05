<?php
function dateToTimezone($timeZone = 'UTC', $dateTimeUTC = null, $dateFormat = 'Y-m-d H:i:s'){

$dateTimeUTC = $dateTimeUTC ? $dateTimeUTC : date("Y-m-d H:i:s");

$date = new DateTime($dateTimeUTC, new DateTimeZone('UTC'));
$date->setTimeZone(new DateTimeZone($timeZone));

return $date->format($dateFormat);
}
?>