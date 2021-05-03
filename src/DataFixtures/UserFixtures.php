<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements FixtureInterface
{
    /**
     * UserFixtures constructor: encode password for more security
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('userTest');
        $user1->setEmail('userTest@mail.com');
        $user1->setPassword($this->encoder->encodePassword($user1, 'pass'));
        $user1->setRoles(['ROLE_ADMIN']);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('jean');
        $user2->setEmail('jean@mail.com');
        $user2->setPassword($this->encoder->encodePassword($user2, 'pass2'));
        $user2->setRoles(['ROLE_USER']);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername('charlie');
        $user3->setEmail('charlie@mail.com');
        $user3->setPassword($this->encoder->encodePassword($user3, 'pass3'));
        $user3->setRoles(['ROLE_USER']);
        $manager->persist($user3);

        $manager->flush();
    }
}
