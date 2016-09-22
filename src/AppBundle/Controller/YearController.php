<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Year;
use AppBundle\Form\YearType;

/**
 * Year controller.
 *
 * @Route("/admin/year")
 */
class YearController extends Controller
{

    /**
     * Lists all Year entities.
     *
     * @Route("/", name="year")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Year')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Year entity.
     *
     * @Route("/", name="year_create")
     * @Method("POST")
     * @Template("AppBundle:Year:new.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = new Year();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlash('success_create', 'success');
            return $this->redirect($this->generateUrl('year'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Year entity.
     *
     * @param Year $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Year $entity)
    {
        $form = $this->createForm(new YearType(), $entity, array(
            'action' => $this->generateUrl('year_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Зберегти',  'attr' => array(
            'class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new Year entity.
     *
     * @Route("/new", name="year_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Year();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Year entity.
     *
     * @Route("/{id}/edit", name="year_edit")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Year')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Year entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }

    /**
    * Creates a form to edit a Year entity.
    *
    * @param Year $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Year $entity)
    {
        $form = $this->createForm(new YearType(), $entity, array(
            'action' => $this->generateUrl('year_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Оновити',  'attr' => array(
            'class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Edits an existing Year entity.
     *
     * @Route("/{id}", name="year_update")
     * @Method("PUT")
     * @Template("AppBundle:Year:edit.html.twig")
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Year')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Year entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->addFlash('success_edit', 'success');
            return $this->redirect($this->generateUrl('year'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * @Route("/generate/measures/{year}", name="generate_measures")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param $year
     */
    public function generateMeasureAction()
    {
        return $this->redirect($this->generateUrl('year'));
    }
}
