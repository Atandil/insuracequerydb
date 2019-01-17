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
    
    /*
    public function operations($slug, Request $request)
    {
        $form = $this->createForm(CalcType::class, array());
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();   
         } else {
          $error= "No input or bad value";
        }   
        //clean Operation name to be sure
        $operationName= 'App\Calculator\Operations\\'  . preg_replace('/[^a-zA-Z]/', '', $slug);
        if(!class_exists($operationName)) {
            $error= "Operation $slug is not implemented";
        }    
   
        if(!isset($error)) {
            try {
                    $calc = new Calculator;
                    //Main Calc  - using Class with Operation
                    $out=$calc->set(new $operationName)->count($data['num1'],$data['num2']);
                    $result['decimal']=$out;
                    //binary for integers
                    $result['binary']= ($out >= 0 && $out < 1000000 && floor( $out ) == $out  )? decbin($out) : '-' ;
                } catch (\Exception $e) {
                    $error=  $e->getMessage();
                }
        }
        $result['error']=isset($error) ? $error : '';    
        return $this->render('calc/index.html.twig', ['result' => $result ]);
    }
     * 
     */
}
