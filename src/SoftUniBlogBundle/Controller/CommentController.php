<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Book;
use SoftUniBlogBundle\Entity\Comment;
use SoftUniBlogBundle\Form\CommentType;
use SoftUniBlogBundle\Service\Book\BookServiceInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller
{
    /**
     * @var BookServiceInterface
     */

    private $bookService;

    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @Route("/comment/create/{id}", name="comment_create", methods={"POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function create(Request $request, $id)
    {
        $book = $this->bookService->getOne($id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);


        $comment->setAuthor($this->getUser())
            ->setArticle($book);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute('book_view',
            ['id' => $book->getId()]);


    }

    public function addUserMessage()
    {

    }

    public function getAllCommentsByArticleId()
    {

    }

}
