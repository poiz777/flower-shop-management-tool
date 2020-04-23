<?php
	
	namespace App\Controller;
	
	use App\Entity\Arbeitszeit;
	use App\Entity\Personen;
	use App\Forms\CoWorkerEntryEntity;
	use App\Forms\WorkStatisticsEntity;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\HTML\Forms\CoWorkerEntryForm;
	use App\Poiz\HTML\Forms\WorkerTimeLoggingForm;
	use App\Poiz\HTML\Forms\WorkStatisticsForm;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	
	class   CoWorkerController extends AbstractController {
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
		private $translator;
		
		/**
		 * AdminController constructor.
		 *
		 * @param \Doctrine\ORM\EntityManagerInterface                       $entityManager
		 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator                      $translator
		 */
		public function __construct(EntityManagerInterface $entityManager, SessionInterface $session, ShopTranslator $translator) {
			$this->entityManager  = $entityManager;
			$this->session        = $session;
			$this->translator     = $translator;
		}
		/**
		 * @Route("/co/worker", name="co_worker")
		 */
		public function index() {
			return $this->render( 'co_worker/index.html.twig', [
				'controller_name' => 'CoWorkerController',
			] );
		}
		
		/**
		 * @Route("/admin/mitarbeitern", name="rte_admin_co_workers")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse
		 */
		public function coWorkers(Request $request) {
			return $this->redirectToRoute("rte_admin_manage_coworkers");      // '/admin/mitarbeitern/arbeitszeit-eintragen');
		}
		
		/**
		 * @Route("/admin/mitarbeitern/arbeitszeit-eintragen", name="rte_admin_log_work_time")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function logWorkTime(Request $request) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			// TODO : CHECK PERMISSIONS VIA ROLES BEFORE ALLOWING ACTIONS TO USER...
			$workTimeObj  = new Arbeitszeit();
			$form         = new WorkerTimeLoggingForm($workTimeObj, $this->translator);
			$workTimeObj  = $form->isValid($request->request->all());
			if($request->query->has('export')){
				$id = $request->query->get('id', 0);
				return $this->handleFullExport($request->query->get('export'),
					[
						'fileTitle' => $request->query->get('t') == 'mwl' ? "monat-arbeitsstatistik-{$id}--" . date("Y-m-d") : null,
						'type'      => $request->query->get('t'),
						'collection' => $this->fetchCoWorkerMonthWorkload($request->query->get('id'))
					]);
			}
			
			if($workTimeObj){
				$timeLogCount = $this->coWorkerHasLoggedTimeEntryToday($workTimeObj);
				if($timeLogCount>0){
					$coWorkerID = $workTimeObj->getArbeitszeitMa();
					$tLogDate   = $workTimeObj->getArbeitszeitDate()->format("d.m.Y");
					$message    = "<strong>Zeiterfassung ist nur 1 mal am Tag möglich.</strong><br /> ";
					$message   .= "<strong>Mitarbeiter</strong> mit ID <strong>{$coWorkerID}</strong> hat seine Zeit bereits <strong>{$timeLogCount} Mal am {$tLogDate}</strong> protokolliert...<br/>";
					$message   .= "Bitte wende dich an den Administrator, wenn ein Problem aufgetreten ist.";
					$this->addFlash('warning', $message);
					return $this->redirectToRoute('rte_admin_log_work_time');
				}
				$totalWorkTime  = $workTimeObj->getArbeitszeitStdMg() +  $workTimeObj->getArbeitszeitStdHg() +  $workTimeObj->getArbeitszeitStdExtern();
				$workTimeObj->setArbeitszeitStdTotal($totalWorkTime);
				$this->entityManager->persist($workTimeObj);
				$this->entityManager->flush();
				$this->addFlash('success', "Zeit erfassung von «{$workTimeObj->getCoWorkerByID($workTimeObj->getArbeitszeitMa())}» für " . $workTimeObj->getArbeitszeitDate()->format('d.m.Y') . " wurde eingetragen.");
				// return $this->redirectToRoute('rte_admin_coworker_month_workload', ['coWorkerID' => $workTimeObj->getArbeitszeitMa()]);
				
				return $this->coWorkerMonthWorkload($request, $workTimeObj->getArbeitszeitMa());
			}
			
			return $this->render( 'co_worker/log-time-entry.html.twig', [
				'controller_name' => 'AdminController',
				'formWidgets'     => $form->getForm(),
				'user'            => $this->getUser(),
				'coWorkers'       => $this->fetchCoWorkers(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Arbeitszeit eintragen',
				'btnText'         => 'Sofort eintragen',
			] );
		}
		
		private function coWorkerHasLoggedTimeEntryToday(Arbeitszeit $workTimeObj){
			# 1ST CHECK IF CO-WORKER HAS LOGGED TIME-ENTRY ON THIS SPECIFIC DATE,
			# AND IF SO, INFORM HIM THAT HE CAN ONLY LOG HIS TIME ENTRY ONCE PER DAY....
			$conn         = $this->entityManager->getConnection();
			$timeLogDate  = $workTimeObj->getArbeitszeitDate()->format("Y-m-d");
			$sql          = " SELECT COUNT(`abz`.`Arbeitszeit_id`) FROM `Arbeitszeit` AS `abz` ";
			$sql         .= " WHERE DATE(`abz`.`Arbeitszeit_date`) =:WK_DATE ";
			$sql         .= " AND `abz`.`Arbeitszeit_ma` =:WK_ID ";
			$statement    = $conn->prepare($sql);
			$statement->execute([':WK_DATE'=>$timeLogDate, ':WK_ID'=>$workTimeObj->getArbeitszeitMa()]);
			$result       = $statement->fetchColumn();
			return (int)$result;
		}
		private function getFormByTask($task, $id=null){
			/**@var Personen $cw */
			$coWorker     = new CoWorkerEntryEntity();
			$cw           = null;
			
			if($id){
				$cw         = $this->entityManager->getRepository(Personen::class)->find($id);
				$coWorker->autoSetClassProps($cw->getEntityBank());
			}
			
			$coWorkerForm = new CoWorkerEntryForm($coWorker, $this->translator);
			
			switch(strtolower($task)){
				case 'edit':
				case 'bearbeiten':
				case 'bearbeitung':
					$title        = 'Mitarbeiter: "' . (($cw ? "{$cw->getVorname()} {$cw->getName()} --  {$cw->getKundenid()}" : "")) . "\" bearbeiten.";
					break;
					
				case 'delete':
				case 'loschen':
				case 'löschen':
				case 'loeschen':
				case 'entfernen':
					// TODO: DECIDE WHETHER TO USE A FLAG AND TURN IT ON/OFF OR TO ACTUALLY DELETE ENTRY
					$title        = 'Mitarbeiter: "' . (($cw ? "{$cw->getVorname()} {$cw->getName()} --  {$cw->getKundenid()}" : "")) . "\" wurde erfolgreich deaktiviert.";
					if($cw){
						$cw->setDeleted(1);
						$this->entityManager->persist($cw);
						$this->entityManager->flush();
					}
					break;
					
				case 'new':
				case 'neue':
				case 'neu':
					$title        = "Neu Mitarbeiter erstellen";
					// TODO: DECIDE WHETHER TO USE A FLAG AND TURN IT ON/OFF OR TO ACTUALLY DELETE ENTRY
					break;
					
				default:
					$title        = "Mitarbeiter verwalten.";
					break;
			}
			
			return [
				'title'         => $title,
				'widgets'       => $coWorkerForm->getForm(),
				'coWorker'      => $coWorker,
				'coWorkerForm'  => $coWorkerForm,
				'coWorkerMain'  => $cw,
			];
		}
		
		/**
		 * # POSSIBLE ADDITION TO THE ROUTE:  , requirements={"page"="\d+"}
		 * @Route("/admin/mitarbeitern/verwalten/{task}/{id}", name="rte_admin_manage_coworkers")
		 *
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @param mixed                                     $id
		 * @param mixed                                     $task
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function manageCoWorkers(Request $request, $id=null, $task=null) {
			/**
			 * @var Personen            $coWorkerMain
			 * @var CoWorkerEntryForm   $coWorkerForm
			 * @var CoWorkerEntryEntity $coWorkerObj
			 */
			$rayFormAndTitle  = null;
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			else if(!in_array('ROLE_ADMIN', $user->getRoles())){return $this->redirectToRoute('rte_admin_log_work_time');}
			
			$postVars           = $request->request->all();
			$coWorkerForm       = null;
			if($task){
				$rayFormAndTitle  = $this->getFormByTask($task, $id);
				
				if(isset($rayFormAndTitle['coWorker'])){
					$coWorkerForm   = $rayFormAndTitle['coWorkerForm'];
					$coWorkerMain   = $rayFormAndTitle['coWorkerMain'];
				}
				
				if(in_array($task, ['delete', 'loschen', 'löschen', 'loeschen', 'entfernen'])){
					$coWorkerName = trim("{$coWorkerMain->getVorname()} {$coWorkerMain->getName()}");
					$message      = "Der Mitarbeiter, <strong>«{$coWorkerName}»</strong>, wurde erfolgreich deaktivieirt.";
					$this->addFlash('success', $message);
					return $this->redirectToRoute('rte_admin_manage_coworkers');
				}
				
				if($coWorkerForm && $postVars && $coWorkerMain){
					if($coWorkerObj = $coWorkerForm->isValid($postVars)){
						$coWorkerMain->autoSetClassProps($coWorkerObj->getEntityBank());
						$this->entityManager->persist($coWorkerMain);
						$this->entityManager->flush();
						$coWorkerName = trim("{$coWorkerObj->getVorname()} {$coWorkerObj->getName()}");
						$message      = "Mitarbeiter Daten von <strong>«{$coWorkerName}»</strong> wurde erfolgreich aktualisiert.";
						$this->addFlash('success', $message);
						return $this->redirectToRoute('rte_admin_manage_coworkers');
					}
				}
				
			}
			return $this->render( 'co_worker/co-workers.html.twig', [
				'controller_name' => 'CoWorkerController',
				'user'            => $this->getUser(),
				'btnText'         => "Los",
				'coWorkers'       => $this->fetchCoWorkers(),
				'formWidgets'     => $rayFormAndTitle && isset($rayFormAndTitle['widgets']) ? $rayFormAndTitle['widgets'] : null ,
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => $rayFormAndTitle && isset($rayFormAndTitle['title']) ? $rayFormAndTitle['title']: 'Mitarbeitern verwalten',
			] );
			
		}
		
		/**
		 * # POSSIBLE ADDITION TO THE ROUTE:  , requirements={"page"="\d+"}
		 * @Route("/admin/mitarbeitern/arbeitszeit-eintragen/monats-arbeits-pensum", name="rte_admin_coworker_month_workload")
		 *
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param null                                      $coWorkerID
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function coWorkerMonthWorkload(Request $request, $coWorkerID) {
			/**@var Personen $coWorker */
			$rayFormAndTitle  = null;
			
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$coWorker     = $this->entityManager->getRepository(Personen::class)->find($coWorkerID);
			
			return $this->render( 'co_worker/month-workload.html.twig', [
				'controller_name' => 'CoWorkerController',
				'user'            => $this->getUser(),
				'coWorkerID'      => $coWorkerID,
				'workload'        => $this->fetchCoWorkerMonthWorkload($coWorkerID),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => "Monats ArbeitsStatistik für Mitarbeiter: {$coWorker->getVorname()} {$coWorker->getName()}.",
			] );
			
		}
		
		protected function fetchCoWorkerMonthWorkload($coWorkerID){
			$qb       = $this->entityManager->getConnection()->createQueryBuilder();
			$and      = $qb->expr()->andX();
			$and->add($qb->expr()->eq('wtm.Arbeitszeit_ma', $qb->expr()->literal($coWorkerID) ) );
			$and->add($qb->expr()->eq('MONTH(wtm.Arbeitszeit_date)', $qb->expr()->literal(date('m')) ) );
			$and->add($qb->expr()->eq('YEAR(wtm.Arbeitszeit_date)', $qb->expr()->literal(date('Y')) ) );
			# $and->add($qb->expr()->gte('wtm.Arbeitszeit_date', $qb->expr()->literal( $dateStrB ) ) );
			# $and->add($qb->expr()->lt('wtm.Arbeitszeit_date', $qb->expr()->literal( $dateStrE ) ) );
			$qb->select( 'wtm.*')
			   ->from('Arbeitszeit', 'wtm')
			   ->where($and);
			return $qb->execute()->fetchAll();
		}
		
		/**
		 * @Route("/admin/mitarbeitern/neu", name="rte_admin_new_coworker")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function newCoWorker(Request $request) {
			/**
			 * @var CoWorkerEntryForm   $coWorkerForm
			 * @var CoWorkerEntryEntity $coWorkerObj
			 */
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$postVars         = $request->request->all();
			$coWorkerForm     = null;
			$rayFormAndTitle  = $this->getFormByTask('neu', null);
			
			if(isset($rayFormAndTitle['coWorker'])){
				$coWorkerForm   = $rayFormAndTitle['coWorkerForm'];
			}
			
			if($coWorkerForm && $postVars){
				if($coWorkerObj = $coWorkerForm->isValid($postVars)){
					$coWorker     = new Personen();
					$coWorker->autoSetClassProps($coWorkerObj->getEntityBank());
					$coWorker->setKategorie(10);
					$coWorker->setPasswort('void');
					$this->entityManager->persist($coWorker);
					$this->entityManager->flush();
					$coWorkerName = trim("{$coWorkerObj->getVorname()} {$coWorkerObj->getName()}");
					$message      = "Ein neuer Mitarbeiter, <strong>«{$coWorkerName}»</strong>, wurde erfolgreich erstellt.";
					$this->addFlash('success', $message);
					return $this->redirectToRoute('rte_admin_manage_coworkers');
				}
			}
			
			return $this->render( 'co_worker/co-workers.html.twig', [
				'controller_name' => 'CoWorkerController',
				'user'            => $this->getUser(),
				'btnText'         => "Los",
				'coWorkers'       => $this->fetchCoWorkers(),
				'formWidgets'     => $rayFormAndTitle && isset($rayFormAndTitle['widgets']) ? $rayFormAndTitle['widgets'] : null ,
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => $rayFormAndTitle && isset($rayFormAndTitle['title']) ? $rayFormAndTitle['title']: 'Mitarbeitern verwalten',
			] );
		}
		
		/**
		 * @Route("/admin/mitarbeitern/arbeitszeit-statistik", name="rte_admin_work_time_statistics")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 * @throws \Exception
		 */
		public function workStatistics(Request $request) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			// TODO : CHECK PERMISSIONS VIA ROLES BEFORE ALLOWING ACTIONS TO USER...
			$workTimeObj  = new WorkStatisticsEntity();
			if($request->request->has('end_date')){
				$workTimeObj->setEndDate((new \DateTime($request->request->get('end_date'))));  // ->format('Y-m-d')
			}
			if($request->request->has('start_date')){
				$workTimeObj->setStartDate((new \DateTime($request->request->get('start_date'))));
			}
			$form         = new WorkStatisticsForm($workTimeObj, $this->translator);
			$timeSheet    = [];
			$coWorkerID   = null;
			$target       = "";
			
			if(($workTimeObj = $form->isValid($request->request->all())) ){
				$end          = $workTimeObj->getEndDate()->format('Y-m-d');
				$start        = $workTimeObj->getStartDate()->format('Y-m-d');
				$sql          = "SELECT a from App\Entity\Arbeitszeit a where (a.Arbeitszeit_date >=:SD AND a.Arbeitszeit_date <=:ED) AND a.Arbeitszeit_ma =:WK ORDER BY a.Arbeitszeit_date DESC";
				$dql          = $this->entityManager->createQuery($sql);
				$coWorkerID   = $workTimeObj->getCoWorker();
				$timeSheet    = $dql->execute(['SD'=>$start, 'ED'=> $end, 'WK'=> $coWorkerID]);
				# $this->addFlash('success', "Arbeitszeit  Statistic erfassung von «{$workTimeObj->getCoWorkerByID($workTimeObj->getArbeitszeitMa())}» für " . $workTimeObj->getArbeitszeitDate()->format('d.m.Y') . " wurde eingetragen.");
				$dateRange    = $workTimeObj->getStartDate()->format('d.m.Y') . " - " . $workTimeObj->getEndDate()->format('d.m.Y');
				$target       = " von «{$workTimeObj->getCoWorkerByID($workTimeObj->getCoWorker())}»: {$dateRange}";
				$form         = new WorkStatisticsForm($workTimeObj, $this->translator);
			}
			
			return $this->render( 'co_worker/work-time-statistics.html.twig', [
				'controller_name' => 'AdminController',
				'timeSheet'       => $timeSheet,
				'coWorkerID'      => $coWorkerID,
				'formWidgets'     => $form->getForm(),
				'user'            => $this->getUser(),
				'coWorkers'       => $this->fetchCoWorkers(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => "Arbeitszeit Statistik{$target}",
				'btnText'         => 'Los',
			] );
		}
		
	}
