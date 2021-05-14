<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture implements FixtureInterface
{
    /**
     * AppFixtures constructor: encode password for more security
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        //users

        $user1 = new User();
        $user1->setUsername('Administrateur');
        $user1->setEmail('adminUser@mail.com');
        $user1->setPassword($this->encoder->encodePassword($user1, 'pass'));
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setSlug($user1->getUsername());
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('Utilisateur');
        $user2->setEmail('user@mail.com');
        $user2->setPassword($this->encoder->encodePassword($user2, 'pass2'));
        $user2->setRoles(['ROLE_USER']);
        $user2->setSlug($user2->getUsername());
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername('anonyme');
        $user3->setEmail('anonyme@mail.com');
        $user3->setPassword($this->encoder->encodePassword($user3, 'pass3'));
        $user3->setRoles(['ROLE_USER']);
        $user3->setSlug($user3->getUsername());
        $manager->persist($user3);

        $user4 = new User();
        $user4->setUsername('userTest');
        $user4->setEmail('user@usermail.com');
        $user4->setPassword($this->encoder->encodePassword($user3, 'pass'));
        $user4->setRoles(['ROLE_USER']);
        $user4->setSlug($user4->getUsername());
        $manager->persist($user4);

        //tasks
        for ($i = 1; $i <= 5; $i++) {
            $task1 = new Task();
            $task1->setCreatedAt(new \DateTime('2021-04-01 10:14:34'));
            $task1->setTitle('Task' . $i);
            $task1->setContent('Oppidum peius inopinis pernicies iactitabant perduelles hac gravia pacari perduelles
        occultis diversis feris consortes praeter eorum in sane Pisidiae feris excursibus gravia apud occultis
        perduelles gravia adulescentem spiritus praedatricibus quibus eorum cuncta latrociniis raris motibus bella
        quibus hac praedatricibus obiecti feris perciti indignitate spiritus capiti adulescentem adfligebat quidam
        erigentes saepeque.');
            $task1->setIsDone(false);
            $task1->setSlug($task1->getTitle());
            $task1->setUsers($user3);
            $manager->persist($task1);
        }

        for ($j = 6; $j <= 10; $j++) {
            $task2 = new Task();
            $task2->setCreatedAt(new \DateTime('2021-04-03 17:12:34'));
            $task2->setTitle('Task' . $j);
            $task2->setContent('Oppidum peius inopinis pernicies iactitabant perduelles hac gravia pacari perduelles
        occultis diversis feris consortes praeter eorum in sane Pisidiae feris excursibus gravia apud occultis
        perduelles gravia adulescentem spiritus praedatricibus quibus eorum cuncta latrociniis raris motibus bella
        quibus hac praedatricibus obiecti feris perciti indignitate spiritus capiti adulescentem adfligebat quidam
        erigentes saepeque.');
            $task2->setIsDone(false);
            $task2->setSlug($task2->getTitle());
            $task2->setUsers($user1);
            $manager->persist($task2);
        }

        for ($k = 11 ; $k <= 15; $k++) {
            $task3 = new Task();
            $task3->setCreatedAt(new \DateTime('2021-05-02 08:43:34'));
            $task3->setTitle('Task' . $k);
            $task3->setContent('Oppidum peius inopinis pernicies iactitabant perduelles hac gravia pacari perduelles
        occultis diversis feris consortes praeter eorum in sane Pisidiae feris excursibus gravia apud occultis
        perduelles gravia adulescentem spiritus praedatricibus quibus eorum cuncta latrociniis raris motibus bella
        quibus hac praedatricibus obiecti feris perciti indignitate spiritus capiti adulescentem adfligebat quidam
        erigentes saepeque.');
            $task3->setIsDone(false);
            $task3->setSlug($task3->getTitle());
            $task3->setUsers($user2);
            $manager->persist($task3);
        }

        $manager->flush();
    }
}
