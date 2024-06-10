<?php



namespace App\Security;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AccountNotVerifiedAuthenticationException extends AuthenticationException

{
    public function getMessageKey()
    {
        return 'Votre adresse électronique n\'est pas confirmée.';
    }
}