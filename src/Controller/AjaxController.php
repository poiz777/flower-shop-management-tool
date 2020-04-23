<?php
	
	namespace App\Controller;
	
	use App\Entity\Ticketeintrag;
	use App\Entity\Tickets;
	use App\Forms\TicketManagementEntity;
	use App\Forms\TicketPostEntity;
	use App\Helpers\Date\DateCalculator;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\HTML\Forms\TicketManagementForm;
	use App\Poiz\HTML\Helpers\Octopus;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
	
	class AjaxController extends AbstractController {
		use AdminControllerHelperTrait;
		
		/**
		 * @var EntityManagerInterface
		 */
		private $entityManager;
		
		/**
		 * @var SessionInterface
		 */
		private $session;
		
		/**
		 * @var array
		 */
		private $melSession = [];
		
		/**
		 * AjaxController constructor.
		 *
		 * @param \Doctrine\ORM\EntityManagerInterface                       $entityManager
		 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
		 */
		public function __construct(EntityManagerInterface $entityManager, SessionInterface $session) {
			$this->entityManager  = $entityManager;
			$this->session        = $session;
			$this->melSession     = $this->session->get(RequestBridge::SessionNameSpace);
		}
		
		/**
		 * @Route("/ajax", name="ajax")
		 */
		public function index() {
			return $this->render( 'ajax/index.html.twig', [
				'controller_name' => 'AjaxController',
			] );
		}
		
		/**
		 * @Route("/mjr/api/v1/ticket/process", name="rte_ajax_process_new_ticket")
		 *
		 *
		 * -- return \Symfony\Component\HttpFoundation\JsonResponse
		 */
		public function processNewFormTicket(){
		
		}
		
		/**
		 * @Route("/mjr/api/v1/ticket/new/{time}/{date}", name="rte_ajax_create_new_ticket")
		 *
		 * @param \Symfony\Component\HttpFoundation\Request                  $request
		 * @param \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface $tokenManager
		 * @param \App\Helpers\Date\DateCalculator                           $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge                            $rb
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator                      $translator
		 * @param string                                                     $time
		 * @param null                                                       $date
		 *
		 * @return \Symfony\Component\HttpFoundation\JsonResponse
		 * @throws \Exception
		 */
		public function newTicket(Request $request, CsrfTokenManagerInterface $tokenManager,  DateCalculator $dateCalculator, RequestBridge $rb, ShopTranslator $translator, $time='07:00', $date=null) {
			/**@var \App\Poiz\HTML\Widgets\Widget $widget */
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$header         = $this->getDefaultHeader();
			$date           = !$date ? new \DateTime() : new \DateTime($date);
			$ticket         = new TicketManagementEntity();
			$ticket->setTicketZeit($time);
			$ticket->setTicketEndtermin($date);
			$ticketForm     = new TicketManagementForm($ticket, null, false);
			$ticketForm->setTranslator($translator);
			
			$payload        =  $request->request->get('payload', null);
			if($payload) {
				$data         = json_decode($payload, true);
				$ticket->autoSetClassProps($data);
				
				$ticketForm     = new TicketManagementForm($ticket, null, false);
				$ticketForm->setTranslator($translator);
				## RETURN SUCCESS STATUS AFTER SAVE.
				if($ticketX = $ticketForm->isValid($data)){
					$statusData = $this->saveTicket($ticketX->getEntityBank());
					if($statusData['status'] == 1){
						$statusData2  = $this->addOrUpdateTicketEntry($data, $statusData['ticketID']);
						if($statusData2['status'] == 1){
							return new JsonResponse($statusData, 200, $header);
						}
					}
				}
			}
			$token      = $tokenManager->getToken('authenticate');
			$formData   = [
				'errors'        => $ticketForm->getFormErrors(),
				'widgets'       => [],
				'widgetsMeta'   => [],
				'date'          => $date->format('d.m.Y H:i:s'),
				'time'          => $time,
				'title'         => 'Ein neues Ticket erstellen',
				'formOpen'      => "<form name='' method='post'>",
				'formClose'     => "</form>",
				'csrfToken'     => "<input type='hidden' name='_csrf_token' value='{$token}' />",
				'formWrapOpen'  => "<div class='pz-wrapper'>",
				'formWrapClose' => "</div>",
				'sendButton'    => "<button type='submit' class='btn btn-primary pz-form-widget' style='max-width:50%;margin-left:50%;'><span class=\"fa fa-paper-plane\"></span> &nbsp;&nbsp;Los</button>",
				];
			
			if( !empty($ticketForm->getForm()) ){
				foreach ($ticketForm->getForm() as $widget){
					$output     = $widget->render();
					if(preg_match("#type[= ]*?['\"]hidden#", $output)){
						$formData['widgets'][]      =  $widget->render() ;
					}else{
						$formData['widgets'][]      = "<div class='form-group'>" . $output . "</div>";
					}
					$formData['widgetsMeta'][]  = $widget->widgetMeta;
				}
				$formData['widgetsMeta']      = $ticketForm->widgetMetaData;
			}
			
			return new JsonResponse($formData, 200, $header);
			
		}
		
		/**
		 * @Route("/mjr/api/v1/ticket/edit/{tid}", name="rte_ajax_edit_ticket")
		 *
		 * @param \Symfony\Component\HttpFoundation\Request                  $request
		 * @param \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface $tokenManager
		 * @param \App\Helpers\Date\DateCalculator                           $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge                            $rb
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator                      $translator
		 * @param null                                                       $tid
		 *
		 * @return \Symfony\Component\HttpFoundation\JsonResponse
		 */
		public function editTicket(Request $request, CsrfTokenManagerInterface $tokenManager,  DateCalculator $dateCalculator, RequestBridge $rb, ShopTranslator $translator, $tid=null) {
			/**@var \App\Poiz\HTML\Widgets\Widget $widget */
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$header         = $this->getDefaultHeader();
			
			if(!$tid && !$request->request->get('payload', null) ){
				return new JsonResponse([], 200, $header);
			}
			$tid = $tid ? $tid : json_decode($request->request->get('payload', []), true)['ticket_id'];
			$ticketMain     = $this->entityManager->getRepository(Tickets::class)->find($tid);
			$rayTicket      = $ticketMain->getEntityBank();
			$ticketEntry    = $this->entityManager->getRepository(Ticketeintrag::class)->findOneBy(['ticketeintrag_ticket_id' => $tid]);
			$ticketEntry    = $ticketEntry ? $ticketEntry : new Ticketeintrag();
			$ticket         = new TicketManagementEntity();
			$ticket->autoSetClassProps($rayTicket);
			$ticket->setTicketeintragEintrag($ticketEntry->getTicketeintragEintrag());
			$ticketForm     = new TicketManagementForm($ticket, null, false);
			$ticketForm->setTranslator($translator);
			
			$payload        =  $request->request->get('payload', null);
			if($payload) {
				$data         = json_decode($payload, true);
				$ticket->autoSetClassProps($data);
				
				$ticketForm     = new TicketManagementForm($ticket, null, false);
				$ticketForm->setTranslator($translator);
				## RETURN SUCCESS STATUS AFTER SAVE.
				if($ticketX = $ticketForm->isValid($data)){
					$statusData = $this->saveTicket($ticketX->getEntityBank(), $ticketX->getTicketId());
					if($statusData['status'] == 1){
						$statusData2    = $this->addOrUpdateTicketEntry($data, $statusData['ticketID']);
						if($statusData2['status']){
							return new JsonResponse($statusData, 200, $header);
						}
					}
				}
			}
			
			$token      = $tokenManager->getToken('authenticate');
			$formData   = [
				'errors'        => $ticketForm->getFormErrors(),
				'widgets'       => [],
				'widgetsMeta'   => [],
				'date'          => $ticket->getTicketEndtermin()->format('d.m.Y H:i:s'),
				'time'          => $ticket->getTicketZeit(),
				'title'         => 'Ein neues Ticket erstellen',
				'formOpen'      => "<form name='' method='post'>",
				'formClose'     => "</form>",
				'csrfToken'     => "<input type='hidden' name='_csrf_token' value='{$token}' />",
				'formWrapOpen'  => "<div class='pz-wrapper'>",
				'formWrapClose' => "</div>",
				'sendButton'    => "<button type='submit' class='btn btn-primary pz-form-widget' style='max-width:50%;margin-left:50%;'><span class=\"fa fa-paper-plane\"></span> &nbsp;&nbsp;Los</button>",
				];
			
			if( !empty($ticketForm->getForm()) ){
				foreach ($ticketForm->getForm() as $widget){
					$output     = $widget->render();
					if(preg_match("#type[= ]*?['\"]hidden#", $output)){
						$formData['widgets'][]      =  $widget->render() ;
					}else{
						$formData['widgets'][]      = "<div class='form-group'>" . $output . "</div>";
					}
					$formData['widgetsMeta'][]  = $widget->widgetMeta;
				}
				$formData['widgetsMeta']      = $ticketForm->widgetMetaData;
			}
			
			return new JsonResponse($formData, 200, $header);
		}
		
		/**
		 * @Route("/mjr/api/v1/ticket-post/edit/{id}", name="rte_ajax_edit_ticket_post")
		 *
		 * @param \Symfony\Component\HttpFoundation\Request                  $request
		 * @param \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface $tokenManager
		 * @param \App\Helpers\Date\DateCalculator                           $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge                            $rb
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator                      $translator
		 * @param mixed                                                      $id
		 *
		 * @return \Symfony\Component\HttpFoundation\JsonResponse
		 * @throws \Exception
		 */
		public function editTicketPost(Request $request, CsrfTokenManagerInterface $tokenManager,  DateCalculator $dateCalculator, RequestBridge $rb, ShopTranslator $translator, $id=null) {
			/**@var \App\Poiz\HTML\Widgets\Widget $widget */
			/**@var TicketPostEntity  $ticketPost */
			/**@var TicketPostEntity  $ticketPostX */
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$header         = $this->getDefaultHeader();
			
			if(!$id && !$request->request->get('payload', null) ){
				return new JsonResponse([], 200, $header);
			}
			$id             = $id ? $id : json_decode($request->request->get('payload', []), true)['id'];
			$ticketEntry    = $this->entityManager->getRepository(Ticketeintrag::class)->find($id);
			$ticketEntry    = $ticketEntry ? $ticketEntry : new Ticketeintrag();
			$ticketPost     = new TicketPostEntity();
			$ticketPost->autoSetClassProps($ticketEntry->getEntityBank());
			$ticketPostForm = new TicketManagementForm($ticketPost, $translator, false);
			
			$payload        =  $request->request->get('payload', null);
			if($payload) {
				$data         = json_decode($payload, true);
				$ticketPost->autoSetClassProps($data);
				
				$ticketPostForm     = new TicketManagementForm($ticketPost, $translator, false);
				## RETURN SUCCESS STATUS AFTER SAVE.
				if($ticketPostX = $ticketPostForm->isValid($data)){
					$statusData = $this->addOrUpdateTicketEntry($ticketPostX->getEntityBank(), $ticketPostX->getTicketeintragTicketId(),  $ticketPostX->getTicketeintragId());
					if($statusData['status'] == 1){
						return new JsonResponse($statusData, 200, $header);
					}
				}
			}
			
			$token      = $tokenManager->getToken('authenticate');
			$formData   = [
				'errors'        => $ticketPostForm->getFormErrors(),
				'widgets'       => [],
				'widgetsMeta'   => [],
				'date'          => $ticketPost->getTicketeintragDatum()->format('d.m.Y H:i:s'),
				'message'       => $ticketPost->getTicketeintragEintrag(),
				'title'         => 'Ein neues Ticket erstellen',
				'formOpen'      => "<form name='' method='post'>",
				'formClose'     => "</form>",
				'csrfToken'     => "<input type='hidden' name='_csrf_token' value='{$token}' />",
				'formWrapOpen'  => "<div class='pz-wrapper'>",
				'formWrapClose' => "</div>",
				'sendButton'    => "<button type='submit' class='btn btn-primary pz-form-widget' style='max-width:50%;margin-left:50%;'><span class=\"fa fa-paper-plane\"></span> &nbsp;&nbsp;Los</button>",
				];
			
			if( !empty($ticketPostForm->getForm()) ){
				foreach ($ticketPostForm->getForm() as $widget){
					$output     = $widget->render();
					if(preg_match("#type[= ]*?['\"]hidden#", $output)){
						$formData['widgets'][]      =  $widget->render() ;
					}else{
						$formData['widgets'][]      = "<div class='form-group'>" . $output . "</div>";
					}
					$formData['widgetsMeta'][]  = $widget->widgetMeta;
				}
				$formData['widgetsMeta']      = $ticketPostForm->widgetMetaData;
			}
			
			return new JsonResponse($formData, 200, $header);
			
		}
		
		/**
		 * @Route("/mjr/api/v1/ticket/delete/{id}", name="rte_ajax_delete_ticket")
		 *
		 * @param \Symfony\Component\HttpFoundation\Request                  $request
		 * @param \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface $tokenManager
		 * @param mixed                                                      $id
		 *
		 * @return \Symfony\Component\HttpFoundation\JsonResponse
		 * @throws \Exception
		 */
		public function deleteTicket(Request $request, CsrfTokenManagerInterface $tokenManager, $id=null){
			$header     = $this->getDefaultHeader();
			if(!($user  = $this->getUser())){ return new JsonResponse([], 200, $header); }
			if($id){
				$status   = $this->removeTicket($id);
				return new JsonResponse($status, 200, $header);
			}
			return new JsonResponse([], 200, $header);
		}
		
		/**
		 * @Route("/mjr/api/v1/ticket-post/delete/{id}", name="rte_ajax_delete_ticket_post")
		 *
		 * @param \Symfony\Component\HttpFoundation\Request                  $request
		 * @param \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface $tokenManager
		 * @param mixed                                                      $id
		 *
		 * @return \Symfony\Component\HttpFoundation\JsonResponse | mixed
		 * @throws \Exception
		 */
		public function deleteTicketEntry(Request $request, CsrfTokenManagerInterface $tokenManager, $id=null){
			$header         = $this->getDefaultHeader();
			$referrer       = $_SERVER['HTTP_REFERER']; // THIS IS OK
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			# if(!($user = $this->getUser())){ return new JsonResponse([], 200, $header); }
			
			if($id){
				$status   = $this->removeTicketEntry($id);
				# return new JsonResponse($status, 200, $header);
				if($status && $status['status']){
					$this->addFlash('success', "Das Ticketpost Nr. {$id} wurde erfolgreich entfernt." );
				}
			}
			if($referrer){
				return $this->redirect($referrer);
			}
			# return new JsonResponse([], 200, $header);
			return $this->redirectToRoute('rte_admin_main',);
		}
		
		/**
		 * @Route("/mjr/api/v1/upload", name="rte_ajax_pix_upload")
		 *
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return bool | \Symfony\Component\HttpFoundation\JsonResponse
		 */
		public function uploadImage(Request $request) {
			header("HTTP/1.1 500 Server Error");
			return false;
			/**@var \App\Poiz\HTML\Widgets\Widget $widget */
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$header         = $this->getDefaultHeader();
			$uploadStatus   = $this->handleImageUpload();
			if(is_array($uploadStatus)){
				$baseURL                  = Octopus::getCurrentPageURL(true);
				$uploadStatus['location'] = $baseURL . "/images/uploads/". basename($uploadStatus['location']);
				return new JsonResponse($uploadStatus, 200, $header);
			}
			# return new JsonResponse([], 200, []);
			header("HTTP/1.1 500 Server Error");
			return false;
		}
		
		private function handleImageUpload(){
			// Images upload path
			$imageFolder  = __DIR__ . "/../../public/images/uploads/";
			
			reset($_FILES);
			$temp         = current($_FILES);
			
			if(is_uploaded_file($temp['tmp_name'])){
				// Sanitize input
				if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
					header("HTTP/1.1 400 Invalid file name.");
					return;
				}
				
				// Verify extension
				if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))){
					header("HTTP/1.1 400 Invalid extension.");
					return;
				}
				
				// Accept upload if there was no origin, or if it is an accepted origin
				$fileToWrite  = $imageFolder . $temp['name'];
				move_uploaded_file($temp['tmp_name'], $fileToWrite);
				
				// Respond to the successful upload with JSON.
				return ['location' => $fileToWrite];
			}
			return false;
		}
		
		private function sanitizeDataForImage(&$data){
			if(isset($data['ticketeintrag_eintrag'])){
				$cleanPost      = preg_replace("#\/?\.\.\/.*?images#", "/images", $data['ticketeintrag_eintrag']);
				$data['ticketeintrag_eintrag']  = $cleanPost;
			}
			return $data;
		}
		
		private function handleImageUploadOriginal(){
			// Allowed origins to upload images
			$accepted_origins = array("http://localhost", "http://107.161.82.130", "http://codexworld.com");

			// Images upload path
			$imageFolder      = "images/";
			
			reset($_FILES);
			$temp = current($_FILES);
			if(is_uploaded_file($temp['tmp_name'])){
				if(isset($_SERVER['HTTP_ORIGIN'])){
					// Same-origin requests won't set an origin. If the origin is set, it must be valid.
					if(in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)){
						header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
					}else{
						header("HTTP/1.1 403 Origin Denied");
						return;
					}
				}
				
				// Sanitize input
				if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
					header("HTTP/1.1 400 Invalid file name.");
					return;
				}
				
				// Verify extension
				if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))){
					header("HTTP/1.1 400 Invalid extension.");
					return;
				}
				
				// Accept upload if there was no origin, or if it is an accepted origin
				$filetowrite = $imageFolder . $temp['name'];
				move_uploaded_file($temp['tmp_name'], $filetowrite);
				
				// Respond to the successful upload with JSON.
				echo json_encode(array('location' => $filetowrite));
			} else {
				// Notify editor that the upload failed
				header("HTTP/1.1 500 Server Error");
			}
		}
		
		public function fetchTicketForm($time='07:00', $date=null) {
			$header     = $this->getDefaultHeader();
			$date       = !$date ? date('Y-m-d') : $date;
			$data       = '';
			return new JsonResponse($data, 200, $header);
		}
		
		private function getDefaultHeader(){
			return [
				'Access-Control-Allow-Origin'       => '*',
				'Access-Control-Allow-Headers'      => 'Origin, Content-Type, Accept, Authorization, X-Request-With',
				'Access-Control-Allow-Methods'      => 'GET, POST, DELETE, PUT, OPTIONS',
				'Access-Control-Allow-Credentials'  => 'true',
				'Access-Control-Max-Age'            => '86400',
				'Content-Type'                      => 'application/json',
			];
		}
		
		
	}
