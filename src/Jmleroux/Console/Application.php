<?php

namespace Jmleroux\Console;

use Jmleroux\Api;
use Knp\Provider\ConsoleServiceProvider;

class Application extends Api\Application
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->registerCommands();
    }

    public function registerProviders()
    {
        parent::registerProviders();

        $this->register(new ConsoleServiceProvider(), [
            'console.name' => 'MyConsole',
            'console.version' => '2.1',
            'console.project_directory' => $this['app.root']
        ]);
    }

    protected function registerCommands()
    {
        $console = $this['console'];

        $console->add(new Command\UserAdd());
    }
}
