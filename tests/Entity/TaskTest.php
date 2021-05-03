<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private $task;

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


}