<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Audio;
use App\Entity\Author;
use App\Entity\Editor;
use App\Entity\Category;
use App\Entity\Favorite;
use App\Entity\Pinnedpage;
use App\Entity\Recommendation;
use App\Service\MailJet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class BackofficeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="backoffice")
     */
    public function index(): Response
    {
    
        // on compte le nombre d'id de la table User
        $userRepository = $this->entityManager->getRepository(User::class);

        $totalUsers = $userRepository->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // on compte le nombre d'id de la table Book
        $bookRepository = $this->entityManager->getRepository(Book::class);

        $totalBooks = $bookRepository->createQueryBuilder('b')
            ->select('count(b.id)')
            ->getQuery()
            ->getSingleScalarResult();


        // on compte le nombre d'id de la table audio    
        $audioRepository = $this->entityManager->getRepository(Audio::class);

        $totalAudios = $audioRepository->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();


        // on compte le nombre d'id de la table Category
        $categoryRepository = $this->entityManager->getRepository(Category::class);

        $totalCategories = $categoryRepository->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $categoryMostRead = $this->entityManager->getRepository(Category::class)->findMostRead();
        if ($categoryMostRead){

            $categoryMostRead = $categoryMostRead[0]->getName();
        }
        

        // on compte le nombre d'id de la tale Author
        $authorRepository = $this->entityManager->getRepository(Author::class);

        $totalAuthors = $authorRepository->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();


        // on compte le nombre d'id de la table Editor    
        $editorRepository = $this->entityManager->getRepository(Editor::class);

        $totalEditor = $editorRepository->createQueryBuilder('e')
            ->select('count(e.id)')
            ->getQuery()
            ->getSingleScalarResult();

        
        // on compte le nombre d'id de la table Recommendation
        $recommendationRepository = $this->entityManager->getRepository(Recommendation::class);

        $totalRecommendations = $recommendationRepository->createQueryBuilder('r')
            ->select('count(r.id)')
            ->getQuery()
            ->getSingleScalarResult();

        //on se sert de la custom query présente dans le repository de Recommendation pour trouver le livre le plus recommandé. Attention, c'est un tableau !
        $bookMostRecommended = $this->entityManager->getRepository(Recommendation::class)->findMostRecommendated();

        //on récupère la première entrée du tableau ( bien que ce soit un tableau avec une seule entrée, on facilite son accessibilité en sortie )
        if($bookMostRecommended){
            $bookMostRecommended = $bookMostRecommended[0]->getBook()->getTitle();
        }else{
            $bookMostRecommended = null;
        }


        // on compte le nombre d'id de la table Favorite
        $favoriteRepository = $this->entityManager->getRepository(Favorite::class);

        $totalFavorites = $favoriteRepository->createQueryBuilder('f')
            ->select('count(f.id)')
            ->getQuery()
            ->getSingleScalarResult();


        // on compte le nombre d'id de la table Pinnedpage.    
        $pinnedpageRepository = $this->entityManager->getRepository(Pinnedpage::class);

        $totalPinnedpages = $pinnedpageRepository->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();


        return $this->render('backoffice/index.html.twig', [
            'nbUsers' => $totalUsers,
            'nbBooks' => $totalBooks,
            'nbAudios' => $totalAudios,
            'nbCategories' => $totalCategories,
            'nbAuthors' => $totalAuthors,
            'nbEditors' => $totalEditor,
            'nbRecommendations' => $totalRecommendations,
            'bookMostRecommended' => $bookMostRecommended,
            'nbFavorites' => $totalFavorites,
            'nbPinnedpages' => $totalPinnedpages,
        ]);
    }
}
