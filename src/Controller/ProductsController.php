<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsController extends AbstractController
{
    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
    public function lowestPrice(Request $request, int $id, DTOSerializer $serializer): Response
    {
        if ($request->headers->has('force_fail')) {
            return new JsonResponse(
                ['error' => 'Promotion Engine failure message'],
                $request->headers->get('force_fail')
            );
        }

        //1 deserialize json data tinto enquerydto
        /**@var LowestPriceEnquiry $lowestPriceEnquiry */

        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json' );

        //2 pass the enquiry unto a ptomotions filter
        //   the appropriate promotion will be applied
        //3 rerurn modified json
        $lowestPriceEnquiry->setDiscountedPrice(50);
        $lowestPriceEnquiry->setPrice(100);
        $lowestPriceEnquiry->setPromotionName('Black Friday half price sale');

        $responseContent = $serializer->serialize($lowestPriceEnquiry, 'json');
        return new Response($responseContent, 200);
    }

    #[Route('/products/{id}/promotions', name: 'promotions', methods:'GET')]
    public function promotions()
    {

    }
}
