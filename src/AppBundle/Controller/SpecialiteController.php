<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Specialite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Specialite controller.
 *
 * @Route("backend/specialite")
 */
class SpecialiteController extends Controller
{
    /**
     * Lists all specialite entities.
     *
     * @Route("/", name="backend_specialite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $specialites = $em->getRepository('AppBundle:Specialite')->findAll();

        return $this->render('specialite/index.html.twig', array(
            'specialites' => $specialites,
        ));
    }

    /**
     * Creates a new specialite entity.
     *
     * @Route("/new", name="backend_specialite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $specialite = new Specialite();
        $form = $this->createForm('AppBundle\Form\SpecialiteType', $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($specialite);
            $em->flush();

            return $this->redirectToRoute('backend_specialite_index');
        }

        return $this->render('specialite/new.html.twig', array(
            'specialite' => $specialite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a specialite entity.
     *
     * @Route("/{slug}", name="backend_specialite_show")
     * @Method("GET")
     */
    public function showAction(Specialite $specialite)
    {
        $deleteForm = $this->createDeleteForm($specialite);

        return $this->render('specialite/show.html.twig', array(
            'specialite' => $specialite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing specialite entity.
     *
     * @Route("/{slug}/edit", name="backend_specialite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Specialite $specialite)
    {
        $deleteForm = $this->createDeleteForm($specialite);
        $editForm = $this->createForm('AppBundle\Form\SpecialiteType', $specialite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_specialite_index');
        }

        return $this->render('specialite/edit.html.twig', array(
            'specialite' => $specialite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a specialite entity.
     *
     * @Route("/{id}", name="backend_specialite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Specialite $specialite)
    {
        $form = $this->createDeleteForm($specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specialite);
            $em->flush();
        }

        return $this->redirectToRoute('backend_specialite_index');
    }

    /**
     * Creates a form to delete a specialite entity.
     *
     * @param Specialite $specialite The specialite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Specialite $specialite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_specialite_delete', array('id' => $specialite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
