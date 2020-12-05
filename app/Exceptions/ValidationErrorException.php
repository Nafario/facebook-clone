<?php

namespace App\Exceptions;

use Exception;

class ValidationErrorException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json(
            [
                'error' => [
                    'code' => 422,
                    'title' => 'Validation Error',
                    'detail' => 'Your request is missing field',
                    'meta' => json_decode($this->getMessage()),
                ],
            ],
            422
        );
    }
}
