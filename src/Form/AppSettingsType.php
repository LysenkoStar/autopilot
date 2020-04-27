<?php

namespace App\Form;

use App\Entity\AppSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('renew_rate', CheckboxType::class, [
                'label'  => 'Автоматически продлевать тариф при наличии средств на балансе',
                'help' => 'А также по возможности переходить с тарифа «Испытатель» на «Премиум»',
                'label_attr' => ['class' => 'switch-custom'],
                'required' => false
            ])
            ->add('receive_notifications', CheckboxType::class, [
                'label'  => 'Получать (и сохранять в статистику) ВСЕ уведомления о получении средств в платежные системы',
                'help' => 'А не только те, которые получены через приложение Автопилота',
                'label_attr' => ['class' => 'switch-custom'],
                'required' => false
            ])
            ->add('save',SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary btn-sm', 'type' => 'button'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AppSettings::class,
        ]);
    }
}
