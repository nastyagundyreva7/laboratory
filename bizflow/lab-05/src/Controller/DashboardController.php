<?php
namespace App\Controller;
use App\Service\DashboardProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class DashboardController extends AbstractController
{
    #[Route('/dashboard',name:'dashboard',methods:['GET'])]
    public function index(DashboardProvider $dashboard): Response { return $this->render('dashboard/index.html.twig',$dashboard->getData()); }
}
