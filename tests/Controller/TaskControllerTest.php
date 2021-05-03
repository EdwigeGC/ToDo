<?php

namespace App\Tests\Controller;

use App\Repository\TaskRepository;
use App\Tests\NeedLogin;
use App\DataFixtures\TaskFixtures;
use Doctrine\Common\DataFixtures\Loader;
use App\Entity\Task;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Persistence\ObjectManager;

class TaskControllerTest extends WebTestCase
{
    use NeedLogin;

    private $client;

    public function setUp():void
    {
        $this->client = static::createClient();
    }

    public function testDisplayTaskList()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/tasks');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testAccessDeniedForVisitor()
    {
        $this->client->request('GET', '/tasks');

        $this->assertResponseStatusCodeSame(302);
    }

    public function testDisplayFormForCreateTask()
    {
        $this->client->request('GET', '/tasks/create');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testCreateActionTask()
    {
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'newTask';
        $form['task[content]'] = 'new content task';

        $this->client->submit($form);

        //$this->assertResponseStatusCodeSame(200);
        $crawler=$this->client->followRedirect('/tasks');
        $this->assertSelectorExists('div', 'alert.alert-success');
    }

    public function testCreateWithEmptyData()
    {
       $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'newTaskN';
        $form['task[content]'] = 'new content taskN';

        $this->client->submit($form);
        $this->assertSelectorExists('div.alert.alert-danger');
    }

    public function testDisplayFormForEditTask()
    {
        $this->client->request('GET', '/tasks/6/edit');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testEditActionTask()
    {
        $crawler=$this->client->request('GET', '/tasks/12/edit');
        $form = $crawler->selectButton('Ajouter')->form();
            $form['task[title]'] = 'newTask edited';
            $form['task[content]'] = 'new content task edited';

        $this->client->submit($form);
        $this->assertResponseStatusCodeSame(200);
    }

    public function testDeleteTask()
    {
        $this->client->request('GET', '/tasks/12/delete');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testToggleTask()
    {
        $this->client->request('GET', '/tasks/12/toggle');
        $this->assertResponseStatusCodeSame(200);
    }

    public function tearDown():void
    {

    }

}