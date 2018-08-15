<?php

namespace App\Service\Response;

use DateTime;

/**
 * Class JSONResponse
 */
class JSONResponse
{
    /**
     * Return success response
     *
     * @param array $data
     * @param int $status
     * @param string $httpMessage
     * @return array
     */
    public static function success(array $data, int $status = 200, string $httpMessage = 'OK')
    {
        $t = microtime(true);
        $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
        $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));

        $data['status'] = $status;
        $data['http_message'] = $httpMessage;
        $data['meta'] = [
            'response_sent' => $d->format("Y-m-d H:i:s.u"),
            'api_version' => 1,
            'docs_url' => 'https://there-is-no.readthedocs.org/wait/until/finished'
        ];
        return $data;
    }

    /**
     * Return errors
     *
     * @param array $errors
     * @param string $mainMessage
     * @param int $status
     * @param string $httpMessage
     * @return array
     */
    public static function error(string $internalErrorCode, array $errors, string $mainMessage, int $status = 422, string $httpMessage = 'Unprocessable Entity')
    {
        $t = microtime(true);
        $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
        $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));

        $response = [
            'status' => $status,
            'http_message' => $httpMessage,
            'message' => $mainMessage,
            'error_code' => $internalErrorCode,
            'meta' => [
                'response_sent' => $d->format("Y-m-d H:i:s.u"),
                'api_version' => 1,
                'docs_url' => 'https://there-is-no.readthedocs.org/wait/until/finished',
                'error_url' => ''
            ],
        ];
        if (!empty($errors)) {
            $response['validation'] = $errors;
        }
        return $response;
    }
}
