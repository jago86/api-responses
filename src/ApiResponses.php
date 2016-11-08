<?php

namespace Jairo\ApiResponses;

use Response;

trait ApiResponses
{
	
	protected $statusCode = 200;


    /**
     * Gets the value of statusCode.
     *
     * @return     mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     *
     * @param      mixed  $statusCode  The status code
     *
     * @return     self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Return a 400 response
     *
     * @param      mixed                     $message  Error message(s)
     *
     * @return     Illuminate\Http\Response
     */
    public function respondNoContent($message = '', $headers = [])
    {
        return $this->setStatusCode(204)->respond($message, $headers);
    }

    /**
     * Return a 400 response
     *
     * @param      mixed                     $message  Error message(s)
     *
     * @return     Illuminate\Http\Response
     */
    public function respondBadRequest($message = 'Bad Request Error!')
    {
    	return $this->setStatusCode(400)->respondWithError($message);
    }

    /**
     * Return a 404 response
     *
     * @param      mixed                     $message  Error message(s)
     *
     * @return     Illuminate\Http\Response
     */
    public function respondNotFound($message = 'NotFound Error!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * Return a 409 response for some kind of conflict
     *
     * @param      mixed                     $message  Error message(s)
     *
     * @return     Illuminate\Http\Response
     */
    public function respondConflict($message = 'There are conflicts. Can\'t process your request!')
    {
        return $this->setStatusCode(409)->respondWithError($message);
    }

    /**
     * Returns a 400 response based in an execption
     *
     * @param      \Exception  $e      The Exception
     *
     * @return     Illuminate\Http\Response
     */
    public function respondException(\Exception $e)
    {
        $class = collect(explode('\\', get_class($e)))->last();
        return $this->setStatusCode(400)->respondWithError([
            'type'      => $class,
            'message'   => $e->getMessage()
        ]);
    }

    /**
     * Return a json response
     *
     * @param      array                     $data     Response data
     * @param      array                     $headers  The headers
     *
     * @return     Illuminate\Http\Response
     */
    public function respond($data, $headers = [])
    {
    	return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Return a response with an error message
     *
     * @param      mixed  $message  The message
     *
     * @return     Illuminate\Http\Response  
     */
    public function respondWithError($message)
    {
    	return $this->respond([
    		'error' 		=> $message,
    		'status_code'	=> $this->getStatusCode()
    	]);
    }
}