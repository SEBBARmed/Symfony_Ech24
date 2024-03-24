<?php

namespace App\Controller;

use App\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InvoiceController extends AbstractController
{
    #[Route('/invoice', name: 'app_invoice')]
    public function index(EntityManagerInterface $manager): Response
    {
        $repository = $manager->getRepository(Invoice::class);
        $invoices = $repository->findAll();

        return $this->render('invoice/index.html.twig', [
            'invoices' => $invoices,
        ]);
    }
}
