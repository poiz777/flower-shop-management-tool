<?php
	
	
	namespace App\Helpers\Date;
	
	
	use App\Controller\AdminController;
	use App\Entity\User;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Security\Core\User\UserInterface;
	
	class RequestBridge {
		
		/**
		 * @var SessionInterface
		 */
		private  $session;
		
		/**
		 * @var Request
		 */
		private  $request;
		
		/**
		 * @var UserInterface
		 */
		private  $user;
		
		/**
		 * @var string
		 */
		const SessionNameSpace = 'MelanieApp';
		/**
		 * RequestBridge constructor.
		 *
		 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
		 */
		public function __construct(SessionInterface $session) {
			$this->session  = $session;
			
		}
		
		/**
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 */
		public function setRequest(Request $request){
			$this->request  = $request;
		}
		
		
		/**
		 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
		 * @param UserInterface                                              $user
		 */
		public function setUser(UserInterface $user){
			$this->user     = $user;
		}
		
		public function initialize(){ // SessionInterface $session, UserInterface $user
			$melanieSession   = $this->session->get(static::SessionNameSpace, []);
			
			if(!isset($melanieSession['user'])){
				$melanieSession['user']  = $this->user;
			}
			
			if(isset($melanieSession['ipp'])){
				if($this->getRequestParamByKey('ipp')  && $this->getRequestParamByKey('ipp') != $melanieSession['ipp']){
					$melanieSession['ipp']  = $this->getRequestParamByKey('ipp');
				}
			}else{
				$melanieSession['ipp']  = AdminController::IPP_DEFAULT;
			}
			
			if(isset($melanieSession['month'])){
				if($this->getRequestParamByKey('month')  && $this->getRequestParamByKey('month') != $melanieSession['month']){
					$melanieSession['month']  = $this->getRequestParamByKey('month');
				}
			}else{
				$melanieSession['month']  = date('m');
			}
			
			if(isset($melanieSession['year'])){
				if($this->getRequestParamByKey('year')  && $this->getRequestParamByKey('year') !=  $melanieSession['year']){
					$melanieSession['year']  = $this->getRequestParamByKey('year');
				}
			}else{
				$melanieSession['year']  = date('Y');
			}
			
			if(isset($melanieSession['day'])){
				if($this->getRequestParamByKey('day')  && $this->getRequestParamByKey('day') != $melanieSession['day']){
					$melanieSession['day']  = ($dy = $this->getRequestParamByKey('day')) ? $dy : date('d');
				}
			}else{
				$melanieSession['day']  = date('d');
			}
			
			if(isset($melanieSession['week'])){
				if($this->getRequestParamByKey('week')  && $this->getRequestParamByKey('week') != $melanieSession['week']){
					$melanieSession['week']  = $this->getRequestParamByKey('week');
				}
			}else{
				$melanieSession['week']  = date('W');
			}
			
			if(isset($melanieSession['department'])){
				if($this->getRequestParamByKey('department')  && $this->getRequestParamByKey('department') != $melanieSession['department']){
					/** @var \Doctrine\ORM\EntityManager $entityManager */
					/** @var \App\Entity\Personen $coWorker */
					global $kernel;
					$entityManager  = $kernel->getContainer()->get('doctrine.orm.entity_manager');
					$melanieSession['department']  = $this->getRequestParamByKey('department');
					$user = $entityManager->getRepository(User::class)->findOneBy(['person_id'=>$melanieSession['department']]);
					if($user){
						$melanieSession['user']  = $user;
						$this->user = $user;
					}
				}
			}else {
					$melanieSession['department'] = $this->user->getPersonId();
			}
			
			if(isset($melanieSession['time'])){
				if($this->getRequestParamByKey('time')  && $this->getRequestParamByKey('time') != $melanieSession['time']){
					$melanieSession['time']  = $this->getRequestParamByKey('time');
				}
			}else{
				$melanieSession['time']  =  date('H:i:s');
			}
			
			$melanieSession['hour']       =  date('H');
			$melanieSession['minutes']    =  date('i');
			$melanieSession['seconds']    =  date('s');
			$this->session->set(static::SessionNameSpace, $melanieSession);
			$this->updateSessionData();
			return $this->user;
		}
		
		public function updateSessionData(){
			$requestData      = $this->getRequestData();
			$melanieSession   = $this->session->get(static::SessionNameSpace, []);
			
			if(empty($requestData)){
				$melanieSession['day']        =  date('d');
				$melanieSession['month']      =  date('m');
				$melanieSession['year']       =  date('Y');
				$melanieSession['week']       =  date('W');
				
				foreach ($melanieSession as $melKey=>&$melVal) { /*$melVal = null; */ }
			}
			foreach ($requestData as $requestKey=>$requestVal) {
				if ( $requestVal ) {
					$melanieSession[ $requestKey ] = $requestVal;
				}
			}
			$this->session->set(static::SessionNameSpace, $melanieSession);
			
		}
		
		public function getRequestData(){
			return array_merge($_GET, $_POST);
		}
		
		public function getRequestParamByKey($key, $default=null){
			$requestData = $this->getRequestData();
			if( isset($requestData[$key]) ){
				return $requestData[$key];
			}
			return $default;
		}
	}
	
	/*
	 
			$department = ($dp = $request->get('department')) ? $dp : null;
			$month      = ($mn = $request->get('month')) ? $mn : date('m');
			$year       = ($yr = $request->get('year')) ? $yr : date('Y');
			$day        = ($yr = $request->get('day')) ? $yr : date('d');
			
	
				// Es beginnt der Kalender
				// Existiert schon eine Session f�r den Kalender? Oder wurde auf den heute-Button geklickt?
				if (!$_SESSION['kalender'] OR $_REQUEST[heute] == 1) {
					$_SESSION['day'] = $aktueller_tag;
					if (substr($_SESSION['day'], 0, 1) == "0") $_SESSION['day'] = substr($_SESSION['day'], 1);
					$_SESSION['monat'] = $aktueller_monat;
					if (substr($_SESSION['monat'], 0, 1) == "0") $_SESSION['monat'] = substr($_SESSION['monat'], 1);
					$_SESSION['jahr'] = $aktuelles_jahr;
					$_SESSION['kalender'] = 1;
					$_SESSION['kalenderwoche'] = kalwoche($_SESSION['day'], $_SESSION['monat'], $_SESSION['jahr']);
				}
				// Alle Eventualit�ten einlesen
				// Wurde ein anderer Tag gew�hlt?
				if ($_REQUEST['mut_tag']) {
					$_SESSION['day'] = $_REQUEST['mut_tag'];
					
					$_SESSION['monat'] = $aktueller_monat;
					if (substr($_SESSION['monat'], 0, 1) == "0") $_SESSION['monat'] = substr($_SESSION['monat'], 1);
					
					$_SESSION['kalenderwoche'] = kalwoche($_SESSION['day'], $_SESSION['monat'], $_SESSION['jahr']);
				}
				// Wurde ein anderer Monat gew�hlt?
				if ($_REQUEST['mut_monat']) {
					$_SESSION['monat'] = $_REQUEST['mut_monat'];
					$_SESSION['day'] = 1;
					$_SESSION['kalenderwoche'] = kalwoche($_SESSION['day'], $_SESSION['monat'], $_SESSION['jahr']);
				}
				// Wurde ein anderes Jahr gew�hlt?
				if ($_REQUEST['mut_jahr']) {
					$_SESSION['jahr'] = $_REQUEST['mut_jahr'];
					// Hat der Monat im neu gew�hlten Jahr weniger Tag als der aktuell gew�hlte? Dann korrigieren
					if (anzahltage_monat($_SESSION['monat'], $_SESSION['jahr']) < $_SESSION['day']) $_SESSION['day'] -= 1;
					$_SESSION['kalenderwoche'] = kalwoche($_SESSION['day'], $_SESSION['monat'], $_SESSION['jahr']);
				}
				// Wurde ein anderes Datum gew�hlt, z.B. von der Kalender-Wochenansicht aus?
				if ($_REQUEST['mut_datum']) {
					$_SESSION['jahr'] = $_REQUEST['mut_jahr'];
					$_SESSION['monat'] = $_REQUEST['mut_monat'];
					$_SESSION['day'] = $_REQUEST['mut_tag'];
					// Hat der Monat im neu gew�hlten Jahr weniger Tag als der aktuell gew�hlte? Dann korrigieren
					if (anzahltage_monat($_SESSION['monat'], $_SESSION['jahr']) < $_SESSION['day']) $_SESSION['day'] -= 1;
					$_SESSION['kalenderwoche'] = kalwoche($_SESSION['day'], $_SESSION['monat'], $_SESSION['jahr']);
				}
				// Wurde eine andere Kalenderwoche gew�hlt? Dann ersten Tag auslesen
				if ($_REQUEST['mut_kw']) {
					$_SESSION['kalenderwoche'] = $_REQUEST['mut_kw'];
					// Anderes Jahr? Das k�nnte sein, wenn der user auf aktuelle Woche geklickt hat
					if ($_REQUEST['mut_y']) $_SESSION['jahr'] = $_REQUEST['mut_y'];
					list($tag_kw, $mon_kw, $jahr_kw, $kw_kw) = beginn_kw($_SESSION['kalenderwoche'], $_SESSION['jahr']);
					// Wenn die KW1 ist, dann ist der Tag und Monat immer 1
					if ($_REQUEST['mut_kw'] == 1) {
						$wtag_ersterjanuar = wochentagnr(1, 1, $_SESSION['jahr']);
						if ($kw == 1 AND $wtag_ersterjanuar < 5 AND $wtag_ersterjanuar != 1) $tag_kw = 1;
					}
					$_SESSION['day'] = $tag_kw;
					// Werte auslesen
//			echo 'Tagday= '.$_SESSION['day'].'kw='.$kw_kw.'mon='.$mon_kw.'jahr='.$jahr_kw.'<br>';
					$_SESSION['monat'] = $mon_kw;
					$_SESSION['jahr'] = $jahr_kw;
					$_SESSION['kalenderwoche'] = $kw_kw;
				}
				// Wurde der Tag eins nach vorne oder zur�ck geswitched?
				if ($_REQUEST['tag_switch']) {
					list($tag_switch, $mon_switch, $jahr_switch) = delta_tag($_SESSION['day'], $_SESSION['monat'], $_SESSION['jahr'], $_REQUEST['tag_switch']);
					$_SESSION['day'] = $tag_switch;
					if (substr($_SESSION['day'], 0, 1) == "0") $_SESSION['day'] = substr($_SESSION['day'], 1);
					$_SESSION['monat'] = $mon_switch;
					if (substr($_SESSION['monat'], 0, 1) == "0") $_SESSION['monat'] = substr($_SESSION['monat'], 1);
					$_SESSION['jahr'] = $jahr_switch;
					$_SESSION['kalenderwoche'] = kalwoche($_SESSION['day'], $_SESSION['monat'], $_SESSION['jahr']);
				}
				// Wurde die Kalenderwoche noch vorne oder zur�ck geswitched?
				if ($_REQUEST['kw_switch']) {
					$_SESSION['kalenderwoche'] += $_REQUEST['kw_switch'];
					$anz_wochen = kalwoche(28, 12, $_SESSION['jahr']);
					// Wenn die KW1 um 1 zur�ckgeswiched wurde, zuerst schauen, wie viele KW das vordere Jahr hatte (der 28. 12. ist immer in der letzten KW)
					if ($_SESSION['kalenderwoche'] == 0) {
						$_SESSION['kalenderwoche'] = kalwoche(28, 12, $_SESSION['jahr']-1);
						$_SESSION['jahr'] -= 1;
						$_SESSION['monat'] = 12;
						list($t, $m) = beginn_kw($_SESSION['kalenderwoche'], $_SESSION['jahr']);
						$_SESSION['day'] = $t;
					} else if (($_SESSION['kalenderwoche'] == 53 AND $anz_wochen != 53) OR $_SESSION['kalenderwoche'] == 54) {
						// KW im neuen Jahr
						$_SESSION['kalenderwoche'] = 1;
						$_SESSION['jahr'] += 1;
						list($t, $m) = beginn_kw($_SESSION['kalenderwoche'], $_SESSION['jahr']);
						$_SESSION['day'] = $t;
						$_SESSION['monat'] = $m;
						if ($t > 25) {
							$_SESSION['day'] = 1;
							$_SESSION['monat'] = 1;
						}
					} else {
						list($tag_kw, $mon_kw) = beginn_kw($_SESSION['kalenderwoche'], $_SESSION['jahr']);
						$_SESSION['day'] = $tag_kw;
						$_SESSION['monat'] = $mon_kw;
					}
				}
				// Diese Werte in jedem Fall einlesen
				$_SESSION['zeit'] = $stdmin;
	 */