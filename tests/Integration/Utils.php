<?php
declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\Tests\Integration;

use Jmleroux\JmlShopping\Api\ApiBundle\Security\TokenEncoder;

class Utils
{
    public const VALID_USER = 'admin';
    public const VALID_PASSWORD = 'foobar';

    /** @var TokenEncoder */
    private $tokenEncoder;

    /** @var string */
    public $generatedToken;

    public function __construct(TokenEncoder $tokenEncoder)
    {
        $this->tokenEncoder = $tokenEncoder;
    }

    public function getValidToken(): string
    {
        if (null === $this->generatedToken) {
            $this->generatedToken = $this->tokenEncoder->encryptToken(self::VALID_USER);
        }

        return $this->generatedToken;
    }
}
