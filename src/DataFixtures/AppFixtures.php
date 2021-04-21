<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        //Users

        $user1 = new User();
        $hash = $this->encoder->encodePassword($user1, 'pass');
        $user1->setUsername('userTest');
        $user1->setEmail('userTest@mail.com');
        $user1->setPassword($hash);
        $manager->persist($user1);

        $user2 = new User();
        $hash = $this->encoder->encodePassword($user2, 'pass2');
        $user2->setUsername('jean');
        $user2->setEmail('jean@mail.com');
        $user2->setPassword($hash);
        $manager->persist($user2);

        $user3 = new User();
        $hash = $this->encoder->encodePassword($user3, 'pass3');
        $user3->setUsername('charlie');
        $user3->setEmail('charlie@mail.com');
        $user3->setPassword($hash);
        $manager->persist($user3);


        //Task
        for($i=1; $i<=5; $i++)
        {
            $task1= new Task();
            $task1->setCreatedAt(new \DateTime('2021-04-01 12:14:34'));
            $task1 ->setTitle('Task'.$i);
            $task1 ->setContent('Oppidum peius inopinis pernicies iactitabant perduelles hac gravia pacari perduelles
            occultis diversis feris consortes praeter eorum in sane Pisidiae feris excursibus gravia apud occultis
            perduelles gravia adulescentem spiritus praedatricibus quibus eorum cuncta latrociniis raris motibus bella
            quibus hac praedatricibus obiecti feris perciti indignitate spiritus capiti adulescentem adfligebat quidam
            erigentes saepeque.');
            $manager->persist($task1);
        }

        for($j=6; $j<=5; $j++)
        {
            $task2= new Task();
            $task2->setCreatedAt(new \DateTime('2021-04-03 17:12:34'));
            $task2->setTitle('Task'.$j);
            $task2->setContent('Oppidum peius inopinis pernicies iactitabant perduelles hac gravia pacari perduelles
            occultis diversis feris consortes praeter eorum in sane Pisidiae feris excursibus gravia apud occultis
            perduelles gravia adulescentem spiritus praedatricibus quibus eorum cuncta latrociniis raris motibus bella
            quibus hac praedatricibus obiecti feris perciti indignitate spiritus capiti adulescentem adfligebat quidam
            erigentes saepeque.');
            $manager->persist($task2);
        }

        for($k=6; $k<=5; $k++)
        {
            $task3= new Task();
            $task3->setCreatedAt(new \DateTime('2021-04-03 17:12:34'));
            $task3->setTitle('Task'.$k);
            $task3 ->setContent('Oppidum peius inopinis pernicies iactitabant perduelles hac gravia pacari perduelles
            occultis diversis feris consortes praeter eorum in sane Pisidiae feris excursibus gravia apud occultis
            perduelles gravia adulescentem spiritus praedatricibus quibus eorum cuncta latrociniis raris motibus bella
            quibus hac praedatricibus obiecti feris perciti indignitate spiritus capiti adulescentem adfligebat quidam
            erigentes saepeque.');
            $manager->persist($task3);
        }

        $manager->flush();
    }
}
