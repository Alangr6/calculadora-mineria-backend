<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CryptoRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Crypto;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/crypto/")
 */

class ApiController extends AbstractController{
    private $cryptoRepository;
    private $em;
    public function  __construct(CryptoRepository $cryptoRepository, EntityManagerInterface $em){
        $this->cryptoRepository = $cryptoRepository;
        $this->em = $em;
         
    }
    /**
     * @Route("read",name="api.crypto.read")
     */
    public function readAction(CryptoRepository $cryptoRepository){
       
        return new JsonResponse([
            'data' => $this->cryptoRepository->getAll()
        ]);
      
    }

      /**
     * @Route("read/{id}", methods={"GET"}, name="api.crypto.readById")
     */
    public function readActionById($id,CryptoRepository $cryptoRepository){
       
        $crypto = $this->cryptoRepository->find($id);

        return new JsonResponse([
            'id' => $crypto->getId(),
            'name' => $crypto->getName(),
            'price' => $crypto->getPrice(),
            'creation_date' => $crypto->getCreationDate()->format('Y-m-d'), 
        ]);
      
       
    }
    /**
     * @Route("create",name="api.crypto.create",methods={"POST"})
     */
    public function createAction(Request $request){
        /* $content = $request->getContent();
        $crypto = new Crypto();
        $crypto->setName($request->get('name'));
        $crypto->setPrice($request->get('price'));
        $crypto->setCreationDate(new \DateTime()); */

        $content = json_decode($request->getContent(),true);
        $crypto = new Crypto();
        if(isset($content['email'])){
            $crypto->setName($content[('name')]);
        }
        if(isset($content['price'])){
            $crypto->setPrice($content[('price')]);
        }
        if(isset($content['creation_date'])){
            $crypto->setCreationDate(\DateTime::createFromFormat('Y-m-d',$content['creation_date']));
        }
        if(isset($content['algorithm'])){
            $crypto->setAlgorithm($content['algorithm']);
        }
       
        $this->em->flush();
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
     * @Route("update/{id}",name="api.crypto.update",methods={"PUT"})
     */

   public function updateAction($id, CryptoRepository $cryptoRepository,Request $request){
    $content = json_decode($request->getContent(),true);

    $crypto = $cryptoRepository->find($id);
    $crypto->setName($content[('name')]);
    $crypto->setPrice($content[('price')]);
    $crypto->setCreationDate(\DateTime::createFromFormat('Y-m-d',$content['creation_date']));
    $crypto->setAlgorithm($content[('algorithm')]);


    $this->em->flush();

    return new JsonResponse([
        'result' => 'ok',
        
    ]);
   }
     /**
     * @Route("/api/crypto/delete/{id}",name="api.crypto.delete",methods={"DELETE"})
     */
    public function deleteAction($id, CryptoRepository $cryptoRepository){
        $crypto = $cryptoRepository->find($id);
        $this->em->remove($crypto);
        $this->em->flush();

        return new JsonResponse([
            'result' => 'ok',
        ]);
    }

    
   
    
}