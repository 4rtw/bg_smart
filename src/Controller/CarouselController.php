<?php

namespace App\Controller;

use App\Repository\CarouselRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CarouselController
 * @package App\Controller
 * @Route("/carousel")
 */
class CarouselController extends AbstractController
{
    /**
     * @Route("/data/{place}", name="app_carousel")
     * @param CarouselRepository $carouselRepository
     * @param String $place
     * @return JsonResponse
     */
    public function index(CarouselRepository $carouselRepository , String $place): JsonResponse
    {
        $carousels=$carouselRepository->lookForCarouselByPlace($place);

        foreach ($carousels as $item) {
            $images[]=$item->getImageUrl();
            $texts[]=$item->getDescription();
        }
        if (!isset($texts)){
            $texts[]='no text found!!!';
        }
        if (!isset($images)){
            $images[]='no image found!!!';
        }
        return $this->json([
            'texts' => $texts,
            'images' => $images,
        ]);
    }
}
