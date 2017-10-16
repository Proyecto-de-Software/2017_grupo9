<?php 

class Admin extends TwigView{
	public function show() {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Administracion'));
        echo self::getTwig()->render('header.twig.html', array('administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'admin'));
        echo self::getTwig()->render('footer.twig.html');
      }
}

?>