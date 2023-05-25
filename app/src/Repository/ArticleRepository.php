<?php

namespace App\Repository;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function getAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.published', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function getToDateOrderedByDate(DateTime $date): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.published <= ' . $date->format('Y-m-d'))
            ->orderBy('a.published', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function getLatest(int $count = 1) : array {
        $date = new DateTime();
        $articles = $this->createQueryBuilder('a')
            ->orderBy('a.published', 'DESC')
            ->where('a.published <= :date')
            ->setParameter('date', $date->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();
        if($count < 1){ $count = 1; }
        return array_slice($articles, 0, $count);
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function getPage(int $page = 1, int $count = 1) : array {
        $date = new DateTime();
        $articles = $this->createQueryBuilder('a')
            ->orderBy('a.published', 'DESC')
            ->where('a.published <= :date')
            ->setParameter('date', $date->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();
        $page = ($page < 1) ? 1 : $page;
        $count = ($count < 1) ? 1 : $count;
        $startIndex = ($page - 1) * $count;
        return array_slice($articles, $startIndex, $count);
    }
}
