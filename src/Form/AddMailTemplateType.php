<?php

namespace App\Form;

use App\Entity\MailTemplate;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\{
    AbstractType,FormBuilderInterface
};

use Symfony\Component\Form\Extension\Core\Type\{
    TextType, ChoiceType, SubmitType, TextareaType
};

use Symfony\Component\OptionsResolver\OptionsResolver;

class AddMailTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Код шаблона',
                'attr' => [ 'class' => 'form-control', 'style' => 'margin: 0px 0px 10px 0px'],
                'required' => true,
                'constraints' => array(new NotBlank())
            ])
            ->add('data_type', ChoiceType::class, [
                'label' => 'Тип содержимого',
                'choices' => [
                    'text' => 'text/plain',
                    'html' => 'text/html'
                ],
                'attr' => [ 'class' => 'form-control', 'style' => 'margin: 0px 0px 10px 0px'],
                'required' => true,
                'constraints' => array(new NotBlank())
            ])
            ->add('subject', TextType::class, [
                'label' => 'Тема письма',
                'attr' => ['class' => 'form-control', 'style' => 'margin: 0px 0px 10px 0px'],
                'required' => true,
                'constraints' => array(new NotBlank())
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Текст письма',
                'attr' => ['class' => 'form-control', 'style' => 'margin: 0px 0px 10px 0px'],
                'required' => true,
                'constraints' => array(new NotBlank())
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Добавить шаблон',
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin: 0px 0px 10px 0px']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MailTemplate::class,
        ]);
    }
}
