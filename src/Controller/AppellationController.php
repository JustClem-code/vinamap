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
use App\Repository\GrapeVarietyRepository;
use App\Repository\WineRegionRepository;
use App\Repository\SubWineRegionRepository;
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
        SubWineRegionRepository $SubWineRegionRepository,
        GrapeVarietyRepository $GrapeVarietyRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $formData = $request->getPayload()->all('formData');

        $wineregion = $WineRegionRepository->find($formData['value']);

        $grapevarietyCollection = $formData['value2'];

        $subwineregion = $SubWineRegionRepository->find($formData['value3']);

        $grapeArray = [];
        foreach ($grapevarietyCollection as $grape) {
            $grapeArray[] = $GrapeVarietyRepository->find($grape['value']);
        }

        $appellation = new Appellation();
        $appellation->setName($formData['name']);
        $appellation->setWineregion($wineregion);
        $appellation->setSubwineregion($subwineregion);

        foreach ($grapeArray as $grapevariety) {
            $appellation->addGrapevariety($grapevariety);
        }

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
        SubWineRegionRepository $SubWineRegionRepository,
        GrapeVarietyRepository $GrapeVarietyRepository,
        EntityManagerInterface $entityManager,
        int $id,
        ValidatorInterface $validator
    ) {
        $formData = $request->getPayload()->all('formData');

        $wineregion = $WineRegionRepository->find($formData['optionValue']);

        $grapevarietyCollection = $formData['optionValue2'];

        $subwineregion = $SubWineRegionRepository->find($formData['optionValue3']);

        $grapeArray = [];
        foreach ($grapevarietyCollection as $grape) {
            $grapeArray[] = $GrapeVarietyRepository->find($grape['value']);
        }

        $appellation = $entityManager->getRepository(Appellation::class)->find($id);

        $grapeCollection = $appellation->getGrapevariety();

        foreach ($grapeCollection as $grape) {
            $appellation->removeGrapevariety($grape);
        }

        $appellation->setName($formData['name']);
        $appellation->setWineregion($wineregion);
        $appellation->setSubwineregion($subwineregion);

        foreach ($grapeArray as $grapevariety) {
            $appellation->addGrapevariety($grapevariety);
        }

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
