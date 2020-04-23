<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController {
    /**
     * @Route("/shop", name="shop")
     */
    public function index() {
    	return $this->render('shop/melanie.html.twig', [
		    'message' => 'Welcome to your new controller!',
		    'path' => 'src/Controller/ShopController.php',
	    ]);
    	
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ShopController.php',
        ]);
    }
	
	/**
	 * @Route("/logon", name="logon")
	 */
	public function logOn() {
		return $this->render('shop/melanie-3.html.twig', [
			'message' => 'Welcome to your new controller!',
			'path' => 'src/Controller/ShopController.php',
		]);
    }
}
