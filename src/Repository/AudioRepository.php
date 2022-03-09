<?php

namespace App\Repository;

use App\Entity\Audio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Audio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Audio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Audio[]    findAll()
 * @method Audio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AudioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Audio::class);
    }

    // SELECT *
    // FROM `audio`
    // INNER JOIN `audio_category`
    // ON audio.id = audio_category.audio_id
    // INNER JOIN `category`
    // ON category.id = audio_category.category_id
    // ORDER BY category.id = 1
    // DESC

    public function findByCategory()
    {

        return $this->createQueryBuilder('a')
            ->innerJoin('App\Entity\Category', 'c')
            ->innerJoin('c.audio', 'ca', 'WITH', 'ca.id = a.id')
            ->innerJoin('a.categories', 'ac', 'WITH', 'ac.id = c.id')
            ->orderBy('c.id' ,'ASC')
            ->getQuery()
            ->getResult();
    }

}
