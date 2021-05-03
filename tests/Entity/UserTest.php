<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testId()
    {
        $this->user->setId(1);
        $this->assertSame(1, $this->user->getId());
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





}