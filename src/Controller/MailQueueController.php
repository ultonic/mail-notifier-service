<?php

namespace App\Controller;

use App\Utils\MailHandler;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\{
    Request, Response
};

use Symfony\Component\Validator\Constraints\{
    NotBlank
};
use Symfony\Component\Form\Extension\Core\Type\{
    SubmitType, TextareaType
};

class MailQueueController extends Controller
{
    /**
     * @Route("/mail/queue/", name="mail_queue")
     */
    public function index(MailHandler $mailHandler, Request $request)
    {

        $form = $this->createFormBuilder()
            ->add(
                'record', TextareaType::class, [
                'label' => 'Задание',
                'attr' => [ 'class' => 'form-control', 'style' => 'margin: 0px 0px 10px 0px'],
                'required' => true,
                'constraints' => array(new NotBlank())
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Добавить задание',
                'attr' => ['class' => 'btn btn-primary', 'style' => 'margin: 0px 0px 10px 0px']
            ])
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $mailHandler->queueManager->addRecord($form['record']->getData());

                $this->addFlash('notice', 'Задание успешно добавлено!');

                return $this->redirectToRoute('mail_queue');
            }

        return $this->render('mail_queue/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
