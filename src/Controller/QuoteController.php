<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use App\Form\QuoteType;
use App\Entity\Quote;
use App\Repository\QuoteRepository;
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
    
    public function edit($id, Request $request) {
        
        $quote=$this->getDoctrine()
        ->getRepository(Quote::class)
        ->find($id);
        
        $form = $this->createForm(QuoteType::class, $quote)
            ->add('edit', SubmitType::class);

        $form->handleRequest($request);
        
        return $this->render('quote/edit.html.twig',[
            'form' => $form->createView(),
            'qoute' => $quote
        ]);
    }
    
    public function add(Request $request) {
        
         $form = $this->createForm(QuoteType::class, array())
            ->add('Add', SubmitType::class);

        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();   
         } 
        
         return $this->render('quote/edit.html.twig', [
            'form' => $form->createView(),
        ]);
        
    }
    
}
