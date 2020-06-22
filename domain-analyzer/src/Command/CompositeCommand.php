<?php
declare(strict_types=1);


namespace App\Command;


/**
 * Class CompositeCommand
 * @package App\Command
 */
class CompositeCommand extends Command
{

    /**
     * @var Command[]
     */
    private $commands;

    /**
     * CompositeCommand constructor.
     * @param Command ...$commands
     */
    public function __construct(Command ...$commands)
    {
        $this->commands = $commands;
    }

    /**
     * @param string $domain
     * @return array
     */
    public function run(string $domain): array
    {
        $result = [];
        foreach ($this->commands as $command) {
            $result = array_merge($result, $command->run($domain));
        }
        return $result;
    }
}