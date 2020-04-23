<?php
	
	namespace App\Controller;
	
	use App\Entity\Personen;
	use App\Entity\Ticketeintrag;
	use App\Entity\Tickets;
	use App\Forms\TicketArchiveEntity;
	use App\Forms\TicketManagementEntity;
	use App\Forms\TicketManagementEntityX;
	use App\Forms\TicketPostEntity;
	use App\Forms\TicketSearchEntity;
	use App\Helpers\Date\DateCalculator;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\HTML\Forms\TicketManagementForm;
	use App\Poiz\HTML\Forms\TicketManagementFormX;
	use App\Poiz\HTML\Forms\TicketPostForm;
	use App\Poiz\HTML\Forms\TicketSearchForm;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\ORM\Query\Expr\Join;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	use function Doctrine\ORM\QueryBuilder;
	
	class TicketController extends AbstractController {
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
		 * TicketController constructor.
		 *
		 * @param \Doctrine\ORM\EntityManagerInterface                       $entityManager
		 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
		 */
		public function __construct(EntityManagerInterface $entityManager, SessionInterface $session) {
			$this->entityManager  = $entityManager;
			$this->session        = $session;
		}
		
		
		/**
		 * @Route("/admin/tickets", name="rte_admin_tickets")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Helpers\Date\DateCalculator          $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge           $rb
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Exception
		 */
		public function tickets(Request $request,  DateCalculator $dateCalculator, RequestBridge $rb) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$rb->setRequest($request);
			$rb->setUser($user);
			$rb->initialize();
			
			$melSession = $this->session->get(RequestBridge::SessionNameSpace);
			$department = ($dp = $melSession['department']) ? $dp : null;
			$month      = ($mn = $melSession['month']) ? $mn : date('m');
			$year       = ($yr = $melSession['year']) ? $yr : date('Y');
			$day        = ($yr = $melSession['day']) ? $yr : date('d');
			# $csrFToken  = ($rf = $melSession['_csrf_token']) ? $rf : null;
			
			$personen   = $this->entityManager->getRepository(Personen::class)
			                                ->findBy(['Kategorie' => 6], ['kundenid'=>'DESC']);
			$calendarAll    = $dateCalculator->buildCentralCalendar($dateCalculator->getTicketsForMonth($month, $department));
			$calendarForm   = $dateCalculator->buildCalendarForm();
			$tickets4Now    = $dateCalculator->getTicketsForActiveDate($day, $month, $year, $department);
			
			return $this->render( 'admin/index.html.twig', [
				'controller_name'   => 'AdminController',
				'calendarAll'       => $calendarAll,
				'calendarForm'      => $calendarForm,
				'user'              => $this->getUser(),
				'branchOptions'     => $personen,
				'department'        => $this->session->get(RequestBridge::SessionNameSpace)['department'],
				'error'             => null,
				'tickets4Now'       => $tickets4Now,
				'persons '          => $personen,
				'navPayload'        => $this->getNavigationPayload(),
			] );
		}
		
		/**
		 * @Route("/admin/kalender/tickets/alle-aktuellen-tickets", name="rte_admin_all_current_tickets")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Helpers\Date\DateCalculator          $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge           $rb
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Exception
		 */
		public function allCurrentTickets(Request $request,  DateCalculator $dateCalculator, RequestBridge $rb) {
			$qb   = $this->entityManager->getConnection()->createQueryBuilder();
			$and  = $qb->expr()->andX();
			$and->add($qb->expr()->neq('tkt.ticket_status', 3));
			$qb->select(
				'tkt.ticket_header',
				'tkt.ticket_kunde',
				'tkt.ticket_id',
				'tkt.ticket_MA_verantwortung',
				'tkt.ticket_endtermin',
				'tkt.ticket_zeit',
				'tst.ticket_status_name AS ticket_status',
				'ttp.ticket_typ_name AS ticket_typ',
				'tpr.ticket_prio_name AS ticket_prio',
				'tkt.ticket_gelesen',
				'psn.name AS lastName',
				'psn.Firma AS company',
				'psn.vorname AS workerFirstName',
				'CONCAT(psn.vorname, " ", psn.name) AS fullName',
				'psn.vorname AS firstName'
			)
			   ->from('tickets', 'tkt');
			#TODO: NOTE -- IF `ticket_MA_verantwortung` != 942 USE :  "AND ticket_MA_verantwortung != 942"   ELSE:   "AND tkt.ticket_MA_verantwortung=psn.kundenid"
			$qb ->leftJoin('tkt', 'personen', 'psn', 'tkt.ticket_kunde=psn.kundenid AND tkt.ticket_MA_verantwortung = psn.kundenid AND tkt.ticket_MA_verantwortung != 942')
			    ->leftJoin('tkt', 'ticket_status', 'tst', 'tst.ticket_status_id=tkt.ticket_status')
			    ->leftJoin('tkt', 'ticket_typ', 'ttp', 'ttp.ticket_typ_id=tkt.ticket_typ')
			    ->leftJoin('tkt', 'ticket_prio', 'tpr', 'tpr.ticket_prio_id=tkt.ticket_prio')
			    ->where($and)
			    ->addOrderBy('tkt.ticket_endtermin', 'ASC')
			    ->addOrderBy('tkt.ticket_zeit', 'ASC')
			    ->addOrderBy('tkt.ticket_id', 'DESC');
			/*
			    ->orderBy('tkt.ticket_zeit', 'ASC')
			    ->orderBy('tkt.ticket_endtermin', 'ASC')
			 */
			$resultSet = $qb->execute()->fetchAll();
			$this-> enhanceTicketsResultSet($resultSet);

			return $this->render( 'ticket/ticket-archive.html.twig', [
				'controller_name' => 'TicketController',
				'user'            => $this->getUser(),
				'tickets'         => $resultSet,
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Alle aktuellen Tickets',
			] );
		}
		
		
		private function enhanceTicketsResultSet(&$resultSet){
			if($resultSet){
				foreach ($resultSet as &$rayEntity){
					$clientData = $this->entityManager->getRepository(Personen::class)->find($rayEntity['ticket_kunde']);
					$clientData = $clientData ? $clientData->toArray() : [];
					$objEntity  = new TicketArchiveEntity();
					$objEntity->setTicketClient($clientData);
					$objEntity->autoSetClassProps($rayEntity);
					$rayEntity = $objEntity;
				}
			}
		}
		
		
		/**
		 * @Route("/admin/kalender/tickets/meine-tickets", name="rte_admin_my_tickets")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Helpers\Date\DateCalculator          $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge           $rb
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Exception
		 */
		public function myTickets(Request $request,  DateCalculator $dateCalculator, RequestBridge $rb) {
			$qb   = $this->entityManager->getConnection()->createQueryBuilder();
			$and  = $qb->expr()->andX();
			$and->add($qb->expr()->neq('tkt.ticket_status', 3));
			$melSession = $this->session->get(RequestBridge::SessionNameSpace);
			if(isset($melSession['department']) && $melSession['department']){
				$and->add($qb->expr()->eq('tkt.ticket_MA_verantwortung', $melSession['department']));
			}
			$qb->select(
				'tkt.ticket_header',
				'tkt.ticket_kunde',
				'tkt.ticket_id',
				'tkt.ticket_MA_verantwortung',
				'tkt.ticket_endtermin',
				'tkt.ticket_zeit',
				'tst.ticket_status_name AS ticket_status',
				'ttp.ticket_typ_name AS ticket_typ',
				'tpr.ticket_prio_name AS ticket_prio',
				'tkt.ticket_gelesen',
				'psn.name AS lastName',
				'psn.vorname AS firstName',
				'psn.Firma AS company',
				'psn.vorname AS workerFirstName',
				'CONCAT(psn.vorname, " ", psn.name) AS fullName'
			)
			   ->from('tickets', 'tkt');
			#TODO: NOTE -- IF `ticket_MA_verantwortung` != 942 USE :  "AND ticket_MA_verantwortung != 942"   ELSE:   "AND tkt.ticket_MA_verantwortung=psn.kundenid"
			$qb ->leftJoin('tkt', 'personen', 'psn', 'tkt.ticket_kunde=psn.kundenid AND tkt.ticket_MA_verantwortung = psn.kundenid AND tkt.ticket_MA_verantwortung != 942')
			    ->leftJoin('tkt', 'ticket_status', 'tst', 'tst.ticket_status_id=tkt.ticket_status')
			    ->leftJoin('tkt', 'ticket_typ', 'ttp', 'ttp.ticket_typ_id=tkt.ticket_typ')
			    ->leftJoin('tkt', 'ticket_prio', 'tpr', 'tpr.ticket_prio_id=tkt.ticket_prio')
			    ->where($and)
			    ->addOrderBy('tkt.ticket_endtermin', 'ASC')
			    ->addOrderBy('tkt.ticket_zeit', 'ASC')
			    ->addOrderBy('tkt.ticket_id', 'DESC');
			$resultSet = $qb->execute()->fetchAll();
			
			$this->enhanceTicketsResultSet($resultSet);
			
			return $this->render( 'ticket/ticket-archive.html.twig', [
				'controller_name' => 'TicketController',
				'user'            => $this->getUser(),
				'tickets'         => $resultSet,
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Meine Tickets',
			] );
		}
		
		/**
		 * @Route("/ticket", name="ticket")
		 */
		public function index() {
			return $this->render( 'ticket/index.html.twig', [
				'controller_name' => 'TicketController',
			] );
		}
		
		/**
		 * @Route("/admin/kalender/tickets/bearbeiten/{id}", name="rte_admin_edit_ticket")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Helpers\Date\DateCalculator          $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge           $rb
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 * @param mixed                                     $id
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function editTicket(Request $request,  DateCalculator $dateCalculator, RequestBridge $rb, ShopTranslator $translator, $id) {
			/**@var Tickets $ticket*/
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$ticket         = $this->entityManager->getRepository(Tickets::class)->find($id);
			$rayTicketData  = $ticket->initializeEntityBank();
			$ticket         = new TicketManagementEntity();
			$ticket->autoSetClassProps($rayTicketData);
			$ticketForm     = new TicketManagementForm($ticket);
			$ticketForm->setTranslator($translator);
			
			if(($ticket = $ticketForm->isValid($request->request->all())) ){
				dump($ticket);
			}
			
			return $this->render( 'ticket/new-ticket.html.twig', [
				'controller_name' => 'TicketController',
				'ticket'          => $ticket,
				'formWidgets'     => $ticketForm->getForm(),
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => "Ticketnr. {$id} bearbeiten",
				'btnText'         => 'Jetzt aktualisieren',
				'clientID'        => NULL,
				'ticketID'        => $id,
			] );
		}
		
		/**
		 * @Route("/admin/kalender/tickets/post-entfernen/{id}/{tid}", name="rte_admin_delete_ticket_entry")
		 * @param mixed $id
		 * @param mixed $tid
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse
		 */
		public function deleteTicketEntry(Request $request, $id, $tid) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			if($id){
				$status   = $this->removeTicketEntry($id);
				if($status && $status['status'] == 1){
					$this->addFlash( 'success', "Das Ticketpost Nr. {$id} wurde erfolgreich entfernt...");
					#return $this->redirectToRoute( 'rte_admin_ticket_detail', ['id' => $status['ticketID']] );
				}else{
					$this->addFlash( 'error', "Error: Das Ticketpost Nr. {$id} könnte nicht geloöscht werden...");
				}
			}
			return $this->redirectToRoute( 'rte_admin_ticket_detail', ['id' => $tid] );
		}
		
		/**
		 * @Route("/admin/kalender/tickets/entfernen/{id}", name="rte_admin_delete_ticket")
		 * @param $id
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse
		 */
		public function deleteTicket($id) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			if($id){
				$status   = $this->removeTicket($id);
				if($status && $status['status'] == 1){
					$this->addFlash( 'success', "Das Ticket Nr. {$id} wurde erfolgreich entfernt...");
					return $this->redirectToRoute( 'rte_admin_my_tickets', [] );
				}else{
					$this->addFlash( 'error', "Error: Das Ticket Nr. {$id} könnte nicht geloöscht werden...");
				}
			}
			return $this->redirectToRoute( 'rte_admin_ticket_detail', ['id' => $id] );
		}
		
		/**
		 * @Route("/admin/kalender/tickets/archive", name="rte_admin_ticket_archive")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function ticketArchive(Request $request) {
			$qb   = $this->entityManager->getConnection()->createQueryBuilder();
			$and  = $qb->expr()->andX();
			$and->add($qb->expr()->lt('tkt.ticket_status', 3));
			$qb->select(
				'tkt.ticket_header',
							 'tkt.ticket_kunde',
							 'tkt.ticket_id',
							 'tkt.ticket_MA_verantwortung',
							 'tkt.ticket_endtermin',
							 'tkt.ticket_zeit',
							 'tst.ticket_status_name AS ticket_status',
							 'ttp.ticket_typ_name AS ticket_typ',
							 'tpr.ticket_prio_name AS ticket_prio',
							 'tkt.ticket_gelesen',
							 'psn.name AS lastName',
							 'psn.Firma AS company',
							 'psn.vorname AS workerFirstName',
							 'CONCAT(psn.vorname, " ", psn.name) AS fullName',
							 'psn.vorname AS firstName'
				)
			   ->from('tickets', 'tkt');
				#TODO: NOTE -- IF `ticket_MA_verantwortung` != 942 USE :  "AND ticket_MA_verantwortung != 942"   ELSE:   "AND tkt.ticket_MA_verantwortung=psn.kundenid"
			  $qb ->leftJoin('tkt', 'personen', 'psn', 'tkt.ticket_kunde=psn.kundenid AND ticket_MA_verantwortung != 942')
			      ->leftJoin('tkt', 'ticket_status', 'tst', 'tst.ticket_status_id=tkt.ticket_status')
			      ->leftJoin('tkt', 'ticket_typ', 'ttp', 'ttp.ticket_typ_id=tkt.ticket_typ')
			      ->leftJoin('tkt', 'ticket_prio', 'tpr', 'tpr.ticket_prio_id=tkt.ticket_prio')
			   ->where($and)
				  ->orderBy('tkt.ticket_endtermin', 'ASC');
			$resultSet = $qb->execute()->fetchAll();
			/*
			if($resultSet){
				foreach ($resultSet as &$rayEntity){
					$clientData = $this->entityManager->getRepository(Personen::class)->find($rayEntity['ticket_kunde']);
					$clientData = $clientData ? $clientData->toArray() : [];
					$objEntity  = new TicketArchiveEntity();
					$objEntity->setTicketClient($clientData);
					$objEntity->autoSetClassProps($rayEntity);
					$rayEntity = $objEntity;
				}
			}
			*/
			$this->enhanceTicketsResultSet($resultSet);
			
			return $this->render( 'ticket/ticket-archive.html.twig', [
				'controller_name' => 'TicketController',
				'user'            => $this->getUser(),
				'tickets'         => $resultSet,
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Ticketarchiv',
			] );
			
		}
	
		/**
		 * @Route("/admin/kalender/tickets/neu", name="rte_admin_new_ticket")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function newTicket(Request $request, ShopTranslator $translator) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$ticket         = new TicketManagementEntity();
			$ticketForm     = new TicketManagementForm($ticket);
			$ticketForm->setTranslator($translator);
			
			if(($ticket = $ticketForm->isValid($request->request->all())) ){
				// CREATE A NEW TICKET -- ONLY TICKET WITHOUT ENTRIES....
				$payload  = $this->saveTicket($ticket->getEntityBank(), false);
				if($payload['status']){ // `$payload` CONTAINS: status, ticketID, message
					$this->addFlash( 'success', $payload['message'] );
					$this->addOrUpdateTicketEntry($ticket->getEntityBank(), $payload['ticketID']);
					return $this->redirectToRoute( 'rte_admin_ticket_detail', ['id' => $payload['ticketID'] ] );
				}
			}
			
			return $this->render( 'ticket/new-ticket.html.twig', [
				'controller_name' => 'TicketController',
				'ticket'          => $ticket,
				'formWidgets'     => $ticketForm->getForm(),
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Ein neues Ticket erstellen',
				'btnText'         => 'Jetzt erstellen',
				'clientID'        => NULL,
				'ticketID'        => NULL,
			] );
			
		}
		
		/**
		 * @Route("/admin/kalender/tickets/ticket-suchen", name="rte_admin_search_tickets")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Helpers\Date\DateCalculator          $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge           $rb
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function searchTickets(Request $request,  DateCalculator $dateCalculator, RequestBridge $rb, ShopTranslator $translator) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$ticket         = new TicketSearchEntity();
			$ticketForm     = new TicketSearchForm($ticket);
			$searchHits     = [];
			$pageTitle      = 'Ticket suchen';
			$ticketForm->setTranslator($translator);
			
			if(($ticket = $ticketForm->isValid($request->request->all())) ){
				$pageTitle  = 'Ticket suchen -- Suchergebnisse...';
				$searchHits = $this->entityManager->getRepository(Tickets::class)->searchTickets($ticket, true);
			}
			
			return $this->render( 'ticket/search-tickets.html.twig', [
				'controller_name' => 'TicketController',
				'ticket'          => $ticket,
				'formWidgets'     => $ticketForm->getForm(),
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => $pageTitle,
				'btnText'         => 'Los',
				'searchHits'      => $searchHits,
				'clientID'        => NULL,
				'ticketID'        => NULL,
			] );
		}
		
		/**
		 * @Route("/admin/kalender/tickets/ticket-detail/{id}", name="rte_admin_ticket_detail")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Helpers\Date\DateCalculator          $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge           $rb
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function ticketDetailsViewAndEdit(Request $request,  DateCalculator $dateCalculator, RequestBridge $rb, ShopTranslator $translator, $id) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$ticketMain     = $this->entityManager->getRepository(Tickets::class)->find($id);
			$ticketEntry    = $this->entityManager->getRepository(Ticketeintrag::class)->findOneBy(['ticketeintrag_ticket_id' => $id]);
			$rayTicket      = $ticketMain->getEntityBank();
			$ticket         = new TicketManagementEntityX();
			$ticket->autoSetClassProps($rayTicket);
			# $ticket->setTicketeintragEintrag($ticketEntry->getTicketeintragEintrag());
			$ticketForm     = new TicketManagementFormX($ticket, $translator, true);
			$ticketForm->setTranslator($translator);
			$ticketsCombo   = $this->fetchTicketsCombo($ticket);
			
			// TICKET ENTRY/POST
			$ticketPostObj  = new TicketPostEntity();
			$ticketPostForm = new TicketPostForm($ticketPostObj, $translator, true, ['formKey'=>'new_ticket_post']);
			$postVars       = $request->request->all();
			
			if(isset($postVars['new_ticket_post'])){
				if(($tkt = $ticketPostForm->isValid($postVars['new_ticket_post'])) ) {
					$tkt->setTicketeintragTicketId($id);
					$entityBank = array_merge($tkt->getEntityBank(), ['ticket_endtermin'=> $tkt->getTicketeintragDatum()]);
					$status = $this->addOrUpdateTicketEntry($entityBank, $id);
					if($status && $status['status']){
						$this->addFlash('success', "Dem Ticket Nr. {$id} wurde ein neuer beitrag erfolgreich hinzugefügt.");
						return $this->redirectToRoute('rte_admin_ticket_detail', ['id'=>$id]);
					}
				}else{
					$this->addFlash('error', 'Es gibt Fehler mit dem eingereichten Formular.');
				}
			}else{
				if(isset($postVars['ticket_header'])){
					if(($tkt = $ticketForm->isValid($postVars)) ){
						$statusX  = $this->saveTicket($tkt->getEntityBank(), $tkt->getTicketId());
						if($statusX && $statusX['status']){
							$this->addFlash('success', "Das Ticket Nr. {$id} wurde erfolgreich aktualisiert.");
							return $this->redirectToRoute('rte_admin_ticket_detail', ['id'=>$id]);
						}
					}else{
						$this->addFlash('error', 'Es gibt Fehler mit dem eingereichten Formular.');
					}
				}
			}
			
			return $this->render( 'ticket/ticket-details-edit.html.twig', [
				'controller_name' => 'TicketController',
				'tickets'         => $ticketsCombo,
				'formWidgets'     => $ticketForm->getForm(),
				'postWidgets'     => $ticketPostForm->getForm(),
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Ticket bearbeiten --- mit Vorschau',
				'btnText'         => 'Los',
				'clientID'        => NULL,
				'ticketID'        => NULL,
			] );
		}
		
		/**
		 * @param $ticket
		 *
		 * @return mixed
		 */
		private function fetchTicketsCombo($ticket){
			/**@var TicketManagementEntity $ticket */
			$resultSet  = $this->entityManager->getRepository(Tickets::class)->fetchTicketForCompanyBranchByID($ticket->getTicketMAVerantwortung(), $ticket->getTicketId(), true);
			return $resultSet;
		}
	
		private function fetchTicketsCombo2($ticket){
			/**@var TicketManagementEntity $ticket */
			$qb         = $this->entityManager->createQueryBuilder();
			$ticketTime = $ticket->getTicketZeit();
			$ticketDate = $ticket->getTicketEndtermin();
			$ticketHour = preg_replace("#:+#", "", $ticketTime);
			
			
			$whereCond  = $qb->expr()->andX();
			$whereCond->add($qb->expr()->eq('ticket_endtermin', $qb->expr()->literal( $ticketDate->format('Y-m-d') ) ) );
			$whereCond->add($qb->expr()->like('ticket_zeit', $qb->expr()->literal("%{$ticketHour}%") ) );
			
			$qb ->select('tkt', 'ten.ticketeintrag_eintrag')
					->from('tickets', 'tkt')
					->where($whereCond)
					->leftJoin('ticketeintrag', 'ten',  Join::ON, 'ten.ticketeintrag_ticket_id = tkt.ticket_id')
					->addOrderBy('tkt.ticket_zeit', 'ASC');
			
			$q        = $qb->getQuery();
			return $q->execute();
		}
	}
