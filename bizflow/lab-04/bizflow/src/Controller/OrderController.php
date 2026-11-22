<?php
declare(strict_types=1);
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class OrderController extends AbstractController
{
    #[Route('/orders',name:'order_index',methods:['GET'])] public function index(): Response { return $this->render('order/index.html.twig',['orders'=>[['id'=>1001,'customer'=>'Анна Смирнова','status'=>'В обработке','total'=>'12 500,00 ₽'],['id'=>1002,'customer'=>'Иван Петров','status'=>'Оплачен','total'=>'8 900,00 ₽']]]); }
    #[Route('/orders/{id}',name:'order_show',requirements:['id'=>'[1-9]\d*'],methods:['GET'])] public function show(int $id): Response { if (!in_array($id,[1001,1002],true)) { throw $this->createNotFoundException('Заказ не найден.'); } return $this->render('page/info.html.twig',['heading'=>'Заказ №'.$id,'message'=>'Демонстрационная карточка заказа.']); }
}
