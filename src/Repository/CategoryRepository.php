<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // SQL query to get the most read category
    // -------------------------------------
    //     SELECT *
    // FROM `category`
    // INNER JOIN `book_category`
    // ON category.id = book_category.category_id
    // INNER JOIN `book`
    // ON book.id = book_category.book_id
    //     INNER JOIN `pinnedpage`
    // ON book.id = pinnedpage.book_id
    // GROUP BY category.id
    // ORDER BY COUNT(*) DESC
    // LIMIT 1
    // -------------------------------------

    public function findMostRead()
    {

        return $this->createQueryBuilder('c')
            ->innerJoin('App\Entity\Book', 'b')
            ->innerJoin('c.books', 'cb', 'WITH', 'cb.id = b.id')
            ->innerJoin('b.categories', 'bc', 'WITH', 'bc.id = c.id')
            ->innerJoin('App\Entity\Pinnedpage', 'p')
            ->innerJoin('p.book', 'pb', 'WITH', 'pb.id = b.id')
            ->groupBy('c.id')
            ->orderBy('count(c.id)', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }


    // public function findByCategorie()
    // {
    //     return $this->createQueryBuilder('c')
    //         // ->groupBy('c.id')
    //         ->where('c.id = :identifier')
    //         ->orderBy('c.id', 'DESC')
    //         ->setParameter('identifier', 3)
    //         ->getQuery()
    //         ->getResult();
    // }

}
