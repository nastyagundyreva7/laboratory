<?php
declare(strict_types=1);
namespace App\Form;
use App\Model\StudentProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
final class StudentProfileType extends AbstractType {
 public function buildForm(FormBuilderInterface $builder,array $options):void {
  $builder->add('name',TextType::class,['label'=>'Имя и фамилия','attr'=>['maxlength'=>120]])
   ->add('email',EmailType::class,['label'=>'Университетская почта'])
   ->add('faculty',TextType::class,['label'=>'Факультет / институт'])
   ->add('program',TextType::class,['label'=>'Направление подготовки'])
   ->add('about',TextareaType::class,['label'=>'Интересы и достижения','required'=>false,'attr'=>['maxlength'=>500,'rows'=>4]])
   ->add('save',SubmitType::class,['label'=>'Сохранить профиль']);
 }
 public function configureOptions(OptionsResolver $resolver):void {$resolver->setDefaults(['data_class'=>StudentProfile::class]);}
}
