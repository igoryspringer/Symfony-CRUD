<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MailControllerTest extends WebTestCase
{
    public function testMailIsSentAndContentIsOk()
    {
        $client = static::createClient();

        $client->enableProfiler();

        $crawler = $client->request('POST', 'http://127.0.0.1:8000/email');

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        $this->assertSame(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Send', $message);
        $this->assertSame('First', $message->getSubject());
        $this->assertSame('igorspringery@gmail.com', key($message->getFrom()));
        $this->assertSame('igoryspringer@gmail.com', key($message->getTo()));
        $this->assertSame(
            'Send',
            $message->getBody()
        );
    }
}