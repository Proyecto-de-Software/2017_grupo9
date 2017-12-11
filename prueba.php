<?php
$datetime1 = new DateTime('2015-01-01');
$datetime2 = new DateTime('2017-02-01');
$interval = $datetime1->diff($datetime2);
echo '<pre>';
var_dump($interval);
echo '</pre>';
echo floor($interval->m);
?>