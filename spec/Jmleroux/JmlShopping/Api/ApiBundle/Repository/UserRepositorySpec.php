<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Statement;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\User;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use PDO;
use PhpSpec\ObjectBehavior;

class UserRepositorySpec extends ObjectBehavior
{
    function let(
        Connection $connection
    ) {
        $this->beConstructedWith($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserRepository::class);
    }

    function it_find_one_user(
        Connection $connection,
        QueryBuilder $qb,
        Statement $statement
    ) {
        $row = $this->get_row_fixture();
        $username = $row['login'];

        $connection->createQueryBuilder()->willReturn($qb);

        $this->prepare_find_query_builder($qb);
        $qb->where('login = ?')->willReturn($qb);
        $qb->values([$username])->willReturn($qb);
        $qb->execute()->willReturn($statement);
        $statement->fetch(PDO::FETCH_ASSOC)->willReturn($row);

        $this->findByUsername('admin')->shouldHaveType(User::class);
    }

    function prepare_find_query_builder(QueryBuilder $qb)
    {
        $qb->select('login, password')->willReturn($qb);
        $qb->from('users', 'u')->willReturn($qb);

        return $qb;
    }

    function get_row_fixture()
    {
        return [
            'login' => 'admin',
            'password' => 'adminpass',
        ];
    }

    function get_user_fixture()
    {
        return [
            'username' => 'admin',
            'password' => 'adminpass',
        ];
    }
}
