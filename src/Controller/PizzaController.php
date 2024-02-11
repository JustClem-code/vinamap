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
        $pizza->setName('Reblo-cochonnade-avec-du gras');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($pizza);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new pizza with id ' . $pizza->getName());
    }

    #[Route('/pizza/{id}', name: 'pizza_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $pizza = $entityManager->getRepository(VictoriousPizza::class)->find($id);

        if (!$pizza) {
            throw $this->createNotFoundException(
                'No pizza found for id ' . $id
            );
        }

        return new Response('Check out this great pizza again: ' . $pizza->getName());
    }
    #[Route('/pizzas', name: 'pizzas_list')]
    public function showAll(EntityManagerInterface $entityManager): Response
    {
        // look for *all* Product objects
        $repository = $entityManager->getRepository(VictoriousPizza::class);

        $pizzas = $repository->findAll();

        $pizzaCollection = array();

        foreach ($pizzas as $item) {
            $pizzaCollection[] = array(
                'id' => $item->getId(),
                'name' => $item->getName(),
                // ... Same for each property you want
            );
        }

        $createPizz = 4;

        var_dump($createPizz);



        // tell Doctrine you want to (eventually) save the Product (no queries yet)


        // actually executes the queries (i.e. the INSERT query)


        return $this->render('/pizza/pizzaslist.html.twig', ['pizzas' => $pizzas, 'pizzaCollection' => $pizzaCollection, 'createPizz' => $createPizz]);
    }
}
