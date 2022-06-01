<?php

namespace App\Controller;
use App\Entity\Account;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
       // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

          return $this->render('login/index.html.twig', [
             'controller_name' => 'LoginController',
             'last_username' => $lastUsername,
            'error'         => $error,
          ]);
      }

      /**
 * @Route("/secure-area", name="homepage")
 */
public function indexAction()
{

    if($this->isGranted('ROLE_FARMER')){
        $user=$this->getUser();
        if($user->getAccount()->isIsBaned()||$user->getAccount()->isIsActivated()==false){
            
            return $this->redirectToRoute('app_logout');
        }
    return $this->redirectToRoute('farmer');
    }


    elseif($this->isGranted('ROLE_GREENGROCER'))
    {
        $user=$this->getUser();
        if($user->getAccount()->isIsBaned()||  $user->getAccount()->isIsActivated()==false){
            
            return $this->redirectToRoute('app_logout');
        }
        return $this->redirectToRoute('greengrocer');
    }
    elseif ($this->isGranted('ROLE_ADMIN')) {
        return $this->redirectToRoute('app_admin');
    }
     
    elseif($this->isGranted('ROLE_DELEVERY'))
    return $this->redirectToRoute('delevery');
    throw new \Exception(AccessDeniedException::class);
}

/**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
        
    }

    }



