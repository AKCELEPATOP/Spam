<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 15.02.2019
 * Time: 16:38
 */

namespace App\Commands;

use App\Command\Base\BaseCommand;
use App\Services\MailGenerator;
use App\Services\RabbitService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FillQueue extends BaseCommand
{
    const COUNT_GENERATE = 5000;

    protected static $defaultName = "queue:fill";

    /** @var RabbitService */
    protected $rabbitService;

    /** @var MailGenerator */
    protected $generatorService;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->rabbitService = new RabbitService();
        $this->generatorService = new MailGenerator();
    }

    protected function configure()
    {
        $this
            ->setDescription('Fill queue with messages')
            ->setHelp('This command allows you to send messages');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $count = self::COUNT_GENERATE;
        $countSent = 0;
        for ($i = 0; $i < $count; $i++) {
            try {
                $consoleMessage = $this->sendMessage($output->isDebug());
                $countSent++;
                $this->info($output, $consoleMessage, OutputInterface::VERBOSITY_VERY_VERBOSE);
            } catch (\Exception $ex) {
                $this->error($output, 'Error: ' . $ex->getMessage());
            }
        }
        $consoleMessage = 'Sent ' . $countSent . ' to queue';
        $this->info($output, $consoleMessage, OutputInterface::VERBOSITY_VERBOSE);
    }

    private function sendMessage(bool $isDebug)
    {
        $message = $this->generatorService->generateMessage();
        $body = json_encode($message);
        $this->rabbitService->sendMessage($body);

        $consoleMessage = 'Sent message to queue for ' . $message->getAddress();
        if ($isDebug) {
            $consoleMessage .= ' with body <' . $message->getBody() . '>';
        }
        return $consoleMessage;
    }
}
