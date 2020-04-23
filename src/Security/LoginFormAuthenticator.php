<?php
	
	namespace App\Security;
	
	use App\Entity\User;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
	use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
	use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
	use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
	use Symfony\Component\Security\Core\Security;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Symfony\Component\Security\Core\User\UserProviderInterface;
	use Symfony\Component\Security\Csrf\CsrfToken;
	use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
	use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
	use Symfony\Component\Security\Http\Util\TargetPathTrait;
	
	class LoginFormAuthenticator extends AbstractFormLoginAuthenticator {
		use TargetPathTrait;
		
		/**
		 * @var \Doctrine\ORM\EntityManagerInterface
		 */
		private $entityManager;
		
		/**
		 * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface
		 */
		private $urlGenerator;
		
		/**
		 * @var \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface
		 */
		private $csrfTokenManager;
		
		/**
		 * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
		 */
		private $session;
		
		public function __construct( EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, SessionInterface $session ) {
			$this->session          = $session;
			$this->entityManager    = $entityManager;
			$this->urlGenerator     = $urlGenerator;
			$this->csrfTokenManager = $csrfTokenManager;
		}
		
		public function supports( Request $request ) {
			return 'app_login' === $request->attributes->get( '_route' )
			       && $request->isMethod( 'POST' );
		}
		
		public function getCredentials( Request $request ) {
			$credentials = [
				#   'email'       => $request->request->get('email'),
				'username'   => $request->request->get( 'username' ),
				'password'   => $request->request->get( 'password' ),
				'csrf_token' => $request->request->get( '_csrf_token' ),
			];
			$request->getSession()->set(
				Security::LAST_USERNAME,
				$credentials['username'] /* $credentials['email'] */
			);
			
			return $credentials;
		}
		
		public function getUser( $credentials, UserProviderInterface $userProvider ) {
			$token = new CsrfToken( 'authenticate', $credentials['csrf_token'] );
			if ( ! $this->csrfTokenManager->isTokenValid( $token ) ) {
				throw new InvalidCsrfTokenException();
			}
			
			# $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);
			$user = $this->entityManager->getRepository( User::class )->findOneBy( [ 'username' => $credentials['username'] ] );
			
			if ( ! $user ) {
				// fail authentication with a custom error
				// throw new CustomUserMessageAuthenticationException('Email could not be found.');
				throw new CustomUserMessageAuthenticationException( 'Username could not be found.' );
			}
			
			return $user;
		}
		
		private function storeUserDataToSession(UserInterface $user){
			$this->session->set('userData', $user);
			$this->session->set('login', 1);
			$this->session->set('benutzer', $user->getPersonId());
			$this->session->set('benutzername', $user->getFriendlyName());
		}
		
		
		public function checkCredentials( $credentials, UserInterface $user ) {
			// PASSWORD_DEFAULT PASSWORD_BCRYPT PASSWORD_ARGON2I PASSWORD_ARGON2ID
			# dump(password_hash('aaa', PASSWORD_BCRYPT));
			
			# CHECK CSRF TOKEN:
			if(!$this->csrfTokenManager->isTokenValid(new CsrfToken('authenticate', $credentials['csrf_token']))){
				//throw new InvalidCsrfTokenException();
				throw new CustomUserMessageAuthenticationException( 'Invalid Token supplied. Please, refresh your Page and try again.' );
			}
			
			$passOK   = password_verify($credentials['password'], $user->getPassword());
			if($passOK && ($user->getUsername() == $credentials['username'])){
				$this->storeUserDataToSession($user);
				return true;
			}
			return false;
			/*
			dump($credentials['password']);
			dump($user->getPassword());
			dump($user);
			dump($credentials);
			die;*/
			// Check the user's password or other credentials and return true or false
			// If there are no credentials to check, you can just return true
			// throw new \Exception( 'TODO: check the credentials inside ' . __FILE__ );
		}
		
		public function onAuthenticationSuccess( Request $request, TokenInterface $token, string $providerKey ) {
			if ( $targetPath = $this->getTargetPath( $request->getSession(), $providerKey ) ) {
				return new RedirectResponse( $targetPath );
			}
			$credentials  = $this->getCredentials($request);
			$user = $this->entityManager->getRepository( User::class )->findOneBy( [ 'username' => $credentials['username'] ] );
			if(in_array('ROLE_ADMIN', $user->getRoles())){
				return new RedirectResponse($this->urlGenerator->generate('rte_admin_calendar'));
			}else{
				return new RedirectResponse($this->urlGenerator->generate('rte_admin_user'));
			}
			// For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
			//throw new \Exception( 'TODO: provide a valid redirect inside ' . __FILE__ );
		}
		
		protected function getLoginUrl() {
			return $this->urlGenerator->generate( 'app_login' );
		}
	}
