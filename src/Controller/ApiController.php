<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    protected $request = [];

    public function __construct()
    {
        $apiRequest = Request::createFromGlobals();
        $data = json_decode($apiRequest->getContent(), true);
        $apiRequest->request->replace(is_array($data) ? $data : []);
        $this->request = clone $apiRequest;
    }
}
