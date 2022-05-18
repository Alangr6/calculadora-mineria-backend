<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;


/**
     * @Route("/api/login/", name="app_login")
     */
class SecurityController extends AbstractController
{
    private $userRepository;
   
    public function  __construct(UserRepository $userRepository, EntityManagerInterface $em){
        $this->userRepository = $userRepository;
        $this->em = $em;

    
        //'data' => $this->cryptoRepository->getAll()

    }
    /**
     * @Route("login2", name="app_login",methods={"POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

     /**
     * @Route("read",name="api.device.read")
     */
    public function readAction(){
        return new JsonResponse([
            'data' => $this->userRepository->getAll() 
        ]);
     
}

    /**
     * @Route("create",name="api.device.create",methods={"POST"})
     */
    public function createAction(Request $request){
        $passwordHasherFactory = new PasswordHasherFactory([
            'legacy' => [
                'algorithm' => 'sha256',
                'encode_as_base64' => true,
                'iterations' => 1,
            ],
        
            User::class => [
                // the new hasher, along with its options
                'algorithm' => 'sodium',
                'migrate_from' => [
                    'bcrypt', // uses the "bcrypt" hasher with the default options
                    'legacy', // uses the "legacy" hasher configured above
                ],
            ],
        ]);
        $passwordHasher = new UserPasswordHasher($passwordHasherFactory);
        $content = json_decode($request->getContent(),true);
        $plaintextPassword = $content['password'];
        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        
        if(isset($content['name'])){
            $user->setName($content[('name')]);
        }
        if(isset($content['username'])){
            $user->setUsername($content[('username')]);
        }
        if(isset($content['email'])){
            $user->setEmail($content[('email')]);
        }
        if(isset($content['password'])){
            // ...
            $user->setPassword($hashedPassword);
        }
        
       
        return new JsonResponse([
            'data' => $this->userRepository->add($user),
             'content' => $content,
        ]);
    
       
    }

}
