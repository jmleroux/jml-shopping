<?php

namespace spec\Jmleroux\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApplicationSpec extends ObjectBehavior
{
    function let()
    {
        $config = [
            'app'        => [
                'app.root' => __DIR__ . '/../../fixtures',
                'debug'    => false,
            ],
            'db.options' => [
                'driver' => 'pdo_sqlite',
                'path'   => '/tmp/dummy',
            ],
        ];

        $this->beConstructedWith($config);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Console\Application');
        $this->shouldHaveType('Jmleroux\Api\Application');
    }
}
