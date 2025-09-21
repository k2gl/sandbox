<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrangeGnomeController extends AbstractController
{
    #[Route('/orange-gnome')]
    public function index(): Response
    {
        return $this->json([
            'controller_name' => 'DeliciousGnomeController',
        ]);
    }
}
