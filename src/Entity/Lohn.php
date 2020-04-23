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
	 * Lohn
	 * @Table(name="Lohn")
	 * @Entity(repositoryClass="App\Entity\Repo\LohnRepo")
	 **/
	class Lohn { 

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
		 * @Id Lohn
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Lohn Id 
		 * ##FormFieldHint <span class='pz-hint'>Lohn_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Lohn_id; 

		/**
		 * @var int
		 * @Column(name="Lohn_ma", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel  Lohn Ma 
		 * ##FormFieldHint <span class='pz-hint'>Lohn_ma</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Lohn_ma; 

		/**
		 * @var int
		 * @Column(name="Lohn_soll", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel  Lohn Soll 
		 * ##FormFieldHint <span class='pz-hint'>Lohn_soll</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Lohn_soll; 

		/**
		 * @var int
		 * @Column(name="Lohn_haben", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel  Lohn Haben 
		 * ##FormFieldHint <span class='pz-hint'>Lohn_haben</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Lohn_haben; 

		/**
		 * @var double
		 * @Column(name="Lohn_betrag", type="text", length=10, nullable=false) 
		 * 
		 * ##FormLabel  Lohn Betrag 
		 * ##FormFieldHint <span class='pz-hint'>Lohn_betrag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Lohn_betrag; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getLohnId() {
			return $this->Lohn_id;
		}

		public function getLohnMa() {
			return $this->Lohn_ma;
		}

		public function getLohnSoll() {
			return $this->Lohn_soll;
		}

		public function getLohnHaben() {
			return $this->Lohn_haben;
		}

		public function getLohnBetrag() {
			return $this->Lohn_betrag;
		}


		public function setLohnId($Lohn_id) {
			$this->Lohn_id = $Lohn_id;
			return $this;
		}

		public function setLohnMa($Lohn_ma) {
			$this->Lohn_ma = $Lohn_ma;
			return $this;
		}

		public function setLohnSoll($Lohn_soll) {
			$this->Lohn_soll = $Lohn_soll;
			return $this;
		}

		public function setLohnHaben($Lohn_haben) {
			$this->Lohn_haben = $Lohn_haben;
			return $this;
		}

		public function setLohnBetrag($Lohn_betrag) {
			$this->Lohn_betrag = $Lohn_betrag;
			return $this;
		}




	} 
