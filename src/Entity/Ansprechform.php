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
	 * Ansprechform
	 * @Table(name="Ansprechform")
	 * @Entity(repositoryClass="App\Entity\Repo\AnsprechformRepo")
	 **/
	class Ansprechform {
		use EntityFieldMapperTrait;
		use FormObjectLexer;

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
		 * @Id Ansprechform
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Ansprechform Id 
		 * ##FormFieldHint <span class='pz-hint'>Ansprechform_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\Biller\HTML\Widgets\FormElements\Number 
		 */
		protected $Ansprechform_id; 

		/**
		 * @var string
		 * @Column(name="Ansprechform_name", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Ansprechform Name 
		 * ##FormFieldHint <span class='pz-hint'>Ansprechform_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\Biller\HTML\Widgets\FormElements\Text 
		 */
		protected $Ansprechform_name;
		
		
		/**
		 * @var \App\Entity\Ansprechform
		 */
		protected static $instance;

		public function __construct(){
			static::$instance = $this;
			$this->initializeEntityBank(); 
		}


		public function getAnsprechformId() {
			return $this->Ansprechform_id;
		}

		public function getAnsprechformName() {
			return $this->Ansprechform_name;
		}


		public function setAnsprechformId($Ansprechform_id) {
			$this->Ansprechform_id = $Ansprechform_id;
			return $this;
		}

		public function setAnsprechformName($Ansprechform_name) {
			$this->Ansprechform_name = $Ansprechform_name;
			return $this;
		}




	} 
