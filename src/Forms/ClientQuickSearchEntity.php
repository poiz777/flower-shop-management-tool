<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * ClientSearchEntity
	 **/
	class ClientQuickSearchEntity {
		
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
		 * @var string
		 * ##FormLabel Suchbegriff
		 * ##FormFieldHint <span class='pz-hint'>Irgendeine Suchbegriff eingeben...</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormUseLabel 0
		 * ##FormAddLabel 0
		 * ##FormPlaceholder Irgendeine Suchbegriff eingeben...
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Suchbegriff;
		
		protected static $instance;

		public function __construct(){
			$this->initializeEntityBank();
		}
		
		/**
		 * @return string
		 */
		public function getSuchbegriff(){
			return $this->Suchbegriff;
		}
		
		/**
		 * @param string $Suchbegriff
		 *
		 * @return ClientQuickSearchEntity
		 */
		public function setSuchbegriff( $Suchbegriff ): ClientQuickSearchEntity {
			$this->Suchbegriff = $Suchbegriff;
			
			return $this;
		}

		


	} 
