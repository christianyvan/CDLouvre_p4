<?php

namespace CD\LouvreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CDLouvreBundle:Default:index.html.twig');
    }
}
