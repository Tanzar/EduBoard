<?php

namespace App\Cache;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use DateTime;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ArticleCache {
    private int $countPerPage = 10;

    public function __construct(
        private CacheInterface $cache, 
        private ArticleRepository $repository) {

    }
    
    /**
     * @return Article[] Returns an array of Article objects
     */
    public function getLatest() : array {
        $date = new DateTime();
        $key = sprintf("articles-latest-%d", $date->format('Y-m-d-H:i:s'));
        
        return $this->cache->get($key, function(ItemInterface $item){
            $item->expiresAfter(60);
            return $this->repository->getLatest(4);
        });
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function getPage(int $page) : array {
        $date = new DateTime();
        $key = sprintf("articles-page-%d-%d", $page, $date->format('Y-m-d-H:i:s'));

        return $this->cache->get($key, function(ItemInterface $item) use ($page) {
            $item->expiresAfter(60);
            return $this->repository->getPage($page, $this->countPerPage);
        });
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function getArticle(int $id) : Article {
        $key = sprintf("articles-id-%d", $id);

        return $this->cache->get($key, function(ItemInterface $item) use ($id) {
            $item->expiresAfter(60);
            return $this->repository->findOneBy(['id' => $id]);
        });
    }
}