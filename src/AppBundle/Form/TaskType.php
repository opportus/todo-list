<?php

namespace AppBundle\Form;

use AppBundle\EventListener\AuthorizerListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * @var AuthorizerListener $authorizerListener
     */
    private $authorizerListener;

    public function __construct()
    {
        $this->authorizerListener = new AuthorizerListener();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        
        $builder
            ->add('title')
            ->add('content', TextareaType::class)
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $formEvent) use ($user) {
                $this->authorizerListener->onFormSubmit($formEvent, $user);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => null,
        ]);
    }
}
