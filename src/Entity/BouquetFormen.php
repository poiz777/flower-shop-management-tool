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
	 * BouquetFormen
	 * @Table(name="bouquet_formen")
	 * @Entity(repositoryClass="App\Entity\Repo\BouquetFormenRepo")
	 **/
	class BouquetFormen { 

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
		 * @Id BouquetFormen
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Bouquetformenid 
		 * ##FormFieldHint <span class='pz-hint'>bouquetformenid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $bouquetformenid; 

		/**
		 * @var string
		 * @Column(name="bouquetform", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel Bouquetform 
		 * ##FormFieldHint <span class='pz-hint'>bouquetform</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $bouquetform; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getBouquetformenid() {
			return $this->bouquetformenid;
		}

		public function getBouquetform() {
			return $this->bouquetform;
		}


		public function setBouquetformenid($bouquetformenid) {
			$this->bouquetformenid = $bouquetformenid;
			return $this;
		}

		public function setBouquetform($bouquetform) {
			$this->bouquetform = $bouquetform;
			return $this;
		}




	} 
