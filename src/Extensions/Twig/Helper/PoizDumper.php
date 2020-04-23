<?php
	
	namespace App\Extensions\Twig\Helper;

	use App\Controller\AdminController;
	use App\Entity\Personen;
	use App\Extensions\PoizTokenParser;
	use App\Helpers\Date\DateCalculator;
	use App\Helpers\Date\PzCalendar;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\Statics\ACLManager;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Carbon\Carbon;
	use Doctrine\DBAL\Connection;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
	use Symfony\Component\Security\Core\User\UserInterface;
	use tidy;
	use Twig\TwigFunction;
	use Twig\TwigFilter;
	
	class PoizDumper extends \Twig_Extension {


		/**
		 * @var \Twig_Environment
		 */
		protected $twigEnv;

		/**
		 * @var UrlGeneratorInterface
		 */
		protected $urlGenerator;
		
		/**
		 * @var Carbon
		 */
		protected $carbon;
		/**
		 * @var EntityManagerInterface
		 */
		protected $em;
		
		/**
		 * @var Connection
		 */
		protected $conn;
		
		/**
		 * @var SessionInterface
		 */
		protected $session;
		
		/**
		 * @var \App\Helpers\Date\PzCalendar
		 */
		protected $pzCal;
		
		/**
		 * #var UserInterface
		 */
		# protected $user;

		public function __construct(\Twig_Environment $twigEnv, UrlGeneratorInterface $urlGenerator, Carbon $carbon, EntityManagerInterface $em, SessionInterface $session, PzCalendar $pzCal){
			$this->em           = $em;
			$this->pzCal        = $pzCal;
			$this->session      = $session;
			$this->conn         = $this->em->getConnection();
			$this->carbon       = $carbon;
			$this->twigEnv      = $twigEnv;
			$this->urlGenerator = $urlGenerator;
			$this->twigEnv->addTokenParser(new PoizTokenParser());
		}

		/**
		 * @return array|\Twig_Filter[]
		 */
		public function getFilters() {
			return [
				new TwigFilter('float', [$this, 'float'], ['is_safe'=>['html']]),
				new TwigFilter('dateDiff4Humans', [$this, 'dateDiff4Humans'], ['is_safe'=>['html']]),
				new TwigFilter('html', [$this, 'html'], ['is_safe'=>['html']]),
				new TwigFilter('noHTML', [$this, 'noHTML'], ['is_safe'=>['html']]),
				new TwigFilter('decimal', [$this, 'decimal'], ['is_safe'=>['html']]),
				new TwigFilter('fullSwissDate', [$this, 'fullSwissDate'], ['is_safe'=>['html']]),
				new TwigFilter('percentage', [$this, 'percentage'], ['is_safe'=>['html']]),
				new TwigFilter('ucFirst', [$this, 'ucFirst'], ['is_safe'=>['html']]),
				new TwigFilter('toDepartmentString', [$this, 'toDepartmentString'], ['is_safe'=>['html']]),
				new TwigFilter('hourTime', [$this, 'hourTime'], ['is_safe'=>['html']]),
				new TwigFilter('ymd2dmy', [$this, 'ymd2dmy'], ['is_safe'=>['html']]),
				new TwigFilter('swissDate', [$this, 'swissDate'], ['is_safe'=>['html']]),
				new TwigFilter('hourMinute', [$this, 'hourMinute'], ['is_safe'=>['html']]),
				new TwigFilter('stripTimeNullSuffix', [$this, 'stripTimeNullSuffix'], ['is_safe'=>['html']]),
				new TwigFilter('stripATSymbol', [$this, 'stripATSymbolFromEmail'], ['is_safe'=>['html']]),
			];
		}

		/**
		 * @return array|\Twig_Function[]
		 */
		public function getFunctions() {
			return [
				new TwigFunction('size', [$this, 'size'], ['is_safe'=>['html']]),
				new TwigFunction('percentVal', [$this, 'percentVal'], ['is_safe'=>['html']]),
				new TwigFunction('getNavigationPayload', [$this, 'getNavigationPayload'], ['is_safe'=>['html']]),
				new TwigFunction('buildClientInfoBlock', [$this, 'buildClientInfoBlock'], ['is_safe'=>['html']]),
				new TwigFunction('get1MonthDiffTimeSlots', [$this, 'get1MonthDiffTimeSlots'], ['is_safe'=>['html']]),
				new TwigFunction('getTicketTargetClient', [$this, 'getTicketTargetClient'], ['is_safe'=>['html']]),
				new TwigFunction('createDayViewBar', [$this, 'createDayViewBar'], ['is_safe'=>['html']]),
				new TwigFunction('createWeekViewBar', [$this, 'createWeekViewBar'], ['is_safe'=>['html']]),
				new TwigFunction('getChartsData', [$this, 'getChartsData'], ['is_safe'=>['html']]),
				new TwigFunction('percentFromArraySum', [$this, 'percentFromArraySum'], ['is_safe'=>['html']]),
				new TwigFunction('isHiddenControl', [$this, 'isHiddenControl'], ['is_safe'=>['html']]),
				new TwigFunction('ticketTypeStringFromID', [$this, 'ticketTypeStringFromID'], ['is_safe'=>['html']]),
				new TwigFunction('billStatusStringFromID', [$this, 'billStatusStringFromID'], ['is_safe'=>['html']]),
				new TwigFunction('ticketStatusIDFromTitle', [$this, 'ticketStatusIDFromTitle'], ['is_safe'=>['html']]),
				new TwigFunction('ticketStatusStringFromID', [$this, 'ticketStatusStringFromID'], ['is_safe'=>['html']]),
				new TwigFunction('ticketPriorityStringFromID', [$this, 'ticketPriorityStringFromID'], ['is_safe'=>['html']]),
				new TwigFunction('renderRaw', [$this, 'renderRaw'], ['is_safe'=>['html']]),
				new TwigFunction('getPersonByID', [$this, 'getPersonByID'], ['is_safe'=>['html']]),
				new TwigFunction('currentCalendarDate', [$this, 'currentCalendarDate'], ['is_safe'=>['html']]),
				new TwigFunction('dateXDaysAgo', [$this, 'dateXDaysAgo'], ['is_safe'=>['html']]),
				new TwigFunction('getActualDate', [$this, 'getActualDate'], ['is_safe'=>['html']]),
				new TwigFunction('buildYearDropDownWidget', [$this, 'buildYearDropDownWidget'], ['is_safe'=>['html']]),
				new TwigFunction('getAddCalendarEventURIForTime', [$this, 'getAddCalendarEventURIForTime'], ['is_safe'=>['html']]),
				new TwigFunction('greet', [$this, 'greet'], ['is_safe'=>['html']]),
				new TwigFunction('userCanInteractWithPage', [$this, 'userCanInteractWithPage'], ['is_safe'=>['html']]),
				new TwigFunction('poiz_dump', [$this, 'dumpVars'], ['is_safe'=>['html']]),
				new TwigFunction('inRoutePath', [$this, 'inRoutePath'], ['is_safe'=>['html']]),
				new TwigFunction('redirect', [$this, 'redirect'], ['is_safe'=>['html']]),
				new TwigFunction('cleanHTML', [$this, 'cleanHTML'], ['is_safe'=>['html']]),
				new TwigFunction('pzIsString', [$this, 'pzIsString'], ['is_safe'=>['html']]),
				new TwigFunction('pzIsArray', [$this, 'pzIsArray'], ['is_safe'=>['html']]),
				new TwigFunction('pzIsObject', [$this, 'pzIsObject'], ['is_safe'=>['html']]),
				new TwigFunction('pzIsBoolean', [$this, 'pzIsBoolean'], ['is_safe'=>['html']]),
				new TwigFunction('p_dump', [$this, 'dumpVars'], ['is_safe'=>['html']]),
				new TwigFunction('pDump', [$this, 'dumpVars'], ['is_safe'=>['html']]),
				new TwigFunction('poizDump', [$this, 'dumpVars'], ['is_safe'=>['html']]),
				new TwigFunction('pzDump', [$this, 'dumpVars'], ['is_safe'=>['html'], 'needs_context' => true, 'needs_environment' => true]),
				new TwigFunction('buildRoute', [$this, 'buildRoute'], ['is_safe'=>['html']]),
				new TwigFunction('buildWidget', [$this, 'buildWidget'], ['is_safe'=>['html']]),
				new TwigFunction('buildPagination', [$this, 'buildPagination'], ['is_safe'=>['html']]),
				new TwigFunction('buildIppDropDown', [$this, 'buildIppDropDown'], ['is_safe'=>['html']]),
				new TwigFunction('buildPaginationCount', [$this, 'buildPaginationCount'], ['is_safe'=>['html']]),
				new TwigFunction('overRideArrayVal', [$this, 'overRideArrayVal'], ['is_safe'=>['html']]),
				new TwigFunction('exec', [$this, 'execClosure'], ['is_safe'=>['html']]),
				new TwigFunction('execClosure', [$this, 'execClosure'], ['is_safe'=>['html']]),
				new TwigFunction('php', [$this, 'executeArbitraryPHPCode'], ['is_safe'=>['html']]),
				new TwigFunction('runSQL', [$this, 'executeArbitrarySQLAgainstActiveDB'], ['is_safe'=>['html']]),
				new TwigFunction('sql', [$this, 'executeArbitrarySQLAgainstActiveDB'], ['is_safe'=>['html']]),
			];
		}

		public function useFilterNr1($str){
			return strtolower($str);
		}

		public function execClosure($closure, ...$data){
			$output = null;
			if($data) {
				try {
					$output = call_user_func_array($closure, $data);
				} catch ( \Exception $e ) {
					$output = $e->getMessage();
				}
			}else{
				$output = call_user_func_array($closure, []);
			}
			if ( is_array( $output ) || is_object( $output ) ) {
				$output = var_export( $output, true );
			}
			return $output;
		}

		public function executeArbitraryPHPCode($phpCodeAsString='var_dump(2)'){
			return eval($phpCodeAsString);
		}

		public function userCanInteractWithPage($user, $rayRoles=[]){
			/**@var \App\Entity\User $user */
			if(!$user) { return $this-> redirect('app_login', []); }
			if($user && $rayRoles){
				foreach ($user->getRoles() as $userRole){
					foreach($rayRoles as $requiredRole){
						if(strtoupper($requiredRole) == strtoupper($userRole)){
							return true;
						}
					}
				}
			}
			return false;
		}

		public function stripATSymbolFromEmail($roles){
		
		}
		
		public function dumpVars(\Twig_Environment $env, $context, ...$vars){  #public function dumpVars($data){
			if (!$this->twigEnv->isDebug()) {
				return;
			}

			ob_start();

			if (!$vars) {
				$vars = array();
				foreach ($context as $key => $value) {
					if (!$value instanceof \Twig_Template) {
						$vars[$key] = $value;
					}
				}

				dump($vars);
			} else {
				dump(...$vars);
			}
			return ob_get_clean();
		}

		public function buildRoute($routeName, $params=['_locale'=>'en']){
			/** @var UrlGeneratorInterface $urlGenerator */
			return $this->urlGenerator->generate($routeName, $params);
		}

		public function buildWidget($inputOptions, $valStrategy, $value, $name, $entityClass, $useLabel){
			$config = [
				'inputOptions'        => $inputOptions,
				'validationStrategy'  => $valStrategy,
				'name'                => $name,
				'class'               => 'form-control pz-form-widget',
				'value'               => $value,
				'entityClass'         => $entityClass,
				'addLabel'            => $useLabel,
				];
			/**@var \App\Poiz\HTML\Widgets\Widget $widget */
			$widgetClassName = "App\\Poiz\HTML\\Widgets\\FormElements\\{$config['entityClass']}";
			$config['entityClass'] = $widgetClassName;
			$rayInputOptions = [];
			if($inputOptions){
				foreach ($inputOptions as $inputOption){
					if(in_array($inputOption->getKundenid(), ['2621', '942'])) { continue; }
					$rayInputOptions[$inputOption->getKundenid()] = $inputOption->getName();
				}
				$config['inputOptions'] = $rayInputOptions;
			}
			
			if(!class_exists($widgetClassName)){ return null;}
			$widget = new $widgetClassName($config, $config['inputOptions']);
			return $widget->render();
		}

		public function getActualDate(){
			return isset($_GET['year']) ? trim($_GET['year']) : date('Y', time());
		}


		public function currentCalendarDate($swissFormat=false){
			$year   = isset($_GET['year'])  ? trim($_GET['year'])   : date('Y', time());
			$month  = isset($_GET['month']) ? trim($_GET['month'])  : date('m', time());
			$day    = isset($_GET['day'])   ? trim($_GET['day'])    : date('d', time());
			$ymd    = trim($year) . "-" .trim($month) . "-" .trim($day);

			return $swissFormat ? date("d.m.Y", strtotime($ymd)) : $ymd;
		}

		public function dateXDaysAgo($numDays=365, $swissFormat=false){
			$cDate    = Carbon::today('Europe/Zurich');
			$xDaysAgo = $cDate->addDays(-1*$numDays);
			return $swissFormat ? $xDaysAgo->format("d.m.Y") : $xDaysAgo->format("Y-m-d");
		}

		public function buildYearDropDownWidget($minYear=2008, $maxYear= 2099){
			$inputOptions = array_reverse(range($minYear, $maxYear), false);
			$currentYear  = isset($_GET['year']) ? $_GET['year'] : date('Y', time());
			$config       = [
				'inputOptions'        => $inputOptions,
				'value'               => $currentYear,
				'validationStrategy'  => 'NUM',
				'name'                => 'year',
				'class'               => 'form-control pz-form-widget',
				'entityClass'         => 'DropDownEnhanced',
				'addLabel'            => 0,
				];
			/**@var \App\Poiz\HTML\Widgets\Widget $widget */
			$widgetClassName = "App\\Poiz\HTML\\Widgets\\FormElements\\{$config['entityClass']}";
			$config['entityClass']  = $widgetClassName;
			$rayInputOptions        = [];
			if($inputOptions){
				foreach ($inputOptions as $inputOption){
					$rayInputOptions[$inputOption] = (string)$inputOption;
				}
				$config['inputOptions'] = $rayInputOptions;
			}
			
			if(!class_exists($widgetClassName)){ return null;}
			$widget = new $widgetClassName($config, $config['inputOptions']);
			return $widget->render();
		}

		public function buildPaginationCount($ipp, $totalCount){
			$melSessionObj = $this->session->get(RequestBridge::SessionNameSpace);
			$ipp      = $melSessionObj['ipp'] ?$melSessionObj['ipp'] : AdminController::IPP_DEFAULT ;
			$showing        = "1 bis {$ipp} von {$totalCount} ";
			$currentPageNum = isset($_GET['page']) && $_GET['page']  ? $_GET['page']  : 1 ;
			if($currentPageNum > 1){
				$showStart    = ($ipp * ($currentPageNum - 1))+1;
				$showStop     = ($val = ($showStart + $ipp -1)) > $totalCount ? $totalCount : $val;
				$showing      =  "{$showStart} bis {$showStop} von {$totalCount} ";
			}
			return "<header style='justify-self:left;'>Anzeige: {$showing}</header>";
			
		}

		public function buildIppDropDown($ipp, $gap=10, $startNum=10, $maxNum=100){
			$melSessionObj = $this->session->get(RequestBridge::SessionNameSpace);
			$ipp      = $melSessionObj['ipp'] ?$melSessionObj['ipp'] : AdminController::IPP_DEFAULT ;
			$dropDown = "<header style='justify-self:left;'>";
			$dropDown.= "<aside style='justify-self:left;'>Anzeige pro Seite:</aside>";
			$dropDown.= "<select style='justify-self:left;' class='form-control' id='' name='' data-change-url='&ipp={$ipp}'>";
			for($cnt=$startNum; $cnt<=$maxNum; $cnt+=$gap){
				$selected = $cnt == $ipp ? "selected='selected'" : "";
				$dropDown.= "<option value='{$cnt}' {$selected}>{$cnt}</option>";
			}
			$dropDown .= "</select></header>";
			return $dropDown;
		}

		public function buildPagination($ipp, $totalCount, $currentPageNum, $maxCells=14, $urlPrefix=''){
			$melSessionObj  = $this->session->get(RequestBridge::SessionNameSpace);
			$ipp            = $melSessionObj['ipp'] ?$melSessionObj['ipp'] : AdminController::IPP_DEFAULT ;
			$currentPageNum = (isset($melSessionObj['page']) && $melSessionObj['page']) ? $melSessionObj['page'] : (isset( $_GET['page']) ?  $_GET['page']: AdminController::DEFAULT_PAGE_NUM);
			$totalPages4Ipp = intval($totalCount/$ipp) +  ($totalCount%$ipp != 0 ? 1 : 0);
			# SHOW FIRST $maxCells PAGES

			$pullBackNum    = ($currentPageNum-$maxCells) > 0 ? ($currentPageNum-$maxCells) : 1;
			$pagination     = "";
			$pagination    .= $pullBackNum > 0 ?  "<a class='pz-prev-link' href='{$urlPrefix}?page=" . $pullBackNum . "&ipp={$ipp}'>" : " <span class='pz-prev-link'>";
			$pagination    .= "<span class='pz-nav-prev fa fa-chevron-left' ></span>";
			$pagination    .= $pullBackNum > 0 ?  "</a>" : "</span>";
			$startPos       = ($currentPageNum >=$maxCells) ? (intval($currentPageNum / $maxCells) * $maxCells ) : 1;  //  ($currentPageNum-1) * $ipp;

			for($loopKey = $startPos; $loopKey <=  ($startPos+$maxCells-1); $loopKey++){
				if($loopKey>= $totalPages4Ipp){break;}
				$activeClass = 'pz-pagination-link';
				if($currentPageNum == $loopKey){
					$activeClass .= ' active pz-active';
				}
				$pagination  .= "<a class='{$activeClass}' href='{$urlPrefix}?page=" . ($loopKey)  . "&ipp={$ipp}'>" . ($loopKey)  . "</a>";
			}
			if($loopKey < $totalPages4Ipp){
				$pagination  .= "<span class='muted pz-ellipses' >...</span>";
				$pagination  .= "";
				$pagination  .= "<a class='pz-next-link' href='{$urlPrefix}?page=" . ($loopKey)  . "&ipp={$ipp}'><span class='pz-nav-next fa fa-chevron-right' ></span></a>";
			}
			return $pagination;
		}

		public function cleanHTML($html){
			// Tidy
			$config = array(
				'indent'         => true,
				'input-xml'     => true,
				'output-xml'   => true,
				'wrap'           => 200);
			$tidy = new tidy;
			$tidy->parseString($html, $config, 'utf8');
			$tidy->cleanRepair();
			return $tidy;
		}

		public function inRoutePath($url1, $url2){
			if(!$url1) return false ;
			return stristr($url2, $url1);
		}

		public function pzIsString($stringVal){
			return is_string($stringVal);
		}

		public function pzIsArray($data){
			return is_array($data);
		}

		public function pzIsObject($data){
			return is_object($data);
		}

		public function pzIsBoolean($data){
			return is_bool($data);
		}

		public function overRideArrayVal($array, $keyValPairs=[]){
			foreach($keyValPairs as $key=>$val){
				if(array_key_exists($key, $array)){
					$array[$key]    = $val;
				}
			}
			return $array;
		}
		
		public function dateDiff4Humans($strDateOrDateTimeObj){
			$strDate    = $strDateOrDateTimeObj;
			if($strDateOrDateTimeObj instanceof \DateTime){
				$strDate= $strDateOrDateTimeObj->format("Y-m-d H:i:s");
			}
			$date       = $this->carbon::parse($strDate);   //->locale('de_CH');
			return $date->diffForHumans();
		}
		
		public function ucFirst($string){
			return ucfirst($string);
		}
		
		public function float($number){
			return  floatval($number);
		}
		
		public function decimal($number, $places){
			return sprintf("%.{$places}f", $number);
		}
		
		public function percentage($amount, $percent=10){
			$pct = round($percent*$amount/100, 2, PHP_ROUND_HALF_UP);
			return $pct;
		}
		
		public function percentVal($amount, $percent=10){
			$pct = round($percent*$amount/100, 2, PHP_ROUND_HALF_UP);
			return $pct;
		}
		public function percentFromArraySum($arrayData, $value, $key='total'){
			$sum = 0; $places = 2;
			if(is_array($arrayData) && $arrayData){
				foreach($arrayData as $data){
					$sum  += $data[$key];
				}
			}
			$percentage =  ($value / $sum) * 100;
			return sprintf("%.{$places}f", $percentage) . "%";
		}
		
		public function getChartsData($payload){
			$poll       = [];
			$loopKey    = 0;
			$chartsData = ['data' => [],];
			if(is_array($payload) && $payload){
				foreach($payload as $data){
					$poll[$data['category']] = str_replace("%", "", $this->percentFromArraySum($payload, $data['total']));
				}
				uasort($poll, function($a, $b){ return $b > $a; });
			}
			foreach($poll as $title=>$percentage){
				$chartsData['data'][] = [
					'name'      => $title,
					'y'         => floatval($percentage),
				];
				if($loopKey === 0){
					$chartsData['data'][$loopKey]['sliced'] = true;
					$chartsData['data'][$loopKey]['selected'] = true;
				}
				$loopKey++;
			}
			return json_encode($chartsData);
		}
		
		public function toDepartmentString($id){
			$entity   = $this->em->getRepository(Personen::class)->find($id);
			return ($entity) ? $entity->name : "";
		}
		
		public function renderRaw($rawHTML=''){
			return html_entity_decode( htmlspecialchars_decode($rawHTML));
			
		}
		
		public function isHiddenControl($formHTML=''){
			return preg_match("#type[= ]*?['\"]hidden#", $formHTML);
			
		}
		
		public function billStatusStringFromID($id){
			$statusMap  = [
				'1'  => 'in Bearbeitung',
				'2'  => 'offen',
				'5'  => 'Mahnung',
				'10' => 'beendet',
			];
			return isset($statusMap[$id]) ? $statusMap[$id] : null;
		}
		
		public function ticketPriorityStringFromID($id){
			$priorityMap  = [
				'1'  => 'niedrig',
				'2'  => 'mittel',
				'3'  => 'hoch',
			];
			return isset($priorityMap[$id]) ? $priorityMap[$id] : null;
		}
		
		public function ticketTypeStringFromID($id){
			$priorityMap  = [
				'1'  => 'Auftrag',
				'2'  => 'Admin',
				'3'  => 'Marketing',
				'4'  => 'Einkauf',
			];
			return isset($priorityMap[$id]) ? $priorityMap[$id] : null;
		}
		
		public function ticketStatusStringFromID($id){
			$statusMap  = [
				'1'  => 'eröffnet',
				'2'  => 'eröffnet', // 'in Bearbeitung',
				'3'  => 'beendet',
				'4'  => 'bereit',
			];
			return isset($statusMap[$id]) ? $statusMap[$id] : null;
		}
		
		public function ticketStatusIDFromTitle($title){
			$title      = strtolower($title);
			$statusMap  = [
				'eröffnet'        => '1',
				'eroeffnet'       => '1',
				'in Bearbeitung'  => '2',
				'beendet'         => '3',
				'bereit'          => '4',
			];
			return isset($statusMap[$title]) ? $statusMap[$title] : null;
		}
		
		public function createDayViewBar($heading='Tagesansicht') {
			$currentDay   = isset($_GET['day'])   ? str_pad($_GET['day'],  1, "0", STR_PAD_LEFT) : date("d");
			$currentMonth = isset($_GET['month']) ? str_pad($_GET['month'],1, "0", STR_PAD_LEFT) : date("m");
			$currentYear  = isset($_GET['year'])  ? $_GET['year']  : date("Y");
			$dateString   = "{$currentYear}-{$currentMonth}-{$currentDay}";
			$currentDate  = $this->currentCalendarDate(true);
			
			$activeDate   = Carbon::parse($dateString, 'Europe/Zurich');
			$tomorrow     = clone $activeDate; $tomorrow  = $tomorrow->addDays(1);
			$yesterday    = clone $activeDate; $yesterday = $yesterday->addDays(-1);
			
			$dayLabels      = [ "So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"];
			$baseURL        = htmlentities( preg_replace("#[\?\&].+$#", "", $_SERVER['REQUEST_URI']) ) . "/";
			$tipToday       = $dayLabels[(int)$activeDate->dayOfWeek]       .   "; {$activeDate->format('d.m.Y')}";
			$tipYesterday   = $dayLabels[(int)$yesterday->dayOfWeek]        .   "; {$yesterday->format('d.m.Y')}";
			$tipTomorrow    = $dayLabels[(int)$tomorrow->dayOfWeek]         .   "; {$tomorrow->format('d.m.Y')}";
			
			return <<<VBAR
<h5 class="pz-sub-page-heading">
	<a class="prev pull-left" href="{$baseURL}?day={$yesterday->format('d')}&month={$yesterday->format('m')}&year={$yesterday->format('Y')}&week={$yesterday->format('W')}"><span class="fa fa-chevron-left" style="color:#FFFFFF;" data-tip="{$tipYesterday}"></span></a>
	<span class="title" data-tip="{$tipToday}">{$heading}: {$currentDate}</span>
	<a class="next pull-right" href="{$baseURL}?day={$tomorrow->format('d')}&month={$tomorrow->format('m')}&year={$tomorrow->format('Y')}&week={$tomorrow->format('W')}"><span class="fa fa-chevron-right" style="color:#FFFFFF;" data-tip="{$tipTomorrow}"></span></a>
</h5>
VBAR;
		}
		
		public function createWeekViewBar($heading='Wochenansicht') {
			$currentYear        = isset($_GET['year'])  ? $_GET['year']   : date('Y');
			$currentWeek        = isset($_GET['week'])  ? $_GET['week']   : date('W');
			$currentMonth       = isset($_GET['month']) ? $_GET['month']  : date('m');
			$prevWeekURI        = $this->pzCal->getPrevOrNextWeekURL($currentMonth, $currentYear, $currentWeek, true );
			$nextWeekURI        = $this->pzCal->getPrevOrNextWeekURL($currentMonth, $currentYear, $currentWeek, false );
			
			$tipLastWeek        = "Wo " . preg_replace("#(^.*&week=)#", "", $prevWeekURI);
			$tipNextWeek        = "Wo " . preg_replace("#(^.*&week=)#", "", $nextWeekURI);
			
			return <<<VBAR
<h5 class="pz-sub-page-heading">
	<a class="prev pull-left" href="{$prevWeekURI}"><span class="fa fa-chevron-left" style="color:#FFFFFF;" data-tip="{$tipLastWeek}"></span></a>
	<span class="title" data-tip="Wo {$currentWeek}">{$heading} &nbsp; -- &nbsp; Wo {$currentWeek}</span>
	<a class="next pull-right" href="{$nextWeekURI}"><span class="fa fa-chevron-right" style="color:#FFFFFF;" data-tip="{$tipNextWeek}"></span></a>
</h5>
VBAR;
		}
		
		public function size($countAble, $singular='Item', $plural='Items'){
			if( ($cnt = sizeof($countAble)) ){
				return $cnt == 1 ? "$cnt {$singular}" :  "$cnt {$plural}";
			}
			return null;
		}
		
		public function getPersonByID($personID, $fullName=false, $abbr=false){
			
			return DateCalculator::getCoWorkerNameByID($personID, $fullName);
		}
		
		public function html($HTMLString){
			return html_entity_decode($HTMLString);
		}
		
		public function noHTML($HTMLString){
			return strip_tags($this->br2NL($this->html($HTMLString), ' '));
		}
		
		
		private function br2NL($string, $replacement='\n'){
			return preg_replace("#<br ?\/?>#", $replacement, $string);
		}
		
		public function stripTimeNullSuffix($string){
			return preg_replace("#\:\d{2}$#", "", $string);
		}
		
		public function getNavigationPayload(){
			return AdminControllerHelperTrait::fetchNavigationPayload();
		}
		
		public function getAddCalendarEventURIForTime($hour){
			$qString  = $_GET;
			$time     = $hour . ":00";
			$rURL     = $_SERVER["REQUEST_URI"];
			$bName    = rtrim( preg_replace("#[\?\&].+$#", "", $rURL), "/" ); // . "/";
			
			$qString['cal_event']  = true;
			$qString['cal_event_Time'] = $time;
			$retVal   = $this->keyValueArrayToQueryString($qString);
			
			// CONSIDER USING AJAX FOR ADDING EVENTS TO THE CALENDAR
			return $bName . $retVal;
		}
		
		private function keyValueArrayToQueryString($kvArray){
			$qString = '?';
			foreach ($kvArray as $key=>$value){
				$qString .= "{$key}={$value}&";
			}
			return substr($qString, 0, (strlen($qString)-1));
		}
		
		public function greet(){
			$greeting = "";
			if (date('H') < 13) $greeting = "Guten Morgen";
			if (date('H')  > 12 AND date('H') < 18) $greeting = "Guten Tag";
			if (date('H') > 17) $greeting = "Guten Abend";
			return $greeting;
		}
		
		public function redirect($route, $params=[], $status=302){
			ob_start();
			$url = $this->buildRoute($route, $params);
			ob_get_flush();
			return new RedirectResponse($url, $status);
		}
		
		public function hourTime($string){
			return preg_replace("#^(\d{1,2})(\:.+)$#", "$1", $string);
		}
		
		public function swissDate($dateString){
			return (new \DateTime($dateString))->format('d.m.Y');
		}
		
		public function fullSwissDate($objDateTime){
			$objDateTime  = ($objDateTime instanceof \DateTime)  ? $objDateTime :  new \DateTime($objDateTime);
			$rayYMD       = [
				'Y'=>$objDateTime->format('Y'),
				'M'=>$objDateTime->format('m'),
				'D'=>$objDateTime->format('d'),
			];
			$carbonDate   = Carbon::now('Europe/Zurich')->locale('de_DE');
			$carbonDate->setDate($rayYMD['Y'], $rayYMD['M'], $rayYMD['D']);
			# $fm = $carbonDate->isoFormat('DD. MMMM YYYY');
			return $carbonDate->isoFormat('Do MMMM YYYY');
		}
		
		public function ymd2dmy($ymd){
			return (new \DateTime($ymd))->format("d.m.y");
		}
		
		public function buildClientInfoBlock($rayClientData, $limitLength=25){
			return DateCalculator::buildClientInfoBlock($rayClientData, $limitLength);
		}
		
		public function getTicketTargetClient($clientData, $limitLength=0, $entityToArray=0){
			if($entityToArray && !is_array($clientData)){
				$clientData = $clientData->toArray();
			}
			$clientName = DateCalculator::getStreamlinedCustomerName($clientData, $limitLength);
			return $clientName;
		}
		
		public function get1MonthDiffTimeSlots(){
			$now          = Carbon::today('Europe/Zurich');
			$oneMonthAgo  = clone $now;
			$oneMonthAgo  = $oneMonthAgo->addMonths(-1);
			return ['start' => $oneMonthAgo->format('Y-m-d'), 'stop' => $now->format('Y-m-d')];
		}
		
		public function hourMinute($string){
			return preg_replace("#^(\d{1,2})(\:\d{1,2})(\:.+)$#", "$1$2", $string);
		}
		
		public function userCan(UserInterface $user, $performableAction='READ_KNOWLEDGE_BASE'){
			return ACLManager::canUser($performableAction, $user);
		}
		
		public function userIsLoggedIin(UserInterface $user){
			return !!$user;
		}
		
		/**
		 * @param       $sql
		 * @param array $socRayParams   ASSOCIATIVE ARRAY OF KEY-VALUE PAIRS TO BE FED INTO THE PREPARED SQL
		 * @param int   $returnType     1 => ARRAY OF OBJECTS, 2 => ARRAY OF ASSOCIATIVE ARRAYS, 3 => SINGLE OBJECT, 4 => SINGLE ASSOC. ARRAY, 5 => SINGLE VALUE AS STRING, 6 => SINGLE VALUE AS INT
		 *
		 * @throws \Doctrine\DBAL\DBALException
		 * @return mixed
		 */
		public function executeArbitrarySQLAgainstActiveDB($sql, $socRayParams=[], $returnType=1){
			$dataMap    = [
				1 => \PDO::FETCH_OBJ,
				2 => \PDO::FETCH_ASSOC,
				3 => \PDO::FETCH_OBJ,
				4 => \PDO::FETCH_ASSOC,
				5 => \PDO::FETCH_COLUMN,
				6 => \PDO::FETCH_NUM,
				
			];
			$statement  = $this->conn->prepare($sql);
			$statement->execute($socRayParams);
			if(in_array($returnType, [1, 2])){
				$result = $statement->fetchAll($dataMap[$returnType]);
			}elseif (in_array($returnType, [3, 4, 6])){
				$result = $statement->fetch($dataMap[$returnType]);
			}elseif ($returnType == 5){
				$result = $statement->fetchColumn();
			}else{
				$result = $statement->fetchAll($dataMap[$returnType]);
			}
			return $result;
		}
		
		private function germanMonthShort( $month ) {
			$monthNames = [
				"Jan",  "Feb",  "M&auml;r", "Apr",
				"Mai",  "Jun",  "Jul",      "Aug",
				"Sep",  "Okt",  "Nov",      "Dez",
			];
			return$monthNames[ $month-1 ];
		}
		
	}
