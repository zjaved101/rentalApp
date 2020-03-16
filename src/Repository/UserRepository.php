<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
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

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return User[]
     */
    public function findAll() {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('SELECT email FROM App\Entity\User email');

        return $query->getResult();
    }

    /**
     * @return User[]
     */
    public function findKey(String $search, String $key) {
        if($key == "first")
            return $this->findFirstName($search);
        if($key == "last")
            return $this->findLastName($search);
        if($key == "home")
            return $this->findHomePhone($search);
        if($key == "cell")
            return $this->findCellPhone($search);
        if($key == "email")
            return $this->findEmail($search);
    }

    /**
     * @return User[]
     */
    public function findEmail(String $email) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT u FROM App\Entity\User u WHERE u.email = :email')->setParameter('email', $email);
        return $query->getResult();
    }

    /**
     * @return User[]
     */
    public function findHomePhone(String $phone) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT u FROM App\Entity\User u WHERE u.homePhone = :phone')->setParameter('phone', $phone);
        return $query->getResult();
    }

    /**
     * @return User[]
     */
    public function findCellPhone(String $phone) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT u FROM App\Entity\User u WHERE u.cellPhone = :phone')->setParameter('phone', $phone);
        return $query->getResult();
    }

    /**
     * @return User[]
     */
    public function findName(String $firstName, String $lastName) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT u FROM App\Entity\User u WHERE u.firstName = :first AND u.lastName = :last')->setParameters(array(
            'first' => $firstName, 
            'last' => $lastName));

        return $query->getResult();
    }

    /**
     * @return User[]
     */
    public function findFirstName(String $firstName) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT u FROM App\Entity\User u WHERE u.firstName = :first')->setParameters(array(
            'first' => $firstName));

        return $query->getResult();
    }

    /**
     * @return User[]
     */
    public function findLastName(String $lastName) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT u FROM App\Entity\User u WHERE u.lastName = :last')->setParameters(array( 
            'last' => $lastName));

        return $query->getResult();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
