<?php
/**
 * @category  WT
 * @package   WT_Playground
 * @author    Rehan Mobin <m.rehan.mobin@gmail.com>
 * @copyright Copyright (c) wardatechnologies. All rights reserved. (https://www.wardatechnologies.com)
 */

namespace WT\Playground\UI\Console;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use \Magento\Framework\App\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Module\Dir\Reader as ModuleDir;

class PlaygroundDirResolver
{
    CONST PG_DIR_PATH = BP. '/dev/tools';
}
