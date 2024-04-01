<?php

namespace App\Controller;

use App\Controller\Trait\ApiTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\GrapeVariety;
use App\Repository\GrapeVarietyRepository;
use Doctrine\ORM\EntityManagerInterface;

class GrapeVarietyController extends AbstractController
{
    use ApiTrait;

    #[Route('/grapevarietys', name: 'app_grape_variety')]
    public function showAll(): Response
    {
        return $this->render('/vinamap/grapevarietylist.html.twig');
    }

    /**
     * @Route("/getgrapevarietys", methods="GET")
     */
    #[Route('/getgrapevarietys', name: 'get_grapevarietys_list', methods: ['GET'])]
    public function getAllGrapeVarietys(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(GrapeVariety::class);

        $grapevarietys = $repository->transformAll();

        return $this->respond($grapevarietys);
    }

    /**
     * @Route("/creategrapevariety", methods="POST")
     */
    #[Route('/creategrapevariety', name: 'create_grapevariety', methods: ['POST'])]
    public function createGrapeVariety(
        Request $request,
        GrapeVarietyRepository $GrapeVarietyRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {

        $grapevariety = new GrapeVariety();
        $grapevariety->setName($request->getPayload()->get('name'));

        $errors = $validator->validate($grapevariety);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($grapevariety);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->respondCreated($GrapeVarietyRepository->transform($grapevariety));
    }

    /**
     * @Route("/updategrapevariety/{id}", methods="POST")
     */
    #[Route('/updategrapevariety/{id}', name: 'update_grapevariety', methods: ['POST'])]
    public function updateGrapeVariety(
        Request $request,
        GrapeVarietyRepository $GrapeVarietyRepository,
        EntityManagerInterface $entityManager,
        int $id,
        ValidatorInterface $validator
    ) {

        $grapevariety = $entityManager->getRepository(GrapeVariety::class)->find($id);
        $grapevariety->setName($request->getPayload()->get('name'));

        $errors = $validator->validate($grapevariety);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }

        $entityManager->flush();

        return $this->respondCreated($GrapeVarietyRepository->transform($grapevariety));
    }

    /**
     * @Route("/deletegrapevariety/{id}", methods="POST")
     */
    #[Route('/deletegrapevariety/{id}', name: 'delete_grapevariety', methods: ['POST'])]
    public function deleteGrapeVariety(EntityManagerInterface $entityManager, int $id): Response
    {
        $grapevariety = $entityManager->getRepository(grapevariety::class)->find($id);
        $appellations = $grapevariety->getAppellations();

        foreach ($appellations as $ap) {
            $grapevariety->removeAppellation($ap);
        }

        $entityManager->remove($grapevariety);
        $entityManager->flush();

        return new Response('Delete wine grapevariety with name ' . $grapevariety->getName());
    }
}
