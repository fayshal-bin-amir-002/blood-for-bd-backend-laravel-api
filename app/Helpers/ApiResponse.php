<?php

namespace App\Helpers;

class ApiResponse
{
  public static function success(
    string $message = 'Success', 
    int $statusCode = 200, 
    $data = null, 
    $meta = null
    ) {
    $response = [
      'success' => true,
      'message' => $message,
      'statusCode' => $statusCode,
    ];
    if(!is_null($data)) $response['data'] = $data;
    if(!is_null($meta)) $response['meta'] = $meta;

    return response()->json($response, $statusCode);
  }

  public static function error(
    string $message = 'Error', 
    int $statusCode = 400, 
    $errors = null
    ) {
    $response = [
      'success' => false,
      'message' => $message,
      'statusCode' => $statusCode,
    ];
    if(!is_null($errors)) {
      $response['errors'] = is_array($errors) ? $errors : [$errors];
    }

    return response()->json($response, $statusCode);
  }
}
