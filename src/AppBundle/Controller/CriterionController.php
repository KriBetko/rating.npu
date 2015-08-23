<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Criterion;
use AppBundle\Form\CriterionType;

/**
 * Criterion controller.
 *
 * @Route("/admin/criterion")
 */
class CriterionController extends Controller
{

    /**
     * Lists all Criterion entities.
     *
     * @Route("/", name="criterion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Criterion')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Criterion entity.
     *
     * @Route("/", name="criterion_create")
     * @Method("POST")
     * @Template("AppBundle:Criterion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Criterion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('criterion_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Criterion entity.
     *
     * @param Criterion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Criterion $entity)
    {
        $form = $this->createForm(new CriterionType(), $entity, array(
            'action' => $this->generateUrl('criterion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Зберегти',  'attr' => array(
            'class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new Criterion entity.
     *
     * @Route("/new", name="criterion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Criterion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Criterion entity.
     *
     * @Route("/{id}/edit", name="criterion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Criterion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Criterion entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }

    /**
    * Creates a form to edit a Criterion entity.
    *
    * @param Criterion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Criterion $entity)
    {
        $form = $this->createForm(new CriterionType(), $entity, array(
            'action' => $this->generateUrl('criterion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Оновити',  'attr' => array(
            'class' => 'btn btn-success')));

        return $form;
    }
    /**
     * Edits an existing Criterion entity.
     *
     * @Route("/{id}", name="criterion_update")
     * @Method("PUT")
     * @Template("AppBundle:Criterion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Criterion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Criterion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('criterion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }
}
