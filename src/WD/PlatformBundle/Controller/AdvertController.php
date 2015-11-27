<?php

// src/WD/PlatformBundle/Controller/AdvertController.php

namespace WD\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFKernel\Exception\NotFoundHttpException;



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
		$advert = array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => $id,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'    => new \Datetime()
		);

		return $this->render('WDPlatformBundle:Advert:view.html.twig', array(
			'advert' => $advert
		));	
	}
	
	public function addAction(Request $request)  {
	 
	 $antispam = $this->container->get('wd_platform.antispam');

    // Je pars du principe que $text contient le texte d'un message quelconque
    $text = 'ffgfgfuigqkufgquigfiuqgfuiqgsiufguiqgfuidgsvigvg<gvg<idgviudsgviugsdiuvgidusvgiudsgviugdsiuvgdsuivgiusdgviusdgviugdsiuvgsdiuvgdiusgviusdgviudsg';
    if ($antispam->isSpam($text)) {
      throw new \Exception('Votre message a été détecté comme spam !');
	 
	}
	 
    if ($request->isMethod('POST')) {

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      return $this->redirectToRoute('wd_platform_view', array('id' => 5));
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