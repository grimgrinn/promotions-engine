<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhpController extends AbstractController
{
    #[Route('/php/phpinfo')]
    public function phpinfo(): Response
    {
        return new Response(
            '<html><body>'. phpinfo() .'</body></html>'
        );
    }
}