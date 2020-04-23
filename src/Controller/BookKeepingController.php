<?php
	
	namespace App\Controller;
	
	use App\Entity\BHJournal;
	use App\Entity\BHKonto;
	use App\Entity\Personen;
	use App\Entity\ProdukteKategorie;
	use App\Entity\Rechnung;
	use App\Entity\RechnungPosten;
	use App\Entity\RechnungPs;
	use App\Forms\BillFinalizerEntity1;
	use App\Forms\BillPostEntity;
	use App\Forms\BillRecapEntity;
	use App\Forms\BillStatusEntity;
	use App\Forms\BKClientEntity;
	use App\Forms\BookKeepingEntity;
	use App\Helpers\Date\DateCalculator;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\HTML\Forms\BillFinalizerForm;
	use App\Poiz\HTML\Forms\BillPostForm;
	use App\Poiz\HTML\Forms\BillRecapForm;
	use App\Poiz\HTML\Forms\BillStatusForm;
	use App\Poiz\HTML\Forms\BKClientForm;
	use App\Poiz\HTML\Forms\BookKeepingForm;
	use App\Poiz\HTML\Forms\ClientForm;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Endroid\QrCode\ErrorCorrectionLevel;
	use Endroid\QrCode\LabelAlignment;
	use Endroid\QrCode\QrCode;
	use Endroid\QrCode\Response\QrCodeResponse;

	class BookKeepingController extends AbstractController {
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
		 * @var array
		 */
		private $viewPayload = [];
		
		/**
		 * @var ShopTranslator
		 */
		private $translator;
		
		/**
		 * @var RequestBridge
		 */
		private $rb;
		
		
		const MJR_LOGO_PATH         = __DIR__ . "/../../public/images/logos/Logo_MJR_Design.png";
		const MJR_LABEL_FONT_PATH   = __DIR__ . "/../../public/fonts/Quicksand_Book.otf";
		const PUBLIC_IMG_DIR        = __DIR__ . "/../../public/images/";
		
		public function __construct(EntityManagerInterface $entityManager, SessionInterface $session,  ShopTranslator $translator, RequestBridge $rb) {
			$this->rb             = $rb;
			$this->session        = $session;
			$this->translator     = $translator;
			$this->entityManager  = $entityManager;
		}
		
		/**
		 * @Route("/book/keeping", name="book_keeping")
		 */
		public function index() {
			return $this->render( 'book_keeping/index.html.twig', [
				'controller_name' => 'BookKeepingController',
			] );
		}
		
		
		/**
		 * @Route("/admin/buchhaltung", name="rte_admin_book_keeping")
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function bookKeeping() {
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			
			return $this->render( 'book_keeping/book-keeping.html.twig', [
				'controller_name' => 'BookKeepingController',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Buchhaltung',
				'infoHTML'        => 'In dieser Rubrik kannst du an buchhalterischen Vorgängen arbeiten. Take it easy...',
				'feedbackHTML'    => 'Funktioniert etwas nicht so, wie du es dir vorstellst? Sag es ruhig Philippe, er wird sich der Sache annehmen...',
			] );
		}
		
		/**
		 * @Route("/admin/buchhaltung/rechnung-neu", name="rte_admin_new_bill")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function newBill(Request $request) {
			# $this->session->clear();
			$user             = $this->initializeActionMethod($request, $this->rb);
			if(!$user instanceof UserInterface){ return $user; }
			$melSession       = $this->session->get( RequestBridge::SessionNameSpace );
			$rayBill          = []; //isset($melSession['lastRechnungPayload']) ? $melSession['lastRechnungPayload']  : [];
			$clientBills      = []; //isset($melSession['lastAllBillsPayload']) ? $melSession['lastAllBillsPayload']  : [];
			$pageTitle        = 'Neue Rechnung eröffnen';
			$bookKeepingObj   = new BookKeepingEntity();
			$bookKeepingForm  = new BookKeepingForm($bookKeepingObj, $this->translator);
			$cClientBills     = $this->fetchCurrentBillsForClient($bookKeepingObj->getClient(), date("Y-m-d"));
			
			$clientEntity     = null;
			$clientForm       = null;
			
			if($bookKeepingObj = $bookKeepingForm->isValid($request->request->all())){
				/**@var $rechnung*/
				$rechnung         = null;
				$bhJournal        = null;
				$rechnungPosten   = null;
				$cClientBills     = [];
				$rayBills         = [];
				$rayBill          = [];
				
				// WE SAVE THE RECHNUNG AND THEN GIVE THE OPERATOR A CHANCE TO ADD NEW PRODUCT (BILL) TO THE CURRENT BILL
				// OR TO TRANSFER THE CURRENT BILL TO ANOTHER CLIENT...
				$response = $this->processRechnung($bookKeepingObj->getClient(), $bookKeepingObj,$melSession,$bhJournal,$rechnung, $rechnungPosten,$rayBill, $rayBills,$cClientBills );
				
				$clientEntity     = new BKClientEntity();
				$clientForm       = new BKClientForm($clientEntity, $this->translator, ['formKey'=>'transfer_bill_to_client']);
				$clientBills      = isset($melSession['lastAllBillsPayload']) ? $melSession['lastAllBillsPayload']  : [];
				
				if($response instanceof RedirectResponse){
					$this->addFlash('success', 'Einen Neuen Rechnung mit ID: ' . $rechnung->getRechnungId() . ' -  wurde erfolgreich erstellt.');
					return $this->redirectToRoute('rte_admin_edit_bill_main', []);
				}
			}
			
			return $this->render( 'book_keeping/new-bill.html.twig', [
				'controller_name' => 'BookKeepingController',
				'pageTitle'       => $pageTitle,
				'btnText'         => 'Los',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'formWidgets'     => $bookKeepingForm ? $bookKeepingForm->getForm() : [],
				'rayBill'         => $rayBill,
				'newClientWidgets'=> $clientForm ? $clientForm->getForm() : [],
				'currentBills'    => $cClientBills,
				'billData'        => $rayBill,
				'clientBills'     => $clientBills,
			] );
		}
		
		/**
		 * @Route("/admin/buchhaltung/rechnung-bearbeiten/finalisierung/{id}/{date}", name="rte_admin_finalize_bill")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @param int|null                                  $id
		 * @param int|null                                  $date
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Exception
		 */
		public function finalizeBill(Request $request, $id=null, $date=null) {
			/**@var Rechnung              $bill */
			/**@var RechnungPs            $rechnungPs */
			/**@var BillFinalizerEntity1  $billFnzObj */
			$user             = $this->initializeActionMethod($request, $this->rb);
			if(!$user instanceof UserInterface){ return $user; }
			$pageTitle          = 'Rechnung bearbeiten';
			$formTitle          = 'Rechnung bearbeiten';
			$qrCodeURL          = null;
			$formTitle          = 'Schritt 1 von 2: Rechnung ergänzen';
			$bill               = $this->entityManager->getRepository(Rechnung::class)->find($id);
			$billFinalizerObj   = new BillFinalizerEntity1();
			/**
			$autoGenBillNumber  = $this->autoGenerateBillNumber();
			$autoGenBillRefNum  = $this->autoGeneratePseudoBankReference($id);  #$this->autoGenerateBillBankReferenceNumber();
			$billFinalizerObj->setBillStatus($bill->getRechnungStatus());
			$billFinalizerObj->setBillNumber($autoGenBillNumber);
			$billFinalizerObj->setBankReferenceNumber($autoGenBillRefNum);
			*/
			$billFinalizerObj->setBillID($id);
			$billFinalizerForm  = new BillFinalizerForm($billFinalizerObj, $this->translator, ['formKey'=>'finalize_bill_step_1']);
			
			if($id){
				$rechnungID       = $id;
				# $qrCodeURL      = $this->createQRCode($id);
				if($date){
					$payload        = $request->request->all();
					$clientBills    = $this->fetchCurrentBillsForClientBasedOnBillNr($id, $date);
					$rayBill        = $clientBills ? $clientBills[0] : [];
					if(isset($payload['finalize_bill_step_1'])){
						$formTitle    = 'Schritt 2 von 2: Rechnung ausdrucken und lossenden';
						$postVars     = $payload['finalize_bill_step_1'];
						
						if($billFnzObj   = $billFinalizerForm->isValid($postVars)){
							// MOVE TO STEP 2:
							$billTotal      = $this->getBillTotalFromBillPosts($clientBills);
							$bill           = $this->entityManager->getRepository(Rechnung::class)->find($billFnzObj->getBillID());
							# $rechnungPs     = $this->entityManager->getRepository(RechnungPs::class)->find($billFnzObj->getPs());
							# $billPSContent  = $rechnungPs->getRechnungPsInhalt();
							$bill->setRechnungNummer($billFnzObj->getBillNumber())
								->setRechnungBetragBill($billTotal)
								->setRechnungKonditionen($billFnzObj->getPaymentConditons())
								->setRechnungStatus($billFnzObj->getBillStatus())
								->setRechnungDank($billFnzObj->getThankYou())
								->setRechnungPsId($billFnzObj->getPs())
								->setRechnungBemerkungen($billFnzObj->getMessage());
							$this->entityManager->persist($bill);
							$this->entityManager->flush();
							
							$clientBills      = $this->fetchCurrentBillsForClientBasedOnBillNr($id, $date);
							$this->addFlash('success', 'Schritt 1 - Rechnung ergänzen - wurde erfolgreich abgeschlossen');

							return $this->render( 'book_keeping/finalize-bill-2.html.twig', [
								'controller_name' => 'BookKeepingController',
								'pageTitle'       => $pageTitle,
								'formTitle'       => $formTitle,
								'btnText'         => 'Los',
								'qrCodeURL'       => $qrCodeURL,
								'user'            => $this->getUser(),
								'navPayload'      => $this->getNavigationPayload(),
								'formWidgets'     => $billFinalizerForm ? $billFinalizerForm->getForm() : [],
								'billData'        => isset($clientBills[0]) && $clientBills[0] ? $clientBills[0] : ( isset($rayBill) && $rayBill? $rayBill: []),
								'clientBills'     => isset($clientBills) ? $clientBills : [],
								'hideForms'       => true,
								'showBillFooter'  => true,
								'showBillNumber'  => true,
								'rechnungID'      => isset($rechnungID) ? $rechnungID : $id,
								'newClientWidgets'=> [],
							] );
						}
					}else{
						// FALL BACK TO STEP 1
					}
				}
			}
			
			
			return $this->render( 'book_keeping/finalize-bill-1.html.twig', [
				'controller_name' => 'BookKeepingController',
				'pageTitle'       => $pageTitle,
				'formTitle'       => $formTitle,
				'btnText'         => 'Los',
				'hideForms'       => false,
				'showBillFooter'  => false,
				'showBillNumber'  => false,
				'qrCodeURL'       => $qrCodeURL,
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'formWidgets'     => $billFinalizerForm ? $billFinalizerForm->getForm() : [],
				'billData'        => isset($rayBill) ? $rayBill : [],
				'clientBills'     => isset($clientBills) ? $clientBills : [],
				'rechnungID'      => isset($rechnungID) ? $rechnungID : $id,
				'newClientWidgets'=> [],  //($clientForm) ? $clientForm->getForm() : [],
			] );
		}
		
		/**
		 * @Route("/admin/buchhaltung/rechnung-bearbeiten/haupt/{id}/{bhj_id}/{date}/{intent}/{billType}", name="rte_admin_edit_bill")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @param int|null                                  $id
		 * @param int|null                                  $bhj_id
		 * @param mixed                                     $intent
		 * @param mixed                                     $billType
		 * @param int|null                                  $date
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Exception
		 */
		public function editBill(Request $request, $id=null, $bhj_id=null, $date=null, $intent=null, $billType=null) {
			return $this->editBillMain($request, $id, $bhj_id, $date, $intent, $billType);
		}
		
		/**
		 * @Route("/admin/buchhaltung/rechnung-bearbeiten/rechnung-posten-bearbeiten/{id}/{bhj_id}/{date}/{intent}", name="rte_admin_edit_bill_main")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @param int|null                                  $id
		 * @param int|null                                  $bhj_id
		 * @param int|null                                  $date
		 * @param int|string                                $intent
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Exception
		 */
		public function editBillMain(Request $request, $id=null, $bhj_id=null, $date=null, $intent=null) {
			/**
			 * @var Rechnung          $bill
			 * @var Rechnung          $theBill
			 * @var Rechnung          $oldBill
			 * @var BHJournal         $bhj
			 * @var ProdukteKategorie $pCat
			 * @var RechnungPosten    $rchPost
			 */
			$user             = $this->initializeActionMethod($request, $this->rb);
			if(!$user instanceof UserInterface){ return $user; }
			$melSession       = $this->session->get( RequestBridge::SessionNameSpace );
			$bookKeepingObj   = new BillPostEntity();
			$formTitle        = '';
			$formKey          = 'add_to_current_bill';
			$qrCodeURL        = null;
			$clientBills      = [];
			$widgets          = [];
			$pageTitle        = 'Rechnung bearbeiten';
			$subTitle         = 'Aktueller Rechnungsentwurf';
			$action           = 'bearbeiten';
			
			if($id){
				$postVars     = $request->request->all();
				#$qrCodeURL   = $this->createQRCode($id);
				$theBill      = $this->entityManager->getRepository(Rechnung::class)->find($id);
				$clientEntity = new BKClientEntity();
				$clientEntity->setClient($theBill->getRechnungKunde());
				$clientForm   = new BKClientForm( $clientEntity, $this->translator, [ 'formKey' => 'transfer_bill_to_client' ] );
				
				$billStatusEntity = new BillStatusEntity();
				$billStatusEntity->setStatus($theBill->getRechnungStatus());
				$billStatusForm   = new BillStatusForm( $billStatusEntity, $this->translator, [ 'formKey' => 'set_bill_status' ] );
				
				if(isset($postVars['add_to_current_bill'])){
					$bookKeepingObj  = new BillPostEntity();
					$bookKeepingForm = new BillPostForm( $bookKeepingObj, $this->translator, [ 'formKey' => 'add_to_current_bill' ] );
					$bookKeepingObjX = $bookKeepingForm->isValid($postVars['add_to_current_bill']);
					
					$widgets  = $bookKeepingForm->getForm();
					if($bookKeepingObjX){
						$bhj      = $this->saveBHJournal($bookKeepingObjX, $melSession);
						$this->saveRechnungPost($id, $bhj->getBHJournalId());
						$this->addFlash('success', 'Neuen Rechnungsposten wurde erfolgreich hinzugefugt');
					}else {
						$widgets = $bookKeepingForm->getValidatedFormWithErrors();
					}
				}
				
				if(isset($postVars['set_bill_status'])){
					// UPDATE THE BILL STATUS OF THE CURRENT BILL
					$statusVars = $postVars['set_bill_status'];
					if($billStatusObj = $billStatusForm->isValid($statusVars)){
						$theBill->setRechnungStatus($billStatusObj->getStatus());
						$this->entityManager->persist($theBill);
						$this->entityManager->flush();
						
						$message  = "Die Status der Rechnung Nr. «{$id}» wurde erfolgreich aktualisiert.";
						$this->addFlash('success', $message);
						return $this->redirectToRoute('rte_admin_edit_bill_main', ['id' => $id, 'bhj_id' => $bhj_id, 'date'=>$date, 'intent' => $intent]);
					}
					$billStatusEntity->setStatus($theBill->getRechnungStatus());
					$billStatusForm   = new BillStatusForm( $billStatusEntity, $this->translator, [ 'formKey' => 'set_bill_status' ] );
				}
				
				$oldBill    = $this->entityManager->getRepository(Rechnung::class)->find($id);
				$this->manageBillTransfer($postVars, $oldBill, $clientForm, $rdrRoute='rte_admin_edit_bill_main', ['id' => $id, 'bhj_id' => $bhj_id, 'date'=>$date, 'intent' => $intent]);
				
				if ($intent){
					switch ( $intent ) {
						case 'edit_client_bill':
							if ( $date ) {
								$pageTitle   = 'Rechnung mit ID: ' . $id . ' - ' . $action;
								$formTitle   = 'Neuen Rechnungsposten hinzufügen';
								$clientBills = $this->fetchCurrentBillsForClientBasedOnBillNr( $id, $date, $theBill->getRechnungStatus());
							}
							//todo...
							break;
						
						case 'edit_single_bill':
							if ( $date ) {
								$pageTitle    = 'Rechnung mit ID: ' . $id . ' :: ' . $bhj_id . ':: - ' . $action;
								$formTitle    = 'Rechnung mit ID: ' . $id . ' :: ' . $bhj_id . ':: - ' . $action;
								$bhj          = $this->entityManager->getRepository( BHJournal::class )->find( $bhj_id );
								$haben        = $bhj->getBHJournalKontoHaben();
								
								// pkt.produktekategorie_BH_Konto	=bhj.BH_Journal_konto_haben
								$bookKeepingObj->setAmount($bhj->getBHJournalBetrag());
								$bookKeepingObj->setMessage($bhj->getBHJournalKommentar());
								$bookKeepingObj->setProductCategory($haben);
								
								$clientBills = $this->fetchCurrentBillsForClientBasedOnBillNr( $id, $date );
								$formKey          = 'update_bill_post';
								
								if(isset($postVars['update_bill_post'])){
									$bookKeepingObj = new BillPostEntity();
									$bookKeepingObj = (new BillPostForm($bookKeepingObj))->isValid($postVars['update_bill_post']);
									$bhj            = $this->saveBHJournal($bookKeepingObj, $melSession, $bhj_id);
									$rchPost        = $this->entityManager->getRepository(RechnungPosten::class)->findOneBy(["Rechnung_posten_BH_Journal_id"=>$bhj->getBHJournalId()]);
									$this->saveRechnungPost($id, $bhj_id,  $rchPost->getRechnungPostenId());
									$this->addFlash('success', 'Rechnungsposten wurde erfolgreich modifiziert und gespeichert.');
									$bookKeepingObj->setAmount(null);
									$bookKeepingObj->setMessage(" ");
									$bookKeepingObj->setProductCategory(null);
									$clientBills = $this->fetchCurrentBillsForClientBasedOnBillNr( $id, $date );
									$formTitle      = 'Neuen Rechnungsposten hinzufügen';
									$formKey        = 'add_to_current_bill';
								}
							}
							break;
						
						default:
							break;
					}
					
					$bookKeepingForm  = new BillPostForm( $bookKeepingObj, $this->translator, [ 'formKey' =>$formKey ] );
					$widgets          = empty($widgets) ? $bookKeepingForm->getForm() : $widgets;
					
					return $this->render( 'book_keeping/edit-client-bill.html.twig', [
						'controller_name'     => 'BookKeepingController',
						'pageTitle'           => $pageTitle,
						'formTitle'           => $formTitle,
						'subTitle'            => $subTitle,
						'btnText'             => 'Los',
						'billStatusFormTitle' => 'RechnungStatus ändern',
						'billStatusForm'      => $billStatusForm->getForm(),
						'user'                => $this->getUser(),
						'navPayload'          => $this->getNavigationPayload(),
						'formWidgets'         => $widgets,
						'billData'            => $clientBills[0],
						'clientBills'         => $clientBills,
						'rechnungID'          => $id,
						'qrCodeURL'           => $qrCodeURL,
						'newClientWidgets'    => $clientForm->getForm(),
					] );
				}
			}
			return $this->render( 'book_keeping/edit-bills.html.twig', [
				'controller_name'     => 'BookKeepingController',
				'pageTitle'           => $pageTitle,
				'formTitle'           => $pageTitle,
				'subTitle'            => $subTitle,
				'btnText'             => 'Los',
				'user'                => $this->getUser(),
				'navPayload'          => $this->getNavigationPayload(),
				'clientBills'         => $this->fetchNewlyInsertedBills(),
				'rayBills'            => $this->fetchNewlyInsertedBills(),
				'rayBill'             => $this->fetchNewlyInsertedBills(),
				'billStatusFormTitle' => 'RechnungStatus ändern',
			] );
	}
		
		/**
		 * @Route("/admin/buchhaltung/offenen-rechnungen", name="rte_admin_all_open_bills")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Doctrine\DBAL\DBALException
		 */
		public function allOpenBills(Request $request) {
			$user             = $this->initializeActionMethod($request, $this->rb);
			if(!$user instanceof UserInterface){ return $user; }
			$sql          = $this->fetchBillsByStatusSQL();
			$conn         = $this->entityManager->getConnection();
			$statement    = $conn->prepare($sql);
			$statement->execute(['STATUS' => '2']);
			$rayBills     = $statement->fetchAll();
			
			return $this->render( 'book_keeping/bills-archive.html.twig', [
				'controller_name' => 'BookKeepingController',
				'pageTitle'       => 'Offene Rechnungen',
				'btnText'         => 'Los',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'formWidgets'     => [],
				'bills'           => $rayBills,
				'rayBills'        => $rayBills,
				'ipp'             => 50,
				'showPagination'  => 0,
				'currentPage'     => 1,
			] );
		}
		
		/**
		 * @Route("/admin/buchhaltung/rechnungsarchiv/details/{id}", name="rte_admin_closed_bill_details")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param mixed                                     $id
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Doctrine\DBAL\DBALException
		 */
		public function closedBillDetails(Request $request, $id=null) {
			/** @var Rechnung           $bill */
			/** @var RechnungPosten     $billPost */
			/** @var ProdukteKategorie  $catObject */
			/** @var BHJournal          $bhjObject */
			$user           = $this->initializeActionMethod($request, $this->rb);
			$billNum        = "???";
			$bhjData        = [];
			$billData       = [];
			if(!$user instanceof UserInterface){ return $user; }
			if($id){
				$bill         = $this->entityManager->getRepository(Rechnung::class)->find($id);
				if($bill){
					$billNum    = $bill->getRechnungNummer();
					$billPosts  = $this->entityManager->getRepository( RechnungPosten::class )->findBy( [ 'Rechnung_posten_Rechnung_id' => $id ] );
					if($billPosts){
						foreach($billPosts as $billPost){
							$bhjID      = $billPost->getRechnungPostenBHJournalId();
							$bhjObject  = $this->entityManager->getRepository( BHJournal::class )->find($bhjID);
							$bhjEBank   = $bhjObject->getEntityBank();
							$catRel     = $bhjEBank['BH_Journal_konto_haben'];
							$catObject  = $this->entityManager->getRepository( ProdukteKategorie::class )->findOneBy(['produktekategorie_BH_Konto'=> $catRel]);
							
							$bhjEBank['kat_name']         = $catObject->getKatName();
							$bhjEBank['Rechnung_status']  = $bill->getRechnungStatus();
							$bhjData[]                    = $bhjEBank;
						}
					}
					$billData   = $bill->getEntityBank();
					$clientData = $this->entityManager->getRepository( Personen::class )->fetchClientByID($billData['Rechnung_kunde'], true);
					$clientData['Geschlecht_praefix'] = $clientData['mrMrs']['Geschlecht_praefix'];
					$billData['kundenid']             = $billData['Rechnung_kunde'];
					$billData['clientData']           = $clientData;
					$billData['clientPurchases']      = $bhjData;
				}
			}
			
			return $this->render( 'book_keeping/bill-details.html.twig', [
				'controller_name' => 'BookKeepingController',
				'pageTitle'       => "Rechnungsarchiv -- Rechnungsdetails Nr. {$billNum}",
				'btnText'         => 'Los',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'formWidgets'     => [],
				'billData'        => $billData,
			] );
		}
		
		/**
		 * @Route("/admin/buchhaltung/rechnung-verfolgen", name="rte_admin_track_bills")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Doctrine\DBAL\DBALException
		 */
		public function trackBills(Request $request) {
			$user = $this->initializeActionMethod( $request, $this->rb );
			if ( ! $user instanceof UserInterface ) {
				return $user;
			}
			$sql       = $this->fetchBillsByStatusSQL( "rch.Rechnung_id DESC, rch.Rechnung_Datum_open  DESC, rch.Rechnung_Nummer DESC, rch.Rechnung_Datum_bez DESC, rch.Rechnung_id DESC");
			$conn      = $this->entityManager->getConnection();
			$statement = $conn->prepare( $sql );
			$statement->execute( [ 'STATUS' => '2' ] );
			$rayBills = $statement->fetchAll();
			
			return $this->render( 'book_keeping/track-bills.html.twig', [
				'controller_name' => 'BookKeepingController',
				#'formTitle'        => $formTitle,
				'pageTitle'       => 'Rechnung verfolgen',
				'btnText'         => 'Los',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'formWidgets'     => [],
				'bills'           => $rayBills,
				'rayBills'        => $rayBills,
				'ipp'             => 50,
				'showPagination'  => 0,
				'currentPage'     => 1,
				'billData'         => isset($rayBills[0]) ? $rayBills[0] : [],
				'clientBills'      => $rayBills,
				/*'formWidgets'      => $bookKeepingForm->getForm(),
				'rechnungID'       => $id,
				'newClientWidgets' => $clientForm->getForm(),*/
			] );
		}
		
		/**
		 * @Route("/admin/buchhaltung/rechnung-verfolgen/track/{id}/{bhj_id}/{date}/{intent}", name="rte_admin_track_open_bill")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @param int|null                                  $id
		 * @param int|null                                  $bhj_id
		 * @param int|null                                  $date
		 * @param int|string                                $intent
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @return void
		 * @throws \Exception
		 */
		public function trackBill(Request $request, $id=null, $bhj_id=null, $date=null, $intent=null) {
			/**
			 * @var Rechnung            $bill
			 * @var Rechnung            $oldBill
			 * @var BillRecapEntity     $recapObj
			 * @var BHJournal           $bhj
			 * @var ProdukteKategorie   $pCat
			 * @var BillRecapEntity     $recapEntity
			 * @var RechnungPosten      $rchPost
			 */
			$user               = $this->initializeActionMethod($request, $this->rb);
			if(!$user instanceof UserInterface){ return $user; }
			$melSession         = $this->session->get( RequestBridge::SessionNameSpace );
			$bookKeepingObj     = new BillPostEntity();
			$action             = 'bearbeiten';
			$recapForm          = null;
			$recapEntity        = null;
			$titleStringsMap    = [
				'pageTitle' => 'Offene Rechnungen',
				'formTitle' => 'Bezahlte Rechnung abbuchen',
				'action'    => 'rekapitulieren',
				'subTitle'  => 'Rechnung rekapitulieren',
			];
			
			$trackBillStatusNum = 2;
			$clientBills        = $this->fetchCurrentBillsForClientBasedOnBillNr( $id, null, $trackBillStatusNum);
			
			if($id){
				$bill           = $this->entityManager->getRepository(Rechnung::class)->find($id);
				$recapFormData  = $this->fetchBillRecapForm($id);
				$recapForm      = $recapFormData['form'];
				$recapEntity    = $recapFormData['entity'];
				$postVars       = $request->request->all();
				$total          = $request->get("total", null);
				
				if($total && !isset($postVars['recapitulate_bill']) && (floatval($total) != floatval($recapEntity->getAmount())) ){
					$val1         = number_format(floatval($total), 2, '.', "'");
					$val2         = number_format(floatval($recapEntity->getAmount()), 2, '.', "'");
					$flashMSG     = '<strong style="text-decoration:underline;">Achtung</strong>: Es wurde ein anderer Betrag einbezahlt als gefordert. Bitte einen manuellen Buchungssatz einfügen, um den Differenzbetrag auszugleichen.';
					$flashMSG    .= "<br /><strong style='color:red;'>CHF {$val1} ≠ CHF {$val2}</strong>";
					$this->addFlash( 'warning', $flashMSG );
				}
				
				if(isset($postVars['recapitulate_bill'])){
					$recapPayload = $postVars['recapitulate_bill'];
					
					if($recapObj  = $recapForm->isValid($recapPayload)){
						
						# UPDATE BILL BILL-DATA:
						$billDate   = is_string($recapObj->getBillDate()) ? (new \DateTime($recapObj->getBillDate())) : $recapObj->getBillDate();
						$bill->setRechnungStatus('10');
						$bill->setRechnungDatumBez($billDate);
						$bill->setRechnungBetragBez($recapObj->getAmount());
						$flashMSG   = "Rechnung <strong>Nr. {$bill->getRechnungNummer()}</strong> wurde erfolgreich einbezahlt & aktualisiert.";
						$message    = "Rechnung {$bill->getRechnungNummer()} einbezahlt";
						$this->entityManager->persist($bill);
						$this->entityManager->flush();
						
						$payLoad    = $this->performInvoiceBooking($recapObj, $id, $message);
						
						# ['bhjID' => $bhjID, 'bhInvoiceData' => $bhInvoiceData]
						$bill->setRechnungBHNrBez($payLoad['bhjID']);
						$this->entityManager->persist($bill);
						$this->entityManager->flush();
						
						$this->addFlash('success', $flashMSG);
						return $this->redirectToRoute('rte_admin_track_open_bill', ["id" => $bill->getRechnungId()] );
					}
				}
				
				
				###############################################################
				$postVars     = $request->request->all();
				#$qrCodeURL   = $this->createQRCode($id);
				$clientEntity = new BKClientEntity();
				$clientForm   = new BKClientForm( $clientEntity, $this->translator, [ 'formKey' => 'transfer_bill_to_client' ] );
				
				$theBill          = $this->entityManager->getRepository(Rechnung::class)->find($id);
				$billStatusEntity = new BillStatusEntity();
				$billStatusEntity->setStatus($theBill->getRechnungStatus());
				$billStatusForm   = new BillStatusForm( $billStatusEntity, $this->translator, [ 'formKey' => 'set_bill_status' ] );
				
				if(isset($postVars['add_to_current_bill'])){
					$bookKeepingObj  = new BillPostEntity();
					$bookKeepingForm = new BillPostForm( $bookKeepingObj, $this->translator, [ 'formKey' => 'add_to_current_bill' ] );
					$bookKeepingObjX = $bookKeepingForm->isValid($postVars['add_to_current_bill']);
					
					$widgets  = $bookKeepingForm->getForm();
					if($bookKeepingObjX){
						$bhj      = $this->saveBHJournal($bookKeepingObjX, $melSession);
						$this->saveRechnungPost($id, $bhj->getBHJournalId());
						$this->addFlash('success', 'Neuen Rechnungsposten wurde erfolgreich hinzugefugt');
					}else {
						$widgets = $bookKeepingForm->getValidatedFormWithErrors();
					}
				}
				
				if(isset($postVars['set_bill_status'])){
					// UPDATE THE BILL STATUS OF THE CURRENT BILL
					$statusVars = $postVars['set_bill_status'];
					if($billStatusObj = $billStatusForm->isValid($statusVars)){
						$theBill->setRechnungStatus($billStatusObj->getStatus());
						$this->entityManager->persist($theBill);
						$this->entityManager->flush();
						
						$message  = "Die Status der Rechnung Nr. «{$id}» wurde erfolgreich aktualisiert.";
						$this->addFlash('success', $message);
						return $this->redirectToRoute('rte_admin_edit_bill_main', ['id' => $id, 'bhj_id' => $bhj_id, 'date'=>$date, 'intent' => $intent]);
					}
					$billStatusEntity->setStatus($theBill->getRechnungStatus());
					$billStatusForm   = new BillStatusForm( $billStatusEntity, $this->translator, [ 'formKey' => 'set_bill_status' ] );
				}
				
				$oldBill    = $this->entityManager->getRepository(Rechnung::class)->find($id);
				$this->manageBillTransfer($postVars, $oldBill, $clientForm, $rdrRoute='rte_admin_edit_bill_main', ['id' => $id, 'bhj_id' => $bhj_id, 'date'=>$date, 'intent' => $intent]);
				
				if ($intent){
					switch ( $intent ) {
						case 'edit_client_bill':
							if ( $date ) {
								$pageTitle   = 'Rechnung mit ID: ' . $id . ' - ' . $action;
								$formTitle   = 'Neuen Rechnungsposten hinzufügen';
								$clientBills = $this->fetchCurrentBillsForClientBasedOnBillNr( $id, $date, $theBill->getRechnungStatus());
							}
							//todo...
							break;
						
						case 'edit_single_bill':
							if ( $date ) {
								$pageTitle    = 'Rechnung mit ID: ' . $id . ' :: ' . $bhj_id . ':: - ' . $action;
								$formTitle    = 'Rechnung mit ID: ' . $id . ' :: ' . $bhj_id . ':: - ' . $action;
								$bhj          = $this->entityManager->getRepository( BHJournal::class )->find( $bhj_id );
								$haben        = $bhj->getBHJournalKontoHaben();
								
								// pkt.produktekategorie_BH_Konto	=bhj.BH_Journal_konto_haben
								$bookKeepingObj->setAmount($bhj->getBHJournalBetrag());
								$bookKeepingObj->setMessage($bhj->getBHJournalKommentar());
								$bookKeepingObj->setProductCategory($haben);
								
								$clientBills = $this->fetchCurrentBillsForClientBasedOnBillNr( $id, $date );
								$formKey          = 'update_bill_post';
								
								if(isset($postVars['update_bill_post'])){
									$bookKeepingObj = new BillPostEntity();
									$bookKeepingObj = (new BillPostForm($bookKeepingObj))->isValid($postVars['update_bill_post']);
									$bhj            = $this->saveBHJournal($bookKeepingObj, $melSession, $bhj_id);
									$rchPost        = $this->entityManager->getRepository(RechnungPosten::class)->findOneBy(["Rechnung_posten_BH_Journal_id"=>$bhj->getBHJournalId()]);
									$this->saveRechnungPost($id, $bhj_id,  $rchPost->getRechnungPostenId());
									$this->addFlash('success', 'Rechnungsposten wurde erfolgreich modifiziert und gespeichert.');
									$bookKeepingObj->setAmount(null);
									$bookKeepingObj->setMessage(" ");
									$bookKeepingObj->setProductCategory(null);
									$clientBills = $this->fetchCurrentBillsForClientBasedOnBillNr( $id, $date );
									$formTitle      = 'Neuen Rechnungsposten hinzufügen';
									$formKey        = 'add_to_current_bill';
								}
							}
							break;
						
						default:
							break;
					}
					
					$bookKeepingForm  = new BillPostForm( $bookKeepingObj, $this->translator, [ 'formKey' =>$formKey ] );
					$widgets          = empty($widgets) ? $bookKeepingForm->getForm() : $widgets;
					
					return $this->render( 'book_keeping/track-open-bill.html.twig', [
						'controller_name'     => 'BookKeepingController',
						'pageTitle'           => isset($pageTitle)  ? $pageTitle  : $titleStringsMap['pageTitle'],
						'formTitle'           => isset($formTitle)  ? $formTitle  : $titleStringsMap['formTitle'],
						'subTitle'            => isset($subTitle)   ? $subTitle   : $titleStringsMap['subTitle'],
						'recapForm'           => $recapForm ? $recapForm->getForm() : [],
						
						'btnText'             => 'Los',
						'billStatusFormTitle' => 'RechnungStatus ändern',
						'billStatusForm'      => $billStatusForm->getForm(),
						'user'                => $this->getUser(),
						'navPayload'          => $this->getNavigationPayload(),
						'formWidgets'         => $widgets,
						'billData'            => isset($clientBills[0]) ? $clientBills[0] : [],
						'clientBills'         => $clientBills,
						'rechnungID'          => $id,
						'qrCodeURL'           => isset($qrCodeURL) ? $qrCodeURL : null,
						'newClientWidgets'    => $clientForm->getForm(),
					] );
				}
			}
			
			return $this->render( 'book_keeping/track-open-bill.html.twig', [
				'controller_name'     => 'BookKeepingController',
				'pageTitle'           => $titleStringsMap['pageTitle'],
				'formTitle'           => $titleStringsMap['formTitle'],
				'subTitle'            => $titleStringsMap['subTitle'],
				'recapForm'           => $recapForm ? $recapForm->getForm() : [],
				'btnText'             => 'Los',
				'user'                => $user,
				'navPayload'          => $this->getNavigationPayload(),
				'clientBills'         => $clientBills,
				'rechnungID'          => $id,
				'billData'            => isset($clientBills[0]) ? $clientBills[0] : [],
				'billStatusFormTitle' => 'RechnungStatus ändern',
			] );
		}
		
		/**
		 * @Route("/admin/buchhaltung/mahnungen", name="rte_admin_all_mahnung_bills")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Doctrine\DBAL\DBALException
		 */
		public function allMahNunGBills(Request $request) {
			$user             = $this->initializeActionMethod($request, $this->rb);
			if(!$user instanceof UserInterface){ return $user; }
			$sql          = $this->fetchBillsByStatusSQL();
			$conn         = $this->entityManager->getConnection();
			$statement    = $conn->prepare($sql);
			$statement->execute(['STATUS' => '5']);
			$rayBills     = $statement->fetchAll();
			
			return $this->render( 'book_keeping/bills-archive.html.twig', [
				'controller_name' => 'BookKeepingController',
				'pageTitle'       => 'Mahnungen',
				'btnText'         => 'Los',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'formWidgets'     => [],
				'bills'           => $rayBills,
				'rayBills'        => $rayBills,
				'ipp'             => 50,
				'showPagination'  => 0,
				'currentPage'     => 1,
			] );
		}
		
		/**
		 * @Route("/admin/buchhaltung/rechnungsarchiv", name="rte_admin_bills_archive")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Doctrine\DBAL\DBALException
		 */
		public function billsArchive(Request $request) {
			$sql          = $this->fetchBillsByStatusSQL();
			$conn         = $this->entityManager->getConnection();
			$statement    = $conn->prepare($sql);
			$statement->execute(['STATUS' => '10']);
			$rayBills     = $statement->fetchAll();
			
			return $this->render( 'book_keeping/bills-archive.html.twig', [
				'controller_name' => 'BookKeepingController',
				'pageTitle'       => 'Rechnungsarchiv',
				'btnText'         => 'Los',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'formWidgets'     => [],
				'bills'           => $rayBills,
				'rayBills'        => $rayBills,
				'ipp'             => 50,
				'showPagination'  => 0,
				'currentPage'     => 1,
			] );
		}
		
		/**
		 * @Route("/admin/buchhaltung/rechnung-entfernen", name="rte_admin_delete_bill")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse
		 * @throws \Exception
		 */
		public function deleteBill(Request $request, $id=null, $bhj_id=null) {
			/**@var Rechnung $rechnung*/
			/**@var RechnungPosten $rechnungPost*/
			$id     = $id     ? $id     : $request->query->get('id',    null);
			$bhj_id = $bhj_id ? $bhj_id : $request->query->get('bhj_id', null);
			if($id){
				$rechnung   = $this->entityManager->getRepository(Rechnung::class)->findOneBy(['Rechnung_id' =>$id]);
				// GET THE ID COS WE'D NEED IT TO DELETE OTHER RELATED FIELDS....
				$rechnungID = $id ? $id : $rechnung->getRechnungId();
				// DELETE THE ENTRY
				if($rechnung){
					$this->entityManager->remove($rechnung);
				}
				
				// DELETE ALL ASSOCIATED RECHNUNG_POSTEN:
				$rechnungPosts  = $this->entityManager->getRepository(RechnungPosten::class)->findBy(
					['Rechnung_posten_Rechnung_id'=>$id]);
				// LOOP THROUGH ALL BILL POSTS AND DELETE EACH ONE POST IN TURN
				if($rechnungPosts){
					foreach($rechnungPosts as $rechnungPost){
						$bhjJournalID    = $rechnungPost->getRechnungPostenBHJournalId();
						// DELETE BH_JOURNAL ENTRY:
						$bhJournal = $this->entityManager->getRepository(BHJournal::class)->find($bhjJournalID);
						if($bhJournal){
							$this->entityManager->remove($bhJournal);
						}
						// DELETE CURRENT RECHNUNG_POST IN CURSOR:
						$this->entityManager->remove($rechnungPost);
					}
					$this->entityManager->flush();
				}
				
				$melSession   = $this->session->get( RequestBridge::SessionNameSpace );
				$cClientBills = $this->fetchCurrentBillsForClient($melSession['lastRechnungPayload']['kundenid'], (new \DateTime($melSession['lastRechnungPayload']['BH_Journal_datum']))->format("Y-m-d"));
				$rayBills     = $cClientBills;
				$melSession['lastRechnungPayload']  = isset($rayBills[0]) ? $rayBills[0] : [];
				$melSession['lastAllBillsPayload']  = isset($rayBills) ? $rayBills : [];
				$this->session->set(RequestBridge::SessionNameSpace, $melSession);
				
				$refR = $_SERVER['HTTP_REFERER'];
				$this->addFlash('success', 'Der Rechnung mit ID: ' . $rechnungID . ' - wurde erfolgreich gelöscht.');
				if($refR){
					return $this->redirect($refR);
				}
				return $this->redirectToRoute('rte_admin_bills_archive', []);
			}
			$this->addFlash('warning', 'Der Rechnung mit ID: ' . $id . ' - könnte momentan nicht gelöscht werden.');
			return $this->redirectToRoute('rte_admin_bills_archive', []);
		}
		
		/**
		 * @Route("/admin/buchhaltung/rechnung-posten-entfernen/{id}/{bhj_id}/{date}/{intent}", name="rte_admin_delete_bill_post")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse
		 */
		public function deleteBillPost(Request $request, $id=null, $bhj_id=null, $date=null, $intent=null) {
			/**@var Rechnung $rechnung*/
			/**@var RechnungPosten $rechnungPost*/
			$id           = $id     ? $id     : $request->query->get('id',    null);
			$bhj_id       = $bhj_id ? $bhj_id : $request->query->get('bhj_id', null);
			$bhj          = $this->entityManager->getRepository( BHJournal::class )->find( $bhj_id );
			if($id){
				$rechnung   = $this->entityManager->getRepository(Rechnung::class)->findOneBy(['Rechnung_id' =>$id]);
				// GET THE ID COS WE'D NEED IT TO DELETE OTHER RELATED FIELDS....
				$rechnungID = $id ? $id : $rechnung->getRechnungId();
				
				// DELETE BOTH BH_JOURNAL ENTRY AND RECHNUNG_POSTEN:
				$rechnungPost = $this->entityManager->getRepository(RechnungPosten::class)->findOneBy(
					['Rechnung_posten_BH_Journal_id'=>$bhj_id]);  # Rechnung_posten_Rechnung_id, $id
				if($rechnungPost){
					$bhjJournalID = $bhj_id  ? $bhj_id : $rechnungPost->getRechnungPostenBHJournalId();
					$bhJournal    = $this->entityManager->getRepository(BHJournal::class)->find($bhjJournalID);
					
					// DELETE RECHNUNG_POSTEN:
					$this->entityManager->remove($rechnungPost);
					
					// DELETE BH_JOURNAL ENTRY:
					$this->entityManager->remove($bhJournal);
					$this->entityManager->flush();
				}
				
				$refR = $_SERVER['HTTP_REFERER'];
				$this->addFlash('success', 'Der Rechnung mit ID: ' . $rechnungID . ' - wurde erfolgreich gelöscht.');
				return $this->redirectToRoute('rte_admin_edit_bill_main', []);
			}
			$this->addFlash('warning', 'Der Rechnung mit ID: ' . $id . ' - könnte momentan nicht gelöscht werden.');
			return $this->redirectToRoute('rte_admin_bills_archive', []);
		}
		
		
		/**
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param int|mixed                                 $id
		 * @param array                                     $rayIntentDateBHJ
		 * @param bool                                      $addBillTransfer
		 * @param bool                                      $addQRCode
		 *
		 * @return null|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		private function runInvoiceManagementProcess(Request $request, $id, $rayIntentDateBHJ, $addBillTransfer=false, $addQRCode=false){
			/**
			 * @var Rechnung          $bill
			 * @var Rechnung          $oldBill
			 * @var BillRecapEntity   $recapEntity
			 * @var BillRecapEntity   $recapObj
			 * @var BHJournal         $bhj
			 * @var ProdukteKategorie $pCat
			 * @var RechnungPosten    $rchPost
			 */
			$melSession       = $this->session->get( RequestBridge::SessionNameSpace, [] );
			$widgets          = [];
			$qrCodeURL        = null;
			$bookKeepingObj   = new BillPostEntity();
			
			if($id){
				$postVars       = $request->request->all();
				
				if($addQRCode){
					$qrCodeURL    = $this->createQRCode($id);
				}
				
				if($addBillTransfer){
					$clientEntity = new BKClientEntity();
					$clientForm   = new BKClientForm( $clientEntity, $this->translator, [ 'formKey' => 'transfer_bill_to_client' ] );
				}
				
				$rayIntentDateBHJ = array_merge([
					'date'                    => null,
					'action'                  => 'bearbeiten',
					'formTitle'               => '',
					'pageTitle'               => '',
					'intent'                  => null,
					'bhj_id'                  => null,
					'viewTemplate'            => 'book_keeping/edit-client-bill.html.twig',
					'billStatusRedirect'      => 'rte_admin_edit_bill_main',
					'billStatusRedirectData'  => [],
					'clientBills'             => [],
					
				], $rayIntentDateBHJ);
				
				$date             = $rayIntentDateBHJ['date'];
				$action           = $rayIntentDateBHJ['action'];
				$clientBills      = $rayIntentDateBHJ['clientBills'];
				$intent           = $rayIntentDateBHJ['intent'];
				$bhj_id           = $rayIntentDateBHJ['bhj_id'];
				
				if(empty(	$rayIntentDateBHJ['billStatusRedirectData'])){
					$rayIntentDateBHJ['billStatusRedirectData'] =  [
						'id' => $id, 'bhj_id' => $bhj_id, 'date'=>$date, 'intent' => $intent
					];
				}
				
				$theBill          = $this->entityManager->getRepository(Rechnung::class)->find($id);
				$billStatusEntity = new BillStatusEntity();
				$billStatusEntity->setStatus($theBill->getRechnungStatus());
				$billStatusForm   = new BillStatusForm( $billStatusEntity, $this->translator, [ 'formKey' => 'set_bill_status' ] );
				
				if(isset($postVars['add_to_current_bill'])){
					$bookKeepingObj  = new BillPostEntity();
					$bookKeepingForm = new BillPostForm( $bookKeepingObj, $this->translator, [ 'formKey' => 'add_to_current_bill' ] );
					$bookKeepingObjX = $bookKeepingForm->isValid($postVars['add_to_current_bill']);
					
					$widgets    = $bookKeepingForm->getForm();
					if($bookKeepingObjX){
						$bhj      = $this->saveBHJournal($bookKeepingObjX, $melSession);
						$this->saveRechnungPost($id, $bhj->getBHJournalId());
						$this->addFlash('success', 'Neuen Rechnungsposten wurde erfolgreich hinzugefugt');
					}else {
						$widgets = $bookKeepingForm->getValidatedFormWithErrors();
					}
				}
				
				if(isset($postVars['set_bill_status'])){
					// UPDATE THE BILL STATUS OF THE CURRENT BILL
					$statusVars = $postVars['set_bill_status'];
					if($billStatusObj = $billStatusForm->isValid($statusVars)){
						$theBill->setRechnungStatus($billStatusObj->getStatus());
						$this->entityManager->persist($theBill);
						$this->entityManager->flush();
						
						$message  = "Die Status der Rechnung Nr. «{$id}» wurde erfolgreich aktualisiert.";
						$this->addFlash('success', $message);
						return $this->redirectToRoute('rte_admin_edit_bill_main', ['id' => $id, 'bhj_id' => $bhj_id, 'date'=>$date, 'intent' => $intent]);
					}
					$billStatusEntity->setStatus($theBill->getRechnungStatus());
					$billStatusForm   = new BillStatusForm( $billStatusEntity, $this->translator, [ 'formKey' => 'set_bill_status' ] );
				}
				
				if(isset($clientForm) && $clientForm){
					$oldBill    = $this->entityManager->getRepository(Rechnung::class)->find($id);
					$this->manageBillTransfer($postVars, $oldBill, $clientForm, $rdrRoute='rte_admin_edit_bill_main', ['id' => $id, 'bhj_id' => $bhj_id, 'date'=>$date, 'intent' => $intent]);
				}
				
				if ($intent){
					$formKey          = null;
					switch ( $intent ) {
						case 'edit_client_bill':
							if ( $date ) {
								$pageTitle   = 'Rechnung mit ID: ' . $id . ' - ' . $action;
								$formTitle   = 'Neuen Rechnungsposten hinzufügen';
								$clientBills = $this->fetchCurrentBillsForClientBasedOnBillNr( $id, $date, $theBill->getRechnungStatus());
							}
							//todo...
							break;
						
						case 'edit_single_bill':
							if ( $date ) {
								$pageTitle    = 'Rechnung mit ID: ' . $id . ' :: ' . $bhj_id . ':: - ' . $action;
								$formTitle    = 'Rechnung mit ID: ' . $id . ' :: ' . $bhj_id . ':: - ' . $action;
								$bhj          = $this->entityManager->getRepository( BHJournal::class )->find( $bhj_id );
								$haben        = $bhj->getBHJournalKontoHaben();
								
								$bookKeepingObj->setAmount($bhj->getBHJournalBetrag());
								$bookKeepingObj->setMessage($bhj->getBHJournalKommentar());
								$bookKeepingObj->setProductCategory($haben);
								
								$clientBills = $this->fetchCurrentBillsForClientBasedOnBillNr( $id, $date );
								$formKey          = 'update_bill_post';
								
								if(isset($postVars['update_bill_post'])){
									$bookKeepingObj = new BillPostEntity();
									$bookKeepingObj = (new BillPostForm($bookKeepingObj))->isValid($postVars['update_bill_post']);
									$bhj            = $this->saveBHJournal($bookKeepingObj, $melSession, $bhj_id);
									$rchPost        = $this->entityManager->getRepository(RechnungPosten::class)->findOneBy(["Rechnung_posten_BH_Journal_id"=>$bhj->getBHJournalId()]);
									$this->saveRechnungPost($id, $bhj_id,  $rchPost->getRechnungPostenId());
									$this->addFlash('success', 'Rechnungsposten wurde erfolgreich modifiziert und gespeichert.');
									$bookKeepingObj->setAmount(null);
									$bookKeepingObj->setMessage(" ");
									$bookKeepingObj->setProductCategory(null);
									$clientBills = $this->fetchCurrentBillsForClientBasedOnBillNr( $id, $date );
									$formTitle      = 'Neuen Rechnungsposten hinzufügen';
									$formKey        = 'add_to_current_bill';
								}
							}
							break;
						
						default:
							break;
					}
					
					$bookKeepingForm  = new BillPostForm( $bookKeepingObj, $this->translator, [ 'formKey' =>$formKey ] );
					$widgets          = empty($widgets) ? $bookKeepingForm->getForm() : $widgets;
					$renderPayload    = [
						'controller_name'     => 'BookKeepingController',
						'pageTitle'           => $rayIntentDateBHJ['pageTitle'],
						'formTitle'           => $rayIntentDateBHJ['formTitle'],
						'btnText'             => 'Los',
						'billStatusFormTitle' => 'RechnungStatus ändern',
						'billStatusForm'      => $billStatusForm->getForm(),
						'user'                => $this->getUser(),
						'navPayload'          => $this->getNavigationPayload(),
						'formWidgets'         => $widgets,
						'rechnungID'          => $id,
					];
					
					if($addQRCode){
						$renderPayload['qrCodeURL']   = $qrCodeURL;
					}
					
					if(isset($subTitle)){
						$renderPayload['subTitle']    = $subTitle;
					}elseif (isset($rayIntentDateBHJ['subTitle'])){
						$renderPayload['subTitle']    = $rayIntentDateBHJ['subTitle'];
					}
					
					if(isset($formTitle)){
						$renderPayload['formTitle']   = $formTitle;
					}elseif (isset($rayIntentDateBHJ['formTitle'])){
						$renderPayload['formTitle']   = $rayIntentDateBHJ['formTitle'];
					}
					
					if(isset($pageTitle)){
						$renderPayload['pageTitle']   = $pageTitle;
					}elseif (isset($rayIntentDateBHJ['pageTitle'])){
						$renderPayload['pageTitle']   = $rayIntentDateBHJ['pageTitle'];
					}
					if(isset($recapForm)){
						$renderPayload['recapForm']   = $recapForm;
					}
					if(isset($clientForm)){
						$renderPayload['newClientWidgets']  = $clientForm->getForm();
					}
					if(isset($clientBills)){
						$renderPayload['clientBills']   = ($cb = $clientBills) ? $cb : (isset($rayIntentDateBHJ['clientBills']) ? $rayIntentDateBHJ['clientBills'] : []);
						$renderPayload['billData']      = isset($renderPayload['clientBills'][0]) ? $renderPayload['clientBills'][0] : [];
					}
					
					return $this->render( $rayIntentDateBHJ['viewTemplate'], $renderPayload);
				}
			}
			return null;
		}
		
		private function performInvoiceBooking(BillRecapEntity $invoiceData, $invoiceID, $message){
			// Betrag bei Postfinance oder bei anderer Zahlungsstelle einbuchen (von Debitoren)
			$melSession = $this->session->get( RequestBridge::SessionNameSpace, ['department' => null] );
			$bhjEntity  = new BHJournal();
			$billDate   = is_scalar($invoiceData->getBillDate()) ? (new \DateTime($invoiceData->getBillDate())) : $invoiceData->getBillDate();
			$bhjEntity->setBHJournalKreditorId('0');
			$bhjEntity->setBHJournalDatum($billDate);                             // $datum_bezahlt
			$bhjEntity->setBHJournalKommentar($message);                          // $bemerkungen
			$bhjEntity->setBHJournalKontoSoll($invoiceData->getPaymentMethod());  // $Zahlungsmittel_konto
			$bhjEntity->setBHJournalKontoHaben(1100);                             // 1100
			$bhjEntity->setBHJournalBetrag($invoiceData->getAmount());            // $betrag_bezahlt
			$bhjEntity->setBHJournalVerkaufId('0');                               // 0
			$bhjEntity->setBHJournalMa($melSession['department']);                // $mitarbeiterin
			$this->entityManager->persist($bhjEntity);
			$this->entityManager->flush();
			
			$bhjID          = $bhjEntity->getBHJournalId();
			$bhInvoiceData  = $this->entityManager->getRepository(Rechnung::class)->fetchSingleInvoiceByID($invoiceID, true);
			
			return ['bhjID' => $bhjID, 'bhInvoiceData' => $bhInvoiceData];
			
			// Zum Schluss die Buchhaltungsnummern der besagten Rechnung auslesen
			/*/	$query_bh_nr            = "	SELECT  BH_Journal_id,
																			BH_Journal_kommentar,
																			BH_Journal_konto_haben,
																			BH_Journal_betrag
															FROM 		BH_Journal,
																			Rechnung,
																			Rechnung_posten
															WHERE 	Rechnung_id = '$invoiceID'
															AND 		Rechnung_posten_Rechnung_id = Rechnung_id
															AND 		Rechnung_posten_BH_Journal_id = BH_Journal_id";/*/
		}
		
		/**
		 * @param $rechnungID
		 * @param $bhJournalID
		 *
		 * @return \App\Entity\RechnungPosten
		 */
		private function saveRechnungPost($rechnungID, $bhJournalID, $rchID=null){
			$rechnungPosten    = (!$rchID) ? new RechnungPosten() : $this->entityManager->getRepository(RechnungPosten::class)->find($rchID);
			$rechnungPosten->setRechnungPostenBHJournalId($bhJournalID);
			$rechnungPosten->setRechnungPostenRechnungId($rechnungID);
			$this->entityManager->persist($rechnungPosten);
			$this->entityManager->flush();
			return $rechnungPosten;
		}
		
		private function fetchBillRecapForm($billID){
			/**@var Rechnung $bill */
			$bill           = $this->entityManager->getRepository(Rechnung::class)->find($billID);
			$objBillRecap   = new BillRecapEntity();
			$objBillRecap->setAmount($bill->getRechnungBetragBill());
			$billRecapForm  = new BillRecapForm($objBillRecap, $this->translator, ['formKey'=>'recapitulate_bill']);
			return ['form'=>$billRecapForm, 'entity'=>$objBillRecap];
		}
		
		private function getBillTypeString($billType){
			$billTypesMap = [
				1 => ['pageTitle' => 'Rechnung bearbeiten', 'action' => 'bearbeiten',     'subTitle' => 'Aktueller Rechnungsentwurf'],
				2 => ['pageTitle' => 'Offene Rechnungen',   'action' => 'rekapitulieren', 'subTitle' => 'Rechnung rekapitulieren'],
			];
			if(array_key_exists($billType, $billTypesMap)){
				return $billTypesMap[$billType];
			}
			return $billTypesMap[1];
		}
		
		private function getBillTotalFromBillPosts($billPosts){
			$billTotal = 0;
			foreach($billPosts as $billPost){
				$billTotal += $billPost['BH_Journal_betrag'];
			}
			return $billTotal;
		}
		
		private function processRechnung($clientID, &$bookKeepingObj, &$melSession, &$bhJournal, &$rechnung, &$rechnungPosten, &$rayBill, &$rayBills, &$cClientBills, $redirect = true ){
			$rechnung   = $this->saveBill($clientID);
			$rechnungID = $rechnung->getRechnungId();
			$melSession['lastRechnungID']   = $rechnungID;
			
			$bhJournal    = $this->saveBHJournal($bookKeepingObj, $melSession);
			$bhJournalID  = $bhJournal->getBHJournalId();
			$melSession['lastBhJournalID']   = $rechnungID;
			
			$rechnungPosten   = $this->saveRechnungPost($rechnungID, $bhJournalID);
			$rechnungPostenId = $rechnungPosten->getRechnungPostenId();
			$melSession['lastRechnungPostenID']   = $rechnungPostenId;
			
			$sql          = $this->fetchGetRechnungSQL();
			$conn         = $this->entityManager->getConnection();
			$statement    = $conn->prepare($sql);
			$statement->execute(['RID'=>$rechnungID]);
			$rayBill      = $statement->fetchAll()[0];
			$cClientBills = $this->fetchCurrentBillsForClient($rayBill['kundenid'], (new \DateTime($rayBill['BH_Journal_datum']))->format("Y-m-d"));
			
			$rayBills     = $cClientBills;  //$statement->fetchAll();
			$melSession['lastRechnungPayload']  = $rayBill;
			$melSession['lastAllBillsPayload']  = $rayBills;
			$this->session->set(RequestBridge::SessionNameSpace, $melSession);
			if($redirect){
				return $this->redirectToRoute('rte_admin_edit_bill_main', ['id' => $rechnungID, 'bhj_id' => null ]);
			}
			return null;
		}
		
		/**
		 * @param $bookKeepingObj
		 * @param $melSession
		 *
		 * @return \App\Entity\BHJournal
		 */
		private function saveBHJournal($bookKeepingObj, $melSession, $bhjID=null){
			$bhJournal    = (!$bhjID) ? new BHJournal() : $this->entityManager->getRepository(BHJournal::class)->find($bhjID);
			if($bookKeepingObj){
				$bhJournal->setBHJournalKommentar($bookKeepingObj->getMessage());
				$bhJournal->setBHJournalKontoHaben($bookKeepingObj->getProductCategory());
				$bhJournal->setBHJournalKontoSoll('1100');
				$bhJournal->setBHJournalBetrag($bookKeepingObj->getAmount());
				$bhJournal->setBHJournalVerkaufId('0');
				$bhJournal->setBHJournalKreditorId(0);
				$bhJournal->setBHJournalMa($melSession['department']);
				$this->entityManager->persist($bhJournal);
				$this->entityManager->flush();
			}
			return $bhJournal;
		}
		
		private function manageBillTransfer($postVars, Rechnung $rechnung, BKClientForm $clientForm, $rdrRoute='', $rdrRouteData=[]){
			/**@var $clientForm */
			if(isset($postVars['transfer_bill_to_client'])){
				$transferVars     = $postVars['transfer_bill_to_client'];
				if($billTransObj  = $clientForm->isValid($transferVars)){
					// SORT OUT THE NEW AND OLD CLIENTS AND GATHER THE BILLS
					$newClient  = $billTransObj->getClient();
					
					// NOW ASSIGN THE BILL TO THE NEW OWNER / CLIENT:
					$rechnung->setRechnungKunde($newClient);
					$this->entityManager->persist($rechnung);
					$this->entityManager->flush();
					$message  = "Die Rechnung Nr. «{$rechnung->getRechnungId()}» wurde erfolgreich zur ein anderen: Kunden Nr.  «{$newClient}» zugewiesen.";
					$this->addFlash('success', $message);
					return $this->redirectToRoute('rte_admin_new_bill', []);
				}else{
					$message  = "Um dieser Rechnung ID: «{$rechnung->getRechnungId()}» ein andere Kunde zugewiesen zu können musst erst ein neue Kunde gewählt werden.";
					$this->addFlash('error', $message);
				}
			}
			return false;
		}
		
		/**
		 * @param $clientID
		 *
		 * @return \App\Entity\Rechnung
		 */
		private function saveBill($clientID){
			$rechnung         = new Rechnung();
			$rechnung->setRechnungKunde($clientID);
			$this->entityManager->persist($rechnung);
			$this->entityManager->flush();
			return $rechnung;
		}
		
		private function fetchGetRechnungSQL(){
			return <<<QRY
SELECT  psn.`Firma`,
				psn.`kundenid`,
				psn.`name`,
				psn.`vorname`,
				psn.`Strasse`,
				psn.`Strassennummer`,
				psn.`PLZ`,
				psn.`Ort`,
				
				rch.`Rechnung_id`,
				rch.`Rechnung_status`,
				
				pkt.`kat_name`,
				
				bhj.`BH_Journal_id`,
				bhj.`BH_Journal_datum`,
				bhj.`BH_Journal_kommentar`,
				bhj.`BH_Journal_betrag`,
				
				gsl.`Geschlecht_praefix`
				
		FROM 			`personen` 						AS psn
		LEFT JOIN `Rechnung` 						AS rch ON rch.Rechnung_kunde							=psn.kundenid
		LEFT JOIN `Rechnung_posten` 		AS rpt ON rpt.Rechnung_posten_Rechnung_id	=rch.Rechnung_id
		LEFT JOIN `Geschlecht` 					AS gsl ON gsl.Geschlecht_id								=psn.Geschlecht
		LEFT JOIN `BH_Journal`					AS bhj ON bhj.BH_Journal_id 							=rpt.Rechnung_posten_BH_Journal_id
		LEFT JOIN `produkte_kategorie`	AS pkt ON pkt.produktekategorie_BH_Konto	=bhj.BH_Journal_konto_haben
		
		WHERE  Rechnung_id =:RID
		ORDER BY BH_Journal_datum ASC, BH_Journal_id ASC
QRY;
		}
		
		private function fetchCurrentBillsForClientBasedOnBillNr($billID, $billDate=null, $billStatus=null){
			/**@var \App\Entity\Rechnung $bill */
			$bill     = $this->entityManager->getRepository(Rechnung::class)->find($billID);
			$clientID = $bill->getRechnungKunde();
			$billDate = ($bill->getRechnungDatumBill() instanceof \DateTime) ? ($bill->getRechnungDatumBill())->format('Y-m-d') : $bill->getRechnungDatumBill();
			return $this->fetchCurrentBillsForClient($clientID, $billDate, $billStatus);
		}
		
		private function fetchBillsByStatusSQL($order="rch.Rechnung_Datum_bez DESC, rch.Rechnung_id DESC", $groupBy="rch.Rechnung_id"){
			return <<<QRY
SELECT
				rch.Rechnung_id,
				rch.Rechnung_nummer,
				rch.Rechnung_Datum_open,
				rch.Rechnung_Datum_bez,
				rch.Rechnung_betrag_bez,
				rch.Rechnung_BHNr_bez,
				rch.`Rechnung_Datum_bill`,
				rch.Rechnung_status,
				psn.Firma,
				psn.name,
				psn.vorname,
				SUM(bhj.BH_Journal_betrag) as total
FROM 	personen 				AS psn,
			Rechnung 				AS rch,
			Rechnung_posten AS rpt,
			BH_Journal			AS bhj
WHERE kundenid = Rechnung_kunde
AND Rechnung_posten_Rechnung_id = Rechnung_id
AND Rechnung_posten_BH_Journal_id = BH_Journal_id
AND Rechnung_status=:STATUS
GROUP BY psn.kundenid, rch.Rechnung_id
ORDER BY {$order}
QRY;
			// {$groupBy}
		}
		
		private function fetchNewlyInsertedBills(){
			$sql          = $this->fetchBillsByStatusSQL("rch.Rechnung_Datum_bez DESC, rch.Rechnung_id DESC", 			"psn.kundenid");
			$conn         = $this->entityManager->getConnection();
			$statement    = $conn->prepare($sql);
			$statement->execute(['STATUS' => '1']);
			return $statement->fetchAll();
		}
		
		private function fetchCurrentBillsForClient($clientID, $billDate, $billStatus=null){
			$sql =<<<QRY
SELECT  psn.`Firma`,
				psn.`kundenid`,
				psn.`name`,
				psn.`vorname`,
				psn.`Strasse`,
				psn.`Strassennummer`,
				psn.`PLZ`,
				psn.`Ort`,
				
				pkt.`kat_name`,
				
				bhj.`BH_Journal_id`,
				bhj.`BH_Journal_datum`,
				bhj.`BH_Journal_kommentar`,
				bhj.`BH_Journal_betrag`,
				
				rch.`Rechnung_dank`,
				rch.`Rechnung_id`,
				rch.`Rechnung_konditionen`,
				rch.`Rechnung_Datum_bill`,
				rch.`Rechnung_nummer`,
				rch.`Rechnung_status`,
				
				gsl.`Geschlecht_praefix`
				
		FROM 			`personen` 						AS psn
		LEFT JOIN `Rechnung` 						AS rch ON rch.Rechnung_kunde							=psn.kundenid
		LEFT JOIN `Rechnung_posten` 		AS rpt ON rpt.Rechnung_posten_Rechnung_id	=rch.Rechnung_id
		LEFT JOIN `Geschlecht` 					AS gsl ON gsl.Geschlecht_id								=psn.Geschlecht
		LEFT JOIN `BH_Journal`					AS bhj ON bhj.BH_Journal_id 							=rpt.Rechnung_posten_BH_Journal_id
		LEFT JOIN `produkte_kategorie`	AS pkt ON pkt.produktekategorie_BH_Konto	=bhj.BH_Journal_konto_haben
		
		WHERE  psn.kundenid =:KID
		AND    DATE(rch.Rechnung_Datum_bill) = DATE(:TODAY)
		
QRY;
			
			if($billStatus){
				$sql  .= " AND rch.`Rechnung_status`='{$billStatus}' ";
			}
			$sql  .= " ORDER BY bhj.BH_Journal_datum ASC, bhj.BH_Journal_id ASC ";
			
			//  AND    bhj.BH_Journal_datum =:TODAY  AND    bhj.BH_Journal_datum =:TODAY
			$data         = ['KID' => $clientID , 'TODAY'=> $billDate]; // , 'TODAY'=> $billDate
			$conn         = $this->entityManager->getConnection();
			$statement    = $conn->prepare($sql);
			$statement->execute($data);
			$resultSet  = $statement->fetchAll();
			return $resultSet;
		}
		
		private function createQRCode($billNumberOrBankRefNum, $label="QR-Code scannen"){
			$filePath = static::PUBLIC_IMG_DIR . "qr-codes/qr-code-{$billNumberOrBankRefNum}.png";
			
			// Save it to a file
			if(!file_exists($filePath)){
				// Create a basic QR code
				$qrCode = new QrCode($billNumberOrBankRefNum);
				$qrCode->setSize(300);
				// Set advanced options
				$qrCode->setWriterByName('png');
				$qrCode->setMargin(10);
				$qrCode->setEncoding('UTF-8');
				$qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
				$qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
				$qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
				$qrCode->setLabel($label, 16, static::MJR_LABEL_FONT_PATH, LabelAlignment::CENTER());
				$qrCode->setLogoPath(static::MJR_LOGO_PATH);
				$qrCode->setLogoSize(150, 200);
				$qrCode->setRoundBlockSize(true);
				$qrCode->setValidateResult(false);
				$qrCode->setWriterOptions(['exclude_xml_declaration' => true]);
				
				// Directly output the QR code
				# header('Content-Type: '.$qrCode->getContentType());
				# echo $qrCode->writeString();
				$QRCodeDir  = realpath(dirname($filePath));
				if(file_exists(dirname($filePath))){
					$qrCode->writeFile($filePath);
				}
			}
			
			return "/images/qr-codes/qr-code-{$billNumberOrBankRefNum}.png";
			
			// Create a response object
			# $response = new QrCodeResponse($qrCode);
		}
		
		private function autoGenerateBillNumber(){
			// GET LAST BILL AND JUST ADD 1 TO IT...
			$conn       = $this->entityManager->getConnection();
			$sql        = "SELECT MAX(`rch`. `Rechnung_nummer`) FROM `Rechnung` AS `rch`";
			$statement  = $conn->prepare($sql);
			$statement->execute();
			$billNum    = $statement->fetchColumn();
			if(is_numeric($billNum)){
				return $billNum+1;
			}
			return rand(200000, 1000000);
		}
		
		private function autoGeneratePseudoBankReference($billID, $separator=' ', $prefix='00', $blockSize=5){
			$theBill  = $this->entityManager->getRepository(Rechnung::class)->find($billID);
			$billMD5  = md5(serialize($theBill->getEntityBank()));
			$billNum  = preg_replace(["#\.#", "#E\+#", "#,#"], "", strval(hexdec($billMD5)));
			$billRay  = str_split($billNum);
			$billStr  = '';
			$tmp      = '';
			for($i=0; $i< count($billRay); $i++){
				if($i % $blockSize === 0 && $i !== 0){ $billStr .= $tmp . $separator; $tmp = ''; }
				$tmp .= $billRay[$i];
			}
			$billStr    = trim($billStr);
			$remain     = 29 - strlen($billStr);
			$target     = abs($remain%$blockSize) * $blockSize;
			$generated  = $this->autoGenerateBillBankReferenceNumber($target, null);
			
			$pseudoBankNumber = $prefix . $separator . $billStr . $separator . $generated;
			return $pseudoBankNumber;
		}
		
		private function autoGenerateBillBankReferenceNumber($length=25, $prefix2Digit='00', $separator=' '){  // $billNum: DO WE NEED THIS FOR THE GENERATION?
			$characters   = '0123456789';
			$randomString = '';
			$randomBlocks = [];
			
			for ( $i = 0; $i < $length; $i ++ ) {
				if($i % 5 === 0 && $i !== 0){
					$randomBlocks[] = $randomString;
					$randomString   = '';
				}
				$randomString .= $characters[ rand( 0, strlen( $characters ) - 1 ) ];
			}
			$preValue         = $prefix2Digit ? $prefix2Digit . $separator : '';
				$pseudoBankRefNum = $preValue . implode($separator, $randomBlocks) . $separator . $randomString;
			
			return $pseudoBankRefNum;
		}
		
		public static function generateRandomBlockNumbers( $length=25, $blockSize=5, $prefix2Digit='00', $separator=' ') {
			$characters   = '0123456789';
			$randomString = '';
			$randomBlocks = [];
			
			for ( $i = 0; $i < $length; $i ++ ) {
				if($i % $blockSize === 0 && $i !== 0){
					$randomBlocks[] = $randomString;
					$randomString   = '';
				}
				$randomString .= $characters[ rand( 0, strlen( $characters ) - 1 ) ];
			}
			$pseudoBankRefNum = $prefix2Digit . $separator . implode($separator, $randomBlocks) . $separator . $randomString;
			
			return $pseudoBankRefNum;
		}
		
		private function strToHex($string){
			$hex = '';
			for ($i=0; $i<strlen($string); $i++){
				$ord = ord($string[$i]);
				$hexCode = dechex($ord);
				$hex .= substr('0'.$hexCode, -2);
			}
			return strToUpper($hex);
		}
		
		private function hexToStr($hex){
			$string='';
			for ($i=0; $i < strlen($hex)-1; $i+=2){
				$string .= chr(hexdec($hex[$i].$hex[$i+1]));
			}
			return $string;
		}
		
	}
