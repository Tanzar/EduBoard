<?php

namespace App\Tests\Unit\Users;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\DatabaseDependantTestCase;

class UserRepositoryTest extends DatabaseDependantTestCase {
    
    private array $emails = [
        'test1@email.com', 'test2@email.com', 'test3@email.com', 'jacus123@gov.com', 'kaczorek92@majl.pl',
        'test6@email.com', 'test8@email.com', 'test10@email.com', 'test11@gov.com', 'test12@majl.pl',
        'test13@email.com', 'test122@email.com', 'test321@email.com', 'mirek@gov.com', 'glapa@majl.pl',
        'test16@email.com', 'test22@email.com', 'test31@email.com', 'rudy102@gov.com', 'polak@majl.pl',
        'test19@email.com', 'test29@email.com', 'test39@email.com', 'j9@gov.com', 'transtrigger@majl.pl',
        'test78@email.com', 'test72@email.com', 'test73@email.com', 'jak5@gov.com', 'kotke2@majl.pl'
    ];

    protected function setUp() : void {
        parent::setUp();
        foreach ($this->emails as $index => $email) {
            $user = $this->setUpUser($email);
            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();
    }

    private function setUpUser(string $email) : User {
        $user = new User();
        $user->setActive(true);
        $user->setEmail($email);
        $user->setPassword('haslo');
        $user->setName('Me');
        $user->setSurname('Me2');
        $user->setPhone('999');
        $user->setAddress('Wieś');
        return $user;
    }

    /** @test */
    public function getFivePerPage() {

        /** @var UserRepository */
        $repository = $this->entityManager->getRepository(User::class);

        $firstPage = $repository->getPage(1, 5);

        /** @var string[] */
        $expectedFirstPage = array_slice($this->emails, 0, 5);

        foreach ($firstPage as $key => $user) {
            $expected = $expectedFirstPage[$key];
            $this->assertEquals($expected, $user->getEmail());
        }

        
        $thirdPage = $repository->getPage(3, 5);

        /** @var string[] */
        $expectedThirdPage = array_slice($this->emails, 10, 5);

        foreach ($thirdPage as $key => $user) {
            $expected = $expectedThirdPage[$key];
            $this->assertEquals($expected, $user->getEmail());
        }
    }

    /** @test */
    public function getSevenPerPage() {

        /** @var UserRepository */
        $repository = $this->entityManager->getRepository(User::class);

        $firstPage = $repository->getPage(1, 7);

        /** @var string[] */
        $expectedFirstPage = array_slice($this->emails, 0, 7);

        foreach ($firstPage as $key => $user) {
            $expected = $expectedFirstPage[$key];
            $this->assertEquals($expected, $user->getEmail());
        }

        
        $thirdPage = $repository->getPage(3, 7);

        /** @var string[] */
        $expectedThirdPage = array_slice($this->emails, 14, 7);

        foreach ($thirdPage as $key => $user) {
            $expected = $expectedThirdPage[$key];
            $this->assertEquals($expected, $user->getEmail());
        }
    }
}