<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function __construct()
    {
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();
        $message = array(
            'errors' => array(
                'message' => $exception->getMessage()
            )
        );
        if ($exception instanceof HttpExceptionInterface) {
            $message['errors']['code'] = $exception->getStatusCode();
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $message['errors']['code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $response->setContent(json_encode($message));
        $event->setResponse($response);
    }
}