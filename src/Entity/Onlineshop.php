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
	 * Onlineshop
	 * @Table(name="onlineshop")
	 * @Entity(repositoryClass="App\Entity\Repo\OnlineshopRepo")
	 **/
	class Onlineshop { 

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
		 * @Id Onlineshop
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Onlineshop Id 
		 * ##FormFieldHint <span class='pz-hint'>onlineshop_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $onlineshop_id; 

		/**
		 * @var int
		 * @Column(name="onlineshop_bestellt", type="smallint", length=2, nullable=true) 
		 * 
		 * ##FormLabel Onlineshop Bestellt 
		 * ##FormFieldHint <span class='pz-hint'>onlineshop_bestellt</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $onlineshop_bestellt; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getOnlineshopId() {
			return $this->onlineshop_id;
		}

		public function getOnlineshopBestellt() {
			return $this->onlineshop_bestellt;
		}


		public function setOnlineshopId($onlineshop_id) {
			$this->onlineshop_id = $onlineshop_id;
			return $this;
		}

		public function setOnlineshopBestellt($onlineshop_bestellt) {
			$this->onlineshop_bestellt = $onlineshop_bestellt;
			return $this;
		}




	} 
