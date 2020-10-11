<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Statement;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\User;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use PDO;
use PhpSpec\ObjectBehavior;

class UserRepositorySpec extends ObjectBehavior
{
    function let(Connection $connection, QueryBuilder $qb, Statement $statement)
    {
        $connection->createQueryBuilder()->willReturn($qb);
        $qb->select('login, password')->willReturn($qb);
        $qb->from('users', 'u')->willReturn($qb);
        $qb->where('login = :username')->willReturn($qb);
        $qb->execute()->willReturn($statement);

        $this->beConstructedWith($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserRepository::class);
    }

    function it_find_one_user(QueryBuilder $qb, Statement $statement)
    {
        $row = $this->get_row_fixture();
        $username = $row['login'];

        $qb->select('login')->willReturn($qb);
        $qb->from('users', 'u')->willReturn($qb);
        $qb->where('login = :username')->willReturn($qb);
        $qb->setParameter('username', $username, \PDO::PARAM_STR)->willReturn($qb);

        $statement->fetchAssociative()->willReturn($row);

        $this->findByUsername('admin')->shouldHaveType(User::class);
    }

    function it_return_null_for_unknown_user(QueryBuilder $qb, Statement $statement)
    {
        $username = 'foo';

        $qb->select('login')->willReturn($qb);
        $qb->from('users', 'u')->willReturn($qb);
        $qb->where('login = :username')->willReturn($qb);
        $qb->setParameter('username', $username, \PDO::PARAM_STR)->willReturn($qb);

        $statement->fetchAssociative()->willReturn(null);

        $this->findByUsername($username)->shouldReturn(null);
    }

    function get_row_fixture()
    {
        return [
            'login' => 'admin',
        ];
    }

    function get_user_fixture()
    {
        return [
            'username' => 'admin',
        ];
    }
}
