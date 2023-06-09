<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Filter\PromotionsFilterInterface;
use App\Repository\ProductRepository;
use App\Service\Serializer\DTOSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsController extends AbstractController
{
    public function __construct(
        private ProductRepository $repository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
    public function lowestPrice(
        Request $request,
        int $id,
        DTOSerializer $serializer,
        PromotionsFilterInterface $promotionsFilter
    ): Response
    {
        if ($request->headers->has('force_fail')) {
            return new JsonResponse(
                ['error' => 'Promotion Engine failure message'],
                $request->headers->get('force_fail')
            );
        }

        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json' );
        $product = $this->repository->find($id);

        $lowestPriceEnquiry->setProduct($product);
        $promotions = $this->entityManager->getRepository(Promotion::class)->findValidForProduct(
            $product,
            date_create_immutable($lowestPriceEnquiry->getRequestDate())
        );

        dd($promotions);

        $modifiedEnquiry = $promotionsFilter->apply($lowestPriceEnquiry, $promotions);

        $responseContent = $serializer->serialize($modifiedEnquiry, 'json');
        return new Response($responseContent, 200);
    }

    #[Route('/products/{id}/promotions', name: 'promotions', methods:'GET')]
    public function promotions()
    {

    }
}
