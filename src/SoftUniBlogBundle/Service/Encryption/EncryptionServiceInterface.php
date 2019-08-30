<?php


namespace SoftUniBlogBundle\Service\Encryption;


interface EncryptionServiceInterface
{
    public function hash($password);
    public function verify($password, $hash);
}