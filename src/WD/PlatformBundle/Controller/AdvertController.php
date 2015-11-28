<?php

// src/WD/PlatformBundle/Controller/AdvertController.php

namespace WD\PlatformBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFKernel\Exception\NotFoundHttpException;
use WD\PlatformBundle\Entity\Advert;
use WD\PlatformBundle\Entity\Application;


class AdvertController extends Controller
{



	public function indexAction($page)
	{
    
		$listAdverts = array(
		array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => 1,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'    => new \Datetime()),
		array(
			'title'   => 'Mission de webmaster',
			'id'      => 2,
			'author'  => 'Hugo',
			'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
			'date'    => new \Datetime()),
		array(
			'title'   => 'Offre de stage webdesigner',
			'id'      => 3,
			'author'  => 'Mathieu',
			'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
			'date'    => new \Datetime())
		);

			return $this->render('WDPlatformBundle:Advert:index.html.twig', array('listAdverts' => $listAdverts));
	
	$mailer = $this->container->get('mailer'); 
	
	
	}
  
	 public function menuAction($limit)  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony2'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('WDPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }
  
	public function viewAction($id){
	  
		$em = $this->getDoctrine()->getManager();

		// On récupère l'annonce $id
		$advert = $em
			->getRepository('WDPlatformBundle:Advert')
			->find($id);

		if (null === $advert) {
			throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
		}

		// On récupère la liste des candidatures de cette annonce
		$listApplications = $em
			->getRepository('WDPlatformBundle:Application')
			->findBy(array('advert' => $advert));

		return $this->render('WDPlatformBundle:Advert:view.html.twig', array(
			'advert'           => $advert,
			'listApplications' => $listApplications
		));
	}
	
	
	public function addAction(Request $request)
  {
    // Création de l'entité
    $advert = new Advert();
    $advert->setTitle('Recherche développeur Symfony2.');
    $advert->setAuthor('Alexandre');
    $advert->setContent("Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…");
    // On peut ne pas définir ni la date ni la publication,
    // car ces attributs sont définis automatiquement dans le constructeur

	
	// Création d'une première candidature
    $application1 = new Application();
    $application1->setAuthor('Marine');
    $application1->setContent("J'ai toutes les qualités requises.");

    // Création d'une deuxième candidature par exemple
    $application2 = new Application();
    $application2->setAuthor('Pierre');
    $application2->setContent("Je suis très motivé.");

    // On lie les candidatures à l'annonce
    $application1->setAdvert($advert);
    $application2->setAdvert($advert);

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($advert);

    // Étape 1 bis : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
    // définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
    $em->persist($application1);
    $em->persist($application2);

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    $em->flush();

    // Reste de la méthode qu'on avait déjà écrit
    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
      return $this->redirect($this->generateUrl('wd_platform_view', array('id' => $advert->getId())));
    }

     return $this->render('WDPlatformBundle:Advert:add.html.twig');
  }
  
    public function editAction($id,Request $request)    {
        if($request ->isMethod('POST')){
		  $request->getSession()->getFlashBag()->add('notice','Annonce bien modifiée.');
		  return $this->redirectToRoute('wd_platform_view',array('id' =>5));
		}
		$advert = array(
		'title'   => 'Recherche développpeur Symfony2',
		'id'      => $id,
		'author'  => 'Alexandre',
		'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
		'date'    => new \Datetime()
		);
		return $this->render('WDPlatformBundle:Advert:edit.html.twig',array('advert' => $advert));
	}
	
	public function deleteAction()    {
         return $this->render('WDPlatformBundle:Advert:delete.html.twig', array('nom' => 'Djimoun'));
    }
}