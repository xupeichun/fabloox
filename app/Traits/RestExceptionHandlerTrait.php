<?php

namespace App\Traits;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait RestExceptionHandlerTrait
{

    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $e)
    {


        switch (true) {
            case $this->isModelNotFoundException($e):
                $retval = $this->modelNotFound();
                break;
//
            case $this->isAuthTokenWrong($e):
                $retval = $this->authenticationExceptionResponse($e);
                break;
            default:
                $retval = $this->badRequest($e);
        }

        return $retval;
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */

    protected function authenticationExceptionResponse($e){

        return $this->jsonResponse(
            [
                'responseCode' => 205,
                'message' => $e->getMessage(),
                'data' => new \ArrayObject(),

            ]
        , 200);

    }


    protected function badRequest($e)
    {

        return $this->jsonResponse(
            [
                'responseCode' => 501,
                'message' => $e->getMessage(),
                'data' => new \ArrayObject(),
                'errors' => [
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile()
                ]
            ]
        );
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelNotFound($message = 'Record not found', $statusCode = 200)
    {
        return $this->jsonResponse(['error' => $message], $statusCode);
    }

    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload = null, $statusCode = 404)
    {
        $payload = $payload ?: [];

        return response()->json($payload, $statusCode);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Exception $e
     * @return bool
     */


    protected function isAuthTokenWrong(Exception $e)
    {

        return $e instanceof AuthenticationException;

    }


    protected function isModelNotFoundException(Exception $e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isBadMethodCallException(Exception $e)
    {
        return $e instanceof \BadMethodCallException;
    }

}