<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\NeedLogin;

class DefaultControllerTest extends WebTestCase
{
    use NeedLogin;

    private $client;

    public function setUp():void
    {
        $this->client = static::createClient();
    }

    public function testDisplayHomeForUser()
    {
        $this->loginUser();
        $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('h1', 'Bienvenue sur ToDo List');
    }

    public function testDisplayHomeForAdmin()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('link', 'Créer un utilisateur');
    }

    public function testRestrictedAccessForAnonymous()
    {
        $this->client->request('GET', '/');

        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/login");   ///login?
        //$this->assertSelectorExists('.alert.alert-danger');
    }
}
