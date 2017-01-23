<?php

namespace DUT\Controllers;

use DUT\Services\SessionStorage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use DUT\Models\Article;
use DUT\Models\Comment;

class ItemsController
{
    /**
     * @param SessionStorage
     */
    private $store;

    public function __construct()
    {
    }

    /**
     * Affiche le formulaire d'ajout ainsi que la liste d'éléments
     * provenant de SessionStorage
     * @param Application $app
     */
    public function indexAction(Application $app)
    {
        $entityManager = $app['em'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');

        $all_article = $repository->findAll();

        return $app['twig']->render('home.twig', ['articles' => $all_article]);
    }

    /**
     * Supprime un élément dans SessionStorage à partir de son index
     * @param Application $app
     * @param int $index
     */
    public function removeAction(Application $app, $index)
    {
        $entityManager = $app['em'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');

        $urlToRedirect = $app['url_generator']->generate('GET_');

        $itemToRemove = $entityManager->find('DUT\\Models\\Article', $index);
        $entityManager->remove($itemToRemove);
        $entityManager->flush();

        return $app->redirect($urlToRedirect);
    }

    /**
     * Ajoute un élément dans SessionStorage depuis les informations d'un
     * formulaire
     * @param Application $app
     * @param Request $request
     */


    public function CreateArticle(Application $app, Request $request)
    {
        if ($request->get('titre_art') == NULL || $request->get('contenu_art') == NULL) {
            return $app['twig']->render('create.twig');
        }

        $entityManager = $app['em'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');

        $urlToRedirect = $app['url_generator']->generate('GET_');

        $newArticle = new Article($request->get('titre_art'), $request->get('contenu_art'), $request->get('image'));
        $entityManager->persist($newArticle);
        $entityManager->flush();

        return $app->redirect($urlToRedirect);

    }

    public function ViewArticle(Application $app, Request $request, $index)
    {
        $entityManager = $app['em'];
        $repositoryArt = $entityManager->getRepository('DUT\\Models\\Article');
        $repositoryCom = $entityManager->getRepository('DUT\\Models\\Comment');

        $Article_Index = $entityManager->find('DUT\\Models\\Article', $index);
        $Comm_Index = $repositoryCom->findBy(['id_article' => $index]);
        return $app['twig']->render('article.twig', ['article' => $Article_Index, 'Comment' => $Comm_Index]);
    }

    public function CommentArticle(Application $app, Request $request, $index)
    {
        $entityManager = $app['em'];
        $repository = $entityManager->getRepository('DUT\\Models\\Comment');

        $article_index = $entityManager->find('DUT\\Models\\Article', $index);

        if ($request->get('pseudo') == NULL || $request->get('contenu_com') == NULL) {
            return $app['twig']->render('comments.twig', ['article' => $article_index]);
        }

        $newComment = new Comment($index, $request->get('pseudo'), $request->get('contenu_com'), date("d-m-Y"));
        $entityManager->persist($newComment);
        $entityManager->flush();

        return $app->redirect($app['url_generator']->generate('GET_article_index', array('index' => $index)));
    }


    public function removeCom (Application $app, $index)
    {
        $entityManager = $app['em'];
        $repository = $entityManager->getRepository('DUT\\Models\\Comment');
        $repository2 = $entityManager->getRepository('DUT\\Models\\Article');
        $Article_Index = $entityManager->find('DUT\\Models\\Comment', $index);
        $urlToRedirect = $app['url_generator']->generate('GET_');
        $itemToRemove = $entityManager->find('DUT\\Models\\Comment', $index);
        $entityManager->remove($itemToRemove);
        $entityManager->flush();
        return $app->redirect($urlToRedirect);
    }
}