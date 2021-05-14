<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    private $user;
    private $task;

    public function setUp(): void
    {
        $this->user = new User();
        $this->task = new Task();
    }

    public function testId(): void
    {
        $this->assertNull($this->task->getId());
    }

    public function testUsername()
    {
        $this->user->setUsername('UserTest');
        $this->assertSame('UserTest', $this->user->getUsername());
    }

    public function testSalt(): void
    {
        $this->assertNull($this->user->getSalt());
    }

    public function testPassword(): void
    {
        $this->user->setPassword('pass');
        $this->assertSame('pass', $this->user->getPassword());
    }

    public function testEmail(): void
    {
        $this->user->setEmail('UserTest@mail.com');
        $this->assertSame('UserTest@mail.com', $this->user->getEmail());
    }

    public function testRoles()
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->assertSame(['ROLE_USER'], $this->user->getRoles());
    }

    public function testUserSlug()
    {
        $this->user->setSlug('newuser');
        $this->assertSame('newuser', $this->user->getSlug());
    }

    public function testEraseCredentials(): void
    {
        $this->assertNull($this->user->eraseCredentials());
    }

    public function testGetTasks(): void
    {
        $task1=$this->task;
        $this->user->addTask($task1);
        $task1 = $this->user->getTasks();
        $this->assertSame($task1, $this->user->getTasks());
    }

    public function testAddTasks(): void
    {
        $task1=$this->task;
        $this->user->addTask($task1);
        $this->assertCount(1, $this->user->getTasks());
    }

    public function testRemoveTasks(): void
    {
        $task1=$this->task;
        $this->user->addTask($task1);
        $this->user->removeTask($task1);
        $this->assertCount(0, $this->user->getTasks());
    }


}