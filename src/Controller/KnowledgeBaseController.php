<?php
	
	namespace App\Controller;
	
	use App\Entity\KnowledgeEintrag;
	use App\Entity\KnowledgeKategorie;
	use App\Entity\Tickets;
	use App\Helpers\Date\DateCalculator;
	use App\Helpers\Date\RequestBridge;
	use App\Poiz\HTML\Forms\KnowledgeCategoryForm;
	use App\Poiz\HTML\Forms\KnowledgeEntryForm;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use App\Poiz\Traits\AdminControllerHelperTrait;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	
	class KnowledgeBaseController extends AbstractController {
		use AdminControllerHelperTrait;
		/**
		 * @var \Doctrine\ORM\EntityManagerInterface
		 */
		private $entityManager;
		
		/**
		 * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
		 */
		private $session;
		
		/**
		 * @var array
		 */
		private $melSession = [];
		
		const NEW_ITEM = 'NEW';
		/**
		 * AdminController constructor.
		 *
		 * @param \Doctrine\ORM\EntityManagerInterface                       $entityManager
		 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
		 */
		public function __construct(EntityManagerInterface $entityManager, SessionInterface $session) {
			$this->entityManager  = $entityManager;
			$this->session        = $session;
		}
		
		/**
		 * @Route("/admin/wissen", name="rte_admin_knowledge_base")
		 */
		public function knowledgeBase(Request $request,  DateCalculator $dateCalculator, RequestBridge $rb) {
			return $this->redirectToRoute("rte_knowledge_base_list");
		}
		
		/**
		 * @Route("/admin/wissen/wissendatenbank/auflistung/loeschen/{id}", name="rte_delete_knowledge_base_entry")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 * @param null                                      $id
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function deleteKnowledgeBaseEntry(Request $request, ShopTranslator $translator, $id = null) {
			return $this->editKnowledgeBaseEntry($request, $translator, $id, 'delete');
			# return $this->redirectToRoute('rte_show_knowledge_base_detail');
		}
		
		/**
		 * @Route("/admin/wissen/wissendatenbank/neu", name="rte_new_knowledge_base_entry")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 * @param null                                      $id
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function newKnowledgeBaseEntry (Request $request, ShopTranslator $translator, $id = null) {
			return $this->editKnowledgeBaseEntry($request, $translator, $id, 'new');
		}
		
		/**
		 * @Route("/admin/wissen/wissendatenbank/auflistung/bearbeiten/{id}", name="rte_edit_knowledge_base_entry")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 * @param null                                      $id
		 * @param bool                                      $task
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function editKnowledgeBaseEntry(Request $request, ShopTranslator $translator, $id=null, $task=null) {
			/** @var KnowledgeEintrag $knowledgeData */
			$pageTitle        = "Wissendatenbank Eintrag bearbeiten";
			$knowledgeData    = new KnowledgeEintrag();
			$statusMsg        = null;
			
			if($id){
				$knowledgeData  = $this->entityManager->getRepository(KnowledgeEintrag::class)->find($id);
				$pageTitle      = "Wissendatenbank Eintrag: <span class='pz-page-sub-title'>«" . $knowledgeData->getKnowledgeEintragfrage() . " - {$knowledgeData->getKnowledgeEintragID()}» bearbeiten...</span>";
			}
			
			if($task == 'new'){
				$pageTitle      = "Neue Wissendatenbank Eintrag erstellen,";
				$statusMsg      = static::NEW_ITEM;
			}else if($task == 'delete'){
				if($knowledgeData){
					$statusMsg      = "Der Eintrag: «" . $knowledgeData->getKnowledgeEintragfrage() . " - {$knowledgeData->getKnowledgeEintragID()}» wurde erfolgreich aus den Wissendatenbank gelöscht...";
					$this->entityManager->remove($knowledgeData);
					$this->entityManager->flush();
					$this->addFlash('success', $statusMsg);
					return $this->redirectToRoute('rte_admin_knowledge_base');
				}
			}
			$form             = new KnowledgeEntryForm($knowledgeData);
			$form->setTranslator($translator);
			
			if($knowledgeData = $form->isValid($request->request->all())){
				$this->entityManager->persist($knowledgeData);
				$this->entityManager->flush();
				$statusMsg  = $statusMsg === static::NEW_ITEM ? "Neue Wissendatenbank Eintrag:«" . $knowledgeData->getKnowledgeEintragfrage() . " - {$knowledgeData->getKnowledgeEintragID()}» wurde erstellt...": $statusMsg;
				$statusMsg  = $statusMsg ? $statusMsg : "Der WDB Eintrag «{$knowledgeData->getKnowledgeEintragfrage()}» mit ID: {$knowledgeData->getKnowledgeEintragID()}  wurde erfolgreich aktualisiert.";
				$this->addFlash('success', $statusMsg);
				
				# return $this->redirectToRoute('rte_knowledge_base_list');
				return $this->redirectToRoute('rte_show_knowledge_base_detail', ['id' => $knowledgeData->getKnowledgeEintragID()]);
			}
			return $this->render( 'knowledge_base/knowledge-base-list.html.twig', [
				'formWidgets'       => $form->getForm(),
				'controller_name'   => 'KnowledgeBaseController',
				'knowledgeBaseData' => $this->fetchKnowledgeData(),
				'user'              => $this->getUser(),
				'navPayload'        => $this->getNavigationPayload(),
				'pageTitle'         => $pageTitle,
				'detailData'        => $knowledgeData,
				'btnText'           => 'Los',
			] );
		}
		
		/**
		 * @Route("/admin/wissen/wissendatenbank/auflistung/detail/{id}", name="rte_show_knowledge_base_detail")
		 */
		public function showKnowledgeBaseDetail($id = null) {
			$pageTitle        = "Wissendatenbank - Auflistung";
			$tickets          = null;
			$knowledgeData    = null;
			if($id){
				/** @var KnowledgeEintrag $knowledgeData */
				$tickets        = $this->fetchAllTicketsAssociatedWithKnowledgeEntry($id);
				$knowledgeData  = $this->entityManager->getRepository(KnowledgeEintrag::class)->find($id);
				$pageTitle      = "WissendatenbankEintrag: <span class='pz-page-sub-title'>" . $knowledgeData->getKnowledgeEintragfrage() . "</span>";
			}
			return $this->render( 'knowledge_base/knowledge-base-list.html.twig', [
				# 'formWidgets'       => $form->getForm(),
				# 'coWorkers'         => $this->fetchCoWorkers(),
				'controller_name'   => 'KnowledgeBaseController',
				'knowledgeBaseData' => $this->fetchKnowledgeData(),
				'tickets'           => $tickets,
				'user'              => $this->getUser(),
				'navPayload'        => $this->getNavigationPayload(),
				'pageTitle'         => $pageTitle,
				'detailData'        => $knowledgeData,
				'btnText'           => 'Los',
			] );
		}
		
		/**
		 * @Route("/admin/wissen/wissendatenbank/auflistung", name="rte_knowledge_base_list")
		 */
		public function knowledgeBaseList() {
			return $this->render( 'knowledge_base/knowledge-base-list.html.twig', [
				# 'formWidgets'       => $form->getForm(),
				# 'coWorkers'         => $this->fetchCoWorkers(),
				'controller_name'   => 'KnowledgeBaseController',
				'knowledgeBaseData' => $this->fetchKnowledgeData(),
				'user'              => $this->getUser(),
				'navPayload'        => $this->getNavigationPayload(),
				'pageTitle'         => "Wissendatenbank - Auflistung",
				'btnText'           => 'Los',
			] );
		}
		
		
		/**
		 * @Route("/admin/wissen/wissendatenbank/kategorien/neu", name="rte_knowledge_base_new_category")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 * @param null                                      $id
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function newKnowledgeBaseCategoryEntry (Request $request, ShopTranslator $translator, $id = null) {
			return $this->editKnowledgeBaseCategory($request, $translator, $id, 'new');
		}
		
		/**
		 * @Route("/admin/wissen/wissendatenbank/kategorien/loeschen/{id}", name="rte_delete_knowledge_base_category")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 * @param null                                      $id
		 *
		 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
		 */
		public function deleteKnowledgeBaseCategory(Request $request, ShopTranslator $translator, $id = null) {
			return $this->editKnowledgeBaseCategory($request, $translator, $id, 'delete');
		}
		
		/**
		 * @Route("/admin/wissen/wissendatenbank/kategorien/bearbeiten/{id}", name="rte_edit_knowledge_base_category")
		 * @param \Symfony\Component\HttpFoundation\Request $request
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator     $translator
		 * @param null                                      $id
		 * @param bool                                      $task
		 *
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function editKnowledgeBaseCategory(Request $request, ShopTranslator $translator, $id=null, $task=null) {
			/** @var KnowledgeKategorie $knowledgeCat */
			$pageTitle        = "Wissendatenbank Kategorie bearbeiten";
			$knowledgeCat     = new KnowledgeKategorie();
			$statusMsg        = null;
			
			if($id){
				$knowledgeCat  = $this->entityManager->getRepository(KnowledgeKategorie::class)->find($id);
				$pageTitle      = "Wissendatenbank Kategorie: <span class='pz-page-sub-title'>«" . $knowledgeCat->getKnowledgeKategoriename() . " - {$knowledgeCat->getKnowledgeKategorieID()}» bearbeiten...</span>";
			}
			
			if($task == 'new'){
				$pageTitle      = "Neue Wissendatenbank Kategorie erstellen,";
				$statusMsg      = static::NEW_ITEM;
			}else if($task == 'delete'){
				if($knowledgeCat){
					$statusMsg      = "Die Kategorie: «" . $knowledgeCat->getKnowledgeKategoriename() . " - {$knowledgeCat->getKnowledgeKategorieID()}» wurde erfolgreich aus den Wissendatenbank gelöscht...";
					$this->entityManager->remove($knowledgeCat);
					$this->entityManager->flush();
					$this->addFlash('success', $statusMsg);
					return $this->redirectToRoute('rte_knowledge_base_categories', []);
				}
			}
			$form             = new KnowledgeCategoryForm($knowledgeCat);
			$form->setTranslator($translator);
			
			if($knowledgeCat = $form->isValid($request->request->all())){
				$this->entityManager->persist($knowledgeCat);
				$this->entityManager->flush();
				$statusMsg  = $statusMsg === static::NEW_ITEM ? "Neue Wissendatenbank Kategorie: «" . $knowledgeCat->getKnowledgeKategoriename() . " - {$knowledgeCat->getKnowledgeKategorieID()}» wurde erstellt...": $statusMsg;
				$statusMsg  = $statusMsg ? $statusMsg : "Die WDB Kategorie «{$knowledgeCat->getKnowledgeKategoriename()}» mit ID: {$knowledgeCat->getKnowledgeKategorieID()}  wurde erfolgreich aktualisiert.";
				$this->addFlash('success', $statusMsg);
				
				return $this->redirectToRoute('rte_knowledge_base_categories', []);
			}
			return $this->render( 'knowledge_base/knowledge-base-categories.html.twig', [
				'formWidgets'       => $form->getForm(),
				'controller_name'   => 'KnowledgeBaseController',
				'knowledgeBaseData' => $this->fetchKnowledgeCategoriesData(),
				'user'              => $this->getUser(),
				'navPayload'        => $this->getNavigationPayload(),
				'pageTitle'         => $pageTitle,
				'detailData'        => $knowledgeCat,
				'btnText'           => 'Los',
			] );
		}
		
		/**
		 * @Route("/admin/wissen/wissendatenbank/kategorien", name="rte_knowledge_base_categories")
		 */
		public function knowledgeBaseCategories() {
			return $this->render( 'knowledge_base/knowledge-base-categories.html.twig', [
				'controller_name'   => 'KnowledgeBaseController',
				'knowledgeBaseData' => $this->fetchKnowledgeCategoriesData(),
				'user'              => $this->getUser(),
				'navPayload'        => $this->getNavigationPayload(),
				'pageTitle'         => "Wissendatenbank - Kategorien",
				'btnText'           => 'Los',
			] );
		}
		
		private function fetchAllTicketsAssociatedWithKnowledgeEntry($kid){
			return $this->entityManager->getRepository(Tickets::class)->findTicketsAssociatedWithWDB($kid);
		}
		
		private function fetchKnowledgeData(){
			/** @var KnowledgeKategorie $knowledgeCat */
			/** @var KnowledgeEintrag $entry */
			$returnData       = [];
			$knowledgeCats    = $this->entityManager->getRepository(KnowledgeKategorie::class)->findBy([], ['knowledge_kategoriename'=>'ASC']);
			if($knowledgeCats){
				foreach($knowledgeCats as $iKey=>$knowledgeCat){
					$catName  = $knowledgeCat->getKnowledgeKategoriename();
					$returnData[$catName]    = [ 'categoryName'=>$catName, 'children'=>[]];
					$knowledgeEntries4Category    = $this->entityManager->getRepository(KnowledgeEintrag::class)->findBy(['knowledge_eintrag_katID' => $knowledgeCat->getKnowledgeKategorieID()], ['knowledge_eintragfrage'=>'ASC']);
					if($knowledgeEntries4Category){
						foreach ($knowledgeEntries4Category as $entry){
							$returnData[$catName]['children'][]    = ['id'=>$entry->getKnowledgeEintragID(), 'name'=>$entry->getKnowledgeEintragfrage()];
						}
					}
				}
			}
			return $returnData;
		}
		
		private function fetchKnowledgeCategoriesData(){
			/** @var KnowledgeKategorie $knowledgeCat */
			/** @var KnowledgeEintrag $entry */
			$returnData       = [];
			$knowledgeCats    = $this->entityManager->getRepository(KnowledgeKategorie::class)->findBy([], ['knowledge_kategoriename'=>'ASC']);
			if($knowledgeCats){
				foreach($knowledgeCats as $iKey=>$knowledgeCat){
					$returnData[] = $knowledgeCat->getEntityBank();
				}
			}
			return $returnData;
		}
		
	}
