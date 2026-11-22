<?php
declare(strict_types=1);
namespace App\Controller;
use App\Form\StudentProfileType;
use App\Model\StudentProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class ProfileController extends AbstractController {
 #[Route('/',name:'home',methods:['GET'])] public function home():Response {return $this->render('dashboard/index.html.twig');}
 #[Route('/profile',name:'profile_edit',methods:['GET','POST'])]
 public function edit(Request $request):Response {
  $saved=$request->getSession()->get('rudcoin_profile',[]); $profile=new StudentProfile($saved['name']??'', $saved['email']??'', $saved['faculty']??'', $saved['program']??'', $saved['about']??'');
  $form=$this->createForm(StudentProfileType::class,$profile);$form->handleRequest($request);
  if($form->isSubmitted()&&$form->isValid()){$request->getSession()->set('rudcoin_profile',['name'=>$profile->name,'email'=>$profile->email,'faculty'=>$profile->faculty,'program'=>$profile->program,'about'=>$profile->about]);$this->addFlash('success','Профиль RUD COIN сохранён в сессии.');return $this->redirectToRoute('profile_edit');}
  return $this->render('profile/edit.html.twig',['form'=>$form,'profile'=>$saved]);
 }
}
