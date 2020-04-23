<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ManagementController extends AbstractController
{
    /**
     * @Route("/management", name="management")
     */
    public function index()
    {
        return $this->render('management/index.html.twig', [
            'controller_name' => 'ManagementController',
        ]);
    }
}
