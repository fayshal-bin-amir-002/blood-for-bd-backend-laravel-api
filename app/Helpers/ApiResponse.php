<?php

namespace App\Helpers;

class ApiResponse
{
  public static function success(
    string $message = 'Success', 
    int $statusCode = 200, 
    $data = null
    ) {

    $response = [
      'success' => true,
      'message' => $message,
      'statusCode' => $statusCode,
    ];

    if (!is_null($data)) {
      if (is_array($data) && isset($data['data'])) {
        $response['data'] = $data['data'];
        if (isset($data['meta'])) {
          $response['meta'] = [
            'current_page' => $data['meta']['current_page'],
            'last_page'    => $data['meta']['last_page'],
            'per_page' => $data['meta']['per_page'],
            'total' => $data['meta']['total'],
          ];
        }
      } else {
        $response['data'] = $data;
      }
    }

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
