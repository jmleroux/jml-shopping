<?php
declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

class TokenEncoder
{
    /** @var Connection */
    private $db;

    /** @var LoggerInterface */
    private $logger;

    /**
     * @var string encryption key should be 16, 24 or 32 characters long form 128, 192, 256 bit encryption
     */
    protected $encryptionKey;

    protected $tokenLifetime = 3600;

    public function __construct(Connection $db, LoggerInterface $logger, string $encryptionKey)
    {
        $this->db = $db;
        $this->encryptionKey = $encryptionKey;
        $this->logger = $logger;
    }

    public function encryptToken(string $username): string
    {
        $key = Key::loadFromAsciiSafeString($this->encryptionKey);
        $token = Crypto::Encrypt($username . '-+-' . time(), $key);

        return $username . '-+-' . base64_encode($token);
    }

    public function decryptToken(string $token): string
    {
        $key = Key::loadFromAsciiSafeString($this->encryptionKey);
        $decrypted = Crypto::Decrypt($token, $key);

        return $decrypted;
    }

    public function tokenIsValid(string $payload): bool
    {
        list($username, $base64Token) = explode('-+-', $payload);
        $token = base64_decode($base64Token);
        $key = Key::loadFromAsciiSafeString($this->encryptionKey);
        try {
            $decrypted = Crypto::Decrypt($token, $key);
        } catch (\Exception $e) {
            return false;
        }
        if ($decrypted) {
            list($secretUsername, $time) = explode('-+-', $decrypted);
            if ($secretUsername != $username) {
                return false;
            }
            if (time() - (int)$time > $this->tokenLifetime) {
                $this->logger->warning('Expired token for ' . $username);
                return false;
            }

            return true;
        }

        return false;
    }
}
