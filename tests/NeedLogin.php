<?php

namespace App\Tests;

trait NeedLogin
{
    /*private $client;

    public function __construct()
    {
        $this->client = static::createClient();
    }*/

    public function loginAdmin ()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            'username' => 'Administrateur',
            'password' => 'pass'
        ]);
    }

    public function loginUser()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            'username' => 'Utilisateur',
            'password' => 'pass2'
        ]);

    }
}