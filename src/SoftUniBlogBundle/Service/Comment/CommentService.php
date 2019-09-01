<?php


namespace SoftUniBlogBundle\Service\Comment;


use SoftUniBlogBundle\Entity\Comment;
use SoftUniBlogBundle\Repository\CommentRepository;

class CommentService implements CommentServiceInterface
{
    private $commentRepository;

    /**
     * CommentService constructor.
     * @param $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return Comment[]
     */
    public function getAllByBookId()
    {
//        return $this->commentRepository->
    }

    public function getOne(): ?Comment
    {
        // TODO: Implement getOne() method.
    }

    public function create(Comment $comment): bool
    {
        return $this->commentRepository->insert($comment);
    }
}