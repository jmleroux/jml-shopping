<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Command\InstallCommand;
use PhpSpec\ObjectBehavior;
use Psr\Container\ContainerInterface;

class InstallCommandSpec extends ObjectBehavior
{
    function let(ContainerInterface $container, Connection $connection)
    {
        $this->beConstructedWith($container, $connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InstallCommand::class);
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
