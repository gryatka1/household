<?php

namespace Household\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use InvalidArgumentException;

class GlobalExceptionHandler implements EventSubscriberInterface
{
    public function handle(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse($exception->getMessage(), 500);

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        if ($exception instanceof InvalidArgumentException) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }


        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'handle'
        ];
    }
}
