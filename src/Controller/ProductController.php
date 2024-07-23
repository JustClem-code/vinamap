<?php

namespace App\Controller;

use App\Controller\Trait\ApiTrait;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;

use Symfony\Bundle\SecurityBundle\Security;

use App\Repository\AppellationRepository;


class ProductController extends AbstractController
{
    use ApiTrait;

    public function __construct(
        private Security $security,
    ){
    }

    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('vinamap/productslist.html.twig');
    }

     /**
     * @Route("/getproducts", methods="GET")
     */
    #[Route('/getproducts', name: 'get_products_list', methods: ['GET'])]
    public function getAllProducts(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Product::class);

        $products = $repository->transformAll();

        return $this->respond($products);
    }

    /**
     * @Route("/createproduct", methods="POST")
     */
    #[Route('/createproduct', name: 'create_product', methods: ['POST'])]
    public function createProduct(
        Request $request,
        ProductRepository $ProductRepository,
        AppellationRepository $AppellationRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ) {
        $formData = $request->getPayload()->all('formData');

        $appellation = $AppellationRepository->find($formData['value']);
        $user = $this->security->getUser();

        $product = new Product();
        $product->setName($formData['name']);
        $product->setAppellation($appellation);
        $product->setUserEmail($user);

        $product->setManufacturer('test manufacturer');


        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $message = $violation->getMessage();
            }
            return $this->respondValidationError((string) $message);
        }


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->respondCreated($ProductRepository->transform($product));
    }

    // TODO: Il reste a mettre le manufacturer/la review dans le formulaire ; afficher l'appellation dans row du listing
    // Éditer et supprimer le product


}
