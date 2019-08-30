<?php


namespace SoftUniBlogBundle\Service\Users;


use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Repository\UserRepository;
use SoftUniBlogBundle\Service\Encryption\ArgonEncryption;
use SoftUniBlogBundle\Service\Roles\RoleServiceInterface;
use Symfony\Component\Security\Core\Security;

class UserService implements UserServiceInterface
{

    private $security;
    private $userRepository;
    private $encryptionService;
    private $roleService;

    public function __construct(Security $security,UserRepository $userRepository,
                                ArgonEncryption $encryptionService, RoleServiceInterface $roleService)
    {
        $this->security=$security;
        $this->userRepository=$userRepository;
        $this->encryptionService=$encryptionService;
        $this->roleService=$roleService;
    }

    public function findOneByEmail(string $email)
    {
        return $this->userRepository->findOneBy(['email'=>$email]);
    }

    public function save(User $user): bool
    {
        $passwordHash=$this->encryptionService->hash($user->getPassword());
        $user->setPassword($passwordHash);
        $userRole=$this->roleService->findOneBy("ROLE_USER");
        $user->addRole($userRole);
        $user->setImage("");






        $user->setPassword($passwordHash);
        return $this->userRepository->insert($user);
    }

    /**
     * @param int $id
     * @return null|User|object
     */
    public function findOneById(int $id): ?User
    {
        return $this->userRepository->findOneBy($id);
    }

    /**
     * @param User $user
     * @return User|null|object
     */
    public function findOne(User $user): ?User
    {
        return $this->userRepository->find($user);
    }

    public function currentUser(): ?User
    {
        $this->security->getUser();
    }

    public function update(?User $user)
    {
        return $this->userRepository->update($user);
    }
}