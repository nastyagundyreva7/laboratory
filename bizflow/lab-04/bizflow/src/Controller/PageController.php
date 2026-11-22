<?php
declare(strict_types=1);
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class PageController extends AbstractController {
 #[Route('/about',name:'about',methods:['GET'])] public function about():Response{return $this->render('page/info.html.twig',['heading'=>'О программе RUD COIN','message'=>'Цифровая концепция студенческой программы лояльности: профиль участника, учёт активности и система баллов RDC.']);}
 public function legal():Response{return $this->render('page/info.html.twig',['heading'=>'Правовая информация','message'=>'Учебный прототип RUD COIN.']);}
}
