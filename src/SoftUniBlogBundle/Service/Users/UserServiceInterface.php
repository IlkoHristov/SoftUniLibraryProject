<?php


namespace SoftUniBlogBundle\Service\Users;


use SoftUniBlogBundle\Entity\User;

interface UserServiceInterface
{
    public function findOneByEmail(string $email);
    public function save(User $user) : bool;
    public function findOneById(int $id) : ?User;
    public function findOne(User $user) : ?User;
    public function currentUser() : ?User;

    public function update(?User $currentUser);
}