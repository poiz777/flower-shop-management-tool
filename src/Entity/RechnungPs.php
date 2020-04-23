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
	 * RechnungPs
	 * @Table(name="Rechnung_ps")
	 * @Entity(repositoryClass="App\Entity\Repo\RechnungPsRepo")
	 **/
	class RechnungPs { 

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
		 * @Id RechnungPs
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Rechnung Ps Id 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_ps_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_ps_id; 

		/**
		 * @var string
		 * @Column(name="Rechnung_ps_header", type="string", length=40, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Ps Header 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_ps_header</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Rechnung_ps_header; 

		/**
		 * @var string
		 * @Column(name="Rechnung_ps_inhalt", type="string", length=400, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Ps Inhalt 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_ps_inhalt</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Rechnung_ps_inhalt; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getRechnungPsId() {
			return $this->Rechnung_ps_id;
		}

		public function getRechnungPsHeader() {
			return $this->Rechnung_ps_header;
		}

		public function getRechnungPsInhalt() {
			return $this->Rechnung_ps_inhalt;
		}


		public function setRechnungPsId($Rechnung_ps_id) {
			$this->Rechnung_ps_id = $Rechnung_ps_id;
			return $this;
		}

		public function setRechnungPsHeader($Rechnung_ps_header) {
			$this->Rechnung_ps_header = $Rechnung_ps_header;
			return $this;
		}

		public function setRechnungPsInhalt($Rechnung_ps_inhalt) {
			$this->Rechnung_ps_inhalt = $Rechnung_ps_inhalt;
			return $this;
		}




	} 
