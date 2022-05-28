<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Farm;
use App\Entity\Greengrocer;
use App\Entity\User;
use App\Entity\Prove;
use App\Service\FileUploader;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager,FileUploader $fileUploader): Response
    {
        $user = new User();
       
        $hh= new class{
            public $propertyName;
            public $propertyDiscription;
            public $propertyLocation; 
            public $email;
            public $plainPassword;
            public $role;
            public $image=[];
        };
        $form = $this->createForm(RegistrationFormType::class,$hh);
     
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('image')->getData();
          // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->getData()->plainPassword
                )
            );

            $user->setEmail( $form->getData()->email);

            $user->setRoles([ $form->getData()->role]);
            $account = new Account();
            $account->setIsActivated(false);
            $account->setIsBaned(false);
            $user->setAccount($account);

            foreach ($brochureFile as $file ) {
                
                $name=$fileUploader->upload($file);
                $prove = new Prove();
                $prove->setUrl($name);
                $user->addProve($prove);
   }

            if($form->getData()->role=='ROLE_FARMER'){
                $farm=new Farm();
                $farm->setFarmName($form->getData()->propertyName);
                $farm->setLoacation($form->getData()->propertyLocation);
                $farm->setDiscription($form->getData()->propertyDiscription);
                $user->setMyfarm($farm);
            }
            if($form->getData()->role=='ROLE_GREENGROCER'){
                $greengrocer=new Greengrocer();
                $greengrocer->setGreengrocerName($form->getData()->propertyName);
                $greengrocer->setLocation($form->getData()->propertyLocation);
                $greengrocer->setDiscription($form->getData()->propertyDiscription);
                $user->setGreengrocer($greengrocer);
            }
        
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
