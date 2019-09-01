<?php


namespace SoftUniBlogBundle\Service\Comment;


use SoftUniBlogBundle\Entity\Comment;

interface CommentServiceInterface
{
    /**
     * @return Comment[]
     */
    public function getAllByBookId();
    public function getOne() :?Comment;
}