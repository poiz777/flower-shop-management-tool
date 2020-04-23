<?php
	
	namespace App\Controller;
	
	use App\Forms\CategorySalesEntity;
	use App\Forms\IndividualStatsEntity;
	use App\Forms\StartStopDateEntity;
	use App\Helpers\Date\DateCalculator;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\HTML\Forms\CategorySalesForm;
	use App\Poiz\HTML\Forms\IndividualStatsForm;
	use App\Poiz\HTML\Forms\StartStopDateForm;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	
	class StatisticsController extends AbstractController {
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
		
		/**
		 * @var int
		 */
		private $department;
		
		/**
		 * @var int
		 */
		private $cashAccount;
		
		public function __construct( EntityManagerInterface $entityManager, SessionInterface $session, ShopTranslator $translator ) {
			$this->translator    = $translator;
			$this->entityManager = $entityManager;
			$this->session       = $session;
			$this->melSession    = $this->session->get( RequestBridge::SessionNameSpace );
			
			if ( isset( $this->melSession['department'] ) ) {
				$this->department  = $this->melSession['department'];
				$this->cashAccount = ( $this->department == 940 ) ? 1000 : 1001;
			}
		}
		
		public function index() {
			return $this->render( 'statistics/index.html.twig', [
				'controller_name' => 'StatisticsController',
			] );
		}
		
		/**
		 * @Route("/admin/statistiken", name="rte_admin_statistics")
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function statistics() {
			if ( ! ( $user = $this->getUser() ) ) {
				return $this->redirectToRoute( 'app_login' );
			}
			
			return $this->render( 'statistics/statistics.html.twig', [
				'controller_name' => 'StatisticsController',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Statistiken',
				'department'      => $this->melSession['department'],
				'infoHTML'        => 'In dieser Rubrik siehst du die Kundenwertanalyse sowie zeit- und kundenbezogene Verkaufslisten...',
				'feedbackHTML'    => 'Funktioniert etwas nicht so, wie du es dir vorstellst? Sag es ruhig Philippe, er wird sich der Sache annehmen...',
			] );
		}
		
		/**
		 * @Route("/admin/statistiken/tagesabrechnung-heute", name="rte_admin_account_statement_today")
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function accountStatementToday() {
			if ( ! ( $user = $this->getUser() ) ) {
				return $this->redirectToRoute( 'app_login' );
			}
			$targetDate     = date( "Y-m-d" );
			$payload        = $this->fetchSalesStatsData4TimeFrame( $targetDate, $targetDate );
			$resultSet      = $payload ? $payload['statsData'] : [];
			$catData        = $payload ? $payload['catData'] : [];
			$payPalPayments = $this->getPaymentsByPayMethodForTimeRange( $targetDate, $targetDate, $this->melSession['department'] );
			$debitORS       = $this->getDebitORS( $targetDate, $targetDate, $this->melSession['department'] );
			$cardsPayments  = $this->fetchAllCardsPaymentsAggregates( $targetDate, $targetDate, $this->melSession['department'] );
			$cashPayments   = $this->fetchAllCashPaymentsAggregate( $targetDate, $targetDate, $this->melSession['department'] );
			$corePayments   = $this->getCorePayments( $targetDate, $targetDate, $this->getCashAccount() );
			
			# $payPalPayments   = $this->getPaymentsByPayMethodForTimeRange('2011-11-15', '941');
			# $debitORS         = $this->getDebitORS('2011-11-15', '941');
			# $debitORS         = $this->getDebitORS($startDate, $stopDate, $this->melSession['department']);
			# $cashExpenses     = $this->fetchAllCashExpensesByAccountForDateRange($this->getCashAccount(), $targetDate);
			
			return $this->render( 'statistics/account-statement-today.html.twig', [
				'controller_name' => 'StatisticsController',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Tagesabrechnung heute',
				'resultSet'       => $resultSet,
				'cashPayments'    => $cashPayments,
				'cardsPayments'   => $cardsPayments,
				'payPalPayments'  => $payPalPayments,
				'debitORS'        => $debitORS,
				'categorizedData' => $catData,
				'department'      => $this->melSession['department'],
				'infoHTML'        => 'In dieser Rubrik siehst du die Kundenwertanalyse sowie zeit- und kundenbezogene Verkaufslisten...',
				'feedbackHTML'    => 'Funktioniert etwas nicht so, wie du es dir vorstellst? Sag es ruhig Philippe, er wird sich der Sache annehmen...',
				
				'startingCashBalance' => $corePayments['startingCashBalance'],
				'cashBalance'         => $corePayments['cashBalance'],
				'debitBalance'        => $corePayments['debitBalance'],
				'creditBalance'       => $corePayments['creditBalance'],
				'cashSales'           => $corePayments['cashSales'],
				'cashExpenses'        => $corePayments['cashExpenses'],
			] );
		}
		
		/**
		 * @Route("/admin/statistiken/umsatz-nach-kategorie", name="rte_admin_sales_by_category")
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function salesByCategory( Request $request, ShopTranslator $translator ) {
			if ( ! ( $user = $this->getUser() ) ) {
				return $this->redirectToRoute( 'app_login' );
			}
			
			$catSalesEntity = new CategorySalesEntity();
			$catSalesForm   = new CategorySalesForm( $catSalesEntity, $translator );
			$postVars       = $request->request->all();
			$department     = isset( $this->melSession['department'] ) ? $this->melSession['department'] : null;
			$salesPayload   = [];
			$calcPercent    = false;
			
			if ( $catSalesEntityX = $catSalesForm->isValid( $postVars ) ) {
				$department  = $catSalesEntityX->getDepartment();    # ? $catSalesEntityX->getDepartment() : $department;
				$db_Laden    = in_array( $department, [
					"940",
					"941"
				] ) ? "BH_Journal_ma = {$department}" : "BH_Journal_ma BETWEEN 940 AND 941";   # ($department == "942" || $department == "0" ? "BH_Journal_ma BETWEEN 940 AND 941" : null);
				$sql         = <<<QRY
SELECT BH_Journal_id, BH_Journal_kommentar, BH_Journal_betrag, BH_Journal_datum, kat_name
		FROM BH_Journal, produkte_kategorie
		WHERE produktekategorie_BH_Konto = BH_Journal_konto_haben
		AND DATE(BH_Journal_datum) BETWEEN :J_DT_START AND :J_DT_STOP
		AND BH_Journal_konto_haben =:P_CAT
		AND {$db_Laden}
		ORDER BY BH_Journal_id ASC
QRY;
				$calcPercent = $catSalesEntityX->getProductCategory() == '3270';
				$conn        = $this->entityManager->getConnection();
				$statement   = $conn->prepare( $sql );
				$statement->execute( [
					':J_DT_START' => $catSalesEntityX->getStartDate()->format( 'Y-m-d' ),
					':J_DT_STOP'  => $catSalesEntityX->getEndDate()->format( 'Y-m-d' ),
					':P_CAT'      => $catSalesEntityX->getProductCategory()
				] );
				$salesPayload = $statement->fetchAll();
			}
			
			return $this->render( 'statistics/sales-by-category.html.twig', [
				'controller_name' => 'StatisticsController',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Abrechnung nach Kategorie',
				'formWidgets'     => $catSalesForm->getForm(),
				'salesPayload'    => $salesPayload,
				'btnText'         => 'Los',
				'calcPercent'     => $calcPercent,
				'department'      => $this->melSession['department'],
				'infoHTML'        => 'In dieser Rubrik siehst du die Kundenwertanalyse sowie zeit- und kundenbezogene Verkaufslisten...',
				'feedbackHTML'    => 'Funktioniert etwas nicht so, wie du es dir vorstellst? Sag es ruhig Philippe, er wird sich der Sache annehmen...',
			] );
		}
		
		/**
		 * @Route("/admin/statistiken/tagesabrechnung-individuel", name="rte_admin_individual_account_statement")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function IndividualAccountStatement( Request $request ) {
			if ( ! ( $user = $this->getUser() ) ) {
				return $this->redirectToRoute( 'app_login' );
			}
			$targetDate      = date( "Y-m-d" );  # date("Y-m-d", strtotime("2019-12-18"));
			$dtStartStopObj  = new StartStopDateEntity();
			$dtStartStopForm = new StartStopDateForm( $dtStartStopObj, $this->translator );
			$postVars        = $request->request->all();
			$resultSet       = [];
			$catData         = [];
			$cashPayments    = [];
			$cardsPayments   = [];
			$payPalPayments  = [];
			$debitORS        = [];
			$pageTitle       = "Tagesabrechnung individuell - {$user->getFriendlyName()}";
			$corePayments    = [
				'startingCashBalance' => 0,
				'cashBalance'         => 0,
				'debitBalance'        => 0,
				'creditBalance'       => 0,
				'cashExpenses'        => 0,
				'cashSales'           => [
					'mjrSalesTotal' => 0,
					'mjrSalesCount' => 0,
				],
			];
			
			if ( $dtStartStopObj = $dtStartStopForm->isValid( $postVars ) ) {
				$cashAccount    = $this->getCashAccount();
				$startDate      = $dtStartStopObj->getStartDate()->format( 'Y-m-d' );
				$stopDate       = $dtStartStopObj->getEndDate()->format( 'Y-m-d' );
				$payload        = $this->fetchSalesStatsData4TimeFrame( $startDate, $stopDate );
				$resultSet      = $payload ? $payload['statsData'] : [];
				$catData        = $payload ? $payload['catData'] : [];
				$pageTitle      = "Tagesabrechnung «{$user->getFriendlyName()}»: {$dtStartStopObj->getStartDate()->format('d.m.Y')} - {$dtStartStopObj->getEndDate()->format('d.m.Y')}";
				$payPalPayments = $this->getPaymentsByPayMethodForTimeRange( $startDate, $stopDate, $this->melSession['department'] );
				$debitORS       = $this->getDebitORS( $startDate, $stopDate, $this->melSession['department'] );
				$cardsPayments  = $this->fetchAllCardsPaymentsAggregates( $startDate, $stopDate, $this->melSession['department'] );
				$cashPayments   = $this->fetchAllCashPaymentsAggregate( $startDate, $stopDate, $this->melSession['department'] );
				$corePayments   = $this->getCorePayments( $startDate, $stopDate, $cashAccount );
			}
			
			return $this->render( 'statistics/individual-account-statement.html.twig', [
				'controller_name'     => 'StatisticsController',
				'user'                => $this->getUser(),
				'navPayload'          => $this->getNavigationPayload(),
				'pageTitle'           => $pageTitle,
				'btnText'             => 'Los',
				'resultSet'           => $resultSet,
				'categorizedData'     => $catData,
				'cashPayments'        => $cashPayments,
				'cardsPayments'       => $cardsPayments,
				'payPalPayments'      => $payPalPayments,
				'debitORS'            => $debitORS,
				'formWidgets'         => $dtStartStopForm->getForm(),
				'department'          => $this->melSession['department'],
				'infoHTML'            => 'In dieser Rubrik siehst du die Kundenwertanalyse sowie zeit- und kundenbezogene Verkaufslisten...',
				'feedbackHTML'        => 'Funktioniert etwas nicht so, wie du es dir vorstellst? Sag es ruhig Philippe, er wird sich der Sache annehmen...',
				'startingCashBalance' => $corePayments['startingCashBalance'],
				'cashBalance'         => $corePayments['cashBalance'],
				'debitBalance'        => $corePayments['debitBalance'],
				'creditBalance'       => $corePayments['creditBalance'],
				'cashExpenses'        => $corePayments['cashExpenses'],
				'cashSales'           => $corePayments['cashSales'],
			] );
		}
		
		/**
		 * @Route("/admin/statistiken/statistik-individuel/{cid}/{start}/{end}/{all}", name="rte_admin_individual_statistics")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param int|string|null                           $cid
		 * @param int|string|null                           $all
		 * @param int|string|null                           $start
		 * @param int|string|null                           $end
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 * @throws \Exception
		 */
		public function individualStatistics(Request $request, $cid = null, $start = null, $end = null, $all = null ) {
			if ( ! ( $user = $this->getUser() ) ) {
				return $this->redirectToRoute( 'app_login' );
			}
			$subTitle               = null;
			$debitORS               = [];
			$statsPayload           = [];
			$pageTitle              = 'Statistik individuell';
			$individualStatsEntity  = new IndividualStatsEntity();
			$individualStatsForm    = new IndividualStatsForm($individualStatsEntity, $this->translator);
			$postVars               = $request->request->all();
			
			if($cid && $start && $end){
				$statsPayload   = $this->fetchSalesStatsData4TimeFrame($start, $end, false, " AND `psn`.`kundenid`={$cid} ");
				$debitORS       = $this->getDebitORS( $start, $end, $this->melSession['department'], " AND `personen`.`kundenid`={$cid}" );
				$clientName     = isset($statsPayload[0]) ? DateCalculator::getStreamlinedCustomerName($statsPayload[0], 0) : '';
				$pageTitle      = "Statistik individuell";
				$pageTitle     .= trim($clientName) ? ": «{$clientName}»" : "";
				$pageTitle     .= " -- KundenNr.  {$cid}";
				$subTitle       = "Statistik «{$clientName}» " . $start . " bis " . $end;
				$individualStatsEntity->setStartDate(new \DateTime($start));
				$individualStatsEntity->setEndDate(new \DateTime($end));
				$individualStatsEntity->setClient($cid);
				$individualStatsForm  = new IndividualStatsForm($individualStatsEntity, $this->translator);
			}
			
			if($individualStatsObj  = $individualStatsForm->isValid($postVars)){
				$clientID       = $individualStatsObj->getClient();
				$dtStart        = $individualStatsObj->getStartDate()->format('Y-m-d');
				$dtStop         = $individualStatsObj->getEndDate()->format('Y-m-d');
				$statsPayload   = $this->fetchSalesStatsData4TimeFrame($dtStart, $dtStop, false, " AND `psn`.`kundenid`={$clientID} ");
				$debitORS       = $this->getDebitORS( $dtStart, $dtStop, $this->melSession['department'], " AND `personen`.`kundenid`={$clientID}" );
				$clientName     = isset($statsPayload[0]) ? DateCalculator::getStreamlinedCustomerName($statsPayload[0], 0) : '';
				$pageTitle      = "Statistik individuell";
				$pageTitle     .= trim($clientName) ? ": «{$clientName}»" : "";
				$pageTitle     .= " -- KundenNr.  {$individualStatsObj->getClient()}";
				$subTitle       = "Statistik «{$clientName}» " . $dtStart . " bis " . $dtStop;
			}
			
			$resultSet      = $statsPayload && isset($statsPayload['statsData'])  ? $statsPayload['statsData']  : [];
			$catData        = $statsPayload && isset($statsPayload['catData'])    ? $statsPayload['catData']    : [];
			
			return $this->render( 'statistics/individual-client-statistics.html.twig', [
				'controller_name' => 'StatisticsController',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'statsPayload'    => $statsPayload,
				'catData'         => $catData,
				'resultSet'       => $resultSet,
				'debitORS'        => $debitORS,
				'formWidgets'     => $individualStatsForm->getForm(),
				'pageTitle'       => $pageTitle,
				'subTitle'        => $subTitle,
				'btnText'         => 'Los',
				'department'      => $this->melSession['department'],
			] );
		}
		
		/**
		 * @Route("/admin/statistiken/verkaufpost-entfernen/{bhj_id}", name="rte_admin_delete_sale_entry")
		 * @param int|string|null $bhj_id
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function deleteSaleEntry( $bhj_id = null ) {
			if ( ! ( $user = $this->getUser() ) ) {
				return $this->redirectToRoute( 'app_login' );
			}
			
			return $this->render( 'statistics/statistics.html.twig', [
				'controller_name' => 'StatisticsController',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'pageTitle'       => 'Statistiken',
				'department'      => $this->melSession['department'],
				'infoHTML'        => 'In dieser Rubrik siehst du die Kundenwertanalyse sowie zeit- und kundenbezogene Verkaufslisten...',
				'feedbackHTML'    => 'Funktioniert etwas nicht so, wie du es dir vorstellst? Sag es ruhig Philippe, er wird sich der Sache annehmen...',
			] );
		}
		
		/**
		 * @Route("/admin/statistiken/kundenwertanalyse", name="rte_admin_customer_value_analysis")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Helpers\Date\DateCalculator          $dateCalculator
		 * @param \App\Helpers\Date\RequestBridge           $rb
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function kundenwertanalyse( Request $request, DateCalculator $dateCalculator, RequestBridge $rb ) {
			if ( ! ( $user = $this->getUser() ) ) {
				return $this->redirectToRoute( 'app_login' );
			}
			# $this->department = $this->melSession['department'];
			$payload  = $this->calculateClientWorth();
			return $this->render( 'statistics/client-worth-analysis.html.twig', [
				'controller_name' => 'StatisticsController',
				'user'            => $this->getUser(),
				'navPayload'      => $this->getNavigationPayload(),
				'rfmr'                      => isset($payload['rfmr'])                    ? $payload['rfmr']                    : [],
				'rfmrDeb'                   => isset($payload['rfmrDeb'])                 ? $payload['rfmrDeb']                 : [],
				'rfmrRowsCount'             => isset($payload['rfmrRowsCount'])           ? $payload['rfmrRowsCount']           : 0,
				'totalRowsAvgSales'         => isset($payload['totalRowsAvgSales'])       ? $payload['totalRowsAvgSales']       : [],
				'totalRowsAvgSalesCount'    => isset($payload['totalRowsAvgSalesCount'])  ? $payload['totalRowsAvgSalesCount']  : 0,
				'department'          => $this->melSession['department'],
				'pageTitle'           => 'Statistiken',
				'clientsWorthData'    => $payload,
				'infoHTML'            => 'In dieser Rubrik siehst du die Kundenwertanalyse sowie zeit- und kundenbezogene Verkaufslisten...',
				'feedbackHTML'        => 'Funktioniert etwas nicht so, wie du es dir vorstellst? Sag es ruhig Philippe, er wird sich der Sache annehmen...',
			] );
		}
		
		private function getCashAccount() {
			$department = isset( $this->melSession['department'] ) ? $this->melSession['department'] : null;
			return $department == "940" ? 1000 : ( ( $department == "941" ) ? 1001 : 1000 ); // ADMIN  HAS NO RIGHTS TO VIEW THIS.... RETURN NULL RATHER THAN 1000
		}
		
		private function getCorePayments( $startDate, $targetDate, $cashAccount ) {
			$user = $this->getUser();
			// ACCOUNT STATUS FROM THE BEGINNING OF 2011?
			/** @var \App\Entity\BHKonto $bookKeepingAccount */
			
			$bookKeepingAccount  = $this->entityManager->getRepository( \App\Entity\BHKonto::class )->findOneBy( [ 'BH_Konto_Nummer' => $cashAccount ] );
			$startingCashBalance = $bookKeepingAccount->getBHKonto2011Open();
			
			$department   = isset( $this->melSession['department'] ) ? $this->melSession['department'] : null;
			$db_Laden     = in_array( $department, [
				"940",
				"941"
			] ) ? "verkaufmitarbeiter = {$department}" : ( $department == "942" ? "verkaufmitarbeiter BETWEEN 940 AND 941" : null );
			$db_Debitoren = in_array( $department, [
				"940",
				"941"
			] ) ? "BH_Journal_ma = {$department}" : ( $department == "942" ? "BH_Journal_ma BETWEEN 940 AND 941" : null );
			$db_bar       = in_array( $department, [
				"940",
				"941"
			] ) ? "BH_Journal_konto_haben = " . $this->getCashAccount() : ( $department == "942" ? "BH_Journal_konto_haben BETWEEN 1000 AND 1001" : null );
			$db_zm        = $department == "940" ? "verkaufzahlungsmittel = 1" : ( $department == "941" ? "verkaufzahlungsmittel = 10" : ( $department == "942" ? "(verkaufzahlungsmittel = 1 OR verkaufzahlungsmittel = 10)" : null ) );
			
			$sql       = "SELECT SUM(BH_Journal_betrag) AS `GRAND_TOTAL` FROM BH_Journal WHERE BH_Journal_konto_soll=:B_KTO AND BH_Journal_datum>=:J_DT_START AND BH_Journal_datum<=:J_DT_STOP ";
			$feedData  = [
				':B_KTO'      => $cashAccount,
				':J_DT_START' => '2011-01-01',
				':J_DT_STOP'  => $targetDate
			];
			$conn      = $this->entityManager->getConnection();
			$statement = $conn->prepare( $sql );
			$statement->execute( $feedData );
			$debitBalance = ( $bhk = $statement->fetch() ) ? $bhk['GRAND_TOTAL'] : null;
			$conn->close();
			
			$sql2       = "SELECT SUM(BH_Journal_betrag) AS `GRAND_TOTAL` FROM BH_Journal WHERE BH_Journal_konto_haben=:B_KHB AND BH_Journal_datum >=:J_DT_START AND BH_Journal_datum<=:J_DT_STOP ";
			$feedData2  = [
				':B_KHB'      => $cashAccount,
				':J_DT_START' => '2011-01-01',
				':J_DT_STOP'  => $targetDate
			];
			$conn2      = $this->entityManager->getConnection();
			$statement2 = $conn2->prepare( $sql2 );
			$statement2->execute( $feedData2 );
			$haben_saldo = ( $bhk = $statement2->fetch() ) ? $bhk['GRAND_TOTAL'] : 0;
			$conn2->close();
			
			// CASH EXPENSES
			$sql3       = "SELECT * FROM BH_Journal WHERE DATE(BH_Journal_datum) BETWEEN :J_DT_START AND :J_DT_STOP AND " . $db_bar . " ORDER BY BH_Journal_id ASC";
			$feedData3  = [
				':J_DT_START' => $startDate,
				':J_DT_STOP'  => $targetDate
			];
			$conn3      = $this->entityManager->getConnection();
			$statement3 = $conn3->prepare( $sql3 );
			$statement3->execute( $feedData3 );
			$cashExpenses = $statement3->fetchAll();
			$conn3->close(); // debit and credit   solL & haben
			
			// CASH SALES SUM...
			$sql4       = "SELECT SUM(verkaufbetrag) AS mjrSalesTotal, COUNT(verkaufid) AS mjrSalesCount FROM verkauf where verkaufdatum between :J_DT_START AND :J_DT_STOP AND " . $db_zm;
			$feedData4  = [
				':J_DT_START' => $startDate,
				':J_DT_STOP'  => $targetDate
			];
			$conn4      = $this->entityManager->getConnection();
			$statement4 = $conn3->prepare( $sql4 );
			$statement4->execute( $feedData4 );
			$cashSales = $statement4->fetch();
			$conn4->close();
			
			// Diese Soll- und Haben-Buchungen aufrechnen, das ergibt den Startsaldo
			# UPDATE `$cashBalance` ACCORDING TO MELANIE: ADD `$totalCashExpenses` TO
			# ( $startingCashBalance + $debitBalance - $haben_saldo )
			$totalCashExpenses  = $this->getTotalCashExpenses($cashExpenses);
			$cashBalance        = ($startingCashBalance + $debitBalance - $haben_saldo) + $totalCashExpenses;
			return [
				'startingCashBalance' => $startingCashBalance,
				'cashBalance'         => $cashBalance,  #( $startingCashBalance + $debitBalance - $haben_saldo ),
				'debitBalance'        => $debitBalance,
				'creditBalance'       => $haben_saldo,
				'cashSales'           => $cashSales,
				'cashExpenses'        => $cashExpenses,
				'totalCashExpenses'   => $totalCashExpenses,
			];
		}
		
		private function getTotalCashExpenses($cashExpenses){
			$totalCashExpenses = 0;
			if(is_array($cashExpenses) && $cashExpenses){
				foreach($cashExpenses as $cashExpense){
					$totalCashExpenses += $cashExpense['BH_Journal_betrag'];
				}
			}
			return $totalCashExpenses;
		}
		
		private function calculateClientWorth(){
			$sql          = $this->fetchKundenWertSQL();
			$conn         = $this->entityManager->getConnection();
			$statement    = $conn->prepare($sql);
			$statement->execute();
			$resultSet          = $statement->fetchAll();
			$row_avgkauf        = $resultSet;
			$totalRows_avgkauf  = sizeof($resultSet);
			$conn->close();
			
			$sql2B        = $this->fetchTimeDiffSQL();
			$conn2B       = $this->entityManager->getConnection();
			$statement2B  = $conn2B->prepare($sql2B);
			$statement2B->execute();
			$resultSet2B     = $statement2B->fetchAll();
			$conn2B->close();
			
			$sql2       = $this->fetchFirstSaleTimeSQL();
			$conn2      = $this->entityManager->getConnection();
			$statement2 = $conn2->prepare($sql2);
			$statement2->execute();
			$resultSet2     = $statement2->fetchAll();
			$row_ersterkauf = $resultSet2;
			$conn2->close();
			
			
			/**
			 *
			
			
			0 =>  [
				"minUnixTimeStampBHJournalDataum" => "0",
				"maxUnixTimeStampNow"             => "1581033829"
			]
			
			"kundenid"                      => "16"
			"name"                          => "Boutellier"
			"vorname"                       => "Denise"
			"Firma"                         => ""
			"sumVerkaufbetrag"              => "1834"
			"avgVerkaufbetrag"              => "35.9608"
			"countVerkaufbetrag"            => "51"
			"minDifFVerkaufDatum"           => "263"
			"minUnixTimeStampVerkaufDataum" => "1193958000"
			 */
			// Zeit zwischen dem ersten Kauf eines Kunden und heute (in Tagen) ausrechnen
			$letzter        = $row_ersterkauf[0]['maxUnixTimeStampNow'];  //.'<br>';
			$erster         = $row_ersterkauf[0]['minUnixTimeStampVerkaufDatum'];
			$gesamtzeit     = ($letzter - $erster) / (3600 * 24);
			
			
			$payload            = $this->mapPayloadRFMR($gesamtzeit, $letzter, $row_avgkauf);
			$tage               = $payload['tage'];
			$kundenid           = $payload['kundenid'];
			$ratio              = $payload['ratio'];
			$monetary           = $payload['monetary'];
			$frequency          = $payload['frequency'];
			$anzahlkaeufe       = $payload['anzahlkaeufe'];
			$durchschnittskauf  = $payload['durchschnittskauf'];
			
			$sql4         = $this->fetchClientRfMrSalesAmountSQL();
			$conn4        = $this->entityManager->getConnection();
			$statement4   = $conn4->prepare($sql4);
			$statement4->execute();
			$resultSet4   = $statement4->fetchAll();
			$conn4->close();
			
			$sql3       = $this->fetchRfMrDebBhjAmountSQL();
			$conn3      = $this->entityManager->getConnection();
			$statement3 = $conn3->prepare($sql3);
			$statement3->execute();
			$resultSet3 = $statement3->fetchAll();
			$conn3->close();
			
			
			$sqlAvg       = $this->fetchRfMrDebBhJournalAveragesSQL();
			$connAvg      = $this->entityManager->getConnection();
			$statementAvg = $connAvg->prepare($sqlAvg);
			$statementAvg->execute();
			$resultSetAvg = $statementAvg->fetchAll();
			$connAvg->close();
			
			$payloadDeb         = $this->mapPayloadRFMRDeb($gesamtzeit, $letzter, $resultSetAvg);
			#$payloadDeb         = $this->mapPayloadRFMRDeb($gesamtzeit, $letzter, $resultSetAvg);
			$tageDeb            = $payloadDeb['tage'];
			$ratioDeb           = $payloadDeb['ratio'];
			$monetaryDeb        = $payloadDeb['monetary'];
			$frequencyDeb       = $payloadDeb['frequency'];
			$anzahlkaeufeDeb    = $payloadDeb['anzahlkaeufe'];
			$durchschnittsDeb   = $payloadDeb['durchschnittskauf'];
			
			
			return [
				'payloadDeb'              => $payloadDeb,
				'rfmr'                    => $resultSet4,
				'rfmrCount'               => sizeof($resultSet4),
				'rfmrDeb'                 => $resultSet3,
				'rfmrRowsCount'           => sizeof($resultSet3),
				'totalRowsAvgSales'       => $row_avgkauf,
				'totalRowsAvgSalesCount'  => $totalRows_avgkauf,
				'anzahlkaeufe'            => $anzahlkaeufe,
				'anzahlkaeufeDeb'         => $anzahlkaeufeDeb,
				'tage'                    => $tage,
				'tageDeb'                 => $tageDeb,
				'durchschnittskauf'       => $durchschnittskauf,
				'durchschnittsDeb'        => $durchschnittsDeb,
				'kundenid'                => $kundenid,
				'ratio'                   => $ratio,
				'ratioDeb'                => $ratioDeb,
				'timeDiff'                => $resultSet2B,
				'frequency'               => $frequency,
				'frequencyDeb'            => $frequencyDeb,
				'monetary'                => $monetary,
				'monetaryDeb'             => $monetaryDeb,
			];
		}
		
		private function mapPayloadRFMR($gesamtzeit, $letzter, &$row_avgkauf){
			$tage               = [];
			$kundenid           = null;
			$ratio              = [];
			$monetary           = [];
			$frequency          = [];
			$anzahlkaeufe       = [];
			$durchschnittskauf  = [];
			foreach ($row_avgkauf as $iKey=>$rowAvgKauF){
				$kundenid                     = $rowAvgKauF['kundenid'];
				$durchschnittskauf[$kundenid] = $rowAvgKauF['avgVerkaufbetrag'];
				$anzahlkaeufe[$kundenid]      = $rowAvgKauF['countVerkaufbetrag'];
				$tage[$kundenid]              = $rowAvgKauF['minDifFVerkaufDatum'];
				
				// Falls heute gekauft wurde, dann Differenz von Null auf 1 setzen
				$letzterkauf                  = $rowAvgKauF['minDifFVerkaufDatum'];
				if ($letzterkauf == 0)  {
					$letzterkauf      = 0.01;
				}
				
				// Ratio berechnen
				$ratio[$kundenid]             = 100 - (($letzterkauf * 100) / $gesamtzeit);
				
				// Frequency berechnen
				$anzahl_kauf                  = $rowAvgKauF['countVerkaufbetrag'];
				$erstkauf                     = $rowAvgKauF['minUnixTimeStampVerkaufDataum'];
				$zeitseiterstkauf             = ($letzter - $erstkauf) / (3600 * 24);
				$frequency[$kundenid]         = ($anzahl_kauf / $zeitseiterstkauf);
				
				// und noch den Durchschnittsumsatz, den haben wir ja schon
				$monetary[$kundenid]          = round($rowAvgKauF['avgVerkaufbetrag'], 2);
				// Der grosse Moment: der RFMR-Wert eines jeden Kunden wird berechnet
				$rfmr                         = round($ratio[$kundenid] * $frequency[$kundenid] * $monetary[$kundenid], 0);
				
				
				// RFMR in DB kunde schreiben....
				$kundin_rfmr                  = "UPDATE personen SET RFMR =:RF_MR_ID WHERE kundenid =:KID";
				$connRFMR                     = $this->entityManager->getConnection();
				$statementRFMR                = $connRFMR->prepare($kundin_rfmr);
				$rfMrStatus                   = $statementRFMR->execute([':RF_MR_ID' => $rfmr, ':KID' => $kundenid]);
				$connRFMR->close();
			}
			
			return [
				'totalRowsAvgSales'       => $row_avgkauf,
				'anzahlkaeufe'            => $anzahlkaeufe,
				'tage'                    => $tage,
				'durchschnittskauf'       => $durchschnittskauf,
				'kundenid'                => $kundenid,
				'ratio'                   => $ratio,
				'frequency'               => $frequency,
				'monetary'                => $monetary,
			];
		}
		
		private function mapPayloadRFMRDeb($gesamtzeit, $letzter, &$row_avgkauf){
			$tage               = [];
			$kundenid           = null;
			$ratio              = [];
			$monetary           = [];
			$frequency          = [];
			$anzahlkaeufe       = [];
			$durchschnittskauf  = [];
			foreach ($row_avgkauf as $iKey=>$rowAvgKauF){
				# dump($rowAvgKauF);
				$kundenid                     = $rowAvgKauF['kundenid'];
				$durchschnittskauf[$kundenid] = $rowAvgKauF['avgBhJournalBetrag'];
				$anzahlkaeufe[$kundenid]      = $rowAvgKauF['countBhJournalBetrag'];
				$tage[$kundenid]              = $rowAvgKauF['minDateDiffNowBjhDatum'];
				
				
				
				// Falls heute gekauft wurde, dann Differenz von Null auf 1 setzen
				$letzterkauf                  = $rowAvgKauF['minDateDiffNowBjhDatum'];
				
				if ($letzterkauf == 0)  {
					$letzterkauf = 0.01;
				}
				
				// Ratio berechnen
				$ratio[$kundenid]             = 100 - (($letzterkauf * 100) / $gesamtzeit);
				
				// Frequency berechnen
				$anzahl_kauf                  = $rowAvgKauF['countBhJournalBetrag'];
				$erstkauf                     = $rowAvgKauF['minUnixTimeStampBHJDatum'];
				$zeitseiterstkauf             = ($letzter - $erstkauf) / (3600 * 24);
				$frequency[$kundenid]         = ($anzahl_kauf / $zeitseiterstkauf);
				
				// und noch den Durchschnittsumsatz, den haben wir ja schon
				$monetary[$kundenid]          = round($rowAvgKauF['avgBhJournalBetrag'], 2);
				// Der grosse Moment: der RFMR-Wert eines jeden Kunden wird berechnet
				$rfmr                         = round($ratio[$kundenid] * $frequency[$kundenid] * $monetary[$kundenid], 0);
				
				
				
				// RFMR in DB kunde schreiben....
				$kundin_rfmr                  = "UPDATE personen SET RFMR_deb =:RF_MR_ID WHERE kundenid =:KID ";
				$connRFMR                     = $this->entityManager->getConnection();
				$statementRFMR                = $connRFMR->prepare($kundin_rfmr);
				$rfMrStatus                   = $statementRFMR->execute([':RF_MR_ID' => $rfmr, ':KID' => $kundenid]);
				$connRFMR->close();
			}
			
			return [
				'totalRowsAvgSales'       => $row_avgkauf,
				'anzahlkaeufe'            => $anzahlkaeufe,
				'tage'                    => $tage,
				'durchschnittskauf'       => $durchschnittskauf,
				'kundenid'                => $kundenid,
				'ratio'                   => $ratio,
				'frequency'               => $frequency,
				'monetary'                => $monetary,
			];
		}
		
		private function fetchKundenWertSQL(){
			$this->department = $this->melSession['department'];
			if ( in_array( $this->department, [ "940", "941" ] ) ) {
				return <<<QRY
SELECT
	kundenid,
	`name`,
	vorname,
	Firma,
	sum(verkaufbetrag) AS sumVerkaufbetrag,
	avg(verkaufbetrag) AS avgVerkaufbetrag,
	count(verkaufbetrag) AS countVerkaufbetrag,
	min(datediff(now(), verkaufdatum)) AS minDifFVerkaufDatum,
	min(UNIX_TIMESTAMP(verkaufdatum)) AS minUnixTimeStampVerkaufDataum
	FROM verkauf, personen
	WHERE verkaufkunde = kundenid
	AND verkaufmitarbeiter = '{$this->department}'
	GROUP BY kundenid
QRY;
			}
			return <<<QRY
SELECT
	kundenid,
	`name`,
	vorname,
	Firma,
	sum(verkaufbetrag) AS sumVerkaufbetrag,
	avg(verkaufbetrag) AS avgVerkaufbetrag,
	count(verkaufbetrag) AS countVerkaufbetrag,
	min(datediff(now(), verkaufdatum)) AS minDifFVerkaufDatum,
	min(UNIX_TIMESTAMP(verkaufdatum)) AS minUnixTimeStampVerkaufDataum
	FROM verkauf, personen
	WHERE verkaufkunde = kundenid
	GROUP BY kundenid
QRY;
		}
		
		private function fetchRfMrDebBhjAmountSQL(){
			$this->department = $this->melSession['department'];
			if ( in_array( $this->department, [ "940", "941" ] ) ) {
				return <<<QRY
SELECT kundenid, name, vorname, Firma, RFMR_deb, SUM(BH_Journal_betrag) AS sumBhJournalBetrag
FROM personen, BH_Journal, Rechnung, Rechnung_posten WHERE Rechnung_kunde = kundenid AND Rechnung_posten_Rechnung_id = Rechnung_id
AND Rechnung_posten_BH_Journal_id = BH_Journal_id AND BH_Journal_ma = '{$this->department}' GROUP BY kundenid order by RFMR_deb desc
QRY;
			}
			return <<<QRY
SELECT kundenid, name, vorname, Firma, RFMR_deb, SUM(BH_Journal_betrag) AS sumBhJournalBetrag
FROM personen, BH_Journal, Rechnung, Rechnung_posten WHERE Rechnung_kunde = kundenid
AND Rechnung_posten_Rechnung_id = Rechnung_id AND Rechnung_posten_BH_Journal_id = BH_Journal_id GROUP BY kundenid order by RFMR_deb desc
QRY;
		}
		
		private function fetchRfMrDebBhJournalAveragesSQL(){
			$this->department = $this->melSession['department'];
			if ( in_array( $this->department, [ "940", "941" ] ) ) {
				return <<<QRY
SELECT kundenid, name, vorname, Firma, sum(BH_Journal_betrag) AS sumBhJournalBetrag, avg(BH_Journal_betrag) AS avgBhJournalBetrag, count(BH_Journal_betrag) AS countBhJournalBetrag,
min(datediff(now(), BH_Journal_datum)) AS minDateDiffNowBjhDatum, min(UNIX_TIMESTAMP(BH_Journal_datum)) AS minUnixTimeStampBHJDatum
FROM BH_Journal, personen, Rechnung, Rechnung_posten where Rechnung_kunde = kundenid AND Rechnung_posten_Rechnung_id = Rechnung_id
AND Rechnung_posten_BH_Journal_id = BH_Journal_id AND BH_Journal_ma = '{$this->department}' group by kundenid
QRY;
			}
			return <<<QRY
SELECT kundenid, name, vorname, Firma, sum(BH_Journal_betrag) AS sumBhJournalBetrag, avg(BH_Journal_betrag) AS avgBhJournalBetrag, count(BH_Journal_betrag) AS countBhJournalBetrag,
min(datediff(now(), BH_Journal_datum)) AS minDateDiffNowBhjDatum, min(UNIX_TIMESTAMP(BH_Journal_datum)) AS minUnixTimeStampBHJDatum
FROM BH_Journal, personen, Rechnung, Rechnung_posten where Rechnung_kunde = kundenid AND Rechnung_posten_Rechnung_id = Rechnung_id
AND Rechnung_posten_BH_Journal_id = BH_Journal_id group by kundenid
QRY;
		}
		
		private function fetchClientRfMrSalesAmountSQL(){
			$this->department = $this->melSession['department'];
			if ( in_array( $this->department, [ "940", "941" ] ) ) {
				return <<<QRY
SELECT kundenid, name, vorname, Firma, RFMR, sum(verkaufbetrag) AS sumVerkaufBetrag FROM personen, verkauf WHERE verkaufkunde = kundenid  AND verkaufmitarbeiter = '{$this->department}' GROUP BY kundenid order by RFMR desc
QRY;
			}
			return <<<QRY
SELECT kundenid, name, vorname, Firma, RFMR, sum(verkaufbetrag) AS sumVerkaufBetrag FROM personen, verkauf WHERE verkaufkunde = kundenid GROUP BY kundenid order by RFMR desc
QRY;
		}
		
		private function fetchFirstSaleTimeSQL(){
			$this->department = $this->melSession['department'];
			if ( in_array( $this->department, [ "940", "941" ] ) ) {
				return <<<QRY
SELECT min(UNIX_TIMESTAMP(verkaufdatum)) AS minUnixTimeStampVerkaufDatum, max(UNIX_TIMESTAMP(now())) AS maxUnixTimeStampNow FROM verkauf WHERE verkaufmitarbeiter = '{$this->department}'
QRY;
			}
			return <<<QRY
SELECT min(UNIX_TIMESTAMP(verkaufdatum)), max(UNIX_TIMESTAMP(now())) FROM verkauf
QRY;
		}
		
		private function fetchTimeDiffSQL(){
			$this->department = $this->melSession['department'];
			if ( in_array( $this->department, [ "940", "941" ] ) ) {
				return <<<QRY
SELECT min(UNIX_TIMESTAMP(BH_Journal_datum)) AS minUnixTimeStampBHJournalDataum, max(UNIX_TIMESTAMP(now())) AS maxUnixTimeStampNow FROM BH_Journal WHERE BH_Journal_ma='{$this->department}'
QRY;
			}
			return <<<QRY
SELECT min(UNIX_TIMESTAMP(BH_Journal_datum)) AS minUnixTimeStampBHJournalDataum, max(UNIX_TIMESTAMP(now())) AS maxUnixTimeStampNow FROM BH_Journal
QRY;
		}
		
		private function fetchSalesStatsData4TimeFrame($startDate, $endDate, $sqlOnly=false, $extraClause=''){
			$WHERE_CLAUSE   = ($startDate == $endDate) ? "WHERE DATE(`vkf`.`verkaufdatum`)='{$startDate}'" :
											 "WHERE DATE(`vkf`.`verkaufdatum`) between '{$startDate}' AND '{$endDate}'";
			$sql            =<<<QUERY
SELECT DISTINCT vkf.*, psn.*, bhj.*, pkt.*, zml.*
	FROM `verkauf` 							AS `vkf`
	JOIN `personen` 						AS `psn` ON `psn`.`kundenid`										= `vkf`.`verkaufkunde`
	JOIN `BH_Journal` 					AS `bhj` ON `bhj`.`BH_Journal_verkauf_id`				= `vkf`.`verkaufid`
	JOIN `produkte_kategorie` 	AS `pkt` ON `pkt`.`produktekategorie_BH_Konto`	= `bhj`.`BH_Journal_konto_haben`
	JOIN `Zahlungsmittel` 			AS `zml` ON `vkf`.`verkaufzahlungsmittel`				= `zml`.`Zahlungsmittel_id`
	{$WHERE_CLAUSE}
	{$extraClause}
	AND `vkf`.`verkaufmitarbeiter`	= '{$this->department}'
	ORDER BY `bhj`.`BH_Journal_verkauf_id`, `bhj`.`BH_Journal_id` ASC
QUERY;
			$catData        = [];
			$responseData   = [];
			$conn           = $this->entityManager->getConnection();
			$statement      = $conn->prepare($sql);
			$statement->execute([]);
			
			if($resultSet = $statement->fetchAll()){
				$totalCount = count($resultSet);
				foreach($resultSet as $iKey=>$result){
					if(!array_key_exists($result['verkaufid'], $responseData)){
						$responseData[$result['verkaufid']]  = [];
					}
					if(!array_key_exists($result['kat_name'], $catData)){
						$catData[$result['kat_name']]  = [];
						$catData[$result['kat_name']]['total']      = 0;
						$catData[$result['kat_name']]['category']   = $result['kat_name'];
					}
					$catData[$result['kat_name']]['total']+= floatval($result['BH_Journal_betrag']);
					$result['totalCount']                 = $totalCount;
					$responseData[$result['verkaufid']][] = $result;
				}
			}
			return $sqlOnly ? $sql : ['statsData' => $responseData, 'catData' => $catData];
		}
		
		private function fetchDebitsSQL($sameDate=false, $extraClause=''){
			$dateClause = ($sameDate) ? " AND DATE(BH_Journal_datum)=:E_DATE " : " AND  DATE(BH_Journal_datum)>=:S_DATE AND DATE(BH_Journal_datum)<=:E_DATE ";
			return <<<QRY
SELECT *
	FROM Rechnung, Rechnung_posten, personen, BH_Journal, produkte_kategorie
	WHERE Rechnung_kunde = kundenid
	{$dateClause}
	AND Rechnung_posten_Rechnung_id = Rechnung_id
	AND Rechnung_posten_BH_Journal_id = BH_Journal_id
	AND BH_Journal_konto_haben = produktekategorie_BH_Konto
	AND BH_Journal_ma =:T_DEPT
	{$extraClause}
	ORDER BY BH_Journal_id ASC
QRY;
		}
		
		private function getPaymentsByPayMethodForTimeRange($startDate, $endDate=null, $department=null, $payMethod=11){
			/**@var \Doctrine\DBAL\Connection $conn */
			$conn       = $this->entityManager->getConnection();
			$endDate    = $endDate ? $endDate : $startDate;
			$department = !$department ? ( isset($this->melSession['department']) ? $this->melSession['department'] : null ) : $department;
			$sql        = " SELECT SUM(`vkf`.`verkaufbetrag`) AS salesTotal, COUNT(`vkf`.`verkaufid`) AS salesCount ";
			$sql       .= " FROM `verkauf` AS `vkf` WHERE DATE(`vkf`.`verkaufdatum`) >=:S_DATE ";
			$sql       .= " AND DATE(`vkf`.`verkaufdatum`) <=:E_DATE ";
			$sql       .= " AND `vkf`.`verkaufzahlungsmittel`=:P_TYPE AND `vkf`.`verkaufmitarbeiter`=:T_DEPT ";
			$statement  = $conn->prepare($sql);
			$statement->execute([':S_DATE' => $startDate, ':E_DATE' => $endDate, ':T_DEPT' => $department, ':P_TYPE' => $payMethod]);
			return $statement->fetch();
		}
		
		private function getDebitORS($startDate, $endDate, $department=null, $extraClause=null){
			/**@var \Doctrine\DBAL\Connection $conn */
			$conn       = $this->entityManager->getConnection();
			$department = !$department ? ( isset($this->melSession['department']) ? $this->melSession['department'] : null ) : $department;
			$sql        = $this->fetchDebitsSQL(($startDate == $endDate), $extraClause);
			$statement  = $conn->prepare($sql);
			$params     = ($startDate == $endDate) ? [':E_DATE' => $endDate, ':T_DEPT' => $department] : [':S_DATE' => $startDate, ':E_DATE' => $endDate, ':T_DEPT' => $department];
			$statement->execute($params); //[':S_DATE' => $startDate, ':E_DATE' => $endDate, ':T_DEPT' => $department]);
			return $statement->fetchAll();
		}
		
		private function fetchAllCashPaymentsAggregate($startDate, $endDate, $department=null){
			/**@var \Doctrine\DBAL\Connection $conn */
			$paymentMap = [
				940                   => '1',
				941                   => '10',
			];
			$allPaymentAggregates = [];
			foreach($paymentMap as $payMethodName => $payMethodID){
				$allPaymentAggregates[$payMethodName] = $this->getPaymentsByPayMethodForTimeRange($startDate, $endDate, $department, $payMethodID);
			}
			return $allPaymentAggregates;
		}
		
		private function fetchAllCardsPaymentsAggregates($startDate, $endDate, $department=null){
			/**@var \Doctrine\DBAL\Connection $conn */
			$paymentMap = [
				'Postcard'            => '3',
				'EC Maestro'          => '2',
				'MasterCard'          => '4',
				'VISA'                => '5',
				'VPay'                => '13',
				'American Express'    => '6',
				'BernCity-Card'       => '8',
				#'PayPal'              => '11',
				#'UnionPay'            => '12',
			];
			$allPaymentAggregates = [];
			foreach($paymentMap as $payMethodName => $payMethodID){
				$allPaymentAggregates[$payMethodName] = ['cardName' => $payMethodName] + $this->getPaymentsByPayMethodForTimeRange($startDate, $endDate, $department, $payMethodID);
			}
			return $allPaymentAggregates;
		}
		
		private function processDateValuesAsYMDString($dateValue){
			if(!$dateValue){
				$dateValue = date("Y-m-d");
			}else{
				if($dateValue instanceof \DateTime){ $dateValue->format('Y-m-d'); }
			}
			return $dateValue;
		}
		
		private function fetchAllCashExpensesByAccountForDateRange($account, $startDate=null, $stopDate=null){
			/**@var \Doctrine\DBAL\Connection $conn */
			$conn   = $this->entityManager->getConnection();
			$dateA  = $this->processDateValuesAsYMDString($startDate);
			$dateZ  = $this->processDateValuesAsYMDString($stopDate);
			$sql    = " SELECT `bhj`.* FROM `BH_Journal` AS `bhj` ";
			$sql   .= " WHERE DATE(`bhj`.`BH_Journal_datum`) BETWEEN :DT_A AND :DT_Z ";
			$sql   .= " AND `bhj`.`BH_Journal_konto_haben`=:CNT ";
			$sql   .= " ORDER BY `bhj`.`BH_Journal_id` ASC ";
			$stMT   = $conn->prepare($sql);
			$stMT->execute([':DT_A'=>$dateA, ':DT_Z'=>$dateZ, ':CNT'=>$account]);
			return $stMT->fetchAll();
		}
		
		private function getIndieStatsSQL(){
			$sql  = " SELECT `psn`.`Firma`,         `psn`.`name`,         `psn`.`vorname`, `psn`.`Kategorie`, ";
			$sql .= " `vkf`.`verkaufid`,            `vkf`.`verkaufdatum`, `vkf`.`verkaufbetrag`, ";
			$sql .= " `bhj`.`BH_Journal_id`,        `bhj`.`BH_Journal_kommentar`,  `bhj`.`BH_Journal_betrag`, ";
			$sql .= " `zmt`.`Zahlungsmittel_kurz`,  `zmt`.`Zahlungsmittel_id`,  ";
			$sql .= " `pkt`.`kat_name`,             `pkt`.`produktekategorieid`   ";
			$sql .= " FROM `verkauf` AS `vkf` ";
			$sql .= " LEFT JOIN `personen` 			      AS `psn` 	ON `vkf`.`verkaufkunde` 			    = `psn`.`kundenid` ";
			$sql .= " LEFT JOIN `BH_Journal` 			    AS `bhj`	ON `bhj`.`BH_Journal_verkauf_id` 	= `vkf`.`verkaufid` ";
			$sql .= " LEFT JOIN `produkte_kategorie` 	AS `pkt`	ON `bhj`.`BH_Journal_konto_haben` = `pkt`.`produktekategorie_BH_Konto` ";
			$sql .= " LEFT JOIN `Zahlungsmittel` 		  AS `zmt` 	ON `zmt`.`Zahlungsmittel_id` 		  = `vkf`.`verkaufzahlungsmittel` ";
			$sql .= " WHERE DATE(verkaufdatum)        BETWEEN :ST_DATE AND :END_DATE ";
			$sql .= " AND `psn`.`kundenid`=:KID ";
			return $sql;
		}
	}
