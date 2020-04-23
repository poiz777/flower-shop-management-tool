<?php 

	namespace App\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use Doctrine\ORM\Mapping\Id;
	use Doctrine\ORM\Mapping\Table;
	use Doctrine\ORM\Mapping\Column;
	use Doctrine\ORM\Mapping\Entity;
	use Doctrine\ORM\Mapping\OneToOne;
	use Doctrine\ORM\Mapping\JoinColumn;
	use Doctrine\ORM\Mapping\GeneratedValue;
	use Doctrine\ORM\Mapping\JoinColumns;
	use Doctrine\ORM\Mapping\OneToMany;
	use Doctrine\ORM\Mapping\ManyToOne;
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\ORM\Mapping\ManyToMany;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * WebsiteLog
	 * @Table(name="Website_log")
	 * @Entity(repositoryClass="App\Entity\Repo\WebsiteLogRepo")
	 **/
	class WebsiteLog { 

		use EntityFieldMapperTrait; 

		/**
		 * @var array
		 */
		protected $entityBank	= [];
		/**
		 * @var EntityManagerInterface
		 */
		protected $eMan;


		/**
		 * @var int
		 * @Id WebsiteLog
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Website Log Id 
		 * ##FormFieldHint <span class='pz-hint'>Website_log_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Website_log_id; 

		/**
		 * @var int
		 * @Column(name="Website_log_seite", type="smallint", length=3, nullable=false) 
		 * 
		 * ##FormLabel  Website Log Seite 
		 * ##FormFieldHint <span class='pz-hint'>Website_log_seite</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Website_log_seite; 

		/**
		 * @var \Date
		 * @Column(name="Website_log_datum", type="date", nullable=false, options={"default":"0000-00-00"}) 
		 * 
		 * ##FormLabel  Website Log Datum 
		 * ##FormFieldHint <span class='pz-hint'>Website_log_datum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Website_log_datum; 

		/**
		 * @var int
		 * @Column(name="Website_log_zeit", type="time", nullable=false) 
		 * 
		 * ##FormLabel  Website Log Zeit 
		 * ##FormFieldHint <span class='pz-hint'>Website_log_zeit</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Website_log_zeit; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getWebsiteLogId() {
			return $this->Website_log_id;
		}

		public function getWebsiteLogSeite() {
			return $this->Website_log_seite;
		}

		public function getWebsiteLogDatum() {
			return $this->Website_log_datum;
		}

		public function getWebsiteLogZeit() {
			return $this->Website_log_zeit;
		}


		public function setWebsiteLogId($Website_log_id) {
			$this->Website_log_id = $Website_log_id;
			return $this;
		}

		public function setWebsiteLogSeite($Website_log_seite) {
			$this->Website_log_seite = $Website_log_seite;
			return $this;
		}

		public function setWebsiteLogDatum($Website_log_datum) {
			$this->Website_log_datum = $Website_log_datum;
			return $this;
		}

		public function setWebsiteLogZeit($Website_log_zeit) {
			$this->Website_log_zeit = $Website_log_zeit;
			return $this;
		}




	} 
