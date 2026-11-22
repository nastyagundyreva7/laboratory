<?php
declare(strict_types=1);
namespace App\Controller;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class PageController extends AbstractController
{
    #[Route('/',name:'home',methods:['GET'])] public function home(CustomerRepository $customers): Response { return $this->render('dashboard/index.html.twig',['customerCount'=>count($customers->all())]); }
    #[Route('/dashboard',name:'dashboard',methods:['GET'])] public function dashboard(CustomerRepository $customers): Response { return $this->render('dashboard/index.html.twig',['customerCount'=>count($customers->all())]); }
    public function legal(): Response { return $this->render('page/info.html.twig',['heading'=>'Правовая информация','message'=>'Учебная страница лабораторной работы.']); }
    public function catalog(): Response { return $this->render('page/info.html.twig',['heading'=>'Товары','message'=>'Раздел товаров подготовлен как учебная заглушка.']); }
}
