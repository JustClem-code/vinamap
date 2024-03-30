<?php

namespace App\Controller;

use App\Controller\Trait\ApiTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\Appellation;
use App\Repository\AppellationRepository;
use App\Repository\WineRegionRepository;
use Doctrine\ORM\EntityManagerInterface;

class AppellationController extends AbstractController
{
    use ApiTrait;


    #[Route('/appellations', name: 'appellations_list')]
    public function showAll(): Response
    {
        return $this->render('/vinamap/appellationsList.html.twig');
    }

     /**
     * @Route("/getappellations", methods="GET")
     */
    #[Route('/getappellations', name: 'get_appellations_list', methods: ['GET'])]
    public function getAllAppellations(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Appellation::class);

        $appellations = $repository->transformAll();

        return $this->respond($appellations);
    }

    /**
     * @Route("/createappellation", methods="POST")
     */
    #[Route('/createappellation', name: 'create_appellation', methods: ['POST'])]
    public function createAppellation(
        Request $request,
        AppellationRepository $AppellationRepository,
        WineRegionRepository $WineRegionRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $wineregion = $WineRegionRepository->find($request->getPayload()->get('optionPost'));

        $appellation = new Appellation();
        $appellation->setName($request->getPayload()->get('name'));
        $appellation->setWineregion($wineregion);


        $errors = $validator->validate($appellation);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($appellation);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->respondCreated($AppellationRepository->transform($appellation));
    }

    /**
     * @Route("/updateappellation/{id}", methods="POST")
     */
    #[Route('/updateappellation/{id}', name: 'update_appellation', methods: ['POST'])]
    public function updateAppellation(
        Request $request,
        AppellationRepository $AppellationRepository,
        WineRegionRepository $WineRegionRepository,
        EntityManagerInterface $entityManager,
        int $id,
        ValidatorInterface $validator
    ) {
        $wineregion = $WineRegionRepository->find($request->getPayload()->get('optionPost'));

        $appellation = $entityManager->getRepository(Appellation::class)->find($id);
        $appellation->setName($request->getPayload()->get('name'));
        $appellation->setWineregion($wineregion);

        $errors = $validator->validate($appellation);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }

        $entityManager->flush();

        return $this->respondCreated($AppellationRepository->transform($appellation));
    }

    /**
     * @Route("/deleteappellation/{id}", methods="POST")
     */
    #[Route('/deleteappellation/{id}', name: 'delete_appellation', methods: ['POST'])]
    public function deleteAppellation(EntityManagerInterface $entityManager, int $id): Response
    {
        $appellation = $entityManager->getRepository(Appellation::class)->find($id);

        $entityManager->remove($appellation);
        $entityManager->flush();

        return new Response('Delete wine appellation with name ' . $appellation->getName());
    }
}
