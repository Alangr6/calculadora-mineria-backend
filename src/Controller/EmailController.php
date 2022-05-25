<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EmailRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Email;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/email/")
 */

class EmailController extends AbstractController{
    private $emailRepository;
    private $em;

   
    public function  __construct(EmailRepository $emailRepository, EntityManagerInterface $em){
        $this->emailRepository = $emailRepository;
        $this->em = $em;

    }
    /**
     * @Route("read",name="email.read")
     */
    public function readAction(){
   
        return new JsonResponse([
            'data' => $this->emailRepository->getAll() 
        ]);
      
    }

     
    /**
     * @Route("create",name="email.create",methods={"POST"})
     */
    public function createAction(Request $request, EntityManagerInterface $em){
       

        $content = json_decode($request->getContent(),true);
        $email = new Email();
        $email->setEmail($content['email']);
      
       $em->persist($email);
       $em->flush();
       
        return new JsonResponse([
             'content' => $content,
        ]);
        
    
   
    }

   
   
    
   
    
}