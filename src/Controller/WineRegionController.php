<?php

namespace App\Controller;

use App\Controller\Trait\ApiTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\WineRegion;
use App\Repository\WineRegionRepository;
use Doctrine\ORM\EntityManagerInterface;

class WineRegionController extends AbstractController
{
    use ApiTrait;

    #[Route('/wineregion/{id}', name: 'wineregion_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $wineregion = $entityManager->getRepository(WineRegion::class)->find($id);

        if (!$wineregion) {
            return new Response('No wine region found for id ' . $id);
            throw $this->createNotFoundException(
                'No wine region found for id ' . $id
            );
        }

        return new Response('Check out this great wine region again: ' . $wineregion->getName());
    }

    #[Route('/wineregions', name: 'wineregions_list')]
    public function showAll(): Response
    {
        return $this->render('/vinamap/wineregionslist.html.twig');
    }

    /**
     * @Route("/getwineregions", methods="GET")
     */
    #[Route('/getwineregions', name: 'get_wineregions_list', methods: ['GET'])]
    public function getAllWineRegions(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(WineRegion::class);

        $wineregions = $repository->transformAll();

        return $this->respond($wineregions);
    }

    /**
     * @Route("/createwineregion", methods="POST")
     */
    #[Route('/createwineregion', name: 'create_wineregion', methods: ['POST'])]
    public function createWineRegion(
        Request $request,
        WineRegionRepository $WineRegionRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {

        $wineregion = new WineRegion();
        $wineregion->setName($request->getPayload()->get('name'));

        $errors = $validator->validate($wineregion);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($wineregion);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->respondCreated($WineRegionRepository->transform($wineregion));
    }

    /**
     * @Route("/updatewineregion/{id}", methods="POST")
     */
    #[Route('/updatewineregion/{id}', name: 'update_wineregion', methods: ['POST'])]
    public function updateWineRegion(
        Request $request,
        WineRegionRepository $WineRegionRepository,
        EntityManagerInterface $entityManager,
        int $id,
        ValidatorInterface $validator
    ) {
        $wineregion = $entityManager->getRepository(WineRegion::class)->find($id);
        $wineregion->setName($request->getPayload()->get('name'));

        $errors = $validator->validate($wineregion);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }

        $entityManager->flush();

        return $this->respondCreated($WineRegionRepository->transform($wineregion));
    }

    /**
     * @Route("/deletewineregion/{id}", methods="POST")
     */
    #[Route('/deletewineregion/{id}', name: 'delete_wineregion', methods: ['POST'])]
    public function deleteWineRegion(EntityManagerInterface $entityManager, int $id): Response
    {
        $wineregion = $entityManager->getRepository(WineRegion::class)->find($id);
        $appellations = $wineregion->getAppellations();

        foreach ($appellations as $ap) {
            $wineregion->removeAppellation($ap);
        }

        $subwineregions = $wineregion->getSubWineRegions();

        foreach ($subwineregions as $sub) {
            $wineregion->removeSubWineRegion($sub);
        }

        $entityManager->remove($wineregion);
        $entityManager->flush();

        return new Response('Delete wine region with name ' . $wineregion->getName());
    }
}
