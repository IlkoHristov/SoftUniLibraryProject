<?php

namespace SoftUniBlogBundle\Controller;

use SoftUniBlogBundle\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="library_index")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $books=$this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->render('library/index.html.twig', ['books'=>$books]);
    }
}
