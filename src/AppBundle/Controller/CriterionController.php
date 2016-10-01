<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Criterion;
use AppBundle\Form\CriterionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

        $entities = $em->getRepository('AppBundle:Criterion')->findGrouped();

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
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
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
            $this->addFlash('success_create', 'success');
            return $this->redirect($this->generateUrl('criterion'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
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

        $form->add('submit', 'submit', array('label' => 'Зберегти', 'attr' => array(
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
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Criterion entity.
     *
     * @Route("/{id}/edit", name="criterion_edit")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array
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
            'entity' => $entity,
            'edit_form' => $editForm->createView()
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

        $form->add('submit', 'submit', array('label' => 'Оновити', 'attr' => array(
            'class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Edits an existing Criterion entity.
     *
     * @Route("/{id}", name="criterion_update")
     * @Method("PUT")
     * @Template("AppBundle:Criterion:edit.html.twig")
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
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
            $this->addFlash('success_edit', 'success');
            return $this->redirect($this->generateUrl('criterion'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        );
    }
}
