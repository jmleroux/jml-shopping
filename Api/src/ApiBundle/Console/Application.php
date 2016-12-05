<?php

namespace Jmleroux\Console;

use Cilex\Provider\Console\ConsoleServiceProvider;
use Jmleroux\Api;

class Application extends Api\Application
{
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $this->registerCommands();
    }

    public function registerProviders()
    {
        parent::registerProviders();

        $this->register(new ConsoleServiceProvider(), [
            'console.name' => 'MyConsole',
            'console.version' => '2.1'
        ]);
    }

    protected function registerCommands()
    {
        $console = $this['console'];

        $console->add(new Command\UserAdd());
        $console->add(new Command\UserDelete());
        $console->add(new Command\ClearRuntime());
    }
}
