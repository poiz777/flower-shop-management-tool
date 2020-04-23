<?php
	
	namespace App\Controller;
	
	use App\Entity\Personen;
	use App\Forms\ClientSearchEntity;
	use App\Helpers\Date\DateCalculator;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\HTML\Forms\ClientForm;
	use App\Poiz\HTML\Forms\ClientQuickSearchForm;
	use App\Poiz\HTML\Forms\ClientSearchForm;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use App\Poiz\HTML\Widgets\FormElements\Date;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\ORM\QueryBuilder;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	
	class ClientController extends AbstractController {
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
		private $translator ;
		
		/**
		 * @var RequestBridge
		 */
		private $rb;
		
		public function __construct(EntityManagerInterface $entityManager, SessionInterface $session,  RequestBridge $rb, ShopTranslator $translator) {
			$this->entityManager  = $entityManager;
			$this->rb             = $rb;
			$this->session        = $session;
			$this->translator     = $translator;
		}
		
		/**
		 * @Route("/admin/kunden/statistiken/{id}", name="rte_admin_client_statistics")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param int|null                                  $id
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function clientStatistics(Request $request, $id=null) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$client         = $this->entityManager->getRepository(Personen::class)->find($id);
			$clientID       = $client->getKundenid();
			$clientForm     = []; # BUILD THE CLIENT STATISTICS AND PASS IT TO THE VIEW...
			return $this->render( 'statistics/client-statistics.html.twig', [
				'controller_name' => 'AdminController',
				'client'          => $client,
				'user'            => $this->getUser(),
				'clientID'        => $clientID,
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Statistiken für «' . DateCalculator::getStreamlinedCustomerName($client->getEntityBank(), 0) .  "»",
			] );
		}
		
		/**
		 * @Route("/admin/kunden/bearbeiten/{id}", name="rte_admin_edit_client")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param int|null                                  $id
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 * @throws \Doctrine\DBAL\DBALException
		 */
		public function editClient(Request $request,  $id=null) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$client         = $this->entityManager->getRepository(Personen::class)->find($id);  // new Personen();
			$clientID       = $client->getKundenid();
			$clientForm     = new ClientForm($client, $this->translator);
			
			if(($client = $clientForm->isValid($request->request->all())) ){
				$entityBank = $client->getEntityBank();
				if(isset($entityBank['mrMrs'])){ unset($entityBank['mrMrs']); }
				if(isset($entityBank['formOfAddress'])){ unset($entityBank['formOfAddress']); }
				$customer   = DateCalculator::getStreamlinedCustomerName($entityBank, 0);
				$this->handleEntityDateFields($entityBank);

				$conn       = $this->entityManager->getConnection();
				$status     = $conn->update('personen', $entityBank, ['kundenid' => $id]);
				$this->addFlash('success', "Die Kunde \"{$customer}\" wurde erfolggreich aktualisiert -- ID: {$client->getKundenid()}");
				return $this->redirectToRoute("rte_admin_client_detail", ['id' => $client->getKundenid()]);
			}
			
			return $this->render( 'admin/edit-client.html.twig', [
				'controller_name' => 'AdminController',
				'client'          => $client,
				'formWidgets'     => $clientForm->getForm(),
				'user'            => $this->getUser(),
				'clientID'        => $clientID,
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Kunde bearbeitung - ID: ' . $clientID,
				'btnText'         => 'Änderung(en)  speichern',
			] );
		}
		
		private function handleEntityDateFields(&$entityBank, $ymd=true){
			foreach($entityBank as $key=>&$val){
				if($val instanceof \DateTime ){
					$val = $ymd ? $val->format("Y-m-d H:i:s"): $val->format("d.m.Y");
				}
			}
			return $entityBank;
		}
		
		/**
		 * @Route("/admin/kunden/loeschen/{id}", name="rte_admin_delete_client")
		 * @param int|null                                  $id
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function deleteClient($id=null) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			
			$client = $this->entityManager->getRepository(Personen::class)->find($id);
			if($client){
				$customer = DateCalculator::getStreamlinedCustomerName($client->getEntityBank(), 0); // trim($client->getFirma()) . " [" . trim($client->getVorname()) . " " . trim($client->getName()) . "]";
				// RATHER THAN ACTUALLY DELETING / REMOVING THE CLIENT DATA,
				// WE JUST SET THE `deleted` FLAG TO 1 ... PERHAPS THE `hidden` FLAG AS WELL...
				$client->setDeleted(1);                   # $client->setHidden(1);
				$this->entityManager->persist($client);   # $this->entityManager->remove($client);
				$this->entityManager->flush();
				
				$this->addFlash('success', "Die Kunde \"{$customer}\" wurde erfoglgreich entfernt -- ID: {$id}");
			}
			return $this->redirectToRoute('rte_admin_clients');
		}
		
		/**
		 * @Route("/admin/kunden/neu/", name="rte_admin_new_client")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Helpers\Date\DateCalculator          $dateCalculator
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function newClient(Request $request,  DateCalculator $dateCalculator) {
			/**@var Personen $client */
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$client         = new Personen();
			$clientForm     = new ClientForm($client, $this->translator);
			
			if(($client = $clientForm->isValid($request->request->all())) ){
				$this->entityManager->persist($client);
				$this->entityManager->flush();
				$customer = trim($client->getFirma()) . " [" . trim($client->getVorname()) . " " . trim($client->getName()) . "]";
				$this->addFlash('success', "Einen neuen Kunden \"{$customer}\" wurde erfoglgreich eröffnet -- ID: {$client->getKundenid()}");
				return $this->redirectToRoute("rte_admin_client_detail", ['id' => $client->getKundenid()]);
			}
			
			return $this->render( 'admin/edit-client.html.twig', [
				'controller_name' => 'AdminController',
				'client'          => $client,
				'formWidgets'     => $clientForm->getForm(),
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Neu Kunde erstellen',
				'btnText'         => 'Jetzt erstellen',
				'clientID'        => NULL,
			] );
		}
		
		/**
		 * @Route("/admin/kunden/detail/{id}", name="rte_admin_client_detail")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function clientDetail(Request $request, $id=null) {
			if(!$id){ return $this->redirectToRoute('rte_admin_clients', []); }
			$clientData = $this->entityManager->getRepository(Personen::class)->fetchClientByID($id, true);
			
			return $this->render('admin/client-detail.html.twig', [
				'pageTitle'   => 'Kunden Information - KundenNr. ' . $clientData['kundenid'],
				'clientData'  => $clientData,
				'user'        => $this->getUser(),
				'navPayload'  => $this->getNavigationPayload(),
			]);
		}
		
		private function handleSessionRelatedData($request, $searchTerm=null){
			$this->melSession   = $this->session->get(RequestBridge::SessionNameSpace);
			if($request->query->has('page')){
				$this->melSession['current_page'] = $request->query->get('page');
			}
			if($request->query->has('ipp')){
				$this->melSession['ipp'] = $request->query->get('ipp');
			}
			if(trim($searchTerm)){
				$this->melSession['searchTerm'] = $searchTerm;
			}
			$this->session->set(RequestBridge::SessionNameSpace, 	$this->melSession);
		}
		
		private function microSearchClients($request, $searchTerm, $entityBank=[], $useLastQuery=false){
			$this->handleSessionRelatedData($request, $searchTerm);
		
			
			if($useLastQuery){
				// $this->session->clear();
				if(isset($this->melSession['lastSearchTerm']) && !$searchTerm){
					$searchTerm = $this->melSession['lastSearchTerm'];
				}
			}
			
			$qb         = $this->entityManager->createQueryBuilder();
			$or         = $qb->expr()->orX();
			$limit      = (!isset($this->melSession['current_page'])) ? ($this->melSession['current_page'] = 1) : $this->melSession['current_page'];
			$limit      = $limit > 1 ? ($limit * $this->melSession['ipp']) : 1;
			
			$this->melSession['lastSearchTerm'] = $searchTerm;
			if($entityBank){
				$searchTerm = "'%{$searchTerm}%'";
				foreach (array_keys($entityBank) as $fieldName){
					if(in_array($fieldName, ['entityBank', 'classProps', 'instance', 'toggleConfig', 'eMan' , 'mrMrs', 'formOfAddress', 'deleted', 'hidden'])){ continue; }
					$sqlFieldName   = "p.{$fieldName}";
					$or->add($qb->expr()->like($sqlFieldName, $searchTerm));
				}
				// ONLY GET RECORDS WHOSE `deleted` FLAG IS SET TO FALSE (0)
			}
			
			if( !(array_key_exists('current_page', $this->melSession)) ){
				$this->melSession['current_page'] = AdminController::DEFAULT_PAGE_NUM;
			}
			if( !(array_key_exists('limit', $this->melSession)) ){
				$this->melSession['limit'] = AdminController::IPP_DEFAULT;
			}
			$this->session->set(RequestBridge::SessionNameSpace, $this->melSession);
			return [
				'result'      => $this->fetchSearchResults($or, $qb, null), // $limit
				'curPage'     => $this->melSession['current_page'],
				'limit'       => $this->melSession['limit'],
				'clientCount' => $this->getClientCount($or),
			];
		}
		
		/**
		 * @Route("/admin/kunden/suche/{id}", name="rte_admin_search_client")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @param null                                      $id
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function searchClient(Request $request, $id=null) {
			## dump(password_hash('gusto', PASSWORD_BCRYPT));
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$id             = $id ? $id : $request->query->get('id',null);
			$melSession     = $this->session->get(RequestBridge::SessionNameSpace);
			$clientName     = "";
			$res            = ['result'=>null, 'clientCount' => 0, 'limit' => 0, 'curPage' => 0];
			$clientForm     = new ClientQuickSearchForm(null, $this->translator);
			$clientData     = null;
			
			
			if(($client=$clientForm->isValid($request->request->all()))){
				$searchTerm = $client->getSuchbegriff();
				$res        = $this->microSearchClients($request, $searchTerm, (new Personen())->getEntityBank());
			}
			
			if($id){
				/** @var Personen $clientData */
				$clientData = $this->entityManager->getRepository(Personen::class)->find($id);
				$res        = $this->microSearchClients($request, null, (new Personen())->getEntityBank(), true);
				if(trim($clientData->getVorname())){
					$clientName .= trim($clientData->getVorname());
					if(trim($clientData->getName())) {
						$clientName .= " " . trim($clientData->getName());
					}
				}elseif(trim($clientData->getName())){
					$clientName .= trim($clientData->getName());
				}
				if(trim($clientData->getFirma())){
					$clientName .= $clientName ? " -- " . trim($clientData->getFirma()) : trim($clientData->getFirma());
				}
			}
			
			$export = $request->query->get('export',null);
			if($export){
				$res        = $this->microSearchClients($request, $melSession['lastSearchTerm'], (new Personen())->getEntityBank());
				return $this->handleFullExport($export, [
					'collection'      => $res['result'],
					'fileTitle'       => "kundensuche--resultaete-fuer-«{$melSession['lastSearchTerm']}»",
					'type'            => 'clientSearch',
				]);
			}
			return $this->render( 'admin/quick-client-search.html.twig', [
				'controller_name' => 'AdminController',
				'client'          => $client,
				'clientData'      => $clientData,
				'formWidgets'     => $clientForm->getForm(),
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => isset($searchTerm) && $searchTerm ? "Du hast für «{$searchTerm}» gesücht..." : ($clientName ? $clientName : 'Kunde suchen - schnell'),
				'btnText'         => 'Los',
				'clients'         => $res['result'],
				'limit'           => $res['limit'],
				'ipp'             => $res['limit'],         // items_per_page
				'currentPage'     => $res['curPage'],       // currentPage, limit, posts_per_page (ppp)
				'clientCount'     => $res['clientCount'],
				'showPagination'  => false,
				'clientID'        => NULL,
			] );
		}
		
		/**
		 * @Route("/admin/kunden/erweitert-suche", name="rte_admin_search_client_advanced")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function searchClientAdvanced(Request $request) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$client         = new ClientSearchEntity();
			$clientForm     = new ClientSearchForm($client, $this->translator);
			$clientCount    = 0;
			$result         = [];
			
			if(($client = $clientForm->isValid($request->request->all()))){
				$this->handleSessionRelatedData($request);
				$qb           = $this->entityManager->createQueryBuilder();
				$or           =  $this->buildConstraintForQuery($qb, $client->getEntityBank());
				$clientCount  = $this->getClientCount($or);
				$result       = $this->fetchSearchResults($or, $qb);
				if( !(array_key_exists('current_page', $this->melSession)) ){
					$this->melSession['current_page'] = AdminController::DEFAULT_PAGE_NUM;
				}
				if( !(array_key_exists('limit', $this->melSession)) ){
					$this->melSession['limit'] = AdminController::IPP_DEFAULT;
				}
			}
			
			return $this->render( 'client/search-client-advanced.html.twig', [
				'controller_name' => 'AdminController',
				'client'          => $client,
				'formWidgets'     => $clientForm->getForm(),
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Kunde suchen - erweitert',
				'btnText'         => 'Los',
				'clientID'        => NULL,
				'showPagination'  => false,
				'clients'         => $result,
				'clientCount'     => $clientCount,
				'ipp'             => isset($this->melSession['ipp']) ? $this->melSession['ipp'] : AdminController::IPP_DEFAULT,
				'limit'           => isset($this->melSession['ipp']) ? $this->melSession['ipp'] : AdminController::IPP_DEFAULT,
				'currentPage'     => isset($this->melSession['current_page']) ? $this->melSession['current_page'] : 1,
			] );
		}
		
		/**
		 * @Route("/admin/kunden", name="rte_admin_clients")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function clients(Request $request) {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$export = $request->query->get('export',null);
			$this->rb->setUser($user);
			$this->rb->setRequest($request);
			$this->rb->initialize();
			
			$melSession   = $this->session->get(RequestBridge::SessionNameSpace);
			if($export){
				return $this->handleFullExport($export);
			}
			if($request->query->has('page')){
				$melSession['current_page'] = $request->query->get('page');
			}
			if($request->query->has('ipp')){
				$melSession['ipp'] = $request->query->get('ipp');
			}
			$this->session->set(RequestBridge::SessionNameSpace, $melSession);
			
			$q1           = $this->entityManager->createQuery("select count(p.kundenid) as clientCount from App\Entity\Personen p where (p.Kategorie != 1000 AND p.Kategorie != -1)");
			$clientCount  = $q1->execute();
			$clientCount  = $clientCount ? $clientCount[0]['clientCount'] : 0;
			
			$limit = (!isset($melSession['current_page'])) ? ($melSession['current_page'] = 1) : $melSession['current_page'];
			$limit = $limit > 1 ? ($limit * $melSession['ipp']) : 1;
			$qb = $this->entityManager->createQueryBuilder();
			$and = $qb->expr()->andX();
			$and->add($qb->expr()->neq('p.Kategorie', 1000));
			$qb->select('p')
			   ->from(Personen::class, 'p')
			   ->where($and)
			   ->orderBy("p.vorname", "ASC")
			   ->orderBy("p.name", "ASC");
			$qb->setMaxResults($melSession['ipp']);
			$qb->setFirstResult($limit);
			
			$q = $qb->getQuery();
			$clients = $q->execute();
			
			if( !(array_key_exists('current_page', $melSession)) ){
				$melSession['current_page'] = AdminController::DEFAULT_PAGE_NUM;
			}
			if( !(array_key_exists('limit', $melSession)) ){
				$melSession['limit'] = AdminController::IPP_DEFAULT;
			}
			
			$curPage      = $melSession['current_page'];
			$limit        = $melSession['limit'];
			
			return $this->render( 'admin/clients.html.twig', [
				'controller_name' => 'AdminController',
				'clients'         => $clients,
				'limit'           => $limit,
				'ipp'             => $limit,          // items_per_page
				'currentPage'     => $curPage,        // currentPage, limit, posts_per_page (ppp)
				'clientCount'     => $clientCount,    // currentPage, limit, posts_per_page (ppp)
				'user'            => $this->getUser(),
				'pageTitle'       => 'Kunden Auflistung',
				'navPayload'      => $this->getNavigationPayload(),
				'showPagination'  => true,
			] );
		}
		
		private function fetchSearchResults($constraint, QueryBuilder $qb, $limit=null){
			$and  = $qb->expr()->andX();
			$and->add($qb->expr()->eq('p.deleted', $qb->expr()->literal(0)));

			$qb->select('p')
			   ->from(Personen::class, 'p')
			   ->where($constraint)
				 ->andWhere($and)         # WE NEED ONLY ENTRIES THAT ARE NOT FLAGGED AS `deleted`
			   ->orderBy("p.vorname", "ASC")
			   ->orderBy("p.name", "ASC");
			if($limit){
				$qb->setMaxResults($this->melSession['ipp']);
				$qb->setFirstResult($limit);
			}
			$q      = $qb->getQuery();
			return $q->execute();
		}
		
		private function getClientCount($constraint){
			$q1     = $this->entityManager->createQueryBuilder();
			$q1->select('COUNT(p.kundenid) as clientCount')
			   ->from(Personen::class, 'p')
			   ->where($constraint);
			$q2           = $q1->getQuery();
			$clientCount  = $q2->execute();
			return $clientCount ? $clientCount[0]['clientCount'] : 0;
		}
		
		private function buildConstraintForQuery(QueryBuilder $qb, array $entityBank=[]){
			$and   = $qb->expr()->andX();
			if($entityBank){
				foreach ($entityBank as $fieldName=>$fieldValue){
					if(in_array($fieldName, ['PF_Bezeichnung', 'Bemerkungen', 'Website'])) { continue; }
					if($fieldName == 'geb_datum' && $fieldValue instanceof \DateTime && $fieldValue->format('Y-m-d') == '1970-01-01') { continue; }
					if($fieldValue instanceof \DateTime){
						$fieldValue = $fieldValue->format("Y-m-d");   #"Y-m-d H:i:s"
					}
					if(  (is_string($fieldValue) || is_numeric($fieldValue)) && trim($fieldValue)){
						$sqlFieldValue  = "'%{$fieldValue}%'";
						$sqlFieldName   = "p.{$fieldName}";
						$and->add($qb->expr()->like($sqlFieldName, $sqlFieldValue));
					}
				}
			}
			return $and;
		}
	}
