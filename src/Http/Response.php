<?php

namespace PhalconRest\Http;

use Phalcon\Http\Response as PhalconResponse;

class Response extends PhalconResponse
{

    /**
     * 1xx: Informational - Request received, continuing process
     * 2xx: Success - The action was successfully received, understood, and accepted
     * 3xx: Redirection - Further action must be taken in order to complete the request
     * 4xx: Client Error - The request contains bad syntax or cannot be fulfilled
     * 5xx: Server Error - The server failed to fulfill an apparently valid request
     */
    const CONTINUE_ = 100;
    const SWITCHING_PROTOCOLS = 101;
    const PROCESSING = 102;
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NON_AUTHORITATIVE_INFORMATION = 203;
    const NO_CONTENT = 204;
    const RESET_CONTENT = 205;
    const PARTIAL_CONTENT = 206;
    const MULTI_STATUS = 207;
    const ALREADY_REPORTED = 208;
    const IM_USED = 226;
    const MULTIPLE_CHOICES = 300;
    const MOVED_PERMANENTLY = 301;
    const FOUND = 302;
    const SEE_OTHER = 303;
    const NOT_MODIFIED = 304;
    const USE_PROXY = 305;
    const UNUSED = 306;
    const TEMPORARY_REDIRECT = 307;
    const PERMANENT_REDIRECT = 308;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const PAYMENT_REQUIRED = 402;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_ACCEPTABLE = 406;
    const PROXY_AUTHENTICATION_REQUIRED = 407;
    const REQUEST_TIMEOUT = 408;
    const CONFLICT = 409;
    const GONE = 410;
    const LENGTH_REQUIRED = 411;
    const PRECONDITION_FAILED = 412;
    const PAYLOAD_TOO_LARGE = 413;
    const URI_TOO_LONG = 414;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const RANGE_NOT_SATISFIABLE = 416;
    const EXPECTATION_FAILED = 417;
    const MISDIRECTED_REQUEST = 421;
    const UNPROCESSABLE_ENTITY = 422;
    const LOCKED = 423;
    const FAILED_DEPENDENCY = 424;
    const UPGRADE_REQUIRED = 426;
    const PRECONDITION_REQUIRED = 428;
    const TOO_MANY_REQUESTS = 429;
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const VARIANT_ALSO_NEGOTIATES = 506;
    const INSUFFICIENT_STORAGE = 507;
    const LOOP_DETECTED = 508;
    const NOT_EXTENDED = 510;
    const NETWORK_AUTHENTICATION_REQUIRED = 511;

