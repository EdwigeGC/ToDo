<?php

namespace App\Tests;

trait NeedLogin
{
    public function loginAdmin ()
    {
        $this->client->request('POST', '/login', [
        '_username'=> 'AdminTest',
        '_password'=>'pass',
        'role'=>'ROLE_ADMIN'
        ]);
    }

    public function loginUser()
    {
        $this->client->request('POST', '/login', [
            '_username'=> 'UserTest',
            '_password'=>'pass',
            'role'=>'ROLE_USER'
        ]);
    }
}