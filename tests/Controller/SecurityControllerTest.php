<?php

namespace App\Tests\Controller;

use App\Tests\NeedLogin;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    use NeedLogin;

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

    public function testLoginSuccess()
    {
        $crawler=$this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            'username' => 'Utilisateur',
            'password' => 'pass2'
        ]);
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/");
        $crawler=$this->client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testLoginWithBadCredentials()
    {
        $crawler=$this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            'username' => 'fakeUser',
            'password' => 'fakePass'
        ]);
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/login");
        $crawler=$this->client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('div.alert.alert-danger');
    }

    public function testLogOut()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/');
        $this->assertSelectorExists('a.pull-right.btn.btn-danger');
        $crawler->selectLink('Se déconnecter')->link();
        $this->throwException(new \LogicException());
        $this->assertResponseStatusCodeSame(200);
    }
}
