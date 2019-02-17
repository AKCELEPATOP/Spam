<?php

namespace App\Services;

use App\Models\Message;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class MailService
{
    protected $transport;

    protected $mailer;

    protected $mailGenerator;

    public function __construct()
    {
        $this->transport = (new Swift_SmtpTransport('smtp.mailtrap.io',2525))
            ->setUsername('c124ddc8a7554b')
            ->setPassword('6218b2112f35e6');
        $this->mailer = new Swift_Mailer($this->transport);
        $this->mailGenerator = new MailGenerator();
    }

    public function sendMessage(Message $messageInfo)
    {
        $message = (new Swift_Message('Shitty Subject'))
            ->setFrom(['from@example.com' => 'example'])
            ->setTo([$messageInfo->getAddress()])
            ->setBody($messageInfo->getBody());
        return $this->mailer->send($message);
    }
}
