<?php
namespace Rating\UserBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ChangePassword extends SecurityAssert\UserPassword
{
    public $message = 'Значення не співпадає з Вашим поточним паролем!';
}