<?php

/* encabezado.html */
class __TwigTemplate_9f04cd4314147a00ea9457bdbcba978a1a1ac978084c761c546eb5b5b88716af extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE HTML>

<html>
\t<header>
\t\t<title>Sistema de votación</title>
\t</header>

\t<body>
\t\t";
        // line 9
        if (twig_test_empty((isset($context["usuario"]) ? $context["usuario"] : null))) {
            // line 10
            echo "\t\t\t<a href=\"/parcial1/index.php?action=login\">Login</a>
\t\t";
        } else {
            // line 12
            echo "\t\t\tBienvenido ";
            echo twig_escape_filter($this->env, (isset($context["usuario"]) ? $context["usuario"] : null), "html", null, true);
            echo "  <a href=\"/parcial1/index.php?action=logout\">
\t\t";
        }
    }

    public function getTemplateName()
    {
        return "encabezado.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 12,  31 => 10,  29 => 9,  19 => 1,);
    }
}
