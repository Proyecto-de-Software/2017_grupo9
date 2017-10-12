<?php


/**
 * Description of TwigView
 *
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

abstract class TwigView {

    private static $twig;

    public static function getTwig() {

        if (!isset(self::$twig)) {

            Twig_Autoloader::register();
            $loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'].'./templates');
            self::$twig = new Twig_Environment($loader, array('cache' => false));
        }
        return self::$twig;
    }

}
