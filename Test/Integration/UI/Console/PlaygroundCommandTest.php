<?php
/**
 * @category  DTP
 * @package   DTP_Playground
 * @author    Rehan Mobin <m.rehan.mobin@gmail.com>
 * @copyright Copyright (c) devteampro. All rights reserved. (https://devteampro.com/)
 */

namespace DTP\Playground\Test\UI\Console;

use DTP\Playground\UI\Console\PlaygroundCommand;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\State;
use Symfony\Component\Console\Tester\CommandTester;

class PlaygroundCommandTest extends TestCase
{
    private ?ObjectManagerInterface $objectManager = null;
    private ?CommandTester $command = null;
    private ?string $testPlayGroundDirPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testPlayGroundDirPath = dirname(__DIR__, 2) . '/';
        $this->objectManager = Bootstrap::getObjectManager();
        $this->given_test_playground_file_does_not_exists();
    }

    /**
     * @test
     * @magentoDbIsolation enabled
     */
    public function does_nothing_if_no_playground_file_exists()
    {
        $this->when_command_execute();
        $this->then_playground_function_will_not_execute();
    }

    /**
     * @test
     * @magentoDbIsolation enabled
     */
    public function execute_playground_function()
    {
        $this->given_there_is_a_playground_file_exists();
        $this->when_command_execute();
        $this->then_playground_fn_output_matches();
    }

    private function when_command_execute(): void
    {
        $this->command = new CommandTester(new PlaygroundCommand(
            $this->objectManager->get(State::class),
            $this->testPlayGroundDirPath
        ));
        $this->command->execute([]);
    }

    private function then_playground_function_will_not_execute(): void
    {
        $output = $this->command->getDisplay();
        $this->assertStringContainsString('No playground fn to execute.', $output);
    }

    private function then_playground_fn_output_matches(): void
    {
        $this->expectOutputRegex('/lib\/web/');
    }

    private function given_there_is_a_playground_file_exists(): void
    {
        file_put_contents($this->testPlayGroundDirPath. 'playground.php', <<<PHP
<?php
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Filesystem\DirectoryList;

return function(ObjectManager \$ob) {
    \$dir = \$ob->get(DirectoryList::class);
    echo (\$dir->getPath('lib_web'));
};
PHP
        );
    }

    private function given_test_playground_file_does_not_exists(): void
    {
        @unlink($this->testPlayGroundDirPath. 'playground.php');
    }
}
