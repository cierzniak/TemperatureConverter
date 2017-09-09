<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Translation\TranslatorInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        $error = ['message' => $this->translator->trans($exception->getMessage(), [], 'exception')];
        $response = new JsonResponse(compact('error'), $exception->getCode());
        $event->setResponse($response);
    }
}
