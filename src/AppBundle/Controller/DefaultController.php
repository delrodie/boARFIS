<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $presentations = $em->getRepository('AppBundle:Presentation')->findBy(array('statut'=>1), array('id'=>'DESC'), 1,0);
        $specialites = $em->getRepository('AppBundle:Specialite')->findBy(array('statut'=>1));
        $services = $em->getRepository('AppBundle:Service')->findBy(array('statut'=>1));
        $produits = $em->getRepository('AppBundle:Produit')->findBy(array('statut'=>1), array('id'=>'DESC'),1,0);
        $contacts = $em->getRepository('AppBundle:Contact')->findBy(array('statut'=>1), array('id'=>'DESC'),1,0);

        return $this->render('default/index.html.twig', [
            'presentations' => $presentations,
            'specialites' => $specialites,
            'services' => $services,
            'produits' => $produits,
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/mail", name="contact_email")
     * @Method({"GET", "POST"})
     */
    public function mailAction(Request $request, \Swift_Mailer $mailer)
    {
        $nom = $request->get('arfisNom');
        $email = $request->get('arfisEmail');
        $objet = $request->get('arfisObjet');
        $observation = $request->get('arfisMessage');

        $message = (new \Swift_Message($objet))
            ->setFrom(['info@arfis-ci.com' => 'INTERNAUTE'])
            //->setTo($partenaire)
            ->setTo(['info@arfis-ci.com', 'arfis.imail@yahoo.fr'])
            //->setTo(['delrodieamoikon@gmail.com', 'delrodieamoikon@outlook.fr'])
            //->setBcc(['info@alloimmo.ci', 'delrodieamoikon@gmail.com'])
            ->setBcc('delrodieamoikon@gmail.com')
            ->setReplyTo($email)
            ->setBody(
                $this->renderView(
                    'default/contact_mail.html.twig',[
                        'nom' => $nom,
                        'email' => $email,
                        'objet' => $objet,
                        'observation' => $observation,
                    ]
                ), 'text/html'
            )
        ;

        if ($mailer->send($message)) {
            $this->addFlash('notice', 'Votre message a bien été envoyé !?');
            return $this->redirectToRoute('homepage');
        } else {
            $this->addFlash('erreur', 'ne sommes desolé votre message n\'a pas pu être envoyé');
        }

        /*return $this->render('default/contact_mail.html.twig',[ 57210365
            'nom' => $nom,
            'email' => $email,
            'objet' => $objet,
            'observation' => $observation,
          ]);*/


        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/backend/dashboard", name="backend")
     */
    public function backendAction(){
        return $this->render('default/dashboard.html.twig');
    }
}
