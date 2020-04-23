<?php
	
	namespace App\Controller;
	
	use App\Forms\CashExpenditureEntity;
	use App\Forms\CashPaymentEntity;
	use App\Forms\CashRegisterClientInfoEntity;
	use App\Forms\CashRegisterProductOrderEntity;
	use App\Forms\OptionalSalesSearchEntity;
	use App\Forms\SalesSearchEntity;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\HTML\Forms\CashExpenditureForm;
	use App\Poiz\HTML\Forms\CashPaymentForm;
	use App\Poiz\HTML\Forms\CashRegisterClientInfoForm;
	use App\Poiz\HTML\Forms\CashRegisterProductOrderForm;
	use App\Poiz\HTML\Forms\OptionalSalesSearchForm;
	use App\Poiz\HTML\Forms\SalesSearchForm;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Doctrine\ORM\EntityManagerInterface;
	use mysql_xdevapi\Exception;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Security\Core\User\UserInterface;
	
	class CashRegisterController extends AbstractController {
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
		 * @var RequestBridge
		 */
		private $rb;
		
		/**
		 * CashRegisterController constructor.
		 *
		 * @param \Doctrine\ORM\EntityManagerInterface                       $entityManager
		 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator                      $translator
		 * @param \App\Helpers\Date\RequestBridge                            $rb
		 */
		public function __construct(EntityManagerInterface $entityManager, SessionInterface $session, ShopTranslator $translator, RequestBridge $rb) {
			$this->entityManager  = $entityManager;
			$this->session        = $session;
			$this->translator     = $translator;
			$this->rb             = $rb;
		}
		
		/**
		 * @Route("/admin/kasse/verkauf-suchen", name="rte_admin_sales_search")
		 */
		public function salesSearch( Request $request) {
			$user               = $this->initializeActionMethod($request, $this->rb);
			if(!$user instanceof UserInterface){ return $user; }
			$conn               = $this->entityManager->getConnection();
			$melSession         = $this->session->get( RequestBridge::SessionNameSpace );
			$salesSearchObj     = new SalesSearchEntity();
			$salesSearchForm    = new SalesSearchForm($salesSearchObj);
			$opSalesSearchObj   = new OptionalSalesSearchEntity();
			$opSalesSearchForm  = new OptionalSalesSearchForm($opSalesSearchObj);
			$salesSearchForm->setTranslator($this->translator);
			$opSalesSearchForm->setTranslator($this->translator);
			$message            = null;
			$barkonto           = null;
			$searchResults      = null;
			$template           = 'cash_register/sales-search.html.twig';
			# $formWidgets        = $opSalesSearchForm->getForm();
			$formWidgetsExtra   = $opSalesSearchForm->getForm();
			
			$requestData        = $request->request->all();
			$salesSearchObj     = isset($requestData['sales_search']) ? $salesSearchForm->isValid($requestData['sales_search']) : $salesSearchObj;
			$opSalesSearchObj   = isset($requestData['sales_search']) ? $opSalesSearchForm->isValid($requestData['optional_sales_search']) : $opSalesSearchObj;
			
			
			if($opSalesSearchObj && $salesSearchObj && $_POST){
				$kunde              = ($bc = trim($salesSearchObj->getBusinessClient()) ) ? $bc : ( ($pc = trim($salesSearchObj->getPrivateClient()) ) ? $pc : $salesSearchObj->getBusinessClient() );
				if(!$salesSearchObj->getMinAmount()) { $salesSearchObj->setMinAmount(0); }
				if(!$salesSearchObj->getMaxAmount()) { $salesSearchObj->setMaxAmount(1000000); }
				if(!$opSalesSearchObj->getMinAmount()) { $opSalesSearchObj->setMinAmount(0); }
				if(!$opSalesSearchObj->getMaxAmount()) { $opSalesSearchObj->setMaxAmount(1000000); }
				
				$sql  = <<<SQL
SELECT
	psn.`Firma`,
	psn.`name`,
	psn.`vorname`,
	psn.`Kategorie`,
	vkf.`verkaufid`,
	vkf.`verkaufdatum`,
	vkf.`verkaufbetrag`,
	zmt.`Zahlungsmittel_kurz`
FROM `verkauf` 							AS vkf
LEFT JOIN `personen` 				AS psn ON vkf.verkaufkunde=psn.kundenid
LEFT JOIN `BH_Journal` 			AS bhj ON vkf.verkaufid=bhj.BH_Journal_verkauf_id
LEFT JOIN `Zahlungsmittel` 	AS zmt ON vkf.verkaufzahlungsmittel=zmt.Zahlungsmittel_id

WHERE vkf.verkaufdatum  		BETWEEN :DATE_1P AND :DATE_2P
AND 	vkf.verkaufbetrag 		BETWEEN :MIN_AMOUNT_N AND :MAX_AMOUNT_N
AND 	bhj.BH_Journal_betrag BETWEEN :MIN_AMOUNT_P AND :MAX_AMOUNT_P
SQL;
				
				$rayData = [
					'DATE_1P'         => $salesSearchObj->getStartDate()->format("Y-m-d"),
					'DATE_2P'         => $salesSearchObj->getEndDate()->format("Y-m-d"),
					'MIN_AMOUNT_N'    => $salesSearchObj->getMinAmount(),
					'MAX_AMOUNT_N'    => $salesSearchObj->getMaxAmount(),
					'MIN_AMOUNT_P'    => $opSalesSearchObj->getMinAmount(),
					'MAX_AMOUNT_P'    => $opSalesSearchObj->getMaxAmount(),
				];
				
				if($kunde){
					$sql  .= " AND vkf.verkaufkunde=:BIZ_PRV_CLIENT ";
					$rayData['BIZ_PRV_CLIENT']  = $kunde;
				}
				if($opSalesSearchObj->getProductCategory()){
					$sql  .= " AND bhj.BH_Journal_konto_haben=:PROD_CATEGORY ";
					$rayData['PROD_CATEGORY']  = $opSalesSearchObj->getProductCategory();
				}
				if($opSalesSearchObj->getInformation()){
					$sql  .= " AND bhj.BH_Journal_kommentar LIKE :COMMENTS ";
					$rayData['COMMENTS']  =  "%{$opSalesSearchObj->getInformation()}%";
				}
				if($salesSearchObj->getDepartment()){
					$sql  .= " AND bhj.BH_Journal_ma=:DEPARTMENT ";
					$rayData['DEPARTMENT']  =  $salesSearchObj->getDepartment();
				}
				if($salesSearchObj->getPaymentMethod()){
					$sql  .= " AND vkf.verkaufzahlungsmittel=:PAYMENT_METHOD ";
					$rayData['PAYMENT_METHOD']  = $salesSearchObj->getPaymentMethod();
				}
				$sql  .= " GROUP BY vkf.`verkaufid` ORDER BY vkf.`verkaufid` DESC ";
				
				$statement  = $conn->prepare($sql);
				$statement->execute($rayData);
				$searchResults = $statement->fetchAll();
				$template = 'cash_register/sales-search-result.html.twig';
			}
			if($searchResults){
				foreach($searchResults as &$dataHead){
					$clientName = "";
					$sql2 =<<<SQL2
SELECT BH_Journal_betrag, BH_Journal_kommentar, kat_name
FROM BH_Journal 							AS bhj
LEFT JOIN verkauf 						AS vkf ON vkf.verkaufid=bhj.BH_Journal_verkauf_id
LEFT JOIN produkte_kategorie	AS pkt ON pkt.produktekategorie_BH_Konto=bhj.BH_Journal_konto_haben
WHERE vkf.verkaufid=:VKF_ID
SQL2;
					if(trim($dataHead['vorname'])){
						$clientName .= trim($dataHead['vorname']);
						if(trim($dataHead['name'])) {
							$clientName .= " " . trim($dataHead['name']);
						}
					}elseif(trim($dataHead['name'])){
						$clientName .= trim($dataHead['name']);
					}
					if(trim($dataHead['Firma'])){
						$clientName .= $clientName ? " -- " . trim($dataHead['Firma']) : trim($dataHead['Firma']);
					}
					
					$stm = $conn->prepare($sql2);
					$stm->execute(['VKF_ID' => $dataHead['verkaufid']]);
					$dataHead['children']     = $stm->fetchAll();
					$dataHead['clientName']   = $clientName;
					$dataHead['verkaufdatum'] = new \DateTime($dataHead['verkaufdatum']);
				}
				$this->addFlash("success", "Suche wurde erfolgreich abgeschlossen...");
			}
			
			return $this->render( $template, [
				'controller_name'   => 'CashRegisterController',
				'formWidgets'       => $salesSearchForm->getForm(),
				'formWidgetsExtra'  => $formWidgetsExtra,
				'user'              => $this->getUser(),
				'error'             => null,
				'navPayload'        => $this->getNavigationPayload(),
				'btnText'           => 'Los',
				'message'           => $message,
				'pageTitle'         => 'Verkauf suchen',
				'searchResults'     => $searchResults,
			] );
		
		}
		
		/**
		 * @Route("/admin/kasse/barausgabe-buchen", name="rte_admin_book_cash_expenditure")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 * @throws \Doctrine\DBAL\DBALException
		 */
		public function bookCashExpenditure( Request $request ) {
			$user             = $this->initializeActionMethod($request, $this->rb);
			if(!$user instanceof UserInterface){ return $user; }
			$conn             = $this->entityManager->getConnection();
			$melSession       = $this->session->get( RequestBridge::SessionNameSpace );
			$cashExpenseObj   = new CashExpenditureEntity();
			$cashExpenseForm  = new CashExpenditureForm($cashExpenseObj, $this->translator);
			$message          = null;
			$barkonto         = null;
			
			if($cashExpenseObj = $cashExpenseForm->isValid($request->request->all()) ){
				//"INSERT INTO BH_Journal (BH_Journal_id, BH_Journal_datum, BH_Journal_kommentar, BH_Journal_konto_soll, BH_Journal_konto_haben, BH_Journal_betrag, BH_Journal_verkauf_id, BH_Journal_ma) VALUES (NULL , NOW( ),  '$bemerkungen',  '$konto',  '$barkonto',  '$betrag',  '0', '$benutzer')";
				$barkonto     = ($dpt = $melSession['department'])  == 940 ? 1000 : 1001;
				$insertStatus = $conn->insert('BH_Journal', [
					'BH_Journal_datum'        => date("Y-m-d H:i:s"),
					'BH_Journal_kommentar'    => $cashExpenseObj->getMessage(),
					'BH_Journal_konto_soll'   => $cashExpenseObj->getAccount(),
					'BH_Journal_betrag'       => $cashExpenseObj->getAmount(),
					'BH_Journal_konto_haben'  => $barkonto,
					'BH_Journal_verkauf_id'   => '0',
					'BH_Journal_kreditor_id'  => '0',
					'BH_Journal_ma'           => $melSession['department']
				]);
				
				if($insertStatus){
					$this->addFlash("success", "Barausgabe wurde erfolgreich gebucht...");
					# CLEAR THE FORM...
					$cashExpenseObj   = new CashExpenditureEntity();
					$cashExpenseForm  = new CashExpenditureForm($cashExpenseObj, $this->translator);
					// REDIRECT TO THE DAILY STATEMENT OF ACCOUNT PAGE: `rte_admin_account_statement_today`
					## return $this->redirectToRoute('rte_admin_account_statement_today', []);
					## $beleg     = $conn->lastInsertId();
					## $message   = $this->buildCashExpenditureBookingConfirmationMessage($beleg, $cashExpenseObj->getAccount());
				}
			}
			
			return $this->render( 'cash_register/cash-expenditure-booking.html.twig', [
				'controller_name'   => 'CashRegisterController',
				'formWidgets'       => $cashExpenseForm->getForm(),
				'user'              => $this->getUser(),
				'error'             => null,
				'navPayload'        => $this->getNavigationPayload(),
				'btnText'           => 'Los',
				'message'           => $message,
				'pageTitle'         => 'Barausgabe buchen',
			] );
		
		}
		
		private function buildCashExpenditureBookingConfirmationMessage($beleg, $konto){
			return <<<MSG
<div class="">
	<div class="pz-info-box"><h3>Barausgabe - Bestätigung</h3></div>
	
	<div class="">
		Bitte trage folgende Angaben auf dem Papierbeleg ein.<br>
		Leg den Beleg ins Büro von Philippe - merci!
	</div>
	<div class="pz-grid-2-cols">
		<div class="list-group-item pz-grid-left">
			Belegnummer: <strong class="fett">Nr. {$beleg}</strong>
		</div>
		<div class="list-group-item pz-grid-right">
			Kontonummer: <strong class="fett">Kt. {$konto}</strong>
		</div>
	</div>
</div>
MSG;
		}
		
		/**
		 * @Route("/admin/kasse/bargeld-einzahlen", name="rte_admin_cash_payment")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Doctrine\DBAL\DBALException
		 */
		public function cashPayment( Request $request ) {
			$user               = $this->initializeActionMethod($request, $this->rb);
			if(!$user instanceof UserInterface){ return $user; }
			$haben              = null;
			$message            = null;
			$pageTitle          = 'Bargeld einzahlen';
			$cashPaymentEntity  = new CashPaymentEntity();
			$cashPaymentForm    = new CashPaymentForm($cashPaymentEntity, $this->translator);
			$melSession         = $this->session->get( RequestBridge::SessionNameSpace );
			$conn               = $this->entityManager->getConnection();
			
			if($cashPaymentEntity = $cashPaymentForm->isValid($request->request->all())){
				$information    = 'Bareinzahlung '. $user->getFriendlyName();
				$coWorker       = $melSession['department'];
				// Aus welcher Filiale bzw. Barkasse wird einbezahlt?
				if ($coWorker == 940){$haben = 1000;}
				if ($coWorker == 941){$haben = 1001;}
				
				$insertStatus = $conn->insert('BH_Journal', [
					'BH_Journal_datum'        => date("Y-m-d H:i:s"),
					'BH_Journal_kommentar'    => $information,
					'BH_Journal_konto_soll'   => '1010',
					'BH_Journal_betrag'       => $cashPaymentEntity->getAmount(),
					'BH_Journal_konto_haben'  => $haben,
					'BH_Journal_verkauf_id'   => '0',
					'BH_Journal_kreditor_id'  => '0',
					'BH_Journal_ma'           => $coWorker,
				]);
				if($insertStatus){
					$beleg      = $conn->lastInsertId();
					$flash      = "CHF {$cashPaymentEntity->getAmount()} wurde erfolgreich aus der Barkasse einbezahlt.";
					$pageTitle  = "Bargeld wurde erfolgreich einbezahlt.";
					$message    = "Vielen Dank! Du hast soeben <strong class='pz-amount'>CHF {$cashPaymentEntity->getAmount()}</strong> ";
					$message   .= " aus der <strong class='pz-amount'>Barkasse  {$user->getFriendlyName()} </strong> einbezahlt. ";
				#	$message   .= "Trage die <strong class='pz-amount'>Nummer {$beleg} </strong> auf dem Beleg der Post ein und leg ihn ins Fächli von Philippe. ";
					$message   .= "<br />Bitte, kontrolliere zudem auf der Tagesabrechnungs-Seite, ob der aktuelle Barkassenstand korrekt ist.";
					$this->addFlash('success', $flash);
					
					# CLEAR THE FORM
					$cashPaymentEntity  = new CashPaymentEntity();
					$cashPaymentForm    = new CashPaymentForm($cashPaymentEntity, $this->translator);
				}
			}
			
			return $this->render( 'cash_register/cash-payment.html.twig', [
				'controller_name'   => 'CashRegisterController',
				'formWidgets'       => $cashPaymentForm->getForm(),
				'user'              => $user,
				'error'             => null,
				'navPayload'        => $this->getNavigationPayload(),
				'btnText'           => 'Los',
				'message'           => $message,
				'pageTitle'         => $pageTitle,
			] );
		}
		
		/**
		 * @Route("/admin/kasse", name="rte_admin_cash_register")
		 */
		public function cashRegister( Request $request) {
			$user             = $this->initializeActionMethod($request, $this->rb);
			if(!$user instanceof UserInterface){ return $user; }
			$cloneAmount      = 2;
			$errorsCount      = 0;
			$groupCount       = -1;
			$cleanDataBank    = [];
			$forms            = [];
			$crcInfoEntity    = new CashRegisterClientInfoEntity();
			$crpOrderEntity   = new CashRegisterProductOrderEntity();
			
			$crcInfoForm      = new CashRegisterClientInfoForm($crcInfoEntity, $this->translator, ['formKey'=>"product_info_form_1"]);
			$crpOrderForm     = new CashRegisterProductOrderForm($crpOrderEntity, $this->translator, ['formKey'=>'product_group_1']);
			
			$postVars         = $request->request->all();
			
			// ADD EXTRA, BULK-PRODUCTS FORM-CONTROLS
			if(isset($postVars['processForm']) && !$postVars['processForm'] &&
			   isset($postVars['extra_product_amount']) &&
			   $postVars['extra_product_amount']) {
				
				$cloneAmount = $postVars['extra_product_amount'];
				for ( $i = 0, $j = 1; $i < $postVars['extra_product_amount']; $i++, $j++ ) {
					$tmpCrpEntity = new CashRegisterProductOrderEntity();
					if ( isset($postVars["product_group_". ( $j + 1 )]) ) {
						$tmpCrpEntity->autoSetClassProps( $postVars["product_group_". ( $j + 1 )] );
					}
					$tmpCrpForm = new CashRegisterProductOrderForm( $tmpCrpEntity, $this->translator, [ 'formKey' => "product_group_" . ( $j + 1 ) ] );
					$forms[]    = $tmpCrpForm->getForm();
				}

				// BUILD THE FORM-CONTROLS IN BULK
				$this->updateFormEntityData($postVars,$crcInfoEntity,$crpOrderEntity,$crcInfoForm,$crpOrderForm);
			}else if(isset($postVars['processForm']) && $postVars['processForm']){
				// SAVE ALL ENTRIES AND REDIRECT AFTERWARDS...
				foreach($postVars as $strKey=>$postVar){
					if(stristr($strKey, 'product_group_') && is_array($postVar)){
						$groupCount++;
					}
				}
				
				if($groupCount>0){
					for ( $i = 0, $j = 1; $i < $groupCount; $i ++, $j ++ ) {
						$tmpCrpEntity = new CashRegisterProductOrderEntity();
						if ( isset($postVars["product_group_". ( $j + 1 )]) ) {
							$tmpCrpEntity->autoSetClassProps( $postVars["product_group_". ( $j + 1 )] );
						}
						$tmpCrpForm = new CashRegisterProductOrderForm( $tmpCrpEntity, null, [ 'formKey' => "product_group_" . ( $j + 1 ) ] );
						$tmpCrpForm->setTranslator($this->translator);
						
						try{
							if( !($tmpObj = $tmpCrpForm->isValid($tmpCrpEntity->getEntityBank()) ) ){
								$errorsCount++;
							}else{
								$cleanDataBank[] = $tmpCrpEntity->getEntityBank();
							}
						}catch(\Exception $e){throw new \Exception($e->getMessage());}
						
						$forms[]    = $tmpCrpForm->getForm();
					}
					//$cloneAmount = $cloneAmount > $groupCount ? $cloneAmount : $groupCount;
				}
				
				$this->updateFormEntityData($postVars,$crcInfoEntity,$crpOrderEntity,$crcInfoForm,$crpOrderForm);
				
				try {
					$possibleVars = $this->getPossibleVars($postVars, 'product_info_form_1');
					$orderVars    = $this->getPossibleVars($postVars, 'product_group_1');
					
					$crcInfoForm->isValid( $possibleVars );
					$crpOrderForm->isValid( $orderVars );
					if( !($tmpObj = $crcInfoForm->isValid($possibleVars) ) ){
						$errorsCount++;
					}else{
						$cleanDataBank['crcInfoForm'] = $tmpObj->getEntityBank();
					}
					// ORDER FORM
					if($orderVars){   # FIX EMPTY $orderVars
						if( !($tmpObj = $crpOrderForm->isValid($orderVars))){
							$errorsCount++;
						}else{
							$cleanDataBank[] = $tmpObj->getEntityBank();
						}
					}
					if($errorsCount == '0'){
						if($this->saveCashRegisterOrderData($cleanDataBank)){
							$this->addFlash("success", "Verkauf wurde hinzugefügt...");
							// REDIRECT TO THIS VERY VIEW...  (NOT THE STATISTICS CURRENT-DATE VIEW)
							// $this->redirectToRoute('rte_admin_cash_register');   # 'rte_admin_account_statement_today');
							
							# RESET THE FORM RATHER:
							$crcInfoEntity    = new CashRegisterClientInfoEntity();
							$crpOrderEntity   = new CashRegisterProductOrderEntity();
							$crcInfoForm      = new CashRegisterClientInfoForm($crcInfoEntity, $this->translator, ['formKey'=>"product_info_form_1"]);
							$crpOrderForm     = new CashRegisterProductOrderForm($crpOrderEntity, $this->translator, ['formKey'=>'product_group_1']);
							$cloneAmount      = 2;
							$forms            = [];
						}
					}
				}catch (\Exception $e){
					throw new \Exception($e);
				}
			}
			
			$cloneAmount = $cloneAmount > $groupCount ? $cloneAmount : $groupCount;
			return $this->render( 'cash_register/cash-register.html.twig', [
				'controller_name'   => 'CashRegisterController',
				'crcInfoWidgets'    => $crcInfoForm->getForm(),
				'crpOrderWidgets'   => $crpOrderForm->getForm(),
				'formWidgetsExtra'  => $forms,
				'user'              => $this->getUser(),
				'error'             => null,
				'navPayload'        => $this->getNavigationPayload(),
				'btnText'           => 'Los',
				'pageTitle'         => 'Kasse',
				'cloneAmount'       => $cloneAmount,
			] );
		}
		
		protected function getPossibleVars($postVars=[], $defaultKey='product_info_form_1'){
			$possibleVars  = [];
			foreach($postVars as $strKey=>$postVar){
				if($defaultKey == 'product_group_1'){
					if(in_array($strKey, ['productCategory', 'amount', 'message'])){
						$possibleVars[$strKey]  = $postVar;
						unset($postVars[$strKey]);
					}
				}else {
					if(in_array($strKey, ['paymentMethod', 'client'])){
						$possibleVars[$strKey]  = $postVar;
						unset($postVars[$strKey]);
					}
				}
			}
			$data =  isset($postVars[$defaultKey]) ? array_merge($possibleVars, $postVars[$defaultKey]) : $possibleVars;
		
			return $data;
		}
		
		protected function saveCashRegisterOrderData($cleanDataBank=[]){
			$conn         = $this->entityManager->getConnection();
			$crcInfoForm  = isset($cleanDataBank['crcInfoForm']) ? $cleanDataBank['crcInfoForm'] : null;
			$kunde        = ($bc = trim($crcInfoForm['client']) ) ? $bc : ( ($pc = trim($crcInfoForm['privateClient'])) ? $pc : 43  );
			unset($cleanDataBank['crcInfoForm']);
			$status       = 5;
			# BUILD SOLL
			switch ($crcInfoForm['paymentMethod']){
				case '1':
					$soll = 1000;
					break;
				case '10':
					$soll = 1001; # im Hirschengraben bar abgebucht? Dann auf entsprechendes Barkonto buchen
					break;
				case '11':
					$soll = 1030; # per PayPal bezahlt (online-Aufträge)?
					break;
				default:
					$soll = 1105;
					break;
			}
			
			# BUILD TOTAL:
			$total  = 0;
			foreach($cleanDataBank as $cleanData){
				$total += $cleanData['amount'];
			}
			$melSession     = $this->session->get(RequestBridge::SessionNameSpace);
			$insertStatus2  = 0;
			$insertStatus1  = $conn->insert('verkauf', [
				'verkaufdatum'          => date("Y-m-d H:i:s"),
				'verkaufzeit'           => date("H:i:s"),
				'verkaufmitarbeiter'    => $melSession['department'],
				'verkaufkunde'          => $kunde,
				'verkaufbetrag'         => $total,
				'verkaufzahlungsmittel' => $crcInfoForm['paymentMethod'],
				'verkauf_status_id'     => $status,
			]);
			$salesID  = $conn->lastInsertId();
			foreach($cleanDataBank as $cleanData){
				$insertStatus2 = $conn->insert('BH_Journal', [
					'BH_Journal_datum'        => date("Y-m-d H:i:s"),
					'BH_Journal_kommentar'    => $cleanData["message"],
					'BH_Journal_konto_soll'   => $soll,
					'BH_Journal_konto_haben'  => $cleanData["productCategory"],
					'BH_Journal_betrag'       => $cleanData["amount"],
					'BH_Journal_verkauf_id'   => $salesID,
					'BH_Journal_kreditor_id'  => '0',
					'BH_Journal_ma'           => $melSession['department']
				]);
			}
			
			return $insertStatus1 && $insertStatus2;
		}
		
		protected function updateFormEntityData($postVars, &$crcInfoEntity, &$crpOrderEntity, &$crcInfoForm, &$crpOrderForm){
			if ( isset($postVars["product_info_form_1"]) ) { // || (isset($postVars['businessClient']) && isset($postVars['paymentMethod']))
				$crcInfoEntity->autoSetClassProps( $postVars["product_info_form_1"] );
				$crcInfoForm      = new CashRegisterClientInfoForm($crcInfoEntity, $this->translator, ['formKey'=>"product_info_form_1"]);
			}else{
				$crcInfoEntity->autoSetClassProps( $postVars );
				$crcInfoForm      = new CashRegisterClientInfoForm($crcInfoEntity, $this->translator);
			}
			if ( isset($postVars["product_group_1"]) ) {
				$crpOrderEntity->autoSetClassProps($postVars["product_group_1"]);
				$crpOrderForm     = new CashRegisterProductOrderForm($crpOrderEntity, $this->translator, ['formKey'=>"product_group_1"]);
			}else{
				$crpOrderEntity->autoSetClassProps( $postVars );
				$crpOrderForm      = new CashRegisterProductOrderForm($crpOrderEntity, $this->translator);
			}
			
			if(isset($postVars['client']) && isset($postVars['paymentMethod'])){
				$crcInfoEntity->autoSetClassProps( $postVars);
				$crcInfoForm      = new CashRegisterClientInfoForm($crcInfoEntity);
			}
		}
	}
