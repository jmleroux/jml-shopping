<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Command\InstallCommand;
use PhpSpec\ObjectBehavior;

class InstallCommandSpec extends ObjectBehavior
{
    function let(Connection $connection)
    {
        $this->beConstructedWith($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InstallCommand::class);
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
