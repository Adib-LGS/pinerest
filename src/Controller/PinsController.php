<?php

namespace App\Controller;


use App\Repository\PinRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{

    /**
     * @Route("/", name="")
     */
    public function index(PinRepository $repo): Response
    {
        //dd($repo->findAll());

        //$pins = $repo->findAll();

        return $this->render('pins/index.html.twig', ['pins' => $repo->findAll()]);
    }
}
