<?php

namespace App\Controller;

use App\Controller\Trait\ApiTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;


use App\Entity\VictoriousPizza;
use App\Repository\VictoriousPizzaRepository;
use Doctrine\ORM\EntityManagerInterface;

class PizzaController extends AbstractController
{
    use ApiTrait;

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
    #[Route('/getpizzas', name: 'get_list', methods: ['GET'])]
    public function getAllPizzas(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(VictoriousPizza::class);

        $pizzas = $repository->transformAll();

        return $this->respond($pizzas);
    }

    /**
     * @Route("/createpizza", methods="POST")
     */
    #[Route('/createpizza', name: 'create_pizza', methods: ['POST'])]
    public function createPizza(
        Request $request,
        VictoriousPizzaRepository $victoriousPizzaRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {


        $pizza = new VictoriousPizza();
        $pizza->setName($request->getPayload()->get('name'));

        $errors = $validator->validate($pizza);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($pizza);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->respondCreated($victoriousPizzaRepository->transform($pizza));
        /* return new Response('Saved new pizza with name ' . $pizza->getName()); */
    }

    /**
     * @Route("/updatepizza/{id}", methods="POST")
     */
    #[Route('/updatepizza/{id}', name: 'update_pizza', methods: ['POST'])]
    public function updatePizza(
        Request $request,
        VictoriousPizzaRepository $victoriousPizzaRepository,
        EntityManagerInterface $entityManager,
        int $id,
        ValidatorInterface $validator
    ) {
        $pizza = $entityManager->getRepository(VictoriousPizza::class)->find($id);
        $pizza->setName($request->getPayload()->get('name'));

        $errors = $validator->validate($pizza);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }

        $entityManager->flush();

        return $this->respondCreated($victoriousPizzaRepository->transform($pizza));
        /* return new Response('Update pizza with name ' . $pizza->getName()); */
    }

    /**
     * @Route("/deletepizza/{id}", methods="POST")
     */
    #[Route('/deletepizza/{id}', name: 'delete_pizza', methods: ['POST'])]
    public function deletePizza(EntityManagerInterface $entityManager, int $id): Response
    {
        $pizza = $entityManager->getRepository(VictoriousPizza::class)->find($id);

        $entityManager->remove($pizza);
        $entityManager->flush();

        return new Response('Delete pizza with name ' . $pizza->getName());
    }
}
