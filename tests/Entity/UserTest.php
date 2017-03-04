<?php

namespace Commission\Tests;

use Commission\Entity\User;
use Commission\Exception\InvalidUserTypeException;
use Commission\Exception\WrongUserIdException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        $this->user = new User();
    }

    public function testSetWrongId()
    {
        $this->expectException(WrongUserIdException::class);
        $this->user->setId('abc');
    }

    public function testSetWrongType()
    {
        $this->expectException(InvalidUserTypeException::class);
        $this->user->setType('type', ['first_type', 'second_type']);
    }
}