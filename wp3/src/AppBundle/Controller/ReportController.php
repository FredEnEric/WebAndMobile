<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Report;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\LoggableController;

class ReportController extends LoggableController
{
    /**
     * @Route("/report/add", name="report_add")
     */
    public function addAction( Request $request )
    {
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );

        $report = new Report();
        
        $form = $this->createFormBuilder( $report )
            ->add( 'location', EntityType::class, array(
                'class' => 'AppBundle:Location',
                'choice_label' => 'name'
            ))
            ->add( 'date', DateType::class )
            ->add( 'text', TextareaType::class )
            ->add( 'save', SubmitType::class, array( 'label' => 'Save report' ) )
            ->getForm();

        $form->handleRequest( $request );
    
        if ( $form->isSubmitted() && $form->isValid() ) {
            $report = $form->getData();
    
            $em = $this->getDoctrine()->getManager();
            $em->persist( $report );
            $em->flush();
    
            return $this->redirectToRoute( 'report_saved' );
        }

        return $this->render( 'AppBundle:Report:add.html.twig', array(
            'form' => $form->createView(),
        ) );
    }
    
    /**
     * @Route("/report/edit/{report}", name="report_edit")
     */
    public function editAction( $report, Request $request )
    {
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );

        $em = $this->getDoctrine()->getManager();
        $report = $em->getRepository( 'AppBundle:Report' )->findOneById( $report );

        $form = $this->createFormBuilder( $report )
            ->add( 'location', EntityType::class, array(
                'class' => 'AppBundle:Location',
                'choice_label' => 'name'
            ))
            ->add( 'date', DateType::class )
            ->add( 'text', TextareaType::class )
            ->add( 'handled', CheckboxType::class, array(
                'required' => false,
            ) )
            ->add( 'technician', EntityType::class, array(
                'class' => 'AppBundle:Technician',
                'choice_label' => 'name'
            ) )
            ->add( 'save', SubmitType::class, array( 'label' => 'Save report' ) )
            ->getForm();

        $form->handleRequest( $request );
    
        if ( $form->isSubmitted() && $form->isValid() ) {
            $report = $form->getData();
    
            $em = $this->getDoctrine()->getManager();
            $em->persist( $report );
            $em->flush();
    
            return $this->redirectToRoute( 'report_saved' );
        }

        return $this->render( 'AppBundle:Report:edit.html.twig', array(
            'form' => $form->createView(),
        ) );
    }

    /**
     * @Route("/report/all", name="report_all")
     */
    public function allAction( Request $request )
    {
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );

        $reports = $this->getDoctrine()->getRepository( 'AppBundle:Report' )->findAll();

        return $this->render( 'AppBundle:Report:all.html.twig', compact( "reports" ) );
    }
    
    /**
     * @Route("/report/saved", name="report_saved")
     */
    public function savedAction( Request $request )
    {
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );

        return $this->render( 'AppBundle:Report:saved.html.twig' );
    }
}
