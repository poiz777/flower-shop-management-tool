<?php
	
	
	namespace App\Helpers\Date;
	
	use App\Forms\TicketArchiveEntity;
	use Carbon\Carbon;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
	
	setlocale(LC_ALL, 'nld_nld');
	$loc_de = setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'deu_deu');
	
	class PzCalendar {
		/********************* PROPERTY ********************/
		private $dayLabels      = [ "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun" ];
		private $monthLabels    = ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N','D'];
		private $currentYear    = 0;
		private $currentMonth   = 0;
		private $currentDay     = 0;
		private $currentWeek    = 0;
		private $currentDate    = null;
		private $daysInMonth    = 0;
		private $naviHref       = null;
		
		/**
		 * @var SessionInterface
		 */
		private $session;
		
		/**
		 * @var UrlGeneratorInterface
		 */
		private $urlGenerator;
		
		
		/**
		 * Constructor
		 *
		 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
		 */
		public function __construct(SessionInterface $session, UrlGeneratorInterface $urlGenerator) {
			$this->session      = $session;
			$this->urlGenerator = $urlGenerator;
			$this->naviHref     = htmlentities( preg_replace("#[\?\&].+$#", "", $_SERVER['REQUEST_URI']) ) . "/";
		}
		
		/********************* PUBLIC **********************/
		
		/**
		 * print out the calendar
		 */
		public function show(array $resultSet=[], $tickets4Now=[]) {
			$year   = null;
			$month  = null;
			
			if ( null == $year && isset( $_GET['year'] ) ) {
				$year = $_GET['year'];
			} else if ( null == $year ) {
				$year = date( "Y", time() );
			}
			
			if ( null == $month && isset( $_GET['month'] ) ) {
				$month = $_GET['month'];
			} else if ( null == $month ) {
				$month = date( "m", time() );
			}
			$this->currentYear  = $year;
		
			$this->currentMonth = $month;
			
			
			$sessionData        = $this->session->get(RequestBridge::SessionNameSpace);
			$this->currentYear  = $sessionData['year'];
			$this->currentMonth = $sessionData['month'];
			
			$this->daysInMonth = $this->_daysInMonth( $this->currentMonth, $this->currentYear );
			
			$content = '<div id="calendar">' .
			           '<div class="box">' .
			           $this->_createNavi() .
			           '</div>' .
			           '<div class="box-content">' .
			           '<ul class="label">' . $this->_createLabels() . '</ul>';
			$content .= '<div class="clear"></div>';
			$content .= '<ul class="dates">';
			
			$weeksInMonth = $this->_weeksInMonth( $this->currentMonth, $this->currentYear );
			// Create weeks in a month
			for ( $i = 0; $i < $weeksInMonth; $i ++ ) {
				//Create days in a week
				for ( $j = 1; $j <= 7; $j ++ ) {
					$content .= $this->_showDay( ($i * 7 + $j), $resultSet, $tickets4Now );
				}
			}
			
			$content .= '</ul>';
			$content .= '<div class="clear"></div>';
			
			$content .= '</div>';
			
			$content .= '</div>';
			
			return $content;
		}
		
		/********************* PRIVATE **********************/
		/**
		 * create the li element for ul
		 */
		private function _showDay( $cellNumber, $resultSet=[], $tickets4Now=[] ) {
			$activeClass = '';
			$priorityCssClass = "";
			$hasEvent     = '';
			
			$currentDay  = $this->session->get(RequestBridge::SessionNameSpace)['day'];
			$department  = $this->session->get(RequestBridge::SessionNameSpace, ['department'=>null])['department'];
			
			if ( $this->currentDay == 0 ) {
				$firstDayOfTheWeek = date( 'N', strtotime( $this->currentYear . '-' . $this->currentMonth . '-01' ) );
				
				if ( intval( $cellNumber ) == intval( $firstDayOfTheWeek ) ) {
					$this->currentDay = 1;
				}
			}
			
			if ( ( $this->currentDay != 0 ) && ( $this->currentDay <= $this->daysInMonth ) ) {
				
				$this->currentDate = date( 'Y-m-d', strtotime( $this->currentYear . '-' . $this->currentMonth . '-' . ( $this->currentDay ) ) );
				$activeClass  = $this->getCurrentDay() == $currentDay ? 'active pz-active-date' : $activeClass;
				if(isset($_REQUEST['day'])){
					$activeClass  = ($this->getCurrentDay() == $currentDay) ? 'active pz-active-date' : '';
					$activeClass  = ($this->getCurrentDay() == date('d') && !$_REQUEST['day']) ? 'active pz-active-date' : $activeClass;
				}
				$ticketsCount4CurrentDate = $this->getTicketsCountForActiveDate($this->currentDay, $this->currentMonth, $this->currentYear, $department);
				if ($ticketsCount4CurrentDate == 1) $priorityCssClass = 'pz-priority-low has-event';
				if ($ticketsCount4CurrentDate > 1 && $ticketsCount4CurrentDate <= 2) $priorityCssClass = 'pz-priority-yellow has-event';
				if ($ticketsCount4CurrentDate  > 2 && $ticketsCount4CurrentDate >= 4) $priorityCssClass = 'pz-priority-orange has-event';
				if ($ticketsCount4CurrentDate > 4) $priorityCssClass = 'pz-priority-red has-event';
				
				/*
				if($resultSet){
					foreach($resultSet as $iKey=>$ticket){
						# if(intval($ticketsCount4CurrentDate)) dump($ticketsCount4CurrentDate);
						if( intval($ticketsCount4CurrentDate) && (new \DateTime($ticket['ticket_endtermin']))->format('d') == $this->currentDay){
							$hasEvent   = 'has-event';
							break;
						}
					}
				}
				*/
				$this->currentWeek  = date("W", strtotime("{$this->currentYear}-{$this->currentMonth}-{$this->currentDay}"));
				$cellContent = "<a class='{$activeClass} {$priorityCssClass}' href='?year={$this->currentYear}&month={$this->currentMonth}&day={$this->currentDay}&week={$this->currentWeek}'>{$this->currentDay}</a>";
				
				$this->currentDay ++;
				
			} else {
				
				$this->currentDate = null;
				
				$cellContent = null;
			}
			
			$className='pz-cell';
			if( $cellNumber % 7 == 1 ){
				$className='start week-start';
			}else if($cellNumber % 7 == 0){
				$className='end week-end';
			}
			
			if(!$cellContent){
				$className ='mask pz-empty';
			}
			/*
			return '<li id="li-' . $this->currentDate . '" class="' . ( $cellNumber % 7 == 1 ? ' start ' : ( $cellNumber % 7 == 0 ? ' end ' : ' ' ) ) .
			       ( $cellContent == null ? 'mask' : '' ) . '">' . $cellContent . '</li>';
			*/
			
			return '<li id="li-' . $this->currentDate . '" class="' . $className . ' ' . $activeClass  . ' ' . $priorityCssClass . '">' . $cellContent . '</li>';
		}
		
		/**
		 * create navigation
		 */
		private function _createNavi() {
			$currentDay   = isset($_GET['day'])   ? str_pad($_GET['day'],  1, "0", STR_PAD_LEFT) : date("d");
			$currentMonth = isset($_GET['month']) ? str_pad($_GET['month'],1, "0", STR_PAD_LEFT) : date("m");
			$currentYear  = isset($_GET['year'])  ? $_GET['year']  : date("Y");
			$dateString   = "{$currentYear}-{$currentMonth}-{$currentDay}";
			
			$activeDate   = Carbon::parse($dateString, 'Europe/Zurich');
			$tomorrow     = clone $activeDate; $tomorrow  = $tomorrow->addDays(1);
			$yesterday    = clone $activeDate; $yesterday = $yesterday->addDays(-1);
			
			$dayLabels      = [ "So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"];
			$overheadTitle  = $this->germanMonthShort((int)$currentMonth)   .   ". {$activeDate->format('Y')}";
			$tipToday       = $dayLabels[(int)$activeDate->dayOfWeek]       .   "; {$activeDate->format('d.m.Y')}";
			$tipYesterday   = $dayLabels[(int)$yesterday->dayOfWeek]        .   "; {$yesterday->format('d.m.Y')}";
			$tipTomorrow    = $dayLabels[(int)$tomorrow->dayOfWeek]         .   "; {$tomorrow->format('d.m.Y')}";
			
			return <<<NAV
<div class="header">
	<a class="prev" href="{$this->naviHref}?day={$yesterday->format('d')}&month={$yesterday->format('m')}&year={$yesterday->format('Y')}&week={$yesterday->format('W')}"><span class="fa fa-chevron-left" data-tip="{$tipYesterday}"></span></a>
	<span class="title" data-tip="{$tipToday}">{$overheadTitle}</span>
	<a class="next" href="{$this->naviHref}?day={$tomorrow->format('d')}&month={$tomorrow->format('m')}&year={$tomorrow->format('Y')}&week={$tomorrow->format('W')}"><span class="fa fa-chevron-right" data-tip="{$tipTomorrow}"></span></a>
</div>
NAV;
		}
		
		/**
		 * create calendar week labels
		 */
		private function _createLabels() {
			
			$content = '';
			
			foreach ( $this->dayLabels as $index => $label ) {
				
				$content .= '<li class="' . ( $label == 6 ? 'end title' : 'start title' ) . ' title">' . $label . '</li>';
				
			}
			
			return $content;
		}
		
		/**
		 * calculate number of weeks in a particular month
		 */
		private function _weeksInMonth( $month = null, $year = null ) {
			
			if ( null == ( $year ) ) {
				$year = date( "Y", time() );
			}
			
			if ( null == ( $month ) ) {
				$month = date( "m", time() );
			}
			
			// find number of days in this month
			$daysInMonths = $this->_daysInMonth( $month, $year );
			
			$numOfweeks = ( $daysInMonths % 7 == 0 ? 0 : 1 ) + intval( $daysInMonths / 7 );
			
			$monthEndingDay = date( 'N', strtotime( $year . '-' . $month . '-' . $daysInMonths ) );
			
			$monthStartDay = date( 'N', strtotime( $year . '-' . $month . '-01' ) );
			
			if ( $monthEndingDay < $monthStartDay ) {
				
				$numOfweeks ++;
				
			}
			
			return $numOfweeks;
		}
		
		/**
		 * calculate number of days in a particular month
		 */
		private function _daysInMonth( $month = null, $year = null ) {
			
			if ( null == ( $year ) ) {
				$year = date( "Y", time() );
			}
			
			if ( null == ( $month ) ) {
				$month = date( "m", time() );
			}
			
			return date( 't', strtotime( $year . '-' . $month . '-01' ) );
		}
		
		
		
		
		/**
		 * @return array
		 */
		public function getDayLabels(): array {
			return $this->dayLabels;
		}
		
		/**
		 * @return int
		 */
		public function getCurrentYear(): int {
			return $this->currentYear;
		}
		
		/**
		 * @return int
		 */
		public function getCurrentMonth(): int {
			return $this->currentMonth;
		}
		
		/**
		 * @return int
		 */
		public function getCurrentDay(): int {
			return $this->currentDay;
		}
		
		/**
		 * @return null
		 */
		public function getCurrentDate() {
			return $this->currentDate;
		}
		
		/**
		 * @return int
		 */
		public function getDaysInMonth(): int {
			return $this->daysInMonth;
		}
		
		/**
		 * @return string|null
		 */
		public function getNaviHref(): ?string {
			return $this->naviHref;
		}
		
		/**
		 * @param array $dayLabels
		 *
		 * @return PzCalendar
		 */
		public function setDayLabels( array $dayLabels ): PzCalendar {
			$this->dayLabels = $dayLabels;
			
			return $this;
		}
		
		/**
		 * @param int $currentYear
		 *
		 * @return PzCalendar
		 */
		public function setCurrentYear( int $currentYear ): PzCalendar {
			$this->currentYear = $currentYear;
			
			return $this;
		}
		
		/**
		 * @param int $currentMonth
		 *
		 * @return PzCalendar
		 */
		public function setCurrentMonth( int $currentMonth ): PzCalendar {
			$this->currentMonth = $currentMonth;
			
			return $this;
		}
		
		/**
		 * @param int $currentDay
		 *
		 * @return PzCalendar
		 */
		public function setCurrentDay( int $currentDay ): PzCalendar {
			$this->currentDay = $currentDay;
			
			return $this;
		}
		
		/**
		 * @param null $currentDate
		 *
		 * @return PzCalendar
		 */
		public function setCurrentDate( $currentDate ) {
			$this->currentDate = $currentDate;
			
			return $this;
		}
		
		/**
		 * @param int $daysInMonth
		 *
		 * @return PzCalendar
		 */
		public function setDaysInMonth( int $daysInMonth ): PzCalendar {
			$this->daysInMonth = $daysInMonth;
			
			return $this;
		}
		
		/**
		 * @param string|null $naviHref
		 *
		 * @return PzCalendar
		 */
		public function setNaviHref( ?string $naviHref ): PzCalendar {
			$this->naviHref = $naviHref;
			
			return $this;
		}
		
		
		/**
		 * Monatsname kurz auslesen
		 *
		 * @param int $month
		 *
		 * @return mixed
		 */
		public function germanMonthShort( $month ) {
			$monthNames = [
				"Jan",
				"Feb",
				"M&auml;r",
				"Apr",
				"Mai",
				"Jun",
				"Jul",
				"Aug",
				"Sep",
				"Okt",
				"Nov",
				"Dez",
			];
			return$monthNames[ $month-1 ];
		}
		
		protected function getWeekNumberOnFirstDayOfMonth($month, $year){
			$firstDayOfMonth = "{$year}-{$month}-01 00:00:00";
			return date("W", strtotime($firstDayOfMonth));
		}
		
		protected function getWeekNumberOnLastDayOfMonth($month, $year){
			$daysInMonth    = $this->_daysInMonth($month, $year);
			$lastDayOfMonth = "{$year}-{$month}-{$daysInMonth} 23:59:59";
			return date("W", strtotime($lastDayOfMonth));
		}
		
		protected function getAccurateWeekRangeForTimeFrame($month, $year){
			# $carbon               = Carbon::createFromDate($year, $month);
			$weekNumDay1          = $this->getWeekNumberOnFirstDayOfMonth($month, $year);
			$weekNumDayX          = $this->getWeekNumberOnLastDayOfMonth($month, $year);
			# $weeksInYear          = date("W", mktime(0, 0, 0, 12, 28, $year));
			# $weeksInYear          = $carbon->weeksInYear;
			$weeksInYear          = $this->getWeeksInYear($year);
			$mnt                  = ($pMon = (int)$month - 1) == 0 ? 12: $pMon;
			$yr                   = ($pMon = (int)$month - 1) == 0 ? $year-1: $year;
			$lastWeekOfLastMonth  = $this->getWeekNumberOnLastDayOfMonth($mnt, $yr);
			
			if($weekNumDay1 > $weekNumDayX){
				if($lastWeekOfLastMonth == $weekNumDay1 && (int)$month == 1){
					$rangeData  = [$lastWeekOfLastMonth];
					for($i=1; $i<=$weekNumDayX; $i++){ $rangeData[] = $i; }
					
				}else if($lastWeekOfLastMonth > $weekNumDay1 && (int)$month == 1){
					$rangeData  = [];
					for($i=1; $i<=$weekNumDayX; $i++){ $rangeData[] = $i; }
					
				}else{
					$range1       = range($weekNumDay1, $weeksInYear);
					$range2       = range($weekNumDayX, $weekNumDayX);
					$rangeData    = $range1 + $range2;
					$rangeData[]  = (int)$weekNumDayX;
					if( count($range1) <= 3 ){
						$rangeData  = $range1 +  range(0, $weekNumDayX) ;
					}
				}
			}else{
				$rangeData = range($weekNumDay1, $weekNumDayX);
			}
			if(count($rangeData) > 6){
				array_pop($rangeData);
			}
			return$rangeData;
		}
		
		public function isLeapYear($year=null){
			$year = !empty($year) ? $year : intval( date('Y', time()) ) % 4 === 0;
			return (intval($year) % 4) === 0 ;
		}
		
		public function getWeeksInYear($year){
			return  (intval($year) % 4 === 0) ? 53 : 52;
		}
		
		public function getPrevOrNextWeekURL($currentMonth, $currentYear, $currentWeek, $previous=true ){
			$carbonDate     = Carbon::parse("{$currentYear}", "Europe/Zurich");
			$carbonDate->week($currentWeek);
			$nextCarbonWeek = clone $carbonDate;
			$prevCarbonWeek = clone $carbonDate;
			
			$prevCarbonWeek->addWeeks(-1);
			$nextCarbonWeek->addWeeks(1);
			$tempCarbonWeek = clone $nextCarbonWeek;
			$prevCarbonWeek->startOfWeek();
			
			if($previous){
				return "?year={$prevCarbonWeek->format('Y')}&month={$prevCarbonWeek->format('m')}&day={$prevCarbonWeek->format('d')}&week={$prevCarbonWeek->format('W')}";
			}
			return "?year={$nextCarbonWeek->format('Y')}&month={$nextCarbonWeek->format('m')}&day={$tempCarbonWeek->startOfWeek()->format('d')}&week={$nextCarbonWeek->format('W')}";
		}
		
		private function getStartAndEndDate($week, $year) {
			$dto = new DateTime();
			$dto->setISODate($year, $week);
			$ret['week_start'] = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$ret['week_end'] = $dto->format('Y-m-d');
			return $ret;
		}
		
		public function buildMonthWeeksCalendar(){
			$currentYear        = isset($_GET['year'])  ? $_GET['year']   : date('Y');
			$currentWeek        = isset($_GET['week'])  ? $_GET['week']   : date('W');
			$currentMonth       = isset($_GET['month']) ? $_GET['month']  : date('m');
			$prevWeekURI        = $this->getPrevOrNextWeekURL($currentMonth, $currentYear, $currentWeek, true );
			$nextWeekURI        = $this->getPrevOrNextWeekURL($currentMonth, $currentYear, $currentWeek, false );
			
			$tipLastWeek        = "Wo " . preg_replace("#(^.*&week=)#", "", $prevWeekURI);
			$tipNextWeek        = "Wo " . preg_replace("#(^.*&week=)#", "", $nextWeekURI);
			$output             =<<<XTR
<div class="month-week-calendar-box">
	<div class="box pz-wk-cal-nav">
		<div class="header">
			<a class="prev" href="{$prevWeekURI}">
				<span class="fa fa-chevron-left" data-tip="{$tipLastWeek}"></span>
			</a>
			<span class="title"  data-tip="Wo {$currentWeek}">Wo {$currentWeek}</span>
			<a class="next" href="{$nextWeekURI}">
				<span class="fa fa-chevron-right" data-tip="{$tipNextWeek}"></span>
			</a>
		</div>
	</div>

<!--- THE CLOSING DIV HERE WAS REMOVED SINCE THE OUTPUT BELOW IS INTENDED TO BE ITS CHILD.... -->
XTR;
			
			foreach($this->monthLabels as $monthKey=> $label){
				$this->currentMonth = $this->currentMonth <= 0 ? 1 : $this->currentMonth;
				$XRange             = $this->getAccurateWeekRangeForTimeFrame($monthKey+1, $currentYear);
				$output   .= "<div class='pz-week-label-wrapper pz-week-label'><div class='pz-week-label'>{$label}</div>";
				
				foreach($XRange as $value){
					$idealDate    = new \DateTime();
					$idealDate->setISODate($currentYear, $value);
					
					$url     = "?year={$idealDate->format('Y')}&month=" . ($monthKey+1 ) . "&day={$idealDate->format('d')}&week={$value}";
					$active  =  $value == $currentWeek ? "pz-active active" : "";
					$output .= "<div class='pz-week {$active}'>";
					$output .= "<a href='{$url}' class='pz-week-link {$active}'>{$value}</a>";
					$output .= "</div>";
				}
				$output   .= "</div>";
			}
			return $output . "</div>";
		}
		
		public function buildYearCalendar(){
			$this->currentYear  = isset($_REQUEST['year'])    ? $_REQUEST['year'] : $this->currentYear;
			$this->currentYear  = !$this->currentYear ? date("Y") : $this->currentYear;
			$yearCalendar  = '<div id="Kalender_jahr">';
			$yearCalendar .=  '<table>';
			$yearAsc      = ($this->currentYear + 2);
			for ($i=$yearAsc; $i>= 2008; $i--) {
				$activeYear = '';
				if($i == $this->currentYear){
					$activeYear = 'active';
				}
				$yearCalendar .=  '<tr><td';
				if ($this->currentYear == $i) $yearCalendar .= ' class="fett"';
				$yearCalendar .=  '><a href="?year='.$i.'" class="' . $activeYear . '">'.$i.'</a></td></tr>';
			}
			$yearCalendar .=  '</table>';
			$yearCalendar .=  '</div>';
			return $yearCalendar;
		}
		
		public function buildCurrentDateFeed(){
			$currentYear      = $this->session->get(RequestBridge::SessionNameSpace)['year'];
			$currentWeek      = $this->session->get(RequestBridge::SessionNameSpace)['week'];
			$currentMonth     = $this->session->get(RequestBridge::SessionNameSpace)['month'];
			$currentDay       = $this->session->get(RequestBridge::SessionNameSpace)['day'];
			
			/*
			$currentWeek      = !$currentWeek  ? date("W") : $currentWeek;
			$currentDay       = !$currentDay   ? date("d") : $currentDay;
			$currentMonth     = !$currentMonth ? date("m") : $currentMonth;
			$currentYear      = !$currentYear  ? date("Y") : $currentYear;
			*/
			$cleanShortMonth  = $this->germanMonthShort($currentMonth);
			$showTodayBox     = "";
			$todayURL         = "?year=" . date('Y') . "&month=" . date('m') . "&week=" . date('W') . "&day=" . date('d');
			$todayURL         = $this->buildRoute('rte_admin_calendar', []);
			if(date('Y') != $currentYear ||
			   date('m') != $currentMonth ||
			   date('d') != $currentDay){
				$showTodayBox   = $this->getShowTodayBox($todayURL);
			}
			$currentDateFeed  =<<<CDF
<div id="pz-day-calendar-wrapper" class="pz-day-calendar-wrapper">
	<aside class="pz-date fat">{$currentDay}</aside>
	<aside class="pz-month-year fat">
		<span class="month">{$cleanShortMonth}</span>
		<span class="year">{$currentYear}</span>
	</aside>
	<aside class="pz-week-number"><span class="week">Wo {$currentWeek}</span></aside>
	{$showTodayBox}
</div>
CDF;
			return $currentDateFeed;
		}
		
		private function getShowTodayBox($todayURL){
			return <<<STD
	<aside class="pz-today-box">
		<a class="pz-today-link" href="{$todayURL}" >
			<span class="fa fa-calendar-check-o"></span>
			<span class="pz-today-text">Heute zeigen</span>
		</a>
	</aside>
STD;

		}
		
		public static function getEntityManager(){
			global $kernel;
			return $kernel->getContainer()->get('doctrine.orm.entity_manager');
		}
		
		public function getTicketsCountForActiveDate($day, $month, $year, $filiale){
			/**@var \Doctrine\ORM\QueryBuilder $qb */
			$qb   = static::getEntityManager()->getConnection()->createQueryBuilder();
			$and  = $qb->expr()->andX();
			$and->add($qb->expr()->eq('tkt.ticket_endtermin', "'{$year}-{$month}-{$day}'"));
			$and->add($qb->expr()->eq('tkt.ticket_MA_verantwortung', $filiale));
			$and->add($qb->expr()->eq('tkt.ticket_typ', 1));
			$and->add($qb->expr()->lt('tkt.ticket_status', 3));
			
			$qb->select( 'COUNT(tkt.ticket_id) AS dayTicketsCount')
			   ->from('tickets', 'tkt')
			   ->leftJoin('tkt', 'ticketeintrag', 'tet', 'tkt.ticket_id=tet.ticketeintrag_ticket_id')
			   ->where($and);
			$ticketCount = $qb->execute()->fetch();
			if($ticketCount){
				$ticketCount= $ticketCount['dayTicketsCount'];
			}
			
			return $ticketCount;
		}
		
		public function buildRoute($routeName, $params=['_locale'=>'de']){
			# global $kernel; $kernel->getContainer()->get('');
			return $this->urlGenerator->generate($routeName, $params);
		}
		
		private function getStartEndDateByWeekYear($week, $year, $getOnlyStartDay=false) {
			$dto = new \DateTime();
			$dto->setISODate($year, $week);
			$ret['week_start'] = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$ret['week_end'] = $dto->format('Y-m-d');
			return $ret;
		}
		
		
	}