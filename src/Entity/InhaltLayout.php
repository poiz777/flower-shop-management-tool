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
	 * InhaltLayout
	 * @Table(name="Inhalt_layout")
	 * @Entity(repositoryClass="App\Entity\Repo\InhaltLayoutRepo")
	 **/
	class InhaltLayout { 

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
		 * @Id InhaltLayout
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Inhalt Layout Id 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_layout_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Inhalt_layout_id; 

		/**
		 * @var int
		 * @Column(name="Inhalt_layout_Inhalt_container_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Layout Inhalt Container Id 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_layout_Inhalt_container_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Inhalt_layout_Inhalt_container_id; 

		/**
		 * @var int
		 * @Column(name="Inhalt_layout_Inhalt_daten_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Layout Inhalt Daten Id 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_layout_Inhalt_daten_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Inhalt_layout_Inhalt_daten_id; 

		/**
		 * @var int
		 * @Column(name="Inhalt_layout_order", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Layout Order 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_layout_order</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Inhalt_layout_order; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getInhaltLayoutId() {
			return $this->Inhalt_layout_id;
		}

		public function getInhaltLayoutInhaltContainerId() {
			return $this->Inhalt_layout_Inhalt_container_id;
		}

		public function getInhaltLayoutInhaltDatenId() {
			return $this->Inhalt_layout_Inhalt_daten_id;
		}

		public function getInhaltLayoutOrder() {
			return $this->Inhalt_layout_order;
		}


		public function setInhaltLayoutId($Inhalt_layout_id) {
			$this->Inhalt_layout_id = $Inhalt_layout_id;
			return $this;
		}

		public function setInhaltLayoutInhaltContainerId($Inhalt_layout_Inhalt_container_id) {
			$this->Inhalt_layout_Inhalt_container_id = $Inhalt_layout_Inhalt_container_id;
			return $this;
		}

		public function setInhaltLayoutInhaltDatenId($Inhalt_layout_Inhalt_daten_id) {
			$this->Inhalt_layout_Inhalt_daten_id = $Inhalt_layout_Inhalt_daten_id;
			return $this;
		}

		public function setInhaltLayoutOrder($Inhalt_layout_order) {
			$this->Inhalt_layout_order = $Inhalt_layout_order;
			return $this;
		}




	} 
