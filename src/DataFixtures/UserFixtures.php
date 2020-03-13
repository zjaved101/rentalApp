<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setEmail('first.last@mail.com');
        // $user->setPassword('1234');
        $user->setPassword($this->passwordEncoder->encodePassword($user, '1234'));
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('admin@email.com');
        $user2->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, '1234'));
        $manager->persist($user2);
        $manager->flush();
    }
}
