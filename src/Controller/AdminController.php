<?php
	
	namespace App\Controller;
	
	use App\Entity\Arbeitszeit;
	use App\Entity\Personen;
	use App\Entity\Tickets;
	use App\Forms\ClientQuickSearchEntity;
	use App\Forms\ClientSearchEntity;
	use App\Forms\PriorityStatusTypeEntity;
	use App\Forms\TicketManagementEntity;
	use App\Forms\WorkStatisticsEntity;
	use App\Helpers\Date\Calendar;
	use App\Helpers\Date\DateCalculator;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\HTML\Forms\ClientForm;
	use App\Poiz\HTML\Forms\ClientQuickSearchForm;
	use App\Poiz\HTML\Forms\ClientSearchForm;
	use App\Poiz\HTML\Forms\PriorityStatusTypeForm;
	use App\Poiz\HTML\Forms\TicketManagementForm;
	use App\Poiz\HTML\Forms\WorkerTimeLoggingForm;
	use App\Poiz\HTML\Forms\WorkStatisticsForm;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Carbon\Carbon;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	
	class AdminController extends AbstractController {
		use AdminControllerHelperTrait;
		/**
		 * @var \Doctrine\ORM\EntityManagerInterface
		 */
		private $entityManager;
		
		/**
		 * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
		 */
		private $session;
		
		/**
		 * @var array
		 */
		private $melSession = [];
		
		/**
		 * @var ShopTranslator
		 */
		private $translator = [];
		
		const IPP_DEFAULT         = 50;
		const MAX_RECORDS_DEFAULT = 20;
		const DEFAULT_PAGE_NUM    = 1;
		
		
		/**
		 * AdminController constructor.
		 *
		 * @param \Doctrine\ORM\EntityManagerInterface                       $entityManager
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator                      $Translator
		 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
		 */
		public function __construct(EntityManagerInterface $entityManager,ShopTranslator $translator, SessionInterface $session) {
			$this->entityManager  = $entityManager;
			$this->session        = $session;
			$this->translator     = $translator;
		}
		
		private function getExactWeekStart(){
			$de           = Carbon::parse("2019-12-20");  //now('Europe/Zurich');
			$de->timezone = 'Europe/Zurich';
			$weekStart    = $de->startOfWeek()->format('Y-m-d');
			$weekStop     = $de->endOfWeek()->format('Y-m-d');
		}
		
		/**
		 * @Route("/admin", name="rte_admin_main")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Helpers\Date\DateCalculator          $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge           $rb
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Exception
		 */
		public function index(Request $request,  DateCalculator $dateCalculator, RequestBridge $rb) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$rb->setRequest($request);
			$rb->setUser($user);
			$user = $rb->initialize();
			
			$melSession = $this->session->get(RequestBridge::SessionNameSpace);
			$department = ($dp = $melSession['department']) ? $dp : null;
			$month      = ($mn = $melSession['month'])      ? $mn : date('m');
			$year       = ($yr = $melSession['year'])       ? $yr : date('Y');
			$day        = ($yr = $melSession['day'])        ? $yr : date('d');
			$personen       = $this->entityManager->getRepository(Personen::class)
			                                ->findBy(['Kategorie' => 6], ['kundenid'=>'DESC']);
			$tickets4Now    = $dateCalculator->getTicketsForActiveDate($day, $month, $year, $department);
			$calendarAll    = $dateCalculator->buildCentralCalendar($dateCalculator->getTicketsForMonth($month, $department), $tickets4Now);
			$calendarForm   = $dateCalculator->buildCalendarForm();
			$tickets4Week   = $dateCalculator->getTicketsForActiveWeek($day, $month, $year, $department);
			return $this->render( 'admin/index.html.twig', [
				'controller_name'   => 'AdminController',
				'pageTitle'         => 'Kalender',
				'calendarAll'       => $calendarAll,
				'calendarForm'      => $calendarForm,
				'pstForm'           => $dateCalculator->buildPriorityStatusTypeBox(),
				'pstFormW'          => $dateCalculator->buildPriorityStatusTypeBox(true),
				'user'              => $user,
				'branchOptions'     => $personen,
				'ticketFormWidgets' => $this->getTicketForm(),
				'department'        => $this->session->get(RequestBridge::SessionNameSpace)['department'],
				'error'             => null,
				'tickets4TheDay'    => $tickets4Now,
				'tickets4TheWeek'   => $tickets4Week,
				'navPayload'        => $this->getNavigationPayload(),
				'persons'           => $personen
			] );
		}
		
		/**
		 * @Route("/admin/kalender", name="rte_admin_calendar")
		 */
		public function calendar(Request $request,  DateCalculator $dateCalculator, RequestBridge $rb) {
			return $this->index($request, $dateCalculator, $rb);
		}
		/**
		 * @Route("/admin/verwalten", name="rte_admin_manage")
		 */
		public function manage(Request $request,  DateCalculator $dateCalculator, RequestBridge $rb) {
			return $this->index($request, $dateCalculator, $rb);
		}
		
		/**
		 * @Route("/dashboard", name="rte_admin_user")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 * @param \App\Helpers\Date\DateCalculator          $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge           $rb
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 * @throws \Exception
		 */
		public function dashboard(Request $request, DateCalculator $dateCalculator, RequestBridge $rb) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			
			$rb->setRequest($request);
			$rb->setUser($user);
			$rb->initialize();
			
			$melSession = $this->session->get(RequestBridge::SessionNameSpace);
			$department = ($dp = $melSession['department']) ? $dp : null;
			$month      = ($mn = $melSession['month']) ? $mn : date('m');
			$year       = ($yr = $melSession['year']) ? $yr : date('Y');
			$day        = ($yr = $melSession['day']) ? $yr : date('d');
			
			if($user->getPersonId() == "2621"){
				return $this->redirectToRoute('rte_admin_sales_by_category');
			}
			$pstEntity      = new PriorityStatusTypeEntity();
			$pstForm        = new PriorityStatusTypeForm($pstEntity);
			$formWidgets    = $pstForm->getForm();
			
			if($department){
				$startDate  = new \DateTime("{$year}-{$month}-{$day}");
				$endDate    = new \DateTime("{$year}-{$month}-{$day}");
				$startDate  = $startDate->sub(new \DateInterval('P4D'));
				$endDate    = $endDate->add(new \DateInterval('P4D'));
				$qb   = $this->entityManager->getConnection()->createQueryBuilder();
				$and  = $qb->expr()->andX();
				$and->add($qb->expr()->gte('tkt.ticket_endtermin', '"' . $startDate->format('Y-m-d').'"' ));
				$and->add($qb->expr()->lte('tkt.ticket_endtermin', '"' .$endDate->format('Y-m-d').'"' ));
				$and->add($qb->expr()->eq('tkt.ticket_MA_verantwortung', $department));
				$and->add($qb->expr()->eq('tkt.ticket_typ', 1));
				$and->add($qb->expr()->lt('tkt.ticket_status', 3));
			}
			
			$personen = $this->entityManager->getRepository(Personen::class)
			                                ->findBy(['Kategorie' => 6], ['kundenid'=>'DESC']);
			$tickets4Now    = $dateCalculator->getTicketsForActiveDate($day, $month, $year, $department);
			$calendarAll    = $dateCalculator->buildCentralCalendar($dateCalculator->getTicketsForMonth($month, $department), $tickets4Now);
			$calendarForm   = $dateCalculator->buildCalendarForm();
			$tickets4Week   = $dateCalculator->getTicketsForActiveWeek($day, $month, $year, $department);
			return $this->render( 'admin/dashboard.html.twig', [
				'controller_name'   => 'AdminController',
				'calendarAll'       => $calendarAll,
				'pageTitle'         => 'Kalender',
				'pstForm'           => $dateCalculator->buildPriorityStatusTypeBox(),
				'pstFormW'          => $dateCalculator->buildPriorityStatusTypeBox(true),
				'calendarForm'      => $calendarForm,
				'user'              => $this->getUser(),
				'branchOptions'     => $personen,
				'ticketFormWidgets' => $this->getTicketForm(),
				'department'        => $this->session->get(RequestBridge::SessionNameSpace)['department'],
				'error'             => null,
				'tickets4TheDay'    => $tickets4Now,
				'tickets4TheWeek'   => $tickets4Week,
				'navPayload'        => $this->getNavigationPayload(),
				'persons'           => $personen
			] );
		}
		
    private function getTicketForm(){
	    if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
	    $ticket         = new TicketManagementEntity();
	    $ticketForm     = new TicketManagementForm($ticket);
	    $ticketForm->setTranslator($this->translator);
	    return $ticketForm->getForm();
    }
	}
