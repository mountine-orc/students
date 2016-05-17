<?php

namespace StudentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('student/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/student/detail/{path}", name="students_detail")
     * @param $path
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction($path)
    {
        $repository = $this->getDoctrine()->getRepository('StudentBundle:Student');
        $student = $repository->findOneByPath($path);

        $response = $this->render('student/detail.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'student' => $student
        ]);

        //set response as public for enable caching
        $response->setPublic();

        return $response;
    }
}
