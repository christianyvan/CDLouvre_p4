<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 24/05/2018
 * Time: 05:34
 */

namespace CD\LouvreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LegalNoticeController extends Controller
{
	public function legalNoticeAction(){
		return $this->render('CDLouvreBundle:LegalNotice:legalNotice.html.twig');
	}
}