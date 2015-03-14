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
    const CONTINUE_STATUS_CODE = 100;
    const SWITCHING_PROTOCOLS_STATUS_CODE = 101;
    const PROCESSING_STATUS_CODE = 102;
    const OK_STATUS_CODE = 200;
    const CREATED_STATUS_CODE = 201;
    const ACCEPTED_STATUS_CODE = 202;
    const NON_AUTHORITATIVE_INFORMATION_STATUS_CODE = 203;
    const NO_CONTENT_STATUS_CODE = 204;
    const RESET_CONTENT_STATUS_CODE = 205;
    const PARTIAL_CONTENT_STATUS_CODE = 206;
    const MULTI_STATUS_STATUS_CODE = 207;
    const ALREADY_REPORTED_STATUS_CODE = 208;
    const IM_USED_STATUS_CODE = 226;
    const MULTIPLE_CHOICES_STATUS_CODE = 300;
    const MOVED_PERMANENTLY_STATUS_CODE = 301;
    const FOUND_STATUS_CODE = 302;
    const SEE_OTHER_STATUS_CODE = 303;
    const NOT_MODIFIED_STATUS_CODE = 304;
    const USE_PROXY_STATUS_CODE = 305;
    const UNUSED_STATUS_CODE = 306;
    const TEMPORARY_REDIRECT_STATUS_CODE = 307;
    const PERMANENT_REDIRECT_STATUS_CODE = 308;
    const BAD_REQUEST_STATUS_CODE = 400;
    const UNAUTHORIZED_STATUS_CODE = 401;
    const PAYMENT_REQUIRED_STATUS_CODE = 402;
    const FORBIDDEN_STATUS_CODE = 403;
    const NOT_FOUND_STATUS_CODE = 404;
    const METHOD_NOT_ALLOWED_STATUS_CODE = 405;
    const NOT_ACCEPTABLE_STATUS_CODE = 406;
    const PROXY_AUTHENTICATION_REQUIRED_STATUS_CODE = 407;
    const REQUEST_TIMEOUT_STATUS_CODE = 408;
    const CONFLICT_STATUS_CODE = 409;
    const GONE_STATUS_CODE = 410;
    const LENGTH_REQUIRED_STATUS_CODE = 411;
    const PRECONDITION_FAILED_STATUS_CODE = 412;
    const PAYLOAD_TOO_LARGE_STATUS_CODE = 413;
    const URI_TOO_LONG_STATUS_CODE = 414;
    const UNSUPPORTED_MEDIA_TYPE_STATUS_CODE = 415;
    const RANGE_NOT_SATISFIABLE_STATUS_CODE = 416;
    const EXPECTATION_FAILED_STATUS_CODE = 417;
    const MISDIRECTED_REQUEST_STATUS_CODE = 421;
    const UNPROCESSABLE_ENTITY_STATUS_CODE = 422;
    const LOCKED_STATUS_CODE = 423;
    const FAILED_DEPENDENCY_STATUS_CODE = 424;
    const UPGRADE_REQUIRED_STATUS_CODE = 426;
    const PRECONDITION_REQUIRED_STATUS_CODE = 428;
    const TOO_MANY_REQUESTS_STATUS_CODE = 429;
    const REQUEST_HEADER_FIELDS_TOO_LARGE_STATUS_CODE = 431;
    const INTERNAL_SERVER_ERROR_STATUS_CODE = 500;
    const NOT_IMPLEMENTED_STATUS_CODE = 501;
    const BAD_GATEWAY_STATUS_CODE = 502;
    const SERVICE_UNAVAILABLE_STATUS_CODE = 503;
    const GATEWAY_TIMEOUT_STATUS_CODE = 504;
    const HTTP_VERSION_NOT_SUPPORTED_STATUS_CODE = 505;
    const VARIANT_ALSO_NEGOTIATES_STATUS_CODE = 506;
    const INSUFFICIENT_STORAGE_STATUS_CODE = 507;
    const LOOP_DETECTED_STATUS_CODE = 508;
    const NOT_EXTENDED_STATUS_CODE = 510;
    const NETWORK_AUTHENTICATION_REQUIRED_STATUS_CODE = 511;

    public static $status = [
        100 => "CONTINUE", // RFC7231, SECTION 6.2.1
        101 => "SWITCHING PROTOCOLS", // RFC7231, SECTION 6.2.2
        102 => "PROCESSING", // RFC2518
        200 => "OK", // RFC7231, SECTION 6.3.1
        201 => "CREATED", // RFC7231, SECTION 6.3.2
        202 => "ACCEPTED", // RFC7231, SECTION 6.3.3
        203 => "NON-AUTHORITATIVE INFORMATION", // RFC7231, SECTION 6.3.4
        204 => "NO CONTENT", // RFC7231, SECTION 6.3.5
        205 => "RESET CONTENT", // RFC7231, SECTION 6.3.6
        206 => "PARTIAL CONTENT", // RFC7233, SECTION 4.1
        207 => "MULTI-STATUS", // RFC4918
        208 => "ALREADY REPORTED", // RFC5842
        226 => "IM USED", // RFC3229
        300 => "MULTIPLE CHOICES", // RFC7231, SECTION 6.4.1
        301 => "MOVED PERMANENTLY", // RFC7231, SECTION 6.4.2
        302 => "FOUND", // RFC7231, SECTION 6.4.3
        303 => "SEE OTHER", // RFC7231, SECTION 6.4.4
        304 => "NOT MODIFIED", // RFC7232, SECTION 4.1
        305 => "USE PROXY", // RFC7231, SECTION 6.4.5
        306 => "(UNUSED)", // RFC7231, SECTION 6.4.6
        307 => "TEMPORARY REDIRECT", // RFC7231, SECTION 6.4.7
        308 => "PERMANENT REDIRECT", // RFC-IETF-HTTPBIS-RFC7238BIS-03
        400 => "BAD REQUEST", // RFC7231, SECTION 6.5.1
        401 => "UNAUTHORIZED", // RFC7235, SECTION 3.1
        402 => "PAYMENT REQUIRED", // RFC7231, SECTION 6.5.2
        403 => "FORBIDDEN", // RFC7231, SECTION 6.5.3
        404 => "NOT FOUND", // RFC7231, SECTION 6.5.4
        405 => "METHOD NOT ALLOWED", // RFC7231, SECTION 6.5.5
        406 => "NOT ACCEPTABLE", // RFC7231, SECTION 6.5.6
        407 => "PROXY AUTHENTICATION REQUIRED", // RFC7235, SECTION 3.2
        408 => "REQUEST TIMEOUT", // RFC7231, SECTION 6.5.7
        409 => "CONFLICT", // RFC7231, SECTION 6.5.8
        410 => "GONE", // RFC7231, SECTION 6.5.9
        411 => "LENGTH REQUIRED", // RFC7231, SECTION 6.5.10
        412 => "PRECONDITION FAILED", // RFC7232, SECTION 4.2
        413 => "PAYLOAD TOO LARGE", // RFC7231, SECTION 6.5.11
        414 => "URI TOO LONG", // RFC7231, SECTION 6.5.12
        415 => "UNSUPPORTED MEDIA TYPE", // RFC7231, SECTION 6.5.13
        416 => "RANGE NOT SATISFIABLE", // RFC7233, SECTION 4.4
        417 => "EXPECTATION FAILED", // RFC7231, SECTION 6.5.14
        421 => "MISDIRECTED REQUEST", // RFC-IETF-HTTPBIS-HTTP2-17, SECTION 9.1.2
        422 => "UNPROCESSABLE ENTITY", // RFC4918
        423 => "LOCKED", // RFC4918
        424 => "FAILED DEPENDENCY", // RFC4918
        426 => "UPGRADE REQUIRED", // RFC7231, SECTION 6.5.15
        428 => "PRECONDITION REQUIRED", // RFC6585
        429 => "TOO MANY REQUESTS", // RFC6585
        431 => "REQUEST HEADER FIELDS TOO LARGE", // RFC6585
        500 => "INTERNAL SERVER ERROR", // RFC7231, SECTION 6.6.1
        501 => "NOT IMPLEMENTED", // RFC7231, SECTION 6.6.2
        502 => "BAD GATEWAY", // RFC7231, SECTION 6.6.3
        503 => "SERVICE UNAVAILABLE", // RFC7231, SECTION 6.6.4
        504 => "GATEWAY TIMEOUT", // RFC7231, SECTION 6.6.5
        505 => "HTTP VERSION NOT SUPPORTED", // RFC7231, SECTION 6.6.6
        506 => "VARIANT ALSO NEGOTIATES", // RFC2295
        507 => "INSUFFICIENT STORAGE", // RFC4918
        508 => "LOOP DETECTED", // RFC5842
        510 => "NOT EXTENDED", // RFC2774
        511 => "NETWORK AUTHENTICATION REQUIRED", // RFC6585    
    ];
    
    public function setStatusCode($code, $message = null)
    {
        if(is_null($message) && isset(self::$status[$code])) {
            $message = self::$status[$code];
        }
        parent::setStatusCode($code, $message);
    }

    public function send()
    {
        $request = $this->getDI()->get('request');
        if ($request->get('suppress_response_codes', null, null)) {
            $this->setStatusCode(self::OK_STATUS_CODE)->sendHeaders();
        }

        return parent::send();
    }

}
