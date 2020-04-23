<?php
	
	
	namespace App\Poiz\Traits;
	
	use App\Controller\AdminController;
	use App\Entity\Personen;
	use App\Entity\Ticketeintrag;
	use App\Entity\Tickets;
	use App\Helpers\Date\RequestBridge;
	use Doctrine\ORM\EntityManagerInterface;
	use Mpdf\Output\Destination;
	use ParseCsv\enums\FileProcessingModeEnum;
	use Symfony\Component\HttpFoundation\BinaryFileResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\ResponseHeaderBag;
	use Symfony\Component\VarDumper\Cloner\Data;
	
	/**@property EntityManagerInterface $entityManager */
	trait AdminControllerHelperTrait {
		
		protected function getBrowserName(){
			$rayBrowser = get_browser(null, true);
			return isset($rayBrowser['browser']) ? "pz-" . strtolower($rayBrowser['browser']) : '';
		}
		
		protected function initializeActionMethod(Request &$request, RequestBridge &$rb){
			if ( ! ( $user = $this->getUser() ) ) {
				return $this->redirectToRoute( 'app_login' );
			}
			$rb->setRequest( $request );
			$rb->setUser( $user );
			$rb->initialize();
			return $user;
		}
		
		/*======================================================*/
		/*=================TICKETS MANIPULATION=================*/
		/*======================================================*/
		protected function saveTicket($data, $ticketID=false){
			$ticket       = $ticketID ? $this->entityManager->getRepository(Tickets::class)->find($ticketID) : new Tickets();
			$ticket->autoSetClassProps($data);
			# $ticket->setTicketGelesen(0);  // USE FLAG FROM MODEL TO UPDATE THIS RATHER THAN MANUALLY...
			$this->entityManager->persist($ticket);
			$this->entityManager->flush();
			
			return [
				'status'    => 1,
				'ticketID'  => $ticket->getTicketId(),
				'message'   => "Das Ticket «{$ticket->getTicketHeader()}» wurde erfolgreich gespeichert..."
			];
		}
		
		protected function removeTicket($ticketID){
			$ticket   = $this->entityManager->getRepository(Tickets::class)->find($ticketID);
			$message  = "Das Ticket Nr. «{$ticketID}» könnte nicht gelöscht werden...";
			if($ticket){
				$message      = "Das Ticket «{$ticket->getTicketHeader()}» wurde erfolgreich gelöscht...";
				$this->entityManager->remove($ticket);
				$this->entityManager->flush();
			}
			
			return [
				'status'    => 1,
				'ticketID'  => $ticketID,
				'message'   => $message,
			];
		}
		
		protected function addOrUpdateTicketEntry($data, $ticketID, $ticketEntryID=false){
			$this->sanitizeDataForImage($data);
			if($ticketEntryID){
				// THIS IS AN UPDATE SCENARIO...
				$ticketEntry  = $this->entityManager->getRepository(Ticketeintrag::class)->find($ticketEntryID);
				$message      = "Das Ticketeintrag «{$ticketEntry->getTicketeintragEintrag()}» wurde erfolgreich aktualisiert...";
			}else{
				// AND THIS IS A "SAVE" SCENARIO...
				$ticketEntry  = new Ticketeintrag();
				$ticketEntry->setTicketeintragTicketId($ticketID);
				$message      = "Eine neue Ticketeintrag wurde erfolgreich erstellt...";
			}
			if(isset($data['ticket_endtermin'])){
				$datum  = ($dt = $data['ticket_endtermin'] instanceof \DateTime) ? $data['ticket_endtermin'] : new \DateTime($data['ticket_endtermin']);
				$ticketEntry->setTicketeintragDatum($datum);
			}
			$ticketEntry->setTicketeintragEintrag($data['ticketeintrag_eintrag']);
			if(isset($data['ticket_opener'])){
				$ticketEntry->setTicketOpener($data['ticket_opener']);
			}
			$ticketEntry->setTicketeintragErstellerId($data['ticket_MA_verantwortung']);
			$this->entityManager->persist($ticketEntry);
			$this->entityManager->flush();
			return [
				'status'        => 1,
				'ticketID'      => $ticketID,
				'ticketEntryID' => $ticketEntry->getTicketeintragId(),
				'message'       => $message
			];
			
		}
		
		protected function removeTicketEntry($ticketEntryID){
			$ticketEntry  = $this->entityManager->getRepository(Ticketeintrag::class)->find($ticketEntryID);
			$ticketID     = $ticketEntry->getTicketeintragTicketId();
			$message      = "Das Ticketeintrag Nr. «{$ticketEntryID}» könnte momentan nicht gelöscht werden...";
			if($ticketEntry){
				$message      = "Das Ticketeintrag «{$ticketEntry->getTicketeintragEintrag()}» wurde erfolgreich gelöscht...";
				$this->entityManager->remove($ticketEntry);
				$this->entityManager->flush();
			}
			
			return [
				'status'        => 1,
				'ticketID'      => $ticketID,
				'ticketPostID'  => $ticketEntryID,
				'message'       => $message,
			];
		}
		
		protected function fetchTicketEntriesByTID($ticketID){
			$ticketEntries  = $this->entityManager->getRepository(Ticketeintrag::class)->findBy(['ticketeintrag_ticket_id' => $ticketID]);
			return $ticketEntries;
		}
		protected function fetchTicketEntriesAlt($ticketID){
			/**@var \Doctrine\DBAL\Query\QueryBuilder $qb */
			$qb   = $this->entityManager->getConnection()->createQueryBuilder();
			$and  = $qb->expr()->andX();
			$and->add($qb->expr()->eq('ten.ticketeintrag_ticket_id', $qb->expr()->literal($ticketID)));
			
			$qb->select( 'ten.*')
			   ->from('ticketeintrag', 'ten')
			   ->where($and)
			   ->addOrderBy('ten.ticketeintrag_datum',    'DESC')
			   ->addOrderBy('ten.ticketeintrag_id',       'DESC');
			return $qb->execute()->fetchAll();
		}
		
		private function sanitizeDataForImage(&$data){
			if(isset($data['ticketeintrag_eintrag'])){
				$cleanPost      = preg_replace("#\/?\.\.\/.*?images#", "/images", $data['ticketeintrag_eintrag']);
				$data['ticketeintrag_eintrag']  = $cleanPost;
			}
			return $data;
		}
		
		
		
		/*======================================================*/
		/*================NAVIGATION, MENU + ACL================*/
		/*======================================================*/
		private function getNavigationPayload(){
			return self::fetchNavigationPayload();
		}
		
		public static function fetchNavigationPayload(){
			return [
				'Kalender'  => [
					'title'   => 'Kalender',
					'url'     => 'rte_admin_calendar',
					'icon'    => 'fa fa-calendar',
					'state'   => 'active pz-active',
					'roles'   => ['ROLE_WORKER'],
					'children'  => [
						'Meine Tickets' => [
							'title'   => 'Meine Tickets',
							'url'     => 'rte_admin_my_tickets',
							'icon'    => 'fa fa-ticket',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Alle aktuellen Tickets' => [
							'title'   => 'Alle aktuellen Tickets',
							'url'     => 'rte_admin_all_current_tickets',
							'icon'    => 'fa fa-tags',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Ticket eröffnen' => [
							'title'   => 'Ticket eröffnen',
							'url'     => 'rte_admin_new_ticket',
							'icon'    => 'fa fa-plus',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Ticketarchiv' => [
							'title'   => 'Ticketarchiv',
							'url'     => 'rte_admin_ticket_archive',
							'icon'    => 'fa fa-archive',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Ticket suchen' => [
							'title'   => 'Ticket suchen',
							'url'     => 'rte_admin_search_tickets',
							'icon'    => 'fa fa-search',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						]
					],
				],
				
				'Kasse'  => [
					'title'   => 'Kasse',
					'url'     => 'rte_admin_cash_register',
					'icon'    => 'fa fa-calculator',
					'state'   => '',
					'roles'   => ['ROLE_WORKER'],
					'children'  => [
						'Barausgabe' => [
							'title'   => 'Barausgabe',
							'url'     => 'rte_admin_book_cash_expenditure',
							'icon'    => 'fa fa-money',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Bargeld einzahlen' => [
							'title'   => 'Bargeld einzahlen',
							'url'     => 'rte_admin_cash_payment',
							'icon'    => 'fa fa-money',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						/*
						'Kassenbuch' => [
							'title'   => 'Kassenbuch',
							'url'     => '',
							'icon'    => 'fa fa-link',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						*/
						'Verkauf suchen' => [
							'title'   => 'Verkauf suchen',
							'url'     => 'rte_admin_sales_search',
							'icon'    => 'fa fa-link',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
					],
				],
				
				'Kunden'  => [
					'title'   => 'Kunden',
					'url'     => 'rte_admin_clients',
					'icon'    => 'fa fa-handshake-o',
					'state'   => '',
					'roles'   => ['ROLE_WORKER'],
					'children'  => [
						'Kunde eröffnen' => [
							'title'   => 'Kunde eröffnen',
							'url'     => 'rte_admin_new_client',
							'icon'    => 'fa fa-plus',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						
						'Kunde suchen' => [
							'title'   => 'Kunde suchen',
							'url'     => 'rte_admin_search_client',
							'icon'    => 'fa fa-search',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						/*
						'Kunde bearbeiten' => [
							'title'   => 'Kunde bearbeiten',
							'url'     => 'rte_admin_edit_client',
							'icon'    => 'fa fa-pencil',
							'state'   => '',
						],
						
						'Erweiterte Kunde suchen' => [
							'title'   => 'Erweiterte Kunde suchen',
							'url'     => 'rte_admin_search_client_advanced',
							'icon'    => 'fa fa-binoculars',
							'state'   => '',
						],
						*/
					],
				],
				
				'Buchhaltung'  => [
					'title'   => 'Buchhaltung',
					'url'     => 'rte_admin_book_keeping',
					'icon'    => 'fa fa-book',
					'state'   => '',
					'roles'   => ['ROLE_WORKER'],
					'children'  => [
						'Rechnung eröffnen' => [
							'title'   => 'Rechnung eröffnen',
							'url'     => 'rte_admin_new_bill',
							'icon'    => 'fa fa-plus',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Rechnung bearbeiten' => [
							'title'   => 'Rechnung bearbeiten',
							'url'     => 'rte_admin_edit_bill_main',
							'icon'    => 'fa fa-pencil',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Rechnung verfolgen' => [
							'title'   => 'Rechnung verfolgen',
							'url'     => 'rte_admin_track_bills',
							'icon'    => 'fa fa-exchange',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Rechnungsarchiv' => [
							'title'   => 'Rechnungsarchiv',
							'url'     => 'rte_admin_bills_archive',
							'icon'    => 'fa fa-archive',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						/*
						'Offene Rechnungen' => [
							'title'   => 'Offene Rechnungen',
							'url'     => 'rte_admin_all_open_bills',
							'icon'    => 'fa fa-envelope-open',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Mahnungen' => [
							'title'   => 'Mahnungen',
							'url'     => 'rte_admin_all_mahnung_bills',
							'icon'    => 'fa fa-gavel',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						*/
					],
				],
				
				'Mitarbeitern'  => [
					'title'   => 'Mitarbeitern',
					'url'     => 'rte_admin_co_workers',
					'icon'    => 'fa fa-users',
					'state'   => '',
					'roles'   => ['ROLE_WORKER'],
					'children'  => [
						'Arbeitszeit eintragen' => [
							'title'   => 'Arbeitszeit eintragen',
							'url'     => 'rte_admin_log_work_time',
							'icon'    => 'fa fa-clock-o',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Arbeitszeit Statistik' => [
							'title'   => 'Arbeitszeit Statistik',
							'url'     => 'rte_admin_work_time_statistics',
							'icon'    => 'fa fa-bar-chart',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Neu Mitarbeiter' => [
							'title'   => 'Neu Mitarbeiter',
							'url'     => 'rte_admin_new_coworker',
							'icon'    => 'fa fa-user',
							'state'   => '',
							'roles'   => ['ROLE_ADMIN'],
						],
						'Mitarbeitern verwalten' => [
							'title'   => 'Mitarbeitern verwalten',
							'url'     => 'rte_admin_manage_coworkers',
							'icon'    => 'fa fa-cog',
							'state'   => '',
							'roles'   => ['ROLE_ADMIN'],
						],
					],
				],
				
				'Wissen'  => [
					'title'   => 'Wissen',
					'url'     => 'rte_admin_knowledge_base',
					'icon'    => 'fa fa-life-buoy',
					'state'   => '',
					'roles'   => ['ROLE_WORKER'],
					'children'  => [
						'WDB anzeigen' => [
							'title'   => 'WDB anzeigen',
							'url'     => 'rte_knowledge_base_list',
							'icon'    => 'fa fa-th-list',      #'fa fa-justify fa-database',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'WDB neuer Eintrag' => [
							'title'   => 'WDB neuer Eintrag',
							'url'     => 'rte_new_knowledge_base_entry',
							'icon'    => 'fa fa-file-text',   // 'fa-file-text-o'  'fa-link',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'WDB Kategorien' => [
							'title'   => 'WDB Kategorien',
							'url'     => 'rte_knowledge_base_categories',
							'icon'    => 'fa fa-sitemap',
							'state'   => '',
							'roles'   => ['ROLE_ADMIN'],    // 'ROLE_WORKER',
						],
						'WDB neuer Kategorie' => [
							'title'   => 'WDB neuer Kategorie',
							'url'     => 'rte_knowledge_base_new_category',
							'icon'    => 'fa fa-folder-open',     // 'fa fa-file-text',
							'state'   => '',
							'roles'   => ['ROLE_ADMIN'],    // 'ROLE_WORKER',
						],
					],
				],
				
				'Statistiken'  => [
					'title'   => 'Statistiken',
					'url'     => 'rte_admin_statistics',
					'icon'    => 'fa fa-pie-chart',
					'state'   => '',
					'roles'   => ['ROLE_WORKER'],
					'children'  => [
						'Tagesabrechnung heute' => [
							'title'   => 'Tagesabrechnung heute',
							'url'     => 'rte_admin_account_statement_today',
							'icon'    => 'fa fa-area-chart',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Tagesabrechnung indiv.' => [
							'title'   => 'Tagesabrechnung indiv.',
							'url'     => 'rte_admin_individual_account_statement',
							'icon'    => 'fa fa-line-chart',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						
						'Umsatz nach Kategorie' => [
							'title'   => 'Umsatz nach Kategorie',
							'url'     => 'rte_admin_sales_by_category',
							'icon'    => 'fa fa-align-center',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Kundenwertanalyse' => [
							'title'   => 'Kundenwertanalyse',
							'url'     => 'rte_admin_customer_value_analysis',
							'icon'    => 'fa fa-binoculars',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
						'Statistik individuell' => [
							'title'   => 'Statistik individuell',
							'url'     => 'rte_admin_individual_statistics',
							'icon'    => 'fa fa-cubes',
							'state'   => '',
							'roles'   => ['ROLE_WORKER'],
						],
					],
				],
				
				'Verwalten'  => [
					'title'   => 'Verwalten',
					'url'     => 'rte_admin_manage',
					'icon'    => 'fa fa-cogs',
					'state'   => '',
					'children'  => [],
					'roles'   => ['ROLE_ADMIN'],
				],
			];
		}
		
		protected function handleACL(){
			return $this->getUser();
			// if(!$this->getUser() || is_null($this->getUser())){ return $this->redirect('/login'); }
		}
		
		
		
		/*======================================================*/
		/*===========PERSONS: COWORKERS + CLIENTS===============*/
		/*======================================================*/
		protected function fetchCoWorkers(){
			// `Kategorie` => 10 => Mitarbeitern
			$coWorkers  = $this->entityManager->
										getRepository(Personen::class)->
										findBy(
											['Kategorie' => '10', 'deleted' => 0],
											[
												'vorname'   => 'ASC',
												'name'      => 'ASC',
												'kundenid'  => 'ASC',
											]
			);
			return $coWorkers;
		}
		
		protected function getDefaultClientsCollection($melSession){
			$conn       = $this->entityManager->getConnection();
			$sql        = "select p.* FROM personen AS p where p.Kategorie !=:KT ORDER BY p.vorname ASC, p.name ASC";
			$sql       .= " LIMIT " . (isset($melSession['page']) ? $melSession['page'] : AdminController::DEFAULT_PAGE_NUM) . ", " .   (isset($melSession['ipp']) ? $melSession['ipp'] : AdminController::IPP_DEFAULT);
			$q          = $conn->prepare($sql);
			$q->execute(['KT' => 1000]);
			return $q->fetchAll(\PDO::FETCH_ASSOC);
		}
		
		
		
		/*======================================================*/
		/*==============PDF, JSON, CSV GENERATION===============*/
		/*======================================================*/
		protected function handleFullExport($export, $config=[]){
			$melSession = $this->session->get(RequestBridge::SessionNameSpace);
			/**@var \Doctrine\DBAL\Connection $conn */
			$files = glob(__DIR__ ."/_tmp/*");
			if($files){
				foreach($files as $fl){
					unlink($fl);
				}
			}
			$collection    = ($config && isset($config['collection'])) ? $config['collection'] : $this->getDefaultClientsCollection($melSession);
			$payload      = [];
			
			$inst1 = isset($collection[0]) ? $collection[0] : null;
			if(!is_array($inst1)){	// if($inst1 instanceof Personen){
				foreach ($collection as &$data){
					$data = $data->getEntityBank();
					foreach($data as &$value){
						if($value instanceof \DateTime){
							$value = $value->format("d.m.Y");
						}
					}
				}
			}
			
			if($collection){
				foreach ($collection as $item){
					$payload[] = $item;
				}
				$fileTitle  = isset($config['fileTitle']) ? $config['fileTitle'] : "kunden-auflistung-melanie-jeanrichard";
				$file       = __DIR__ . "/_tmp/{$fileTitle}-". date('Y-m-d') ;
				switch (strtolower($export)){
					case 'json':
						$file      .= '.json';
						file_put_contents($file, json_encode($payload, JSON_PRETTY_PRINT));
						break;
					case 'csv':
						$file      .= '.csv';
						$csv        = new \ParseCsv\Csv();
						$inst1      = $payload[0];
						$values     = array_keys($inst1);
						# $payload = array_filter($payload, function($elem){return is_array($elem);});
						try{
							$csv->save($file, $payload,  FileProcessingModeEnum::MODE_FILE_OVERWRITE, $values);    // , array_keys($payload[0]), ','
						}catch (\Exception $e){
							
							$this->addFlash('success', 'Could not generate CSV...');
							return $this->redirectToRoute('rte_admin_search_client');
						}
						break;
					case 'pdf':
						$file      .= '.pdf';
						$pdfHeader  = $this->buildPDFHeader($payload);
						$pdfFooter  = $this->buildPDFFooter($payload);
						if(isset($config['type'])){
							$pdfBody    = $this->buildPDFBodyForType($payload, $config['type']);
						}else{
							$pdfBody    = $this->buildPDFBodyForType(null);
						}
						$this->generatePDF($pdfBody, $file, $pdfHeader, $pdfFooter);
						break;
				}

				$response = new BinaryFileResponse($file);
				$response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
				return $response;
			}
		}
		
		protected function generatePDF($content, $fileName, $headerMarkUp, $footerMarkUp) {;
			$mpdf               = new \Mpdf\Mpdf([
				'header_line_spacing' => '1.25',
				'fontDir' => [__DIR__ .'/../../../public/fonts/',
				],
				'fontdata'  => [
					'sfpro' => [
						'R'     => 'SF-Pro-Display-Regular.ttf',
						'B'     => 'SF-Pro-Display-Bold.ttf'
					]
				],
				'default_font'  => 'sfpro'
			]);
			$mpdf->SetTitle(basename($fileName));
			$mpdf->simpleTables = true;
			$mpdf->table_error_report = true;
			$mpdf->shrink_tables_to_fit = 1;
			
			
			$mpdf->SetHTMLFooter($footerMarkUp);
			$mpdf->SetHTMLHeader($headerMarkUp);
			$exploded = explode("</tr>", $content);
			$mpdf->AddPageByArray([
				'margin-left'   => '13',  ## POIZ EDITS: THIS WAS ORIGINALLY: 13mm
				'margin-right'  => '13',  ## POIZ EDITS: THIS WAS ORIGINALLY: 13mm
				'margin-top'    => '36',   ## POIZ EDITS: THIS WAS ORIGINALLY: 13mm
				'margin-bottom' => '42',   ## POIZ EDITS: THIS WAS ORIGINALLY: 13mm
			]);
			# $output     = preg_replace("#(<title.*\/\s*title>)#si", "", $content, 1);
			$mpdf->WriteHTML($content);
			$mpdf->Output(basename($fileName), Destination::DOWNLOAD);
			// $mpdf->Output($fileName, Destination::FILE);
			die();
		}
		
		protected function buildPDFFooter($payload){
			return <<<FTR
<footer style="text-align:center">
<img alt="MJR Logo - Text" src="/images/logos/Melanie_JeanRichard_Logo_OK_01.png" style="width:45mm;height:auto;display:block;" /><br />
<div style="font-size:8pt;display:block;padding:15px 0px 8px 0px;">JeanRichard-dit-Bressel GmbH</div>
<div style="font-size:8.5pt;margin:0;padding:0;">Münstergasse 72&nbsp;&nbsp;&nbsp;3011 Bern&nbsp;&nbsp;&nbsp;031 311 46 79&nbsp;Hirschengraben 11&nbsp;&nbsp;&nbsp;3011 Bern&nbsp;&nbsp;&nbsp;031 311 11 01</div>
<div style="font-size:8.5pt;margin:0;padding:0;">blumen@melaniejeanrichard.ch&nbsp;&nbsp;&nbsp;melaniejeanrichard.ch</div>
<div style="font-size:8.5pt;margin:0;padding:0;">MwSt CHE-105.642.287&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IBAN:&nbsp;&nbsp;CH46 0900 0000 6055 9437 4</div>
</footer>
FTR;

		}
		
		protected function buildPDFHeader($payload){
			return <<<HDR

<header style="text-align:center">
	<img alt="MJR Logo - Text" src="/images/logos/Logo_MJR_Design.png" style="width:18mm;height:auto;display:block;" />
</header>
HDR;

		}
		
		protected function buildPDFBodyForType($payload, $type=null){
			switch ($type){
				case 'mwl':
					$response = $this->buildMonthlyWorkLoadPDFBodyForWorker($payload);
					break;
				
				case 'clientSearch':
					$response = $this->buildclientSearchPDFBody($payload);
					break;
				
				case 'clients':
				default:
					$response = $this->buildPDFBodyForClients();
					break;
			}
			return $response;
		}
		
		protected function buildClientSearchPDFBody($payload){
			return $this->buildPDFBodyForClients($payload);
		}
		
		protected function buildPDFBodyForClients($payload=null){
			$payload  = !$payload ? $this->getDefaultClientsCollection($this->session->get(RequestBridge::SessionNameSpace)) : $payload;
			$pdfBody = <<<PBD
	<div style="font-size: 9pt;border-top:solid 1px #A2A2A2;border-bottom:solid 1px #A2A2A2;padding:5px 0;">
	<header style="width:10%;font-weight: bold;float:left">ID</header>
	<header style="width:20%;font-weight: bold;float:left">Firma</header>
	<header style="width:15%;font-weight: bold;float:left">Name</header>
	<header style="width:15%;font-weight: bold;float:left">Vorname</header>
	<header style="width:40%;font-weight: bold;float:left">Kontakt</header>
</div>
PBD;

			foreach ($payload as $ikey=>$person){
				$pdfBody.= "<div style=\"font-size: 9pt;clear:both; margin-bottom:5px;border-bottom:solid 1px #BBBBBB;padding:5px 0;\">";
				$pdfBody.= "<div style='width:10%;font-size: 9pt;font-weight: 300;float:left'>{$person['kundenid']}</div>";
				$pdfBody.= "<div style='width:20%;font-size: 9pt;font-weight: 300;float:left'>" . html_entity_decode($person['Firma']) . "&nbsp; </div>";
				$pdfBody.= "<div style='width:15%;font-size: 9pt;font-weight: 300;float:left'>" . html_entity_decode($person['name']) . "&nbsp; </div>";
				$pdfBody.= "<div style='width:15%;font-size: 9pt;font-weight: 300;float:left'>" . html_entity_decode($person['vorname']) . "&nbsp; </div>";
				$pdfBody.= "<div style='width:40%;font-size: 9pt;font-weight: 300;float:left'>
					{$person['Strasse']} {$person['Strassennummer']}<br />
					{$person['PLZ']} {$person['Ort']}<br />
					T. {$person['Telefon']}<br />
					H. {$person['Handy']}<br />
					E. {$person['EMail']}<br />

</div>";
				$pdfBody.= "</div>";
			}
			return $pdfBody;

		}
		
		protected function buildMonthlyWorkLoadPDFBodyForWorker($payload){
			$pdfBody = <<<PBD
	<div style="font-size: 9pt;border-top:solid 1px #A2A2A2;border-bottom:solid 1px #A2A2A2;padding:5px 0;">
	<header style="width:15%;font-weight: bold;float:left">Datum</header>
	<header style="width:10%;font-weight: bold;float:left">MG</header> <!-- Münstergasse -->
	<header style="width:10%;font-weight: bold;float:left">HG</header> <!-- Hirschengraben -->
	<header style="width:10%;font-weight: bold;float:left">Extern</header>
	<header style="width:10%;font-weight: bold;float:left">Total</header>
	<header style="width:45%;font-weight: bold;float:left">Bemerkungen</header>
</div>
PBD;

			foreach ($payload as $ikey=>$entity){
				$pdfBody.= "<div style=\"font-size: 9pt;clear:both; margin-bottom:5px;border-bottom:solid 1px #BBBBBB;padding:5px 0;\">";
				$pdfBody.= "<div style='width:15%;font-size: 9pt;font-weight: 300;float:left'>" . date('d.m.Y', strtotime($entity['Arbeitszeit_date'])) . "</div>";
				$pdfBody.= "<div style='width:10%;font-size: 9pt;font-weight: 300;float:left'>" . html_entity_decode($entity['Arbeitszeit_std_mg']) . "&nbsp; </div>";
				$pdfBody.= "<div style='width:10%;font-size: 9pt;font-weight: 300;float:left'>" . html_entity_decode($entity['Arbeitszeit_std_hg']) . "&nbsp; </div>";
				$pdfBody.= "<div style='width:10%;font-size: 9pt;font-weight: 300;float:left'>" . html_entity_decode($entity['Arbeitszeit_std_extern']) . "&nbsp; </div>";
				$pdfBody.= "<div style='width:10%;font-size: 9pt;font-weight: 300;float:left'>" . html_entity_decode($entity['Arbeitszeit_std_total']) . "&nbsp; </div>";
				$pdfBody.= "<div style='width:45%;font-size: 9pt;font-weight: 300;float:left'>" . html_entity_decode($entity['Arbeitszeit_kommentar']) . "&nbsp; </div>";
				$pdfBody.= "</div>";
			}
			return $pdfBody;

		}
		
		protected function buildPDFBody2($payload){
			$pdfBody = "<table class='pz' width='100%'; style='width: 100%;'>";
			$pdfBody.= "<thead class='pz'>";
			$pdfBody.= "<tr class='pz'>";
			$pdfBody.= "<th class='pz'>ID</th>";
			$pdfBody.= "<th class='pz'>Firma</th>";
			$pdfBody.= "<th class='pz'>Name</th>";
			$pdfBody.= "<th class='pz'>Vorname</th>";
			$pdfBody.= "<th class='pz'>Kontakt</th>";
			$pdfBody.= "</tr>";
			$pdfBody.= "</thead>";
			$pdfBody.= "<tbody>";
			
			foreach ($payload as $ikey=>$person){
				$pdfBody.= "<tr class='pz'>";
				$pdfBody.= "<td class='pz'>{$person['kundenid']}</td>";
				$pdfBody.= "<td class='pz'>" . html_entity_decode($person['Firma']) . "</td>";
				$pdfBody.= "<td class='pz'>" . html_entity_decode($person['name']) . "</td>";
				$pdfBody.= "<td class='pz'>" . html_entity_decode($person['vorname']) . "</td>";
				$pdfBody.= "<td class='pz'>
					{$person['Strasse']} {$person['Strassennummer']}<br />
					{$person['PLZ']} {$person['Ort']}<br />
					T. {$person['Telefon']}<br />
					H. {$person['Handy']}<br />
					E. {$person['EMail']}<br />
				</td>";
				$pdfBody.= "</tr>";
			}
			$pdfBody.= "</tbody>";
			$pdfBody.= "</table>";
			return $pdfBody;
			return <<<BDY

			<tr class="pz-clients-thead-row first pz-tbl-heading-row">
				<th>ID&nbsp;
					<span class="fa fa-angle-up pz-sort-icon pz-sort-up pz-active active" data-sort-by="kundenid" data-sort-direction="asc"></span>
					<span class="fa fa-angle-down pz-sort-icon pz-sort-down" data-sort-by="kundenid" data-sort-direction="desc"></span>
				</th>
				<th>Firma&nbsp;
					<span class="fa fa-angle-up pz-sort-icon pz-sort-up" data-sort-by="Firma" data-sort-direction="asc"></span>
					<span class="fa fa-angle-down pz-sort-icon pz-sort-down" data-sort-by="Firma" data-sort-direction="desc"></span>
				</th>
				<th>Name&nbsp;
					<span class="fa fa-angle-up pz-sort-icon pz-sort-up" data-sort-by="name" data-sort-direction="asc"></span>
					<span class="fa fa-angle-down pz-sort-icon pz-sort-down" data-sort-by="name" data-sort-direction="desc"></span>
				</th>
				<th>Vorname&nbsp;
					<span class="fa fa-angle-up pz-sort-icon pz-sort-up" data-sort-by="vorname" data-sort-direction="asc"></span>
					<span class="fa fa-angle-down pz-sort-icon pz-sort-down" data-sort-by="vorname" data-sort-direction="desc"></span>
				</th>
				<th>Mut</th>
				<th>Stat</th>
				<th>Actions</th>
			</tr>
<div style="">
Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Quisque velit nisi, pretium ut lacinia in, elementum id enim.

Nulla quis lorem ut libero malesuada feugiat. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Nulla quis lorem ut libero malesuada feugiat.

Donec sollicitudin molestie malesuada. Vivamus suscipit tortor eget felis porttitor volutpat. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.

Pellentesque in ipsum id orci porta dapibus. Curabitur aliquet quam id dui posuere blandit. Donec rutrum congue leo eget malesuada.

Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Nulla porttitor accumsan tincidunt. Quisque velit nisi, pretium ut lacinia in, elementum id enim.
</div>
BDY;

		}
		
		protected function handleSearchExport($export){
			$melSession = $this->session->get(RequestBridge::SessionNameSpace);
			dump($export);
			dump($melSession['lastSearchTerm']);
		}
	}