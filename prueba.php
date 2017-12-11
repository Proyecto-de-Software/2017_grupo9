<?php
$datetime1 = new DateTime('2011-10-01');
$datetime2 = new DateTime('2011-12-01');
$interval = $datetime1->diff($datetime2);
echo floor($interval->format('%m'));
?>