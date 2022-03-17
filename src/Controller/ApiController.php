<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CryptoRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Crypto;
use Doctrine\ORM\EntityManagerInterface;

class ApiController extends AbstractController{
    private $cryptoRepository;
    private $em;
    public function  __construct(CryptoRepository $cryptoRepository, EntityManagerInterface $em){
        $this->cryptoRepository = $cryptoRepository;
        $this->em = $em;
         
    }
    /**
     * @Route("/api/crypto/read",name="api.crypto.read")
     */
    public function readAction(CryptoRepository $cryptoRepository){
       
        return new JsonResponse([
            'data' => $this->cryptoRepository->getAll()
        ]);
      
       
    }
    /**
     * @Route("/api/crypto/create",name="api.crypto.create",methods={"POST"})
     */
    public function createAction(Request $request){
        /* $content = $request->getContent();
        $crypto = new Crypto();
        $crypto->setName($request->get('name'));
        $crypto->setPrice($request->get('price'));
        $crypto->setCreationDate(new \DateTime()); */

           $content = json_decode($request->getContent(),true);
        $crypto = new Crypto();
        $crypto->setName($content[('name')]);
        $crypto->setPrice($content[('price')]);
        $crypto->setCreationDate(new \DateTime());
       
        
        return new JsonResponse([
            'data' => $this->cryptoRepository->add($crypto),
             'content' => $content,
        ]);
        
    
      
    /*   return $this->json([
            'data' => $this->cryptoRepository->add($crypto),
             'content' => $content,
        ]); */
       
    }

       /**
     * @Route("/api/crypto/update/{id}",name="api.crypto.update",methods={"PUT"})
     */

   public function update($id, CryptoRepository $cryptoRepository,Request $request){
    $content = json_decode($request->getContent(),true);

    $crypto = $cryptoRepository->find($id);
    $crypto->setName($content[('name')]);
    $crypto->setPrice($content[('price')]);

    $this->em->flush();

    return new JsonResponse([
        'result' => 'ok',
        
    ]);
   }
     /**
     * @Route("/api/crypto/delete/{id}",name="api.crypto.delete",methods={"DELETE"})
     */
    public function delete($id, CryptoRepository $cryptoRepository){
        $crypto = $cryptoRepository->find($id);
        $this->em->remove($crypto);
        $this->em->flush();

        return new JsonResponse([
            'result' => 'ok',
        ]);
    }

    
   
    
}