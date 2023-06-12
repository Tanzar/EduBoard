<?php

namespace App\Cache;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class UsersCache {

    private int $usersPerPage = 20;

    private int $timer = 10;

    public function __construct(
        private CacheInterface $cache,
        private UserRepository $userRepository
    ){

    }

    /** 
     * @param int $page number of page lists only some users, if number is 0 then lists all
     *  
     * @return User[] 
     */
    public function getAll(int $page = 0) : array {
        if($page === 0){
            $key = 'users-all';
            return $this->cache->get($key, function(ItemInterface $item){
                $item->expiresAfter($this->timer);
                return $this->userRepository->findAll();
            });
        }
        else{
            $key = 'users-all-page-' . $page;
            return $this->cache->get($key, function(ItemInterface $item) use ($page){
                $item->expiresAfter($this->timer);
                return $this->userRepository->getPage($page, $this->usersPerPage);
            });
        }
    }

    public function getPagesCount() : int {
        $users = $this->getAll();
        return (int) ceil(count($users) / $this->usersPerPage);
    }

    /** @return User[] */
    public function getActive(int $page = 0) : array {
        if($page === 0){
            $key = 'users-active';
            return $this->cache->get($key, function(ItemInterface $item){
                $item->expiresAfter($this->timer);
                return $this->userRepository->findBy(['active' => 1]);
            });
        }
        else{
            $key = 'users-active-page-' . $page;
            return $this->cache->get($key, function(ItemInterface $item) use ($page){
                $item->expiresAfter($this->timer);
                return $this->userRepository->getPageOfActive($page, $this->usersPerPage);
            });
        }
    }

    /** @return User[] */
    public function getInactive(int $page = 0) : array {
        if($page === 0){
            $key = 'users-inactive';
            return $this->cache->get($key, function(ItemInterface $item){
                $item->expiresAfter($this->timer);
                return $this->userRepository->findBy(['active' => 0]);
            });
        }
        else{
            $key = 'users-inactive-page-' . $page;
            return $this->cache->get($key, function(ItemInterface $item) use ($page){
                $item->expiresAfter($this->timer);
                return $this->userRepository->getPageOfInactive($page, $this->usersPerPage);
            });
        }
    }

}