<?php
/**
 * @category  DTP
 * @package   DTP_Playground
 * @author    Rehan Mobin <m.rehan.mobin@gmail.com>
 * @copyright Copyright (c) devteampro. All rights reserved. (https://devteampro.com/)
 */

namespace DTP\Playground\UI\Console;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use \Magento\Framework\App\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PlaygroundCommand extends Command
{
    private State $state;
    private string $dirPath;

    public function __construct(State $state, string $pgDir)
    {
        $this->state = $state;
        $this->dirPath = $pgDir;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('dtp:playground')
            ->setDescription('playground for developers to quickly test any code.');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->state->setAreaCode(Area::AREA_GLOBAL);
        $playgroundFn = @include $this->dirPath . '/playground.php';
        if (!$playgroundFn) {
            $output->writeln('No playground fn to execute.');
            return 0;
        }
        $instance = ObjectManager::getInstance();
        $playgroundFn($instance);
        return 0;
    }
}
