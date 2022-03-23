<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DeviceRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Device;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/device/")
 */

class DeviceController extends AbstractController{
    private $deviceRepository;
   
    public function  __construct(DeviceRepository $deviceRepository, EntityManagerInterface $em){
        $this->deviceRepository = $deviceRepository;
        $this->em = $em;

    
        //'data' => $this->cryptoRepository->getAll()

    }
    /**
     * @Route("read",name="api.device.read")
     */
    public function readAction(){
       $devices = $this->getDoctrine()->getRepository(Device::class)->findAll();
       $jsonData = array();
       $index = 0;
       foreach ($devices as $device) {
           $temp = array(
            'id' => $device->getId(),
               'type' => $device->getType(),
               'name' => $device->getName(),
               'price' => $device->getPrice(), 
                'comsumption' => $device->getComsumption(),
                'hashrate' => $device->getHashrate()
           );
           $jsonData[$index++] = $temp;
       }
        return new JsonResponse($jsonData);
      
    }


    


      /**
     * @Route("read/{id}", methods={"GET"}, name="api.device.readById")
     */
    public function readActionById($id,DeviceRepository $deviceRepository){
       
        $device = $this->deviceRepository->find($id);

        return new JsonResponse([
            'id' => $device->getId(),
            'name' => $device->getName(),
            'price' => $device->getPrice(),
            'creation_date' => $device->getCreationDate()->format('Y-m-d'), 
        ]);
      
       
    }
    /**
     * @Route("create",name="api.device.create",methods={"POST"})
     */
    public function createAction(Request $request){
        /* $content = $request->getContent();
        $crypto = new Crypto();
        $crypto->setName($request->get('name'));
        $crypto->setPrice($request->get('price'));
        $crypto->setCreationDate(new \DateTime()); */

        $content = json_decode($request->getContent(),true);
        $device = new Device();
        if(isset($content['type'])){
            $device->setType($content[('type')]);
        }
        if(isset($content['name'])){
            $device->setName($content[('name')]);
        }
        if(isset($content['price'])){
            $device->setPrice($content[('price')]);
        }
        if(isset($content['comsumption'])){
            $device->setComsumption($content['comsumption']);
        }
        if(isset($content['hashrate'])){
            $device->setHashrate($content['hashrate']);
        }
       
       
        return new JsonResponse([
            'data' => $this->deviceRepository->add($device),
             'content' => $content,
        ]);
    
       
    }

       /**
     * @Route("update/{id}/",name="api.device.update",methods={"PUT"})
     */

   public function updateAction($id, DeviceRepository $deviceRepository,Request $request){
    $content = json_decode($request->getContent(),true);

    $device = $deviceRepository->find($id);
    $device->setType($content[('type')]);
    $device->setName($content[('name')]);
    $device->setPrice($content[('price')]);
    $device->setComsumption($content[('comsumption')]);
    $device->setHashrate($content[('hashrate')]);




    $this->em->flush();

    return new JsonResponse([
        'result' => 'ok',
        
    ]);
   }
     /**
     * @Route("delete/{id}",name="api.device.delete",methods={"DELETE"})
     */
    public function deleteAction($id, DeviceRepository $deviceRepository){
        $device = $deviceRepository->find($id);
        $this->em->remove($device);
        $this->em->flush();

        return new JsonResponse([
            'data' => 'ok',
        ]);
    }

    
   
    
}