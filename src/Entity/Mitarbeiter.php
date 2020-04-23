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
	 * Mitarbeiter
	 * @Table(name="Mitarbeiter")
	 * @Entity(repositoryClass="App\Entity\Repo\MitarbeiterRepo")
	 **/
	class Mitarbeiter { 

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
		 * @Id Mitarbeiter
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Mitarbeiterid 
		 * ##FormFieldHint <span class='pz-hint'>mitarbeiterid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $mitarbeiterid; 

		/**
		 * @var int
		 * @Column(name="mitarbeiterberechtigung", type="integer", length=3, nullable=false, options={"default":1}) 
		 * 
		 * ##FormLabel Mitarbeiterberechtigung 
		 * ##FormFieldHint <span class='pz-hint'>mitarbeiterberechtigung</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $mitarbeiterberechtigung; 

		/**
		 * @var string
		 * @Column(name="mitarbeitername", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel Mitarbeitername 
		 * ##FormFieldHint <span class='pz-hint'>mitarbeitername</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $mitarbeitername; 

		/**
		 * @var string
		 * @Column(name="mitarbeitervorname", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel Mitarbeitervorname 
		 * ##FormFieldHint <span class='pz-hint'>mitarbeitervorname</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $mitarbeitervorname; 

		/**
		 * @var string
		 * @Column(name="mitarbeiteremail", type="string", length=40, nullable=false) 
		 * 
		 * ##FormLabel Mitarbeiteremail 
		 * ##FormFieldHint <span class='pz-hint'>mitarbeiteremail</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $mitarbeiteremail; 

		/**
		 * @var string
		 * @Column(name="mitarbeiterpass", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel Mitarbeiterpass 
		 * ##FormFieldHint <span class='pz-hint'>mitarbeiterpass</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $mitarbeiterpass; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getMitarbeiterid() {
			return $this->mitarbeiterid;
		}

		public function getMitarbeiterberechtigung() {
			return $this->mitarbeiterberechtigung;
		}

		public function getMitarbeitername() {
			return $this->mitarbeitername;
		}

		public function getMitarbeitervorname() {
			return $this->mitarbeitervorname;
		}

		public function getMitarbeiteremail() {
			return $this->mitarbeiteremail;
		}

		public function getMitarbeiterpass() {
			return $this->mitarbeiterpass;
		}


		public function setMitarbeiterid($mitarbeiterid) {
			$this->mitarbeiterid = $mitarbeiterid;
			return $this;
		}

		public function setMitarbeiterberechtigung($mitarbeiterberechtigung) {
			$this->mitarbeiterberechtigung = $mitarbeiterberechtigung;
			return $this;
		}

		public function setMitarbeitername($mitarbeitername) {
			$this->mitarbeitername = $mitarbeitername;
			return $this;
		}

		public function setMitarbeitervorname($mitarbeitervorname) {
			$this->mitarbeitervorname = $mitarbeitervorname;
			return $this;
		}

		public function setMitarbeiteremail($mitarbeiteremail) {
			$this->mitarbeiteremail = $mitarbeiteremail;
			return $this;
		}

		public function setMitarbeiterpass($mitarbeiterpass) {
			$this->mitarbeiterpass = $mitarbeiterpass;
			return $this;
		}




	} 
