<?php

namespace App\Controller;

use App\Entity\MailTemplate;
use App\Form\AddMailTemplateType;
use App\Repository\MailTemplateRepository;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{
    Request, Response
};

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Utils\MailHandler;


class MailTemplateController extends Controller
{
    /**
     * @Route("/mail/template", name="mail_template")
     */
    public function index(MailTemplateRepository $templates) : Response
    {
        return $this->render('mail/list.html.twig', [
            'templates' => $templates->findAll()
        ]);
    }

    /**
     * @Route("/mail/add", name="mail_template_add")
     */
    public function add(Request $request) : Response
    {
        $template = new MailTemplate();

        $form = $this->createForm(AddMailTemplateType::class, $template);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($template);
            $em->flush();

            $this->addFlash('Внимание', 'Шаблон успешно добавлен');

            return $this->redirectToRoute('mail_template');
        }


        return $this->render('mail/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
