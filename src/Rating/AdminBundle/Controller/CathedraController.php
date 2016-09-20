<?php

namespace Rating\AdminBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rating\SubdivisionBundle\Entity\Cathedra;
use Rating\SubdivisionBundle\Form\CathedraType;

/**
 * Cathedra controller.
 *
 * @Route("/admin/cathedra")
 */
class CathedraController extends Controller
{
    /**
     * Lists all Cathedra entities.
     *
     * @Route("/", name="cathedras")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RatingSubdivisionBundle:Cathedra')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Cathedra entity.
     * @Route("/", name="cathedra_create")
     * @Method("POST")
     * @Template("RatingAdminBundle:Cathedra:new.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = new Cathedra();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cathedra_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Cathedra entity.
     *
     * @param Cathedra $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cathedra $entity)
    {
        $form = $this->createForm(new CathedraType(), $entity, array(
            'action' => $this->generateUrl('cathedra_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Зберегти',  'attr' => array(
            'class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new Cathedra entity.
     *
     * @Route("/new", name="cathedra_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cathedra();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cathedra entity.
     *
     * @Route("/{id}", name="cathedra_show")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RatingSubdivisionBundle:Cathedra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cathedra entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cathedra entity.
     *
     * @Route("/{id}/edit", name="cathedra_edit")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RatingSubdivisionBundle:Cathedra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cathedra entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Cathedra entity.
    *
    * @param Cathedra $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cathedra $entity)
    {
        $form = $this->createForm(new CathedraType(), $entity, array(
            'action' => $this->generateUrl('cathedra_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Оновити',  'attr' => array(
            'class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Edits an existing Cathedra entity.
     *
     * @Route("/{id}", name="cathedra_update")
     * @Method("PUT")
     * @Template("RatingAdminBundle:Cathedra:edit.html.twig")
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RatingSubdivisionBundle:Cathedra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cathedra entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cathedra_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Cathedra entity.
     *
     * @Route("/{id}", name="cathedra_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RatingSubdivisionBundle:Cathedra')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cathedra entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cathedra'));
    }

    /**
     * Creates a form to delete a Cathedra entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cathedra_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm();
    }

}
