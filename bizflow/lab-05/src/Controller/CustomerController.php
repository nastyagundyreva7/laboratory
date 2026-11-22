<?php
namespace App\Controller;
use App\Repository\CustomerRepository;
use App\Repository\SalesOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class CustomerController extends AbstractController
{
    #[Route('/customers/{id}',name:'customer_show',requirements:['id'=>'\\d+'],methods:['GET'])]
    public function show(int $id,Request $request,CustomerRepository $customers,SalesOrderRepository $orders): Response {
        $customer=$customers->find($id); if(!$customer) throw $this->createNotFoundException();
        $page=max(1,$request->query->getInt('page',1)); $perPage=10;
        return $this->render('customer/show.html.twig',['customer'=>$customer,'orders'=>$orders->findByCustomer($id,$page,$perPage),
            'page'=>$page,'pages'=>max(1,(int)ceil($orders->countByCustomer($id)/$perPage))]);
    }
}
