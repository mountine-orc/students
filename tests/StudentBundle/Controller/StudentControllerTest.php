<?php

namespace Tests\StudentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StudentControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/student/detail/yura_panayotov');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Yura Panayotov', $crawler->filter('h1')->text());
    }
}
