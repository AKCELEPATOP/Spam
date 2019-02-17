<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 15.02.2019
 * Time: 12:46
 */

namespace App\Command\Base;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
    protected function info(OutputInterface $output, $message, int $minLevel = OutputInterface::VERBOSITY_QUIET)
    {
        $output->writeln('<info>' . $message . '</info>', $minLevel);
    }

    protected function error(OutputInterface $output, $message)
    {
        $output->writeln('<error>' . $message . '</error>');
    }
}
