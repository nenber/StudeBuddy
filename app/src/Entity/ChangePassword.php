<?php

namespace App\Entity;

use App\Repository\ChangePasswordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

/**
 * @ORM\Entity(repositoryClass=ChangePasswordRepository::class)
 */
class ChangePassword
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
    protected $oldPassword;

    protected $newPassword;


    function getOldPassword()
    {
        return $this->oldPassword;
    }

    function getNewPassword()
    {
        return $this->newPassword;
    }

    function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
        return $this;
    }
}
