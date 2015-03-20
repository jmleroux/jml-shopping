<?php

namespace spec\Jmleroux\Api;

use PhpSpec\ObjectBehavior;

class ApplicationSpec extends ObjectBehavior
{
    protected $config;

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

        $this->config = $config;
        $this->beConstructedWith($config);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Api\Application');
        $this->shouldHaveType('Silex\Application');
    }

    function it_can_register_providers()
    {
        $this->offsetGet('db.options')->shouldReturn($this->config['db.options']);
        $this->offsetGet('monolog.logfile')
            ->shouldReturn($this->config['app']['app.root'] . '/runtime/log/application.log');
    }
}
