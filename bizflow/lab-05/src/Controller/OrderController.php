<?php
namespace App\Controller;
use App\Repository\SalesOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class OrderController extends AbstractController
{
    #[Route('/orders',name:'order_index',methods:['GET'])]
    public function index(Request $request,SalesOrderRepository $orders): Response {
        $status=$request->query->get('status');
        $rows=$status && in_array($status,\App\Entity\SalesOrder::STATUSES,true) ? $orders->findByStatus($status) : $orders->findByPeriod(new \DateTimeImmutable('-10 years'),new \DateTimeImmutable('+1 day'));
        return $this->render('order/index.html.twig',['orders'=>$rows,'status'=>$status]);
    }
}
