<?php

namespace App\Controller;

use App\Repository\CryptoRepository;
use App\Repository\DeviceRepository;
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

    private CryptoRepository $cryptoRepository;
    private DeviceRepository $deviceRepository;
    private CryptoDeviceRepository $cryptoDeviceRepository;

    public function __construct(CryptoRepository $cryptoRepository,DeviceRepository $deviceRepository,CryptoDeviceRepository $cryptoDeviceRepository,EntityManagerInterface $em)
    {
        $this->cryptoRepository = $cryptoRepository;
        $this->deviceRepository = $deviceRepository;
        $this->cryptoDeviceRepository = $cryptoDeviceRepository;
        $this->em = $em;

    }

     /**
     * @Route("read",name="api.crypto.device.read")
     */
    public function readAction(){

         return new JsonResponse([
             'data' => $this->cryptoDeviceRepository->getAll(),
         ]);
       
     }
      /**
     * @Route("create",name="api.crypto.device.create",methods={"POST"})
     */
     public function createAction(Request $request ){

         $content = json_decode($request->getContent(), true);

         $crypto = $this->cryptoRepository->find($content['crypto_id']);
         $device = $this->deviceRepository->find($content['device_id']);


         $cryptoDevice = new CryptoDevice();
         $cryptoDevice->setBenefits($content['benefits']);
         $cryptoDevice->setCrypto($crypto);
         $cryptoDevice->setDevice($device);

         $this->cryptoDeviceRepository->add($cryptoDevice,true);

         return new JsonResponse([
            'message' => "crypto device stored successful"
        ]);
     }

      /**
     * @Route("delete/{id}",name="api.crypto.delete",methods={"DELETE"})
     */
    public function deleteAction($id, CryptoDeviceRepository $cryptoDeviceRepository){
        $cryptoDevice = $cryptoDeviceRepository->find($id);
        $this->em->remove($cryptoDevice);
        $this->em->flush();

        return new JsonResponse([
            'data' => 'ok',
        ]);
    }
}