    public static $status = [
        self::CONTINUE_ => 'Continue', // RFC7231, SECTION 6.2.1
        self::SWITCHING_PROTOCOLS => 'Switching Protocols', // RFC7231, SECTION 6.2.2
        self::PROCESSING => 'Processing', // RFC2518
        self::OK => 'OK', // RFC7231, SECTION 6.3.1
        self::CREATED => 'Created', // RFC7231, SECTION 6.3.2
        self::ACCEPTED => 'Accepted', // RFC7231, SECTION 6.3.3
        self::NON_AUTHORITATIVE_INFORMATION => 'Non-Authoritative Information', // RFC7231, SECTION 6.3.4
        self::NO_CONTENT => 'No Content', // RFC7231, SECTION 6.3.5
        self::RESET_CONTENT => 'Reset Content', // RFC7231, SECTION 6.3.6
        self::PARTIAL_CONTENT => 'Partial Content', // RFC7233, SECTION 4.1
        self::MULTI_STATUS => 'Multi-Status', // RFC4918
        self::ALREADY_REPORTED => 'Already Reported', // RFC5842
        self::IM_USED => 'IM Used', // RFC3229
        self::MULTIPLE_CHOICES => 'Multiple Choices', // RFC7231, SECTION 6.4.1
        self::MOVED_PERMANENTLY => 'Moved Permanently', // RFC7231, SECTION 6.4.2
        self::FOUND => 'Found', // RFC7231, SECTION 6.4.3
        self::SEE_OTHER => 'See Other', // RFC7231, SECTION 6.4.4
        self::NOT_MODIFIED => 'Not Modified', // RFC7232, SECTION 4.1
        self::USE_PROXY => 'Use Proxy', // RFC7231, SECTION 6.4.5
        self::UNUSED => '(Unused)', // RFC7231, SECTION 6.4.6
        self::TEMPORARY_REDIRECT => 'Temporary Redirect', // RFC7231, SECTION 6.4.7
        self::PERMANENT_REDIRECT => 'Permanent Redirect', // RFC-IETF-HTTPBIS-RFC7238BIS-03
        self::BAD_REQUEST => 'Bad Request', // RFC7231, SECTION 6.5.1
        self::UNAUTHORIZED => 'Unauthorized', // RFC7235, SECTION 3.1
        self::PAYMENT_REQUIRED => 'Payment Required', // RFC7231, SECTION 6.5.2
        self::FORBIDDEN => 'Forbidden', // RFC7231, SECTION 6.5.3
        self::NOT_FOUND => 'Not Found', // RFC7231, SECTION 6.5.4
        self::METHOD_NOT_ALLOWED => 'Method Not Allowed', // RFC7231, SECTION 6.5.5
        self::NOT_ACCEPTABLE => 'Not Acceptable', // RFC7231, SECTION 6.5.6
        self::PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required', // RFC7235, SECTION 3.2
        self::REQUEST_TIMEOUT => 'Request Timeout', // RFC7231, SECTION 6.5.7
        self::CONFLICT => 'Conflict', // RFC7231, SECTION 6.5.8
        self::GONE => 'Gone', // RFC7231, SECTION 6.5.9
        self::LENGTH_REQUIRED => 'Length Required', // RFC7231, SECTION 6.5.10
        self::PRECONDITION_FAILED => 'Precondition Failed', // RFC7232, SECTION 4.2
        self::PAYLOAD_TOO_LARGE => 'Payload Too Large', // RFC7231, SECTION 6.5.11
        self::URI_TOO_LONG => 'URI Too Long', // RFC7231, SECTION 6.5.12
        self::UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type', // RFC7231, SECTION 6.5.13
        self::RANGE_NOT_SATISFIABLE => 'Range Not Satisfiable', // RFC7233, SECTION 4.4
        self::EXPECTATION_FAILED => 'Expectation Failed', // RFC7231, SECTION 6.5.14
        self::MISDIRECTED_REQUEST => 'Misdirected Request', // RFC-IETF-HTTPBIS-HTTP2-17, SECTION 9.1.2
        self::UNPROCESSABLE_ENTITY => 'Unprocessable Entity', // RFC4918
        self::LOCKED => 'Locked', // RFC4918
        self::FAILED_DEPENDENCY => 'Failed Dependency', // RFC4918
        self::UPGRADE_REQUIRED => 'Upgrade Required', // RFC7231, SECTION 6.5.15
        self::PRECONDITION_REQUIRED => 'Precondition Required', // RFC6585
        self::TOO_MANY_REQUESTS => 'Too Many Requests', // RFC6585
        self::REQUEST_HEADER_FIELDS_TOO_LARGE => 'Request Header Fields Too Large', // RFC6585
        self::INTERNAL_SERVER_ERROR => 'Internal Server Error', // RFC7231, SECTION 6.6.1
        self::NOT_IMPLEMENTED => 'Not Implemented', // RFC7231, SECTION 6.6.2
        self::BAD_GATEWAY => 'Bad Gateway', // RFC7231, SECTION 6.6.3
        self::SERVICE_UNAVAILABLE => 'Service Unavailable', // RFC7231, SECTION 6.6.4
        self::GATEWAY_TIMEOUT => 'Gateway Timeout', // RFC7231, SECTION 6.6.5
        self::HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported', // RFC7231, SECTION 6.6.6
        self::VARIANT_ALSO_NEGOTIATES => 'Variant Also Negotiates', // RFC2295
        self::INSUFFICIENT_STORAGE => 'Insufficient Storage', // RFC4918
        self::LOOP_DETECTED => 'Loop Detected', // RFC5842
        self::NOT_EXTENDED => 'Not Extended', // RFC2774
        self::NETWORK_AUTHENTICATION_REQUIRED => 'Network Authentication Required', // RFC6585
    ];

    /**
     * Sets the HTTP response code
     *
     * <code>
     * 	$response->setStatusCode(404, "Not Found");
     *  // or
     *  $response->setStatusCode(404);
     * </code>
     *
     * @param int $code
     * @param string $message
     * @return \Phalcon\Http\ResponseInterface
     */
    public function setStatusCode($code, $message = null)
    {
        if (is_null($message) && isset(self::$status[$code])) {
            $message = self::$status[$code];
        }
        return parent::setStatusCode($code, $message);
    }

    /**
     * Get message for code
     * <code>
     * $response->getStatusCodeMessage(404);
     * </code>
     * @param int $code
     * @return string
     */
    public function getStatusCodeMessage($code)
    {
        return isset(self::$status[$code]) ? self::$status[$code] : null;
    }

    /**
     * Prints out HTTP response to the client
     * And if isset request 'suppress_response_codes', then set status code 200
     * @return \Phalcon\Http\ResponseInterface
     */
    public function send()
    {
        $request = $this->getDI()->get('request');
        if ($request->get('suppress_response_codes', null, null)) {
            $this->setStatusCode(self::OK)->sendHeaders();
        }

        return parent::send();
    }

}
