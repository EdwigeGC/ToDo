<?php

namespace App\Tests\Controller;

use App\DataFixtures\AppFixtures;
use App\Tests\NeedLogin;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;


class TaskControllerTest extends WebTestCase
{
    use NeedLogin;

    private $client;
    private EntityManager $entityManager;

    public function setUp():void
    {
        $this->client = static::createClient();

        TaskControllerTest::$kernel=self::bootKernel();

        $this->entityManager= TaskControllerTest::$kernel->getContainer()->get('doctrine')->getManager();
        $fixture=new AppFixtures();
        $fixture->load($this->entityManager);
        dump($fixture);die;
    }

    public function testDisplayTaskListForUser()
    {
        $this->loginUser();

        $this->client->request('GET', '/tasks');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testTaskListNoAccessForAnonymous()
    {
        $this->client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/login");
    }

    public function testDisplaysFormForCreateTask()
    {
        $this->loginUser();

        $this->client->request('GET', '/tasks/create');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testCreateTask()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'newTask';
        $form['task[content]'] = 'new content task';
        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(302);
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('div', 'alert.alert-success');
    }

    public function testDisplaysFormForEditTask()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks/task2/edit');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testTaskModificationFormForAnonymous()
    {
        $this->client->request('GET', '/tasks/task2/edit');
        $this->assertResponseStatusCodeSame(302);
    }

    public function testEditTask()
    {
        $this->loginUser();
        $crawler=$this->client->request('GET', '/tasks/task2/edit');
        $form = $crawler->selectButton('Enregistrer les modifications')->form();
        $form['task[title]'] = 'Task edited';
        $form['task[content]'] = 'content task edited';
        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/tasks");
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('div.alert.alert-success');
    }

    public function testDeleteTaskAssignedToUser()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks/task12/delete');
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/tasks");
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('div.alert.alert-success');
    }

    public function testAdminDeleteAnonymousTask()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/tasks/task5/delete');
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/tasks");
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('div.alert.alert-success');
    }

    public function testUserDeleteAnonymousTask()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks/task5/delete');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testDeleteTaskNotAssignedToUser()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks/task2/delete');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testToggleTask()
    {
        $this->loginUser();

        $this->client->request('GET', '/tasks/task3/toggle');
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects("/tasks");
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('div.alert.alert-success');
    }

}