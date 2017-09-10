<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Translation\TranslatorInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private $translator;
    private $template;

    public function __construct(TranslatorInterface $translator, \Twig_Environment $template)
    {
        $this->translator = $translator;
        $this->template = $template;
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $json = (bool) preg_match('/^\/api\//', $event->getRequest()->getPathInfo());
        $exception = $event->getException();
        $code = $exception->getCode();
        if ($code === 0) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        $error = [
            'message' => $this->translator->trans($exception->getMessage(), [], 'exception'),
            'response_code' => $code,
        ];
        $response = new JsonResponse(compact('error'), $code);
        if ($json === false) {
            $response = new Response($this->template->render('ExceptionSubscriber/error.html.twig', $error));
        }
        $event->setResponse($response);
    }
}
