<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('igorspringery@gmail.com')
            ->to('igoryspringer@gmail.com')
            ->subject('First')
            ->text('Send');
        //->html('<p>See first send</p>')
        //->attachFromPath('/home/igoryspringer/Изображения/bullterier.jpg')
        //->embed(fopen('/home/igoryspringer/Изображения/bullterier2.jpg', 'r'), 'logo');
        $mailer->send($email);

        return new JsonResponse(['success' => true]);
    }
}
