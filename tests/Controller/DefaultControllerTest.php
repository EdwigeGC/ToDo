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

    /*public function testDisplayHomeForUser()
    {
        $this->loginAdmin($this->client);
        $this->client->request('GET', '/');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
    }*/

    public function testRestrictedAccessForAnonymous()
    {
        $this->client->request('GET', '/');

        $this->assertResponseStatusCodeSame(302);    //403
        $this->assertResponseRedirects();   ///login?
        //$this->assertSelectorExists('.alert.alert-danger');
    }

    /*public function testDisplayHomeForAdmin()
    {
        $this->client->request('GET', '/');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('button', 'Créer un utilisateur');
    }*/
}
