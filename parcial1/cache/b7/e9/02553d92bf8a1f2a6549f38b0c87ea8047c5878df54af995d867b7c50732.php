<?php

/* home.html */
class __TwigTemplate_b7e902553d92bf8a1f2a6549f38b0c87ea8047c5878df54af995d867b7c50732 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("encabezado.html");

        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "encabezado.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "home.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array ();
    }
}
