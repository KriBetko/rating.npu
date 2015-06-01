<?php

namespace Rating\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RatingUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}