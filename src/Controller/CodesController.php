<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CodesController extends Controller
{
    /**
     * @Route("/codes", name="codes")
     */
    public function index()
    {
        return $this->render('codes/index.html.twig', [
            'controller_name' => 'CodesController',
        ]);
    }
}
