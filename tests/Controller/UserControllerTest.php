<?php

namespace App\Tests\Controller;

use App\Tests\NeedLogin;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class UserControllerTest extends WebTestCase
{
    use NeedLogin;

    private $client;

    public function setUp():void
    {
        $this->client = static::createClient();
    }

    public function testDisplayUsersList()
    {
        $this->loginAdmin($this->client);
        $this->client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(200);
    }

    /*public function testAccessDeniedForUserManagement()
    {
        $this->loginUser($this->client);
        $this->client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(403);
        $this->client->followRedirect();
        $this->assertSelectorExists('div', 'alert.alert-danger');
    }*/

    public function testDisplayFormForCreateUser()
    {
        $this->client->request('GET', '/users/create');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testCreateUser()
    {
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'user';
        $form['user[password][first]'] = 'pass';
        $form['user[password][second]'] = 'pass';
        $form['user[email]'] = 'user@email.com';
        //$form['ROLE_USER']->tick();
        $this->client->submit($form);

        $this->assertSelectorExists('div', 'Superbe !');

        /*

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('div', 'alert.alert-success');
        //$this->assertResponseRedirects();*/
    }

    /*public function testCreateWithBadData()
    {
        $this->client->request('POST', '/users/create', [
            '_username'=> 'userTest',
            '_password_first'=>'pass',
            '_password_second'=>'pass2',
            '_email'=> 'userTest.email.com'
            //'_role'=>'ROLE_USER'
        ]);

        $this->assertResponseStatusCodeSame(400);
        //$this->assertResponseRedirects('/users/create');
        $this->client->followRedirect();
        $this->assertSelectorExists('div', 'alert.alert-danger');
    }*/

    public function testDisplayFormForEditUser()
    {
        $this->client->request('GET', '/users/4/edit');

        $this->assertResponseStatusCodeSame(200);
    }

    /*public function testEditActionUser()
    {

    }*/

}