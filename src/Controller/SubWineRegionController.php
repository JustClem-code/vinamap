<?php

namespace App\Controller;

use App\Controller\Trait\ApiTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\SubWineRegion;
use App\Repository\SubWineRegionRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\WineRegionRepository;


class SubWineRegionController extends AbstractController
{
    use ApiTrait;

    #[Route('/subwineregions', name: 'subwineregions_list')]
    public function showAll(): Response
    {
        return $this->render('/vinamap/subwineregionslist.html.twig');
    }

    #[Route('/subwineregion/{id}', name: 'subwineregion_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $subwineregion = $entityManager->getRepository(SubWineRegion::class)->find($id);

        if (!$subwineregion) {
            return new Response('No sub wine region found for id ' . $id);
            throw $this->createNotFoundException(
                'No subwine region found for id ' . $id
            );
        }

        return new Response('Check out this great wine region again: ' . $subwineregion->getName());
    }

    /**
     * @Route("/getsubwineregions", methods="GET")
     */
    #[Route('/getsubwineregions', name: 'get_subwineregions_list', methods: ['GET'])]
    public function getAllSubWineRegions(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(SubWineRegion::class);

        $subwineregions = $repository->transformAll();

        return $this->respond($subwineregions);
    }

    /**
     * @Route("/createsubwineregion", methods="POST")
     */
    #[Route('/createsubwineregion', name: 'create_subwineregion', methods: ['POST'])]
    public function createSubWineRegion(
        Request $request,
        SubWineRegionRepository $SubWineRegionRepository,
        WineRegionRepository $WineRegionRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $formData = $request->getPayload()->all('formData');

        $wineregion = $WineRegionRepository->find($formData['value']);

        $subwineregion = new SubWineRegion();
        $subwineregion->setName($formData['name']);
        $subwineregion->setWineregion($wineregion);

        $errors = $validator->validate($subwineregion);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($subwineregion);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->respondCreated($SubWineRegionRepository->transform($subwineregion));
    }

    /**
     * @Route("/updatesubwineregion/{id}", methods="POST")
     */
    #[Route('/updatesubwineregion/{id}', name: 'update_subwineregion', methods: ['POST'])]
    public function updateSubWineRegion(
        Request $request,
        SubWineRegionRepository $SubWineRegionRepository,
        WineRegionRepository $WineRegionRepository,
        EntityManagerInterface $entityManager,
        int $id,
        ValidatorInterface $validator
    ) {
        $formData = $request->getPayload()->all('formData');

        $wineregion = $WineRegionRepository->find($formData['optionValue']);

        $subwineregion = $entityManager->getRepository(SubWineRegion::class)->find($id);
        $subwineregion->setName($formData['name']);
        $subwineregion->setWineregion($wineregion);

        $errors = $validator->validate($subwineregion);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }

        $entityManager->flush();

        return $this->respondCreated($SubWineRegionRepository->transform($subwineregion));
    }

    /**
     * @Route("/deletesubwineregion/{id}", methods="POST")
     */
    #[Route('/deletesubwineregion/{id}', name: 'delete_subwineregion', methods: ['POST'])]
    public function deletesubWineRegion(EntityManagerInterface $entityManager, int $id): Response
    {
        $subwineregion = $entityManager->getRepository(SubWineRegion::class)->find($id);
        $appellations = $subwineregion->getAppellations();

        foreach ($appellations as $ap) {
            $subwineregion->removeAppellation($ap);
        }

        $entityManager->remove($subwineregion);
        $entityManager->flush();

        return new Response('Delete sub wine region with name ' . $subwineregion->getName());
    }
}
