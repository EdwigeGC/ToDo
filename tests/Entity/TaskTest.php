<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{
    private Task $task;

    public function setUp(): void
    {
        $this->task = new Task();
    }

    public function testId(): void
    {
        $this->assertNull($this->task->getId());
    }

    public function testCreatedAt()
    {
        $date = new \DateTime();
        $this->task->setCreatedAt($date);
        $this->assertSame($date, $this->task->getCreatedAt());
    }

    public function testSlug()
    {
        $this->task->setSlug('newtask');
        $this->assertSame('newtask', $this->task->getSlug());
    }

    public function testTitle()
    {
        $this->task->setTitle('New Task');
        $this->assertSame('New Task', $this->task->getTitle());
    }

    public function testContent()
    {
        $this->task->setContent('Content of the task');
        $this->assertSame('Content of the task', $this->task->getContent());
    }

    public function testIsDone()
    {
        $this->task->setIsDone(true);
        $this->task->toggle(true);
        $this->assertSame(true, $this->task->getIsDone());
        $this->assertSame(true, $this->task->isDone());
    }

        public function testUsers()
    {
        $this->task->setUsers(new User());
        $this->assertInstanceOf(User::class, $this->task->getUsers());
    }

}