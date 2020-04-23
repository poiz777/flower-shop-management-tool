<?php
	
	
	namespace App\Helpers\Date;
	
	use App\Entity\Personen;
	use App\Entity\Ticketeintrag;
	use App\Entity\Tickets;
	use App\Forms\PriorityStatusTypeEntity;
	use App\Forms\PriorityStatusTypeWEntity;
	use App\Poiz\HTML\Forms\PriorityStatusTypeForm;
	use App\Poiz\HTML\Forms\PriorityStatusTypeWForm;
	use Carbon\Carbon;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	
	/**
	 * Class DateCalculator
	 * @package App\Services\Helpers\Date
	 */
	class DateCalculator {
		
		/**
		 * @var string|int
		 */
		private $day;
		
		/**
		 * @var string|int
		 */
		private $month;
		
		/**
		 * @var string|int
		 */
		private $year;
		
		/**
		 * @var string|int
		 */
		private $calendarWeek;
		
		/**
		 * @var string
		 */
		private $monthNameLong;
		
		/**
		 * @var string
		 */
		private $wochentagname;
		
		
		/**
		 * @var int|string
		 */
		private $wochennummer;
		
		/**
		 * @var string
		 */
		private $monthNameShort;
		
		##REQUEST RELATED DATA: BEGIN###
		/**
		 * @var string
		 */
		private $Form_woche = '';
		
		/**
		 * @var string
		 */
		private $ticket_Typ = '';
		
		/**
		 * @var string
		 */
		private $ticket_Prio = '';
		
		/**
		 * @var string
		 */
		private $department = '940';
		
		/**
		 * @var EntityManagerInterface
		 */
		private $em;
		
		/**
		 * @var int;
		 */
		private $aktueller_tag;
		
		/**
		 * @var int;
		 */
		private $aktueller_monat;
		
		/**
		 * @var int;
		 */
		private $aktuelles_jahr;
		
		/**
		 * @var SessionInterface
		 */
		private $session;
		
		/**
		 * @var string
		 */
		private $ticket_Status = '';
		##REQUEST RELATED DATA: END###
		
		/**
		 * @var \App\Helpers\Date\PzCalendar
		 */
		private $pzCalendar;
		
		/**
		 * @var array
		 */
		private $monthFullNames      = [
			1   =>  "Januar",
			2   =>  "Februar",
			3   =>  "M&auml;rz",
			4   =>  "April",
			5   =>  "Mai",
			6   =>  "Juni",
			7   =>  "Juli",
			8   =>  "August",
			9   =>  "September",
			10  =>  "Oktober",
			11  =>  "November",
			12  =>  "Dezember",
		];
		
		/**
		 * @var array
		 */
		private $tag    = [
				"Sonntag",
				"Montag",
				"Dienstag",
				"Mittwoch",
				"Donnerstag",
				"Freitag",
				"Samstag",
		];
		
		/**
		 * @var array
		 */
		private $weekDaysFull      = [
			"Montag",
			"Dienstag",
			"Mittwoch",
			"Donnerstag",
			"Freitag",
			"Samstag",
			"Sonntag"
		];
		
		/**
		 * DateCalculator constructor.
		 *
		 * @param \Doctrine\ORM\EntityManagerInterface                       $em
		 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
		 * @param \App\Helpers\Date\PzCalendar                               $pzCalendar
		 * @param array                                                      $config
		 */
		public function __construct(EntityManagerInterface $em, SessionInterface $session, PzCalendar $pzCalendar, array $config=[]) {
			$this->em             = $em;
			$this->session        = $session;
			$this->pzCalendar     = $pzCalendar;
			$this->day            = isset($config['day'])           ? trim($config['day'])            : date('d');
			$this->month          = isset($config['month'])         ? trim($config['month'])          : date('m');
			$this->year           = isset($config['year'])          ? trim($config['year'])           : date('Y');
			$this->calendarWeek   = isset($config['calendarWeek'])  ? trim($config['calendarWeek'])   : date("W", time());  // date("W", strtotime('2013-06-06'));
			$this->initialize();
		}
		
		protected function initialize(){
			// Aktuelles Datum + Zeit
			setlocale(LC_TIME, 'German');
			
			// Aktueller Tag
			if(!$this->session->has('aktueller_tag')){
				$this->aktueller_tag    = date('d');
				$this->day              = $this->aktueller_tag;
				$this->session->set('aktueller_tag', $this->aktueller_tag);
			}
			
			// day
			if(!$this->session->has('day')) {
				$this->session->set( 'day', $this->aktueller_tag );
			}
			
			// Aktueller Monat
			if(!$this->session->has('aktueller_monat')) {
				$this->aktueller_monat  = date('m');
				$this->month            = $this->aktueller_monat;
				$this->session->set( 'aktueller_monat', $this->aktueller_monat );
			}

			// Aktuelles Jahr
			if(!$this->session->has('aktuelles_jahr')) {
				$this->aktuelles_jahr   = date( 'Y' );
				$this->session->set('aktuelles_jahr', $this->aktuelles_jahr);
				$this->year             = $this->aktuelles_jahr;
			}
			
			// Datum, schön formatiert, ohne Zeit
			if(!$this->session->has('datum')) {
				$this->session->set( 'datum', strftime( '%A, %d. %B %Y' ) );
			}
			
			// Datum, schön formatiert, ohne Wpochentag
			$this->session->set('datum_kurz',  strftime('%d. %B %Y'));
			
			// Datum, schön formatiert, mit Zeit
			if(!$this->session->has('datum_zeit')) {
				$this->session->set( 'datum_zeit', strftime( '%A, %d. %B %Y, %H:%M' ) );
			}
			
			// Std und Min
			if(!$this->session->has('stdmin')) {
				$this->session->set('stdmin',  strftime('%H:%M'));
			}

			// Heutiges Datum für Einträge in die DB formatieren
			if(!$this->session->has('datum_DB')) {
				$this->session->set( 'datum_DB', strftime( '%Y-%m-%d' ) );
			}
			
			// Heutiges Datum als UNIX-Zeitstempel
			if(!$this->session->has('unix_heute')) {
				$this->session->set( 'unix_heute', mktime( 0, 0, 0, $this->aktueller_monat, $this->aktueller_tag, $this->aktuelles_jahr ) );
			}
			
			// Heutiger Wochentag, numerisch, von 0 (Sonntag) bis 6 (Samstag)
			if(!$this->session->has('wochentag')) {
				$this->calendarWeek     = date("w", time());  // date( "w" );
				$this->session->set( 'wochentag', $this->calendarWeek );
			}


		// Wochentag auslesen
			$this->tag    = [
				"Sonntag",
				"Montag",
				"Dienstag",
				"Mittwoch",
				"Donnerstag",
				"Freitag",
				"Samstag",
			];
			
			// Wochentagname auslesen
			$this->wochentagname = isset($this->tag[$this->calendarWeek]) ? $this->tag[$this->calendarWeek] : null;
			
			// Wochennummer auslesen
			$this->wochennummer   = date("W");
			
			// Aktuelle Stunde
			$this->session->set( 'stunde', strftime('%H') );
			
			// Aktuelle Zeit auslesen
			$this->session->set( 'zeit_akutell', strftime('%H:%M:%S') );
			
			// Aktueller Zeitcode für Online-Shop (DB-Tabelle versand_datecode)
			# $row_dateCode = $this->getDateCode();
			# $this->session->set( 'datecode', $row_dateCode['versand_datecode_id'] );
			
		}
		
		private function getDateCode() {
			$qb     = $this->em->getConnection()->createQueryBuilder();
			$and    = $qb->expr()->andX();
			$and->add($qb->expr()->eq('vdt.versand_datecode_wochentag', $qb->expr()->literal($this->session->get( 'wochentag')    )) );
			$and->add($qb->expr()->lt('vdt.versand_datecode_zeit_min',  $qb->expr()->literal($this->session->get( 'zeit_akutell') )) );
			$and->add($qb->expr()->gt('vdt.versand_datecode_zeit_max',  $qb->expr()->literal($this->session->get( 'zeit_akutell') )) );
			$qb->select( 'vdt.versand_datecode_id')
			   ->from('versand_datecode', 'vdt')
			   ->where($and);
			return $qb->execute()->fetch();
		}
		
		/**
		 * Wochentag ermitteln
		 *
		 * @param int|string|null $d
		 * @param int|string|null $m
		 * @param int|string|null $j
		 *
		 * @return string|int
		 */
		public function wochentagnr($d=null, $m=null, $j=null) {
			// Wir fragen mit w ab (So=0 usw.), da N (Mo=1, So=7) hier noch nicht funktioniert...
			$d = $d ? $d : $this->day;
			$j = $j ? $j : $this->year;
			$m = $m ? $m : $this->month;
			$wochentagnr = date( 'w', mktime( 0, 0, 0, $m, $d, $j ) );
			// ...was wir jetzt manuell korrigieren
			if ( $wochentagnr == 0 ) {
				$wochentagnr = 7;
			}
			return $wochentagnr;
		}
		
		/**
		 * Monatsname lang auslesen
		 *
		 * @param int  $month
		 *
		 * @return mixed
		 */
		public function monatsname_lang( $month ) {
			$this->monthNameLong  = $this->monthFullNames[ $month ];
			return $this->monthNameLong;
		}
		
		/**
		 * Monatsname kurz auslesen
		 */
		public function monatsname_kurz( $mon ) {
			$monat_name[1]  = "Jan";
			$monat_name[2]  = "Feb";
			$monat_name[3]  = "M&auml;r";
			$monat_name[4]  = "Apr";
			$monat_name[5]  = "Mai";
			$monat_name[6]  = "Jun";
			$monat_name[7]  = "Jul";
			$monat_name[8]  = "Aug";
			$monat_name[9]  = "Sep";
			$monat_name[10] = "Okt";
			$monat_name[11] = "Nov";
			$monat_name[12] = "Dez";
			
			return $monatsname = $monat_name[ $mon ];
		}
		
		/**
		 * Funktion gibt Anzahl Tage im gegebenen Monat zurück
		 */
		public function anzahltage_monat( $m, $j ) {
			if($m  && $j )
				return cal_days_in_month(CAL_GREGORIAN, $m, $j);
			//return $anzahltage = date( 't', mktime( 0, 0, 0, $m, 1, $j ) );
		}
		
		/**
		 * Funktion, welche Tag, Monat und Jahr einliest und das neue Datum im Format 12. Januar 2011 ausliest,
		 * welches x Tage in der Zukunft bzw. Vergangenheit liegt
		 */
		public function datumsrechnung( $d, $m, $j, $delta, $monat_name ) {
			// Monatsname auslesen
			$datum_check = date( 'd.m.y', mktime( 0, 0, 0, $m, $d + $delta, $j ) );
			if ( substr( $datum_check, 3, 2 ) < 10 ) {
				$monatszahl = substr( $datum_check, 4, 1 );
			} else {
				$monatszahl = substr( $datum_check, 3, 2 );
			}
			$datum_formatiert = substr( $datum_check, 0, 3 ) . ' ' . monatsname_lang( $monatszahl ) . ' 20' . substr( $datum_check, - 2, 2 );
			// Ist die Tageszahl einstellig? Dann die 0 entfernen
			if ( substr( $datum_formatiert, 0, 1 ) == 0 ) {
				$datum_formatiert = substr( $datum_formatiert, 1 );
			}
			
			return $datum_formatiert;
		}
		
		/**
		 * Funktion, welche Tag, Monat und Jahr einliest und das neue Datum,
		 * welches x Tage in der Zukunft bzw. Vergangenheit liegt,
		 * mit den Variablen tag, mon und jahr ausgibt
		 */
		public function delta_tag( $d, $m, $j, $delta ) {
			// Monatsname auslesen
			$datum_check = date( 'd.m.y', mktime( 0, 0, 0, $m, $d + $delta, $j ) );
			if ( substr( $datum_check, 3, 2 ) < 10 ) {
				$monatszahl = substr( $datum_check, 4, 1 );
			} else {
				$monatszahl = substr( $datum_check, 3, 2 );
			}
			$delta = [
				substr( $datum_check, 0, 2 ),
				substr( $datum_check, 3, 2 ),
				'20' . substr( $datum_check, - 2, 2 ),
			];
			
			return ( $delta );
		}
		
		/**
		 * Kalenderwoche eines beliebigen Tags ermitteln
		 */
		public function kalwoche( $d, $m, $j ) {
			return $kalenderw = date( 'W', mktime( 0, 0, 0, $m, $d, $j ) );
		}
		
		/**
		 * erste Tag und Monat einer gegebenen Kalenderwoche zurückgeben
		 *
		 * @param int|string|null   $kw
		 * @param int|string|null   $jahr
		 *
		 * @return array
		 */
		public function beginn_kw( $kw = null, $jahr = null ) {
			$kw   = !$kw    ? $this->calendarWeek : $kw;
			$jahr = !$jahr  ? $this->year         : $jahr;
			
			// Jetzt gehts los
			$stop = 0;
			for ( $i = 1; $i < 13; $i ++ ) {
				$anz_day = $this->anzahltage_monat( $i, $jahr );
				for ( $j = 1; $j < ( $anz_day + 1 ); $j ++ ) {
					if ( $stop != 1 AND date( 'W', mktime( 0, 0, 0, $i, $j, $jahr ) ) == $kw ) {
						// Murks: wenn KW52 ausgewählt wurde, muss die Schleife beim Monat Januar übersprungen werden, da sonst das alte Jahr noch zum Zug kommt
						if ( ! ( $i == 1 AND $kw == 52 ) AND ! ( $i == 1 AND $kw == 53 ) ) {
							$stop   = 1;
							$beginn = [ $j, $i, $jahr, $kw ];
							return ( $beginn );
							break;
						}
					}
				}
			}
		}
		
		/**
		 * Diese Funktion gibt für den gewünschten Monat die Anzahl KW zurück
		 * Die erste KW eines Monats muss mindestens 4 Tage umfassen
		 *
		 * @param string|int $m
		 * @param string|int $j
		 *
		 * @return bool|int|string
		 */
		public function mon_kw( $m, $j ) {
			$erster_wochetag = $this->wochentagnr( 1, $m, $j );
			
			return $erster_wochetag;
		}
		
		/**
		 * Funktion zur Formatierung des Datums aus dem DB-Format 'YYYY-MM-TT' in 'TT.MM.JJ'
		 * @param $datum string : THE `YYYY-MM-TT` FORMATTED DATE STRING...
		 * @return string: THE SWISS FORMATTED DATE-STRING.
		 */
		public function datum_layout( $datum ) {
			$ymdDate      = $this->extractYMDValuesFromDateStringAsObject($datum, false);
			return $datum = $ymdDate->d . '.' . $ymdDate->m . '.' . $ymdDate->y;
		}
		
		/**
		 * Funktion zur Formatierung des Datums aus dem DB-Format 'YYYY-MM-TT'
		 * in 3 Session-Variablen tag, monat und jahr
		 * SETS SESSION DATA FOR THE EXTRACTED Y-M-D VALUES;
		 * @param $datum string
		 */
		public function datum_pulldown( $datum) {
			// the second argument is the value returned when the attribute doesn't exist
			# $filters            = $this->session->get('filters', []);
			$ymdDate            = $this->extractYMDValuesFromDateStringAsObject($datum, true);
			$this->session->set('tag',    $ymdDate->d);
			$this->session->set('monat',  $ymdDate->m);
			$this->session->set('jahr',   $ymdDate->y);
		}
		
		/**
		 * EXTRACTS THE YEAR, MONTH AND DAY FROM A `YYYY-MM-DD` FORMATTED DATE-STRING
		 * USING REGULAR STRING MANIPULATION FUNCTION: `substr()`
		 * @param string  $dateString
		 * @param $fourDigitYear bool : WOULD YOU WANT A 4-DIGIT-YEAR (2020) OR JUST A 2-DIGIT REPRESENTATION(20)?
		 *
		 * @return \stdClass
		 */
		protected function extractYMDValuesFromDateStringAsObject($dateString, $fourDigitYear=true ){
			$extract    = new \stdClass();
			$extract->y = $fourDigitYear ?  substr( $dateString, 0, 4 ) : substr( $dateString, 2, 2 );
			$extract->m = substr( $dateString, 5, 2 );
			$extract->d = substr( $dateString, 8, 2 );
			return $extract;
		}
		
		private function fetchTickets($theDay, $department){
			if ($_REQUEST['Form_woche'] == 1) {
				$query_tickets = "SELECT ticket_id, ticket_knowledgeID, ticket_header, ticket_kunde, client.Kategorie, client.Firma, client.name
													as kundenname, client.vorname as kundenvorname, worker.vorname as arbeitervorname, ticket_zeit, ticket_MA_verantwortung, ticket_status, ticket_prio, ticket_gelesen, ticket_typ_name, ticket_status_name
													FROM tickets, ticket_typ, ticket_status, personen as client, personen as worker WHERE ticket_typ_id = ticket_typ AND ticket_status = ticket_status_id
													AND ticket_kunde = client.kundenid AND ticket_MA_verantwortung = worker.kundenid
													AND ticket_endtermin = '$theDay' AND ticket_MA_verantwortung = '$department'";
				if ($_REQUEST['ticket_Typ']) {
					$var_typ = $_REQUEST['ticket_Typ'];
					$query_tickets .= " AND ticket_typ = $var_typ";
				}
				if ($_REQUEST['ticket_Prio']) {
					$var_prio = $_REQUEST['ticket_Prio'];
					$query_tickets .= " AND ticket_prio = $var_prio";
				}
				if ($_REQUEST['ticket_Status']) {
					$var_status = $_REQUEST['ticket_Status'];
					$query_tickets .= " AND ticket_status = $var_status";
				}
				$query_tickets .= " ORDER BY ticket_zeit ASC";
			} else {
				$query_tickets = "SELECT ticket_id, ticket_knowledgeID, ticket_header, ticket_kunde, client.Kategorie, client.Firma, client.name as kundenname, client.vorname
													as kundenvorname, worker.vorname as arbeitervorname, ticket_zeit, ticket_MA_verantwortung, ticket_status, ticket_prio, ticket_gelesen, ticket_typ_name, ticket_status_name
													FROM tickets, ticket_typ, ticket_status, personen as client, personen as worker WHERE ticket_typ_id = ticket_typ AND ticket_status = ticket_status_id
													AND ticket_kunde = client.kundenid AND ticket_MA_verantwortung = worker.kundenid AND ticket_endtermin = '$theDay'
													AND ticket_MA_verantwortung = '$department' ORDER BY ticket_zeit ASC";
			}
		}
		
		/**
		 * Funktion zur Formatierung des Datums in das DB-Format 'YYYY-MM-TT'
		 *
		 * @param string|int $tag
		 * @param string|int $monat
		 * @param string|int $jahr
		 *
		 * @return string: THE 'YYYY-MM-TT' FORMATTED DATE-STRING.
		 */
		public function datum_db( $tag, $monat, $jahr ) {
			return $datum = $jahr . '-' . $monat . '-' . $tag;
		}
		
		public function getPendingTicketsEntryForID($ticketID){
			$qb   = $this->em->getConnection()->createQueryBuilder();
			$and  = $qb->expr()->andX();
			$and->add($qb->expr()->eq('tkt.ticket_id', $qb->expr()->literal($ticketID)));
			$qb->select(
				'tkt.ticket_header',
				'tkt.ticket_kunde',
				'tkt.ticket_id',
				'tkt.ticket_MA_verantwortung',
				'tkt.ticket_endtermin',
				'tkt.ticket_zeit',
				'tst.ticket_status_name AS ticket_status',
				'ttp.ticket_typ_name AS ticket_typ',
				'tpr.ticket_prio_name AS ticket_prio',
				'tkt.ticket_gelesen',
				'ten.*',
				'psn.name AS lastName',
				'psn.Firma AS company',
				'psn.vorname AS workerFirstName',
				'CONCAT(psn.vorname, " ", psn.name) AS fullName',
				'psn.vorname AS firstName'
			)
			   ->from('tickets', 'tkt')
			   ->leftJoin('tkt', 'personen', 'psn', 'tkt.ticket_kunde=psn.kundenid AND tkt.ticket_MA_verantwortung = psn.kundenid AND tkt.ticket_MA_verantwortung != 942')
			    ->leftJoin('tkt', 'ticket_status', 'tst', 'tst.ticket_status_id=tkt.ticket_status')
			    ->leftJoin('tkt', 'ticket_typ', 'ttp', 'ttp.ticket_typ_id=tkt.ticket_typ')
			    ->leftJoin('tkt', 'ticket_prio', 'tpr', 'tpr.ticket_prio_id=tkt.ticket_prio')
			    ->leftJoin('tkt', 'ticketeintrag', 'ten', 'ten.ticketeintrag_ticket_id=tkt.ticket_id')
			    ->where($and)
			    ->orderBy('ten.ticketeintrag_id', 'DESC');
			return  $qb->execute()->fetch();
		}
		
		public function getTicketsForTimeFrameByStatus($date=null, $status=null, $groupIntoTimeSlots=true){
			$status         = !$status  ? [1, 2]  : (is_array($status) ? $status : [$status]);
			$ticketDate     = !$date    ? date("Y-m-d") : ( ($date instanceof \DateTime) ? $date->format('Y-m-d') : $date);
			$mjrSession     = $this->session->get(RequestBridge::SessionNameSpace);
			$department     = isset($mjrSession['department']) ? [ $mjrSession['department'] ] : ['940'];
			$tickets4TFrame = $this->em->getRepository(Tickets::class)->findTicketsByStatusForCompanyBranchByDate($status, $department, $ticketDate, true);
			$returnData     = [];
			if($groupIntoTimeSlots){
				if($tickets4TFrame){
					foreach($tickets4TFrame as $iKey=>$ticket){
						$ticketTime = substr($ticket["ticket_zeit"], 0, 5);
						if(!array_key_exists($ticketTime, $returnData)){
							$returnData[$ticketTime]  = [];
						}
						$returnData[$ticketTime][] = $ticket;
					}
				}
				uksort($returnData, function($prev, $next){ return $next < $prev;});
			}
			return $groupIntoTimeSlots? $returnData : $tickets4TFrame;
		}
		
		public function getTicketsForMonth($month, $filiale){
			/**@var \Doctrine\ORM\QueryBuilder $qb */
			$qb   = $this->em->getConnection()->createQueryBuilder();
			$and  = $qb->expr()->andX();
			$and->add($qb->expr()->eq('MONTH(tkt.ticket_endtermin)', $month));
			$and->add($qb->expr()->eq('tkt.ticket_MA_verantwortung', $filiale));
			$and->add($qb->expr()->eq('tkt.ticket_typ', 1));
			$and->add($qb->expr()->lt('tkt.ticket_status', 3));
			
			$qb->select('tkt.*', 'tet.*')
			   ->from('tickets', 'tkt')
			   ->leftJoin('tkt', 'ticketeintrag', 'tet', 'tkt.ticket_id=tet.ticketeintrag_ticket_id')
			   ->where($and);
			$resultSet = $qb->execute()->fetchAll();
			
			return $resultSet;
		}
		
		public function getTicketsForActiveDate($day, $month, $year, $filiale){
			$de           = Carbon::parse(date("Y-m-d", strtotime("{$year}-{$month}-{$day}")));
			$de->timezone = 'Europe/Zurich';
			$resultSet  = $this->em->getRepository(Tickets::class)->
			findTicketsForCompanyBranchByDate($filiale, $de->toDate(), true);
			return $resultSet;
		}
		
		public function getTicketsForActiveWeek($day, $month, $year, $filiale, $status='lt3'){
			/**@var \Doctrine\ORM\QueryBuilder $qb */
			$payload      = [
				'Montag'      => ['abbr'=> 'mo','full'=> 'Montag',],
				'Dienstag'    => ['abbr'=> 'di','full'=> 'Dienstag',],
				'Mittwoch'    => ['abbr'=> 'mi','full'=> 'Mittwoch',],
				'Donnerstag'  => ['abbr'=> 'do','full'=> 'Donnerstag',],
				'Freitag'     => ['abbr'=> 'fr','full'=> 'Freitag',],
				'Samstag'     => ['abbr'=> 'sa','full'=> 'Samstag',],
				'Sonntag'     => ['abbr'=> 'so','full'=> 'Sonntag',],
			];
			
			$i = 0;
			$de           = Carbon::parse(date("Y-m-d", strtotime("{$year}-{$month}-{$day}")));
			$de->timezone = 'Europe/Zurich';
			
			foreach($payload as &$weekDay){
				$de         = $de->startOfWeek()->addDays($i);
				$resultSet  = $this->em->getRepository(Tickets::class)->
										findTicketsForCompanyBranchByDate($filiale, $de->toDate(), true);
				
				$i++;
				$de2              = Carbon::parse(date("Y-m-d", strtotime($de->format('Y-m-d'))));
				$de2->timezone    = 'Europe/Zurich';
				$weekDay['date']  = $de2->format('d.m.Y');
				$weekDay['from']  = $de2->startOfWeek()->format('d.m.Y');
				$weekDay['till']  = $de2->endOfWeek()->format('d.m.Y');
				$weekDay['data']  = $resultSet;
			}
			return $payload;
		}
		
		public function buildCalendarForm(){
			$calendarHTML  = '<div id="calendar-form" class="calendar-form">';
			$calendarHTML .= '<div id="Filiale">';
			$calendarHTML .= '<form name="Auswahl_Filiale" method="post" action="">';
			$calendarHTML .= '<div id="kal_headline">';
			$calendarHTML .= '<table><tr><td>';
			$calendarHTML .= 'Kalender ';
			$calendarHTML .= '<select name="Filiale_wahl">';
			$calendarHTML .= "";    // $this->getDropDownOptionsForWorkers();
			$calendarHTML .='</select></td>';
			$calendarHTML .='<td><input type="image" name="absenden" src="../../images/buttons/ok_css.gif" /></td>';
			$calendarHTML .='</tr></table>';
			$calendarHTML .='</div>';
			$calendarHTML .='<input type="hidden" name="tag_switch" value="" />';
			$calendarHTML .='<input type="hidden" name="kw_switch" value="" />';
			$calendarHTML .='</form>';
			$calendarHTML .='</div>';
			$calendarHTML .='</div>';
			return $calendarHTML;
			
		}
		
		public function buildCentralCalendar(array $resultSet=[], $tickets4Now=[]){
			$weekCalendar  = "";
			$weekCalendar .= '<div id="Kalender_kalenderwochen">';
			$weekCalendar .=  $this->pzCalendar->buildMonthWeeksCalendar();
			$weekCalendar .=  '</div>';
			$this->pzCalendar->setDayLabels(['Mo','Di', 'Mi', 'Do', 'Fr', 'Sa', 'So']);
			
			$calendarHTML  = $this->pzCalendar->buildCurrentDateFeed();
			$calendarHTML .="<div id=\"Kalender_monat\">{$this->pzCalendar->show($resultSet, $tickets4Now)}</div>";
			$calendarHTML .= $weekCalendar;
			# $calendarHTML .= $this->pzCalendar->buildYearCalendar(); // NOW ADDED FROM WITHIN THE VIEW TEMPLATE
			$calendarHTML .= $this->buildCalendarStatusFeedBack();    //  . "</div>";
			
			return $calendarHTML;
		}
		
		private function getPSTArray(){
			$melSession     = $this->session->get(RequestBridge::SessionNameSpace);
			if(isset($_POST['type'])){ $melSession['type'] = $_POST['type']; }
			if(isset($_POST['typeW'])){ $melSession['typeW'] = $_POST['typeW']; }
			if(isset($_POST['status'])){ $melSession['status'] = $_POST['status']; }
			if(isset($_POST['statusW'])){ $melSession['statusW'] = $_POST['statusW']; }
			if(isset($_POST['priority'])){ $melSession['priority'] = $_POST['priority']; }
			if(isset($_POST['priorityW'])){ $melSession['priorityW'] = $_POST['priorityW']; }
			$this->session->set(RequestBridge::SessionNameSpace, $melSession);
			return [
				'typeW'     => isset($melSession['typeW']) ? $melSession['typeW'] : '',
				'statusW'   => isset($melSession['statusW']) ? $melSession['statusW'] : '',
				'priorityW' => isset($melSession['priorityW']) ? $melSession['priorityW'] : '',
				'type'      => isset($melSession['type']) ? $melSession['type'] : '',
				'status'    => isset($melSession['status']) ? $melSession['status'] : '',
				'priority'  => isset($melSession['priority']) ? $melSession['priority'] : '',
				'pst'   => [
					'type'      => isset($melSession['type']) ? $melSession['type'] : '',
					'status'    => isset($melSession['status']) ? $melSession['status'] : '',
					'priority'  => isset($melSession['priority']) ? $melSession['priority'] : '',
					],
				'pstW'  => [
					'typeW'     => isset($melSession['typeW']) ? $melSession['typeW'] : '',
					'statusW'   => isset($melSession['statusW']) ? $melSession['statusW'] : '',
					'priorityW' => isset($melSession['priorityW']) ? $melSession['priorityW'] : '',
					],
			];
		}
		
		public function buildPriorityStatusTypeBox($isW=false) {
			$pst            = $this->getPSTArray();
			$pstEntity      = $isW ? new PriorityStatusTypeWEntity() : new PriorityStatusTypeEntity();
			if($isW){
				$pstEntity->autoSetClassProps($pst['pst']);
			}else{
				$pstEntity->autoSetClassProps($pst['pstW']);
			}
			$pstEntity->autoSetClassProps($pst);
			
			$pstForm        = $isW ? new PriorityStatusTypeWForm($pstEntity)   : new PriorityStatusTypeForm($pstEntity);
			$classIDSuffix  = $isW ? 'pz-priority-type-status-w' : 'pz-priority-type-status';
			$formWidgets    = $pstForm->getForm();
			
			$calendarHTML   ="<div id=\"{$classIDSuffix}\" class='pz-priority-type-status-box {$classIDSuffix}'>";
			foreach($formWidgets as $widget){
				$calendarHTML .="<div class='pz-pts form-group'>";
				$calendarHTML .= $widget->render();
				$calendarHTML .="</div>";
			}
			$calendarHTML .=<<<PST
<!-- <div class='pz-pts form-group'>  &nbsp;&nbsp;Los -->
<button type="submit" class="pz-form-widget pz-grid-right">
<span class="fa fa-paper-plane"></span></button>
<!-- </div> -->
PST;
			$calendarHTML .="</div>";
			// $calendarHTML .="</form>";
			
			return $calendarHTML;
		}
		
		protected function getStatusFeedBackFeed(){
			$dateToday      = date("y-m-d");  // "2020-01-07";   // date("y-m-d");  // "2020-02-02";   //
			$calFeedback    = "<div id=\"pz-today-snapshot\" class=\"pz-today-snapshot\">";
			$openTickets    = $this->getTicketsForTimeFrameByStatus($dateToday, [1, 2], true);
			$closedTickets  = $this->getTicketsForTimeFrameByStatus($dateToday, [3], true);
			$readyTickets   = $this->getTicketsForTimeFrameByStatus($dateToday, [4], true);
		
			if(empty($openTickets) && empty($closedTickets) && empty($readyTickets)){
				$calFeedback   .=  '<img class="pz-no-tickets-svg" src="/images/logos/keine-tickets-fuer-heute-2.svg" alt="Keine Tickets für heute..." />';
				$calFeedback   .=  '</div>';
				return $calFeedback;
			}
			
			$calFeedback   .=  $this->buildSnapShotBlocks("Pendent", $openTickets);
			$calFeedback   .=  $this->buildSnapShotBlocks("Bereit", $readyTickets);
			$calFeedback   .=  $this->buildSnapShotBlocks("Abgeholt / ausgeliefert", $closedTickets);
			$calFeedback   .=  '</div>';
			return $calFeedback;
		}
		
		public static function buildClientInfoBlock($rayClientData, $limitLength=25){
			if(empty($rayClientData) || !$rayClientData) { return "<span>Keine Info.</span>";}
			$customerName   = trim(strip_tags(self::getStreamlinedCustomerName($rayClientData, $limitLength), "<br>,<strong>"));
			
			$sp       = "&nbsp;&nbsp;";
			$address  = trim($rayClientData['Strasse'])                       ? trim($rayClientData['Strasse'])                   : "";
			$address .= ($address && trim($rayClientData['Strassennummer']))  ? " "   . trim($rayClientData['Strassennummer'])    : ( trim($rayClientData['Strassennummer'])  ? trim($rayClientData['Strassennummer']) : "");
			$zipCity  = trim($rayClientData['PLZ'])                           ? trim($rayClientData['PLZ'])                       : "";
			$zipCity .= ($zipCity && trim($rayClientData['Ort']))             ? " "   . trim($rayClientData['Ort'])               : ( trim($rayClientData['Ort'])             ? trim($rayClientData['Ort'])             : "");
			$eContact = trim($rayClientData['Telefon'])                       ? "T: " . trim($rayClientData['Telefon'])           : "";
			$eContact.= ($eContact && trim($rayClientData['Handy']))          ? "{$sp}|{$sp}H: " . trim($rayClientData['Handy'])  : ( trim($rayClientData['Handy']) ? "H: " . trim($rayClientData['Handy']) : "");
			$eContact.= ($eContact && trim($rayClientData['EMail']))          ? "{$sp}|{$sp}E: " . trim($rayClientData['EMail'])  : ( trim($rayClientData['EMail']) ? "E: " . trim($rayClientData['EMail']) : "");
			
			$customerName = trim($customerName) ? "<div><strong>{$customerName}</strong></div>" : "";
			$address      = trim($address)       ? "<div>{$address}</div>"                      : "";
			$zipCity      = trim($zipCity)      ? "<div>{$zipCity}</div>"                       : "";
			$eContact     = trim($eContact)     ? "<div>{$eContact}</div>"                      : "";
			$return       = "<section>{$customerName}{$address}{$zipCity}{$eContact}</section>";
			return $return;
		}
		
		public static function getStreamlinedCustomerName($rayClientData, $limitLength=25){
			$clientCompany  = "";
			$clientFullName = "";
			if(($tcl = $rayClientData) && !empty($rayClientData)){
				$clientFullName = (trim($tcl['name']) || trim($tcl['vorname'])) ? trim(strip_tags($tcl['vorname'] . " " . $tcl['name'],"<br>,<strong>")) : $clientFullName;
				$clientCompany  = trim($tcl['Firma']) ? trim(strip_tags($tcl['Firma'],"<br>,<strong>,<b>,<em>,<i>")) : $clientCompany;
				if($limitLength){
					$clientCompany  = $clientCompany ? substr($clientCompany, 0, $limitLength) : $clientCompany;
					$clientCompany .= strlen($rayClientData['Firma']) > $limitLength ? "..." : "";
				}
			}
			return trim($clientCompany) ? trim($clientCompany) : trim($clientFullName);

		}
		
		public static function getTicketEntry($ticketEntry, $ticket){
			$entryDate          = $ticketEntry['ticketeintrag_datum'];
			$entryDate          = ($entryDate instanceof \DateTime) ? $entryDate->format('d.m.Y') : $entryDate;
			$ticketCreatorHTML  = self::getTicketCreatorHTML($ticketEntry, $ticket);
			$ticketEntryHTML    =<<<TEN
<!-- INDIVIDUAL TICKET POSTS: START -->
<aside class="pz-individual-ticket-post">
	<div class="pz-ticket-text">
		<aside class="pz-ticket-entry">
			<span class="badge">{$entryDate}</span>
			{$ticketEntry['ticketeintrag_eintrag']}
			<div><a class="pz-trash-dis-post fa fa-trash pull-right"
			   href="/mjr/api/v1/ticket-post/delete/{$ticketEntry['ticketeintrag_id']}"
			   data-warn-b4-delete="1"
			   data-delete-question="Möchtest Du wirklich das Ticketpost Nr.  {$ticketEntry['ticketeintrag_id']} <strong style='color:red'>entfernen?</strong>"
			   data-tip="Ticketpost Nr. {$ticketEntry['ticketeintrag_id']}<br/><strong style='color:red;'>entfernen</strong>"></a>
			<a class="pz-add-2-dis-post fa fa-plus-square pull-right"
			   href="/admin/kalender/tickets/ticket-detail/{$ticket['ticket_id']}"
			   data-tip="Neue Post zur<br/>Ticket Nr. {$ticketEntry['ticketeintrag_ticket_id']}<br/><strong style='color:darkgreen;'>hinzufügen</strong>"></a></div>
		</aside>
		
		<!-- TICKET CREATOR: START -->
		{$ticketCreatorHTML}
		<!--  TICKET CREATOR: STOP -->
	</div>
</aside>
<!-- INDIVIDUAL TICKET POSTS: STOP -->
TEN;
			
			return $ticketEntryHTML;
		}
		
		public static function getEntityManager(){
			global $kernel;
			return $kernel->getContainer()->get('doctrine.orm.entity_manager');
		}
		
		public static function getCoWorkerNameByID($coWorkerID, $fullName=false){
			/** @var Personen $person */
			$eMan     = self::getEntityManager();
			$person   = $eMan->getRepository(Personen::class)->findOneBy(['kundenid'=>$coWorkerID]);
			if($person){
				if($fullName){
					return trim("{$person->getVorname()} {$person->getName()}");
				}
				return trim("{$person->getVorname()}");
			}
			return null;
		}
		
		public static function getTicketCreatorHTML($ticketEntry, $ticket){
			$ticketOpener     = null;
			$ticketOpenerHTML = '';
			if($ticketEntry['ticket_opener']){
				$ticketOpener = $ticketEntry['ticket_opener'];
			}else{
				if($ticket['ticket_opener']){
					$ticketOpener = $ticket['ticket_opener'];
				}
			}
			if($ticketOpener){
				$ticketOpenerHTML .= "<div class='pz-ticket-opener'>";
				$ticketOpenerHTML .= "<span data-tip='geschrieben von:<br/>" . self::getCoWorkerNameByID($ticketOpener) . "' ";
				$ticketOpenerHTML .= " class='pz-owner-name pz-ticket-status-{$ticket['ticket_status']} pz-ticket-priority-{$ticket['ticket_prio']}' >";
				$ticketOpenerHTML .= "<span class='fa fa-angle-right'></span>&nbsp;&nbsp;" . self::getCoWorkerNameByID($ticketOpener);
				$ticketOpenerHTML .= "</span>";
				$ticketOpenerHTML .= "</div>";
			}
			return $ticketOpenerHTML;
		}
		
		private function buildSnapShotBlocks($blockTitle, $ticketsData = []){
			$calFeedback    = "";
			if ($ticketsData) {
				$firstTicket  = array_values($ticketsData)[0];
				$calFeedback .= "<div class='pz-snapshot-wrapper pz-snapshot-wrapper-status-{$firstTicket[0]['ticket_status']}'>\n";
				$calFeedback .= "<table>\n<tr>";
				$calFeedback .= "<td class='pz-heading'>{$blockTitle}</td>\n";
				$calFeedback .= "</tr>\n</table>\n";
				
				foreach ($ticketsData as $timeSlot=>$tickets){
					if($tickets){
						$ticket0      = $tickets[0];
						$calFeedback .= "<div class='pz-snapshot-time-group pz-snapshot-time-group-status-{$ticket0['ticket_status']}";
						$calFeedback .= " pz-snapshot-time-group-type-{$ticket0['ticket_typ']}'>\n";
						foreach ($tickets as $iKey=>$singleTicket){
							$ticketClient   = isset($singleTicket['client'])   ? $singleTicket['client']    : [];
							$customerName   = self::getStreamlinedCustomerName($ticketClient, 25);
					
							/* THIS WASN'T CLOSED*/
							# BE SURE TO DISPLAY THE TIME SLOT ONCE
							$ticketTime   = ($iKey == 0 ) ? $timeSlot : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							$calFeedback .= "<div class='pz-snapshot pz-snapshot-status-{$singleTicket['ticket_status']}' id='pz-snapshot-box-{$singleTicket['ticket_id']}'>";
							$calFeedback .= "<table>";
							$calFeedback .= "<tr>\n";
							$calFeedback .= "<td class='pz-time'>{$ticketTime}</td>\n";
							$calFeedback .= "<td class='pz-entry'>";
							
							$clientEditURL= "/admin/kunden/bearbeiten/{$singleTicket['ticket_kunde']}";
							$ticketEditURL= "/admin/kalender/tickets/ticket-detail/{$singleTicket['ticket_id']}";
							$clientEditTip= self::buildClientInfoBlock($ticketClient);

							$calFeedback .= "<aside class='pz-snapshot-entries-wrapper'>";
							$calFeedback .= "<div class='pz-snapshot-hover-trigger'><a href='{$ticketEditURL}' class='pz-ticket-title'><span class='fa fa-link'></span>&nbsp;{$singleTicket['ticket_header']}</a>&nbsp;<span class='fa fa-angle-down pz-toggle-ticket-view pull-right'></span></div>";
							$calFeedback .= "<a href='{$clientEditURL}' data-tip='{$clientEditTip}' class='pz-ticket-client'><span class='fa fa-user'></span>&nbsp;[ {$customerName} ]</a>";
							
							$calFeedback .= "<div class='pz-ticket-posts-group pz-hidden'>";
							if(isset($singleTicket['children']) && !empty($singleTicket['children'])){
								// HERE WE LIST ALL THE POSTS -- DECIDE HOW TO GO WITH RESPECT TO RENDERING...
								// EXTRACT CUSTOMER DATA FROM FIRST ENTRY...
								foreach ($singleTicket['children'] as $iKey2=>$ticketEntry){
									$calFeedback .= self::getTicketEntry($ticketEntry, $singleTicket);
								}
							}
							$calFeedback .=  '</div>';
							
							$calFeedback .=  '</aside>';
					
							$calFeedback .=  '</td></tr>';
							$calFeedback .=  '</table>';
							$calFeedback .=  '</div>';
						}
						$calFeedback .= "</div>\n";
					}
				}
				$calFeedback .= "</div>\n";
			}
			return $calFeedback;
		}
		
		public function buildCalendarStatusFeedBack(){
			return $this->getStatusFeedBackFeed();
		}
		
		
		
		
		
		protected function fetchTicketEntriesByTID($ticketID){
			$ticketEntries  = $this->em->getRepository(Ticketeintrag::class)->findBy(['ticketeintrag_ticket_id' => $ticketID], ['ticketeintrag_id'=>'DESC']);
			return $ticketEntries;
		}
		
		protected function fetchTicketEntriesAlt($ticketID){
			/**@var \Doctrine\DBAL\Query\QueryBuilder $qb */
			$qb   = $this->em->getConnection()->createQueryBuilder();
			$and  = $qb->expr()->andX();
			$and->add($qb->expr()->eq('ten.ticketeintrag_ticket_id', $qb->expr()->literal($ticketID)));
			
			$qb->select( 'ten.*')
			   ->from('ticketeintrag', 'ten')
			   ->where($and)
			   ->addOrderBy('ten.ticketeintrag_datum',    'DESC')
			   ->addOrderBy('ten.ticketeintrag_id',       'DESC');
			return $qb->execute()->fetchAll();
		}
	}