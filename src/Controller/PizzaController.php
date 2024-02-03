<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\VictoriousPizza;
use Doctrine\ORM\EntityManagerInterface;

class PizzaController extends AbstractController
{
    #[Route('/pizza', name: 'app_pizza')]
    public function createPizza(EntityManagerInterface $entityManager): Response
    {
        $pizza = new VictoriousPizza();
        $pizza->setName('Reblo-cochonne');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($pizza);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new pizza with id '.$pizza->getName());
    }

}
