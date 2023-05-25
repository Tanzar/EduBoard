<?php

namespace App\Tests\Unit\News;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Tests\DatabaseDependantTestCase;
use DateTime;

class ArticleRepositoryTest extends DatabaseDependantTestCase {
    
    private array $articles = [];

    protected function setUp() : void {
        parent::setUp();
        $user = $this->setUpUser();
        $this->entityManager->persist($user);
        $date = new DateTime();
        $date->modify('+1 days');
        for ($i=0; $i < 30; $i++) { 
            $article = new Article();
            $time = new DateTime($date->format('Y-m-d H:i:s'));
            $date->modify('-1 days');
            $article->setTimestamp($time);
            $article->setPublished($time);
            $article->setTitle('Title ' . $i);
            $article->setText('test');
            $article->setAuthor($user);
            $this->articles[] = $article;
            $this->entityManager->persist($article);
            $this->entityManager->flush();
        }
    }

    private function setUpUser() : User {
        $user = new User();
        $user->setEmail('test@mail.com');
        $user->setPassword('haslo');
        $user->setName('Me');
        $user->setSurname('Me2');
        $user->setPhone('999');
        $user->setAddress('Wieś');
        return $user;
    }

    /** @test */
    public function getLatest() {
        
        /** @var ArticleRepository */
        $repository = $this->entityManager->getRepository(Article::class);

        $articles = $repository->getLatest(4);

        /** @var Article[] */
        $expected = array_slice($this->articles, 1, 4);

        foreach ($articles as $key => $article) {
            $expectedArticle = $expected[$key];
            $this->assertEquals($expectedArticle, $article);
        }
    }

    /** @test */
    public function getFivePerPage() {

        /** @var ArticleRepository */
        $repository = $this->entityManager->getRepository(Article::class);

        $firstPage = $repository->getPage(1, 5);

        /** @var Article[] */
        $expectedFirstPage = array_slice($this->articles, 1, 5);

        foreach ($firstPage as $key => $article) {
            $expectedArticle = $expectedFirstPage[$key];
            $this->assertEquals($expectedArticle, $article);
        }

        
        $thirdPage = $repository->getPage(3, 5);

        /** @var Article[] */
        $expectedThirdPage = array_slice($this->articles, 11, 5);

        foreach ($thirdPage as $key => $article) {
            $expectedArticle = $expectedThirdPage[$key];
            $this->assertEquals($expectedArticle, $article);
        }
    }

    /** @test */
    public function getSevenPerPage() {

        /** @var ArticleRepository */
        $repository = $this->entityManager->getRepository(Article::class);

        $firstPage = $repository->getPage(1, 7);

        /** @var Article[] */
        $expectedFirstPage = array_slice($this->articles, 1, 7);

        foreach ($firstPage as $key => $article) {
            $expectedArticle = $expectedFirstPage[$key];
            $this->assertEquals($expectedArticle, $article);
        }

        
        $thirdPage = $repository->getPage(3, 7);

        /** @var Article[] */
        $expectedThirdPage = array_slice($this->articles, 15, 7);

        foreach ($thirdPage as $key => $article) {
            $expectedArticle = $expectedThirdPage[$key];
            $this->assertEquals($expectedArticle, $article);
        }
    }
}