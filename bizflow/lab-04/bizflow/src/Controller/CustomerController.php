<?php
declare(strict_types=1);
namespace App\Controller;
use App\Form\CustomerType;
use App\Model\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class CustomerController extends AbstractController
{
    #[Route('/customers',name:'customer_index',methods:['GET'])]
    public function index(Request $request, CustomerRepository $repository): Response {
        $search=trim((string)$request->query->get('search','')); $sort=(string)$request->query->get('sort','name');
        if (!in_array($sort,['name','email'],true)) { $sort='name'; }
        return $this->render('customer/index.html.twig',['customers'=>$repository->all($search,$sort),'search'=>$search,'sort'=>$sort]);
    }
    #[Route('/customers/new',name:'customer_new',methods:['GET','POST'])]
    public function new(Request $request, CustomerRepository $repository): Response {
        $customer=new Customer(); $form=$this->createForm(CustomerType::class,$customer); $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { $repository->save($customer); $this->addFlash('success','Клиент успешно создан.'); return $this->redirectToRoute('customer_index'); }
        return $this->render('customer/new.html.twig',['form'=>$form]);
    }
    #[Route('/customers/{id}',name:'customer_show',requirements:['id'=>'[1-9]\d*'],methods:['GET'])]
    public function show(int $id, CustomerRepository $repository): Response { $customer=$repository->find($id); if (!$customer) { throw $this->createNotFoundException('Клиент не найден.'); } return $this->render('customer/show.html.twig',['customer'=>$customer]); }
    #[Route('/customers/{id}/edit',name:'customer_edit',requirements:['id'=>'[1-9]\d*'],methods:['GET','POST'])]
    public function edit(int $id, Request $request, CustomerRepository $repository): Response {
        $customer=$repository->find($id); if (!$customer) { throw $this->createNotFoundException('Клиент не найден.'); }
        $form=$this->createForm(CustomerType::class,$customer); $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { $repository->save($customer); $this->addFlash('success','Данные клиента обновлены.'); return $this->redirectToRoute('customer_show',['id'=>$id]); }
        return $this->render('customer/edit.html.twig',['form'=>$form,'customer'=>$customer]);
    }
}
