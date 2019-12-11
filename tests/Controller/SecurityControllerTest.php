<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testlogin()
    {
        $client = static ::createClient();
        $crawler = $client->request('GET', '/article/login');
        $ButtonCrawlerNote = $crawler->selectButton('submit');
        $form = $ButtonCrawlerNote->form([
            'username' => 'Igor',
            'password' => '123',
        ]);
        $client->submit($form);

        $client->request('GET', '/article/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
