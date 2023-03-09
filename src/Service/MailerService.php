<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class MailerService
{
    private $replyTo;
    public function __construct(private MailerInterface $mailer)
    {
    }
    public function sendEmail(
        $to = 'mariemchebbi112233@gmail.com',
        $content = '<p>See Twig integration for better HTML integration!</p>',
        $subject = 'Time for Symfony Mailer!'
    ): void {

        $from = new Address('commercial.edusex@gmail.com');

        $email = (new Email())
            ->from('commercial.edusex@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')

            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)

            //            ->text('Sending emails is fun again!')
            ->html($content);
        $this->mailer->send($email);
        // ...
    }
}
