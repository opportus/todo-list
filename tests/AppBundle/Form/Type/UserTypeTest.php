<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Symfony\Component\Form\Test\Traits\ValidatorExtensionTrait;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    use ValidatorExtensionTrait;

    public function testSubmitValidData()
    {
        $userToCompare = new User();

        $form = $this->factory->create(UserType::class, $userToCompare);

        $user = new User();
        $user->setUsername('Meli Melo');
        $user->setEmail('melimelo@example.com');
        $user->setRole(User::ROLE_USER);

        $formData = [
            'username' => 'Meli Melo',
            'email'    => 'melimelo@example.com',
            'role'     => User::ROLE_USER
        ];

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($user, $userToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (\array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
