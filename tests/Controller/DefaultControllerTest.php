<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testReadArticle()
    {
        $client = static ::createClient();
        $crawler = $client->request('GET', '/article/login');
        $ButtonCrawlerNote = $crawler->selectButton('submit');
        $form = $ButtonCrawlerNote->form([
            'username' => 'plumbum',
            'password' => 'mubmulp',
        ]);
        $client->submit($form);

        $crawler = $client->request('GET', '/article/en');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowArticle()
    {
        $client = static ::createClient();
        $crawler = $client->request('GET', '/article/login');
        $ButtonCrawlerNote = $crawler->selectButton('submit');
        $form = $ButtonCrawlerNote->form([
            'username' => 'plumbum',
            'password' => 'mubmulp',
        ]);
        $client->submit($form);

        $crawler = $client->request('GET', '/article/en/show/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateArticle()
    {
        $client = static ::createClient();
        $crawler = $client->request('GET', '/article/login');
        $ButtonCrawlerNote = $crawler->selectButton('submit');
        $form = $ButtonCrawlerNote->form([
            'username' => 'plumbum',
            'password' => 'mubmulp',
        ]);
        $client->submit($form);

        $crawler = $client->request('GET', '/article/en/new');
        $buttonCrawlerNode = $crawler->selectButton('article[submit]');
        $form = $buttonCrawlerNode->form([
           'article[name]' => 'fort',
           'article[description]' => 'trof',
           'article[created_at][date][month]' => '1',
           'article[created_at][date][day]' => '1',
           'article[created_at][date][year]' => '2019',
        ]);
        $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testUpdateArticle()
    {
        $client = static ::createClient();
        $crawler = $client->request('GET', '/article/login');
        $ButtonCrawlerNote = $crawler->selectButton('submit');
        $form = $ButtonCrawlerNote->form([
            'username' => 'plumbum',
            'password' => 'mubmulp',
        ]);
        $client->submit($form);

        $crawler = $client->request('GET', '/article/en/edit/1');
        $buttonCrawlerNode = $crawler->selectButton('article[submit]');
        $form = $buttonCrawlerNode->form([
            'article[name]' => 'win',
            'article[description]' => 'niw',
            'article[created_at][date][month]' => '1',
            'article[created_at][date][day]' => '1',
            'article[created_at][date][year]' => '2020',
        ]);
        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testDeleteArticle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article/login');
        $ButtonCrawlerNote = $crawler->selectButton('submit');
        $form = $ButtonCrawlerNote->form([
            'username' => 'plumbum',
            'password' => 'mubmulp',
        ]);
        $client->submit($form);

        $client->request('GET', '/article/en/delete/1');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
