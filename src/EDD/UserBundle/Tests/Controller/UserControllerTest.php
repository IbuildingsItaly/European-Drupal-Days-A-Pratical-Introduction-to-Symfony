<?php

namespace EDD\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testCreateuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createUser');
    }

    public function testDeleteuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteUser');
    }

    public function testReadusers()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readUsers');
    }

    public function testReaduser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readUser');
    }

}
