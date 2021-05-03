<?php

namespace App\Tests\Controller;

use App\Tests\NeedLogin;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client;

    public function setUp():void
    {
        $this->client = static::createClient();
    }

    public function testDisplayLoginPage()
    {
        $this->client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('button', 'Se connecter');
    }


    /*public function testLoginWithBadCredentials()
    {
        $this->client->request('POST', '/login', [
            '_username'=> 'fakeUser',
            '_password'=>'fakePass'
        ]);
        $this->assertResponseStatusCodeSame(302);
        $this->client->followRedirect();
        $this->assertSelectorExists('div', 'alert.alert-danger');
    }*/

    /*public function testLoginSuccess()
    {
        $this->client->request('POST', '/login', [
            '_username'=> 'UserTest',
            '_password'=>'pass'
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
    }*/

    /*public function testLogOut()
    {
        $crawler = $this->client->request('GET', '/');
        $crawler->selectLink('Se déconnecter')->link();
        $this->assertResponseStatusCodeSame(200);
    }*/
}
