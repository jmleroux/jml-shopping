<?php

namespace spec\Jmleroux\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApplicationSpec extends ObjectBehavior
{
    protected $config = [
        'app' => [
            'app.root' => '/tmp',
            'debug'    => false,
        ],
        'db.options' => [
            'driver' => 'pdo_sqlite',
            'path' => '/tmp/dummy',
        ],
    ];

    function let()
    {
        $this->beConstructedWith($this->config);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Console\Application');
        $this->shouldHaveType('Jmleroux\Api\Application');
    }
}
