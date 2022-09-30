<?php

namespace App\Controller;

use App\Repository\CarouselRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private $carourelRepo;
    public function __construct(CarouselRepository $carouselRepository)
    {
        $this->carourelRepo=$carouselRepository;
    }

    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact(): Response
    {
//        $carousel=$this->carourelRepo->findOneBy(['name'=>'contact']);
//        $imgCar=$carousel->getImageurl();
//        $imgDesc=$carousel->getDescription();
        return $this->render('contact/contact.html.twig');
    }

    /**
     * @Route("/message/send", name="app_message_post", methods="POST")
     * @param Request $request
     * @return Response
     */
    public function sendMessage(Request $request): Response
    {

        $data=$request;
        dd($data);
        return new JsonResponse([
            "responseDataPost"=> $data
        ]);
    }

}
