<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 24/05/2018
 * Time: 05:29
 */
namespace CD\LouvreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InformationsController extends Controller
{
	public function informationsAction(){

		// vue qui renvoie à la page Information du site
		return $this->render('CDLouvreBundle:Informations:informations.html.twig');
	}
}