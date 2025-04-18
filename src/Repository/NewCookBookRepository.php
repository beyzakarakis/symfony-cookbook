<?php

namespace App\Repository;

use App\Entity\NewCookBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewCookBook>
 */
class NewCookBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewCookBook::class);
    }


    public function findOneByIdJoinedToCategory(int $id): ?NewCookBook
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p, c
            FROM App\Entity\NewCookBook p
            INNER JOIN p.category c
            WHERE p.id = :id'
        )->setParameter('id', $id);

        return $query->getOneOrNullResult();
    }

    public function addNewCookBook($title, $description, $category, $size)
    {
        $newCookBook = new NewCookBook();

        $newCookBook
            ->setTitle($title)
            ->setDescription($description)
            ->setCategory($category)
            ->setSize($size);

        $this->manager->persist($newCookBook);
        $this->manager->flush();
    }

    //    /**
    //     * @return NewCookBook[] Returns an array of NewCookBook objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?NewCookBook
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
