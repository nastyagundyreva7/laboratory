<?php
declare(strict_types=1);
namespace App\Form;
use App\Model\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
final class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder->add('name',TextType::class,['label'=>'Имя клиента','attr'=>['maxlength'=>120]])
            ->add('email',EmailType::class,['label'=>'Email','attr'=>['maxlength'=>180]])
            ->add('phone',TextType::class,['label'=>'Телефон','required'=>false,'attr'=>['maxlength'=>30]])
            ->add('company',TextType::class,['label'=>'Компания','required'=>false,'attr'=>['maxlength'=>120]])
            ->add('comment',TextareaType::class,['label'=>'Комментарий','required'=>false,'attr'=>['maxlength'=>1000,'rows'=>4]])
            ->add('save',SubmitType::class,['label'=>'Сохранить клиента']);
    }
    public function configureOptions(OptionsResolver $resolver): void { $resolver->setDefaults(['data_class'=>Customer::class]); }
}
