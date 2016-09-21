<?php

namespace Rating\AdminBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rating\SubdivisionBundle\Entity\Institute;
use Rating\SubdivisionBundle\Form\InstituteType;


/**
 * Institute controller.
 *
 * @Route("/institute")
 */
class InstituteController extends Controller
{

    /**
     * Lists all Institute entities.
     *
     * @Route("/", name="institutes")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RatingSubdivisionBundle:Institute')->findAll();


        return $this->render('RatingAdminBundle:Institute:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Creates a new Institute entity.
     *
     * @Route("/", name="institute_create")
     * @Method("POST")
     * @Template("RatingAdminBundle:Institute:new.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = new Institute();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('institutes'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Institute entity.
     *
     * @param Institute $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Institute $entity)
    {
        $form = $this->createForm(new InstituteType(), $entity, array(
            'action' => $this->generateUrl('institute_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Зберегти',  'attr' => array(
            'class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new Institute entity.
     *
     * @Route("/new", name="institute_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Institute();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Institute entity.
     *
     * @Route("/{id}", name="institute_show")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RatingSubdivisionBundle:Institute')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Institute entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Institute entity.
     *
     * @Route("/{id}/edit", name="institute_edit")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RatingSubdivisionBundle:Institute')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Institute entity.');
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
    * Creates a form to edit a Institute entity.
    *
    * @param Institute $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Institute $entity)
    {
        $form = $this->createForm(new InstituteType(), $entity, array(
            'action' => $this->generateUrl('institute_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Оновити',  'attr' => array(
            'class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Edits an existing Institute entity.
     *
     * @Route("/{id}", name="institute_update")
     * @Method("PUT")
     * @Template("RatingAdminBundle:Institute:edit.html.twig")
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RatingSubdivisionBundle:Institute')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Institute entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('institute_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Institute entity.
     *
     * @Route("/{id}", name="institute_delete")
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
            $entity = $em->getRepository('RatingSubdivisionBundle:Institute')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Institute entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('institute'));
    }

    /**
     * Creates a form to delete a Institute entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('institute_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm();
    }
}
