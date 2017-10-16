<?php 

class Config extends TwigView{
	public function show() {
	    echo self::getTwig()->render('head.twig.html',  array('title' => 'Configuración'));
        echo self::getTwig()->render('header.twig.html', array('usuario' => unserialize($_SESSION['usuario']) , 'administrador' => $_SESSION['administrador'] , 'recepcionista' => $_SESSION['recepcionista'] , 'pediatra' => $_SESSION['pediatra']));        
        echo self::getTwig()->render('container.twig.html', array('tipo' => 'config'));
        echo self::getTwig()->render('footer.twig.html');
      }
}

?>

