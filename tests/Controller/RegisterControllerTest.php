<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static ::createClient();
        /*$crawler = $client->request('GET', '/create_user');
        $ButtonCrawlerNote = $crawler->selectButton('submit');
        $form = $ButtonCrawlerNote->form([
            'register[username]' => 'Igor',
            'register[password][first]' => '123',
            'register[password][second]' => '123',
        ]);
        $client->submit($form);*/

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
