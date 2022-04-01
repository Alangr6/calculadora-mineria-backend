<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CryptoDevice;
use App\Entity\Crypto;
use App\Entity\Device;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CryptoDeviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


 /**
     * @Route("/api/crypto/device/", name="app_crypto_device")
     */
class CryptoDeviceController extends AbstractController
{
    private $cryptoDeviceRepository;
   
    public function  __construct(CryptoDeviceRepository $cryptoDeviceRepository, EntityManagerInterface $em){
        $this->cryptoDeviceRepository = $cryptoDeviceRepository;
        $this->em = $em;
    }
     /**
     * @Route("read",name="api.crypto.device.read")
     */
    public function readAction(/* ManagerRegistry $doctrine, int $id */){
        /* $name = $doctrine->getRepository(Crypto::class)->find($id);
        $crypto = $name->getCrypto(); */

         return new JsonResponse([
             'data' => $this->cryptoDeviceRepository->getAll(),
                

         ]);
       
     }
      /**
     * @Route("create",name="api.crypto.device.create",methods={"POST"})
     */
     public function createAction(Request $request){
        $crypto = $this->getDoctrine()->getRepository(Crypto::class);
        $devices = $this->getDoctrine()->getRepository(Device::class);

         $content = json_decode($request->getContent(), true);
         $cryptoDevice = new CryptoDevice();
         if (isset($crypto)) {
             $cryptoAlert->setCrypto($crypt);
         }
         if (isset($device)) {
             $deviceAlert->setDevice($device);
         }
         if (isset($content['price'])) {
             $cryptoDevice->setBenefits($content[('benefits')]);
         }
         return new JsonResponse([
            'data' => $this->cryptoDeviceRepository->add($cryptoDevice),
             'content' => $content,
        ]);
     }
}
