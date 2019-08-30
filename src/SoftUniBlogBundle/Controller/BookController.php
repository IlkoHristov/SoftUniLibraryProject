<?php

namespace SoftUniBlogBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Book;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends Controller
{
    /**
     *
     * @Route("/article/create", name="book_create", methods={"POST", "GET"})
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        $book->setViewCount(0);

        if ($form->isSubmitted()) {
            $this->uploadFile($form, $book);
            $book->setAuthor($this->getUser());
            $em=$this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            $this->addFlash("info", "Article created successfully!");
            return $this->redirectToRoute('library_index');
        }


        return $this->render("articles/create.html.twig",
            ['form' => $form->createView()]);
    }


    /**
     * @Route("/book/{id}", name="book_view")
     * @param $id
     * @return Response
     */

    public function viewArticle($id)
    {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        return $this->render('articles/view.html.twig', ['book' => $book]);
    }
    /**
     * @Route("/book/edit/{id}", name="book_edit",methods={"POST", "GET"})
     * @param $id
     * @param Request $request
     * @return Response
     */

    public function editArticle($id, Request $request)
    {
        $book=$this->getDoctrine()->getRepository(Book::class)->find($id);

        if($book===null){
            return $this->redirectToRoute('library_index');

        }

        $currentUser=$this->getUser();

        /**
         *@var User $currentUser
         */
        if(!$currentUser->isAuthor($book) && !$currentUser->isAdmin()){
            return $this->redirectToRoute('library_index');
        }

        $form=$this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $this->uploadFile($form, $book);
            $em=$this->getDoctrine()->getManager();
            $em->merge($book);
            $em->flush();

            return $this->redirectToRoute("library_index");
        }

        return $this->render('articles/edit.html.twig', array('book'=>$book,
            'form'=>$form->createView()));

    }
    /**
     * @Route("/book/delete/{id}", name="book_delete")
     * @param $id
     * @param Request $request
     * @return Response
     */

    public function delete($id, Request $request)
    {
        $book=$this->getDoctrine()->getRepository(Book::class)->find($id);

        if($book===null){
            return $this->redirectToRoute('library_index');

        }
        $currentUser=$this->getUser();
        /**
         *@var User $currentUser
         */
        if(!$currentUser->isAuthor($book) && !$currentUser->isAdmin()){
            return $this->redirectToRoute('library_index');
        }

        $form=$this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush();

            return $this->redirectToRoute("library_index");
        }

        return $this->render('articles/delete.html.twig', array('book'=>$book,
            'form'=>$form->createView()));

    }
    /**
     * @Route("/articles/my_articles",name="my_articles")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     */
    public function getAllArticlesByUser()
    {
        $books = $this->getDoctrine()->getRepository(Book::class)
            ->findBy(['author' => $this->getUser()]);

        return $this->render(
            "articles/myArticle.html.twig",
            ["books" => $books]
        );
    }
    /**
     * @param FormInterface $form
     * @param Book $book
     */
    public function uploadFile(FormInterface $form, Book $book)
    {
        /**
         * @var UploadedFile $file
         */
        $file = $form['image']->getData();

        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        if ($file) {
            $file->move(
                $this->getParameter('articles_directory'),
                $fileName
            );

            $book->setImage($fileName);
        }
    }

}
