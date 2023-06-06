<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

   /**
     * @return User[] Returns an array of User objects
     */
    public function getPage(int $page = 1, int $count = 1) : array {
        $users = $this->createQueryBuilder('u')
            ->orderBy('u.surname', 'ASC')
            ->getQuery()
            ->getResult();
        $page = ($page < 1) ? 1 : $page;
        $count = ($count < 1) ? 1 : $count;
        $startIndex = ($page - 1) * $count;
        return array_slice($users, $startIndex, $count);
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function getPageOfActive(int $page = 1, int $count = 1) : array {
        $users = $this->createQueryBuilder('u')
            ->orderBy('u.surname', 'ASC')
            ->andWhere('u.active = :active')
            ->setParameter('active', 1)
            ->getQuery()
            ->getResult();
        $page = ($page < 1) ? 1 : $page;
        $count = ($count < 1) ? 1 : $count;
        $startIndex = ($page - 1) * $count;
        return array_slice($users, $startIndex, $count);
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function getPageOfInactive(int $page = 1, int $count = 1) : array {
        $users = $this->createQueryBuilder('u')
            ->orderBy('u.surname', 'ASC')
            ->andWhere('u.active = :active')
            ->setParameter('active', 0)
            ->getQuery()
            ->getResult();
        $page = ($page < 1) ? 1 : $page;
        $count = ($count < 1) ? 1 : $count;
        $startIndex = ($page - 1) * $count;
        return array_slice($users, $startIndex, $count);
    }
}
