<?php

namespace MWSimple\Bundle\ForoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MWSimple\Bundle\ForoBundle\Entity\Respuesta;
use MWSimple\Bundle\ForoBundle\Form\RespuestaType;
use MWSimple\Bundle\ForoBundle\Form\RespuestaFilterType;

/**
 * Respuesta controller.
 * @author Nombre Apellido <name@gmail.com>
 *
 * @Route("/fororespuesta")
 */
class RespuestaController extends Controller
{
    public function newAction($entrada_id) {
        $entrada = $this->getEntrada($entrada_id);
        $usuario = $this->get('security.context')->getToken()->getUser();
        $respuesta = new Respuesta();
        $respuesta->setEntrada($entrada);
        $respuesta->setMiembro($usuario);
        $form   = $this->createForm(new RespuestaType(), $respuesta);

        return $this->render('MWSimpleForoBundle:Respuesta:form.html.twig', array(
            'entrada' => $entrada,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Respuesta entity.
     *
     * @Route("/{entrada_id}", name="foro_respuesta_create")
     * @Method("POST")
     * @Template("MWSimpleForoBundle:Respuesta:create.html.twig")
     */
    public function createAction($entrada_id)
    {
        $entrada = $this->getEntrada($entrada_id);
        $usuario = $this->get('security.context')->getToken()->getUser();
        $respuesta = new Respuesta();
        $respuesta->setEntrada($entrada);
        $respuesta->setMiembro($usuario);
        $request = $this->getRequest();
        $form   = $this->createForm(new RespuestaType(), $respuesta);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($respuesta);
            $em->flush();

            // Redirect 
            return $this->redirect($this->generateUrl('foro_mws', array(
                'foro_id' => $entrada->getGrupo()->getId())) .
                '#respuesta-' . $respuesta->getId()
            );
        }

        return $this->render('MWSimpleForoBundle:Respuesta:create.html.twig', array(
            'respuesta' => $respuesta,
            'form'    => $form->createView()
        ));
    }


    protected function getEntrada($entrada_id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entrada = $em->getRepository('MWSimpleForoBundle:Entrada')->find($entrada_id);

        if (!$entrada) {
            throw $this->createNotFoundException('Unable to find Grupo post.');
        }

        return $entrada;
    }

    /**
     * Finds and delete a Respuesta entity.
     *
     * @Route("/id/{respuesta_id}", name="borrar_respuesta", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deletedRespuesta(Request $request, $respuesta_id) {
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getManager();
        $respuesta = $em->getRepository('MWSimpleForoBundle:Respuesta')->find($respuesta_id);
        $entrada = $respuesta->getEntrada();
        $em->remove($respuesta);
        $em->flush();

        // Redirect 
        return $this->redirect($this->generateUrl('foro_mws', array(
            'foro_id' => $entrada->getGrupo()->getId())) .
            '#respuesta-' . '0'
        );
        
    }
}