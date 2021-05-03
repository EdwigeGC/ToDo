<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $task1 = new Task();
            $task1->setCreatedAt(new \DateTime('2021-04-01 10:14:34'));
            $task1->setTitle('Task' . $i);
            $task1->setContent('Oppidum peius inopinis pernicies iactitabant perduelles hac gravia pacari perduelles
        occultis diversis feris consortes praeter eorum in sane Pisidiae feris excursibus gravia apud occultis
        perduelles gravia adulescentem spiritus praedatricibus quibus eorum cuncta latrociniis raris motibus bella
        quibus hac praedatricibus obiecti feris perciti indignitate spiritus capiti adulescentem adfligebat quidam
        erigentes saepeque.');
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
            $manager->persist($task3);
        }
        $manager->flush();
    }
}