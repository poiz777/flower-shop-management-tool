<?php
	
	namespace App\Controller;
	
	use App\Entity\Ticketeintrag;
	use App\Entity\Tickets;
	use App\Entity\Verkauf;
	use App\Forms\TicketManagementEntity;
	use App\Forms\TicketPostEntity;
	use App\Helpers\Date\DateCalculator;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\HTML\Forms\TicketManagementForm;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
	
	class PrinterController extends AbstractController {
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
		 * PrinterController constructor.
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
		 * @Route("/mjr/api/v1/print/bill/{saleID}", name="rte_printer_print_bill")
		 *
		 * @param \Symfony\Component\HttpFoundation\Request                  $request
		 * @param null                                                       $saleID
		 *
		 * @return \Symfony\Component\HttpFoundation\JsonResponse
		 * @throws \Exception
		 */
		public function printBill(Request $request,  $saleID=null) {
			/**@var \App\Poiz\HTML\Widgets\Widget $widget */
			if(!($user = $this->getUser())){ return $this->redirectToRoute('app_login'); }
			$header             = $this->getDefaultHeader();
			$printableBillData  = $this->entityManager->getRepository(Verkauf::class)->fetchPrintableSalesData($saleID);
			$printableBillHTML  = $this->craftPrintableBillHTML($printableBillData);
			
			return new JsonResponse($printableBillHTML, 200, $header);
		}
		
		private function craftPrintableBillHTML($printableBillData){
			$salesDate          = $printableBillData['verkaufdatum'];
			$salesDate          = ($salesDate instanceof \DateTime) ? $salesDate->format("d.m.Y") : (new \DateTime($salesDate))->format("d.m.Y");
			$addressBlock       = $this->getClientAddressBlock($printableBillData['client']);
			$salesRows          = $this->getSalesRows($printableBillData['bhJournal']);
			$rayPaymentMethod   = (isset($printableBillData['paymentMethod']) && $printableBillData['paymentMethod']) ? $printableBillData['paymentMethod'] : null;
			$paymentMethod      = ($rayPaymentMethod) ? $rayPaymentMethod['Zahlungsmittel_name'] : null;
			$paymentMethod      = stristr($paymentMethod, 'bar ') ? 'Bargeld' : $paymentMethod;
			$printableBillHTML  =<<<PHTM
<div class="col-md-12 no-lr-pad pz-wrapper-main" id="pz-wrapper-main">
    <div class="pz-wrapper">
        <div id="Rechnung_detail" class="printable">
            <section class="bill-client-address-wrapper" id="bill-client-address-wrapper">
                <div id="Rechnung_layout" class="printable bill-client-address">
                    <div class="client-info-empty-left print-only"></div>
                    <div id="Empfaenger" class="client-info-right">
                        <div class="pz-client-address-block">
                        	{$addressBlock}
                        </div>
                    </div>
                </div>
                <div class="no-print"></div>
            </section>

            <div class="print-only printable" id="bill-number-date" style="clear:both; width:100%;margin-bottom:25px;">
                <article class="pz-recipient-slot pz-rcp-date" style="margin-bottom:15px;">
                    <span class="pz-bill-date"><strong>Bern</strong>, {$salesDate}</span>
                </article>
                <article class="pz-recipient-slot pz-rcp-bill-num"><strong class="pz-bill-num">Quittung</strong></article>
            </div>

            <div class="table-responsive">
                <table class="table-bordered table-striped table-condensed table table-hover printable strip-fa-icons-on-print" id="pz-bill-table" >
                    <thead>
	                    <tr>
	                        <th>Datum</th>
	                        <th>Kategorie</th>
	                        <th>Bezeichnung</th>
	                        <th class="w-15">Betrag</th>
	                    </tr>
                    </thead>
                    <tbody>
                    	{$salesRows['rows']}
	                    <tr>
	                        <td><strong>Total</strong></td>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
	                        <td><strong>CHF {$salesRows['total']}</strong></td>
	                    </tr>
                    </tbody>
                </table>
                <!-- Conditions: -->
                <div class="print-only printable" id="bill-conditions">Zahlungsmethode: {$paymentMethod}</div>
                <div class="print-only printable" id="bill-thank-you" style="margin-top:10px;">Betrag inkl. 2.5% MwSt. Mit bestem Dank für Ihren Einkauf.</div>
                <!-- Conditions: -->
            </div>
        </div>
</div>
</div>
PHTM;
			
			$pageTitle  = 'Quittung';
			return ['html' => $printableBillHTML, 'pageTitle' => $pageTitle];
		}
		
		private function getSalesRows($rayJournals){
			$rows   = '';
			$total  = 0;
			
			if($rayJournals){
				foreach($rayJournals as $journal){
					$total   += $journal['BH_Journal_betrag'];
					$jnDate   = $journal['BH_Journal_datum'];
					$jnDate   = ($jnDate instanceof \DateTime) ? $jnDate->format("d.m.Y") : (new \DateTime($jnDate))->format("d.m.Y");
					$tmpRow   = "<tr class='pz-clients-tbody-row'>" . PHP_EOL;
					$tmpRow  .= "<td>{$jnDate}</td>" . PHP_EOL;
					$tmpRow  .= "<td>{$journal['productCat']['kat_name']}</td>" . PHP_EOL;
					$tmpRow  .= "<td>{$journal['BH_Journal_kommentar']}</td>" . PHP_EOL;
					$tmpRow  .= "<td>CHF {$journal['BH_Journal_betrag']}</td>" . PHP_EOL;
					$tmpRow  .= "</tr>" . PHP_EOL;
					$rows    .= $tmpRow;
				}
			}
			
			return [
				'rows'  => $rows,
				'total' => $total,
			];
		}
		
		private function getClientAddressBlock($rayClientData){
			$rayMrMrs       = $rayClientData['mrMrs'];
			$clientAddress  = ($firm  = trim($rayClientData['Firma'])) ? "<article class='pz-company-name'><h3>{$firm}</h3></article>\n" : "";
			$clientAddress .= "<div class='pz-recipient-name'>\n";
			$clientAddress .= ($rayMrMrs && $mRs = trim($rayMrMrs['Geschlecht_praefix'])) ? "<article class='pz-recipient-slot pz-rcp-prefix'><span class='pz-salutation'>{$mRs}</span></article>\n"      : "";
			$clientAddress .= ($clientName = $this->getClientFullName($rayClientData))    ? "<article class='pz-recipient-slot pz-rcp-name'><span class='pz-full-name'>{$clientName}</span></article>\n"  : "";
			$clientAddress .= "</div>\n";
			$clientAddress .= ($address = $this->getClientAddress($rayClientData))     ? "<article class='pz-recipient-slot pz-rcp-address'><span class='pz-address'>{$address}</span></article>\n"       : "";
			$clientAddress .= ($zipCity = $this->getClientZipCity($rayClientData))     ? "<article class='pz-recipient-slot pz-rcp-zip-city'><span class='pz-zip-city'>{$zipCity}</span></article>\n"     : "";
			return ($rayClientData['kundenid'] == '43') ? '' : $clientAddress;
		}
		
		
		private function getClientAddress($rayClientData){
			$streetName = ( isset($rayClientData['Strasse'])        && trim($rayClientData['Strasse']) )        ? trim($rayClientData['Strasse'])         : "";
			$streetNum  = ( isset($rayClientData['Strassennummer']) && trim($rayClientData['Strassennummer']) ) ? trim($rayClientData['Strassennummer'])  : "";
			return trim($streetName . " " . $streetNum);
		}
		
		private function getClientZipCity($rayClientData){
			$zip    = ( isset($rayClientData['PLZ'])  && trim($rayClientData['PLZ']) )  ? trim($rayClientData['PLZ']) : "";
			$city   = ( isset($rayClientData['Ort'])  && trim($rayClientData['Ort']) )  ? trim($rayClientData['Ort']) : "";
			return trim($zip . " " . $city);
		}
		
		private function getClientFullName($rayClientData){
			$firstName  = ( isset($rayClientData['vorname'])  && trim($rayClientData['vorname']) )  ? trim($rayClientData['vorname']) : "";
			$lastName   = ( isset($rayClientData['name'])     && trim($rayClientData['name']) )     ? trim($rayClientData['name'])    : "";
			return trim($firstName . " " . $lastName);
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
