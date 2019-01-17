<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use App\Form\QuoteType;
use App\Entity\Quote;

/**
 * Main Quote controller
 */
class QuoteController extends AbstractController{
    
    public function index() 
    {
        return $this->render('quote/index.html.twig');
    }
    
    
    /*
     * Future function add datables as server side procesing
     * https://datatables.net/examples/server_side/simple.html
     * show only demended rows (parse reqest)
     */
    
    public function jsondata()
    {
            
        $data=$this->getDoctrine()
        ->getRepository(Quote::class)
        ->findAsoc();
        
       
        $encoders = array(new JsonEncoder());
        $normalizers = array(new DateTimeNormalizer('Y-m-d H:i:s'));

        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($data, 'json');
        
        
        return new Response($json);
    }
    
    public function edit($id, Request $request) : Response {
        
        $quote=$this->getDoctrine()
        ->getRepository(Quote::class)
        ->find($id);
        
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);
        
         if ($form->isSubmitted() && $form->isValid()) {

             $this->getDoctrine()->getManager()->flush();

         return new Response('Sucess - Quote edited');
        }
        
        return $this->render('quote/edit.html.twig',[
            'form' => $form->createView(),
            'qoute' => $quote,
            'actionurl' => "quote/edit/$id"
        ]);
    }
    
    public function add(Request $request) : Response {
        
        $quote=new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);
       
         if ($form->isSubmitted() && $form->isValid()) {

             $quote=$form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quote);
            $entityManager->flush();

         return new Response('Sucess - Quote Added');
        }
        
        return $this->render('quote/edit.html.twig',[
            'form' => $form->createView(),
            'actionurl' => "quote/add"
        ]);
        
    }
    
    
     public function delete($id) : Response
    {
        $quote=$this->getDoctrine()
        ->getRepository(Quote::class)
        ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($quote);
        $em->flush();

        return new Response('Sucess - Quote Deleted');
    }

    
}
