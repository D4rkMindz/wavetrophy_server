<?php

namespace App\Service\Response;

/**
 * Class HttpMessage
 */
class HttpMessage
{
    const CODE100 = 'Continue';
    const CODE101 = 'Switching Protocols';
    const CODE102 = 'Processing';
    const CODE103 = 'Early Hints';

    const CODE200 = 'OK';
    const CODE201 = 'Created';
    const CODE202 = 'Accepted';
    const CODE203 = 'Non-Authoritative Information';
    const CODE204 = 'No Content';
    const CODE205 = 'Reset Content';
    const CODE206 = 'Partial Content';
    const CODE207 = 'Multi-Status';
    const CODE208 = 'Already Reported';
    const CODE226 = 'IM Used';

    const CODE300 = 'Multiple Choices';
    const CODE301 = 'Moved Permanently';
    const CODE302 = 'Found';
    const CODE303 = 'See Other';
    const CODE304 = 'Not Modified';
    const CODE305 = 'Use Proxy';
    const CODE306 = 'Switch Proxy';
    const CODE307 = 'Temporary Redirect';
    const CODE308 = 'Permanent Redirect';

    const CODE400 = 'Bad Request';
    const CODE401 = 'Unauthorized';
    const CODE402 = 'Payment Required';
    const CODE403 = 'Forbidden';
    const CODE404 = 'Not Found';
    const CODE405 = 'Method Not Allowed';
    const CODE406 = 'Not Acceptable';
    const CODE407 = 'Proxy Authentication Required';
    const CODE408 = 'Request Timeout';
    const CODE409 = 'Conflict';
    const CODE410 = 'Gone';
    const CODE411 = 'Length Required';
    const CODE412 = 'Precondition Failed';
    const CODE413 = 'Payload Too Large';
    const CODE414 = 'URI Too Long';
    const CODE415 = 'Unsupported Media Type';
    const CODE416 = 'Range Not Satisfiable';
    const CODE417 = 'Expectation Failed';
    const CODE418 = 'I\'m a teapot';
    const CODE421 = 'Misdirected Request';
    const CODE422 = 'Unprocessable Entity';
    const CODE423 = 'Locked';
    const CODE424 = 'Failed Dependency';
    const CODE426 = 'Upgrade Required';
    const CODE428 = 'Precondition Required';
    const CODE429 = 'Too Many Requests';
    const CODE431 = 'Request Header Fields Too Large';
    const CODE451 = 'Unavailable For Legal Reasons';

    const CODE500 = 'Internal Server Error';
    const CODE501 = 'Not Implemented';
    const CODE502 = 'Bad Gateway';
    const CODE503 = 'Service Unavailable';
    const CODE504 = 'Gateway Timeout';
    const CODE505 = 'HTTP Version Not Supported';
    const CODE506 = 'Variant Also Negotiates';
    const CODE507 = 'Insufficient Storage';
    const CODE508 = 'Loop Detected';
    const CODE510 = 'Not Extended';
    const CODE511 = 'Network Authentication Required';
}
