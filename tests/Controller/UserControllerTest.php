<?php

namespace App\Tests\Controller;

use App\Tests\NeedLogin;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    use NeedLogin;

    private $client;

    public function setUp():void
    {
        $this->client = static::createClient();
    }

    public function testDisplayListForAdminUser()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testUserListNoAccessForUserRole()
    {
        $this->loginUser();
        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testUserListNoAccessForAnonymous()
    {
        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/login");
    }


    public function testDisplayRegistrationForm()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users/create');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testNoUserCreationFormForUserRole()
    {
        $this->loginUser();
        $this->client->request('GET', '/users/create');
        $this->assertResponseStatusCodeSame(403);
        /*$this->client->followRedirect();
        $this->assertSelectorExists('div', 'alert.alert-danger');*/
    }

    public function testNoUserCreationFormForAnonymous()
    {
        $this->client->request('GET', '/users/create');
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/login");
    }

    public function testCreateUser()
    {
        $this->loginAdmin();

        $crawler = $this->client->request('GET', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'new user';
        $form['user[password][first]'] = 'pass';
        $form['user[password][second]'] = 'pass';
        $form['user[email]'] = 'newUser@email.com';
        $form['user[roles][0]']->select('ROLE_USER');
        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects('/users');
        $crawler=$this->client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('div.alert.alert-success');
    }

    public function testUserModificationFormForAdmin()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users/43/edit');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testUserModificationFormForUser()
    {
        $this->loginUser();
        $this->client->request('GET', '/users/43/edit');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testEditUser()
    {
        $this->loginAdmin();
        $crawler=$this->client->request('GET', '/users/43/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'new userName'; //modification du username
        $form['user[password][first]'] = 'pass';
        $form['user[password][second]'] = 'pass';
        $form['user[roles][0]']->select('ROLE_ADMIN'); //modification du rôle
        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/users");
        $crawler=$this->client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('div.alert.alert-success');
    }

}