<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController

{
    public function index()
    {
        return $this->render('quote/index.html.twig');
    }
    
    public function test() {
	return new Response('Test :)');
    }
    
}