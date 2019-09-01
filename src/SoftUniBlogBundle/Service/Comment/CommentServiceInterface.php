<?php


namespace SoftUniBlogBundle\Service\Comment;


use SoftUniBlogBundle\Entity\Comment;

interface CommentServiceInterface
{
    public function create(Comment $comment):bool;
    /**
     * @return Comment[]
     */
    public function getAllByBookId();
    public function getOne() :?Comment;
}