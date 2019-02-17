<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 15.02.2019
 * Time: 17:36
 */

namespace App\Commands;


use App\Command\Base\BaseCommand;
use App\Models\Message;
use App\Services\MailService;
use App\Services\RabbitService;
use Karriere\JsonDecoder\JsonDecoder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueListener extends BaseCommand
{
    protected static $defaultName = "queue:listen";

    /** @var RabbitService */
    protected $rabbitService;

    /** @var MailService  */
    protected $mailService;

    /** @var JsonDecoder  */
    protected $jsonDecoder;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->rabbitService = new RabbitService();
        $this->mailService = new MailService();
        $this->jsonDecoder = new JsonDecoder();
    }

    protected function configure()
    {
        $this
            ->setDescription('Start listen queue')
            ->setHelp('This command start daemon sending emails from queue');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $callback = function ($msg) use ($output) {
            /** @var Message */
            $message = $this->jsonDecoder->decode($msg, Message::class);
            try{
                $this->mailService->sendMessage($message);
                $consoleMessage = 'Sent message';
                if($output->isVerbose()){
                    $consoleMessage .= ' to ' . $message->getBody();
                }
            }catch (\Exception $ex){

            }
        };
    }


}
