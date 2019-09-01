<?php


namespace SoftUniBlogBundle\Service\Book;


use SoftUniBlogBundle\Repository\BookRepository;

class BookService implements BookServiceInterface
{
    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository=$bookRepository;
    }

    public function getOne(int $id)
    {
        return $this->bookRepository->find($id);
    }
}