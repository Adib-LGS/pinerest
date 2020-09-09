<?php

namespace App\Controller;
use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(PinRepository $repo): Response
    {
        //dd($repo->findAll());
        //$pins = $repo->findAll();
        return $this->render('pins/index.html.twig', ['pins' => $repo->findAll()]);
    }

    /**
     * @Route("/pins/{id<[0-9]+>}", name="pins.show", methods={"GET"})
     */
    public function show(Pin $pin): Response
    {
        /*Manual way

        public function show(PinRepository $repo, int $id)
        $pin = $repo->find($id);
        //dd($pin);

        if(! $pin){
            throw $this->createNotFoundException('Pin #' . $id . ' Not Found :(');
        }*/

        return $this->render('pins/show.html.twig', compact('pin'));
    }

    /**
     * @Route("/pins/create", name="pins.create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $pin = new Pin;

        $form = $this->createFormBuilder($pin)
        ->add('title', TextType::class, ['attr' => ['autofocus' => true]])
        ->add('description', TextareaType::class, ['attr' => ['rows' => 10, 'cols' => 50]])
        ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('pins.show', ['id' => $pin->getId() ]);
        }
        //dd($form);
        return $this->render('pins/create.html.twig', ['form' => $form->createView()]);
    }

}
