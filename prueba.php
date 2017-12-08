<?php

	$array = array(1, 2, 3, 4);
	foreach ($array as &$value) {
        $value =$value * 100;
      }

      var_dump($array);
?>