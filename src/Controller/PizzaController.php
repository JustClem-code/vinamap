<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\VictoriousPizza;
use Doctrine\ORM\EntityManagerInterface;

class PizzaController extends AbstractController
{

    #[Route('/pizza/{id}', name: 'pizza_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $pizza = $entityManager->getRepository(VictoriousPizza::class)->find($id);

        if (!$pizza) {
            return new Response('No pizza found for id ' . $id);
            throw $this->createNotFoundException(
                'No pizza found for id ' . $id
            );
        }

        return new Response('Check out this great pizza again: ' . $pizza->getName());
    }

    #[Route('/pizzas', name: 'pizzas_list')]
    public function showAll(): Response
    {
        return $this->render('/pizza/pizzaslist.html.twig');
    }

    /**
     * @Route("/getpizzas", methods="GET")
     */
    #[Route('/getpizzas', name: 'get_list')]
    public function getAllPizzas(EntityManagerInterface $entityManager): Response
    {

        $repository = $entityManager->getRepository(VictoriousPizza::class);

        $pizzas = $repository->findAll();

        $pizzaCollection = [];

        foreach ($pizzas as $pizza) {
            $pizzaCollection[] = array(
                'id' => $pizza->getId(),
                'name' => $pizza->getName(),
            );
        }

        return new JsonResponse($pizzaCollection);
    }

    /**
     * @Route("/createpizza", methods="POST")
     */
    #[Route('/createpizza', name: 'create_pizza')]
    public function createPizza(Request $request, EntityManagerInterface $entityManager): Response
    {

        $pizza = new VictoriousPizza();
        $pizza->setName($request->getPayload()->get('name'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($pizza);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new pizza with id ' . $pizza->getName());
    }

    /**
     * @Route("/updatepizza/{id}", methods="POST")
     */
    #[Route('/updatepizza/{id}', name: 'update_pizza')]
    public function updatePizza(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $pizza = $entityManager->getRepository(VictoriousPizza::class)->find($id);
        $pizza->setName($request->getPayload()->get('name'));

        $entityManager->flush();

        return $this->redirectToRoute('lucky_number');

    }

    /**
     * @Route("/deletepizza/{id}", methods="POST")
     */
    #[Route('/deletepizza/{id}', name: 'delete_pizza')]
    public function deletePizza(EntityManagerInterface $entityManager, int $id): Response
    {
        $pizza = $entityManager->getRepository(VictoriousPizza::class)->find($id);

        $entityManager->remove($pizza);
        $entityManager->flush();

        return $this->redirectToRoute('lucky_number');

    }
}
