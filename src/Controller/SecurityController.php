<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
	    if ($this->getUser()) {
		    return $this->redirectToRoute('rte_admin_main');
	    }
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
	    /*
	     *   - Customize your new authenticator.
					 - Finish the redirect "TODO" in the App\Security\LoginFormAuthenticator::onAuthenticationSuccess() method.
					 - Check the user's password in App\Security\LoginFormAuthenticator::checkCredentials().
					 - Review & adapt the login template: templates/security/login.html.twig.
	     */

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(SessionInterface $session)  {
    	$this->clearUserDataFromSession($session);
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
	
			private function clearUserDataFromSession(SessionInterface $session){
				$session->remove('userData');
				$session->remove('login');
				$session->remove('benutzer');
				$session->remove('benutzername');
			}
}
