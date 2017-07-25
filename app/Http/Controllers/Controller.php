<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Send formated json responce
     * 
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponce(array $data = [], array $errors = [], $code = 200)
    {
        return new JsonResponse([
            'data' => $data,
            'errors' => $errors,
            'code' => $code,
        ], $code);
    }
    
    /**
     * Send formated json error responce
     * 
     * @param Illuminate\Contracts\Validation\Validator $validator
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonErrorResponce(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return $this->jsonResponce([], $this->formatValidationErrors($validator), 422);
    }
    
    /**
     * Send formated json not found responce
     * 
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonNotFoundResponce($message = 'Not found')
    {
        return $this->jsonResponce([], [$message], 404);
    }
}
