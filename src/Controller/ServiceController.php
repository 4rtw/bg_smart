<?php

namespace App\Controller;

use App\Repository\CarouselRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    private $carourelRepo;
    public function __construct(CarouselRepository $carouselRepository)
    {
        $this->carourelRepo=$carouselRepository;
    }
    /**
     * @Route("/service", name="app_service")
     */
    public function services(): Response
    {
//        $carousel=$this->carourelRepo->lookForCarouselByPlace(['name'=>'services']);
//        $imgCar=$carousel->getImageurl();
//        $imgDesc=$carousel->getDescription();
        return $this->render('service/services.html.twig');
    }


}
