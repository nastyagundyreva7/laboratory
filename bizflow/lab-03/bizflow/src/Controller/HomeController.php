<?php
declare(strict_types=1);
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class HomeController extends AbstractController {
 #[Route('/', name: 'home', methods: ['GET'])]
 public function index(): Response { return $this->render('home/index.html.twig'); }
 #[Route('/about', name: 'about', methods: ['GET'])]
 public function about(): Response { return $this->render('home/about.html.twig'); }
 #[Route('/dashboard', name: 'dashboard', methods: ['GET'])]
 public function dashboard(): Response { return $this->render('dashboard/index.html.twig', ['wallet'=>['balance'=>1250,'earned'=>420,'spent'=>170], 'transactions'=>[['date'=>'20.11.2026','title'=>'Участие в мероприятии','amount'=>'+150 RDC'],['date'=>'18.11.2026','title'=>'Начисление за активность','amount'=>'+100 RDC'],['date'=>'15.11.2026','title'=>'Использование привилегии','amount'=>'−50 RDC']]]); }
}
