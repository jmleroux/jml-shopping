<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\Tests\Integration\Security;

use Jmleroux\JmlShopping\Api\ApiBundle\Security\PasswordEncoder;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class PasswordEncoderTest extends TestCase
{
    public function testEncodePlainPassword()
    {
        $encoder = new PasswordEncoder();
        $encoded = $encoder->encodePlainPassword('foo');
        Assert::assertEquals(60, strlen($encoded));
    }

    public function testIsPasswordValid()
    {
        $encoder = new PasswordEncoder();
        Assert::assertTrue(
            $encoder->isPasswordValid('$2y$10$eUc9b9dsyPoJtdoKqE/dROpNyhTMsVsdX.8weoK5gBnLMPabr79MS', 'foobar')
        );
        Assert::assertFalse(
            $encoder->isPasswordValid('$2y$10$Vzca1uIY2d85UDcBpCuTzOhT0Y8tg0lEyK7/Nw7C3JrDQNI7HRfoo', 'foo')
        );
    }
}
