<?php

use Slim\Http\Request;

/**
 * Handling email
 *
 * This function is shortening for filter_var.
 *
 * @see filter_var()
 *
 * @param string $email to check
 *
 * @return mixed
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


/**
 * Check if Request comes from the mobile application.
 *
 * @param Request $request
 * @return bool
 */
function isRequestedFromMobileApp(Request $request)
{
    $header = $request->getHeader('X-App');
    $header = empty($header) ? 'browser' : $header[0];
    if (strtolower($header) === 'mobile') {
        return true;
    }

    return false;
}

/**
 * Get base url.
 *
 * @param string $path
 * @return mixed|string
 */
function baseurl($path = '')
{
    $environment = container()->get('environment');
    $scriptName = $environment->get('SCRIPT_NAME');
    $baseUri = dirname(dirname($scriptName));
    $result = str_replace('\\', '/', $baseUri) . $path;
    $result = str_replace('//', '/', $result);
    return $result;
}