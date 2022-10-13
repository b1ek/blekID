<?php

$reload = 'Reload the page. If it doesn\'t work, contact the administrator.';
$malf = 'If you see an error page with this code, the website should be malfunctioning.';

if (!isset($_SERVER['HTTP_LOCATION'])) {
    $_SERVER['HTTP_LOCATION'] = '?';
}

return array(

    // 1xx errors
    '100' => array(
        'code' => '100',
        'text' => 'Continue',
        'help' => $reload
    ),

    '101' => array(
        'code' => '101',
        'text' => 'Switching Protocols',
        'help' => $reload
    ),

    '102' => array(
        'code' => '102',
        'text' => 'Processing',
        'help' => 'Server is processing your request, but the result is not available right now. Reload the page in a while and see whats going to happen.'
    ),

    '103' => array(
        'code' => '103',
        'text' => 'Early Hints',
        'help' => $reload
    ),


    // 2xx errors
    '200' => array(
        'code' => '200',
        'text' => 'OK',
        'help' => 'The request was completed. ' . $malf
    ),

    '201' => array(
        'code' => '201',
        'text' => 'Created',
        'help' => 'The request was succeded. ' . $malf
    ),

    '202' => array(
        'code' => '202',
        'text' => 'Accepted',
        'help' => 'The request was accepted. ' . $malf
    ),

    '203' => array(
        'code' => '203',
        'text' => 'Non-Authoritative Information',
        'help' => $malf
    ),

    '204' => array(
        'code' => '204',
        'text' => 'No content',
        'help' => 'No content is sent. ' . $malf
    ),

    '205' => array(
        'code' => '205',
        'text' => 'Reset Content',
        'help' => $malf
    ),

    '206' => array(
        'code' => '206',
        'text' => 'Partial Content',
        'help' => $malf
    ),

    '207' => array(
        'code' => '207',
        'text' => 'Multi-Status',
        'help' => 'There are multiple status codes(headers?). ' . $malf
    ),

    '208' => array(
        'code' => '208',
        'text' => 'Already Reported',
        'help' => $malf
    ),

    '209' => array(
        'code' => '226',
        'text' => 'IM Used',
        'help' => $malf
    ),


    // 3xx errors
    '300' => array(
        'code' => '300',
        'text' => 'Multiple Choices',
        'help' => 'There is multiple possible responses. ' . $malf
    ),

    '301' => array(
        'code' => '301',
        'text' => 'Moved Permamently',
        'help' => 'The page has been moved to <a href=\'' . $_SERVER['HTTP_LOCATION'] . '\'>' . $_SERVER['HTTP_LOCATION'] . '</a>'
    ),

    '302' => array(
        'code' => '302',
        'text' => 'Found',
        'help' => 'The page has been moved temporarily to a new url'
    ),

    '303' => array(
        'code' => '303',
        'text' => 'See Other',
        'help' => 'The page has been moved to <a href=\'' . $_SERVER['HTTP_LOCATION'] . '\'>' . $_SERVER['HTTP_LOCATION'] . '</a>'
    ),

    '304' => array(
        'code' => '304',
        'text' => 'Not Modified',
        'help' => 'The page you see is not changed at all. If you see an error page with this code, its obviously not true and website is probably malfunctioning right now.'
    ),

    '305' => array(
        'code' => '305',
        'text' => 'Use Proxy',
        'help' => $malf
    ),

    '306' => array(
        'code' => '306',
        'text' => 'unused',
        'help' => 'This error code is unused and means nothing. ' . $reload
    ),

    '307' => array(
        'code' => '308',
        'text' => 'Temporary Redirect',
        'help' => 'The page has been moved temporarily to a new url'
    ),

    '308' => array(
        'code' => '308',
        'text' => 'Permanent Redirect',
        'help' => "$reload $malf"
    ),

    // 4xx errors
    '400' => array(
        'code' => '400',
        'text' => 'Bad Request',
        'help' => <<<HTML
You got a bad request error.<br/>
<a href='https://www.itpro.com/infrastructure/network-internet/359323/what-is-http-error-400-and-how-do-you-fix-it'>What do i have to do?</a>
HTML
),
    '401' => array(
        'code' => '401',
        'text' => 'Unauthorized',
        'help' => 'You are not allowed to see the page.<br/><a href=\'https://kinsta.com/knowledgebase/401-error\'>How to fix this?</a>'
    ),

    '402' => array(
        'code' => '402',
        'text' => 'Payment Required',
        'help' => 'You need to make a payment to continue.'
    ),

    '403' => array(
        'code' => '403',
        'text' => 'Forbidden',
        'help' => 'You are not allowed to see the page.<br/><a href=\'https://phoenixnap.com/kb/403-forbidden\'>How to fix this?</a>'
    ),

    '404' => array(
        'code' => '404',
        'text' => 'Not Found',
        'help' => 'The requested URL is not found.<br/><a href=\'https://www.lifewire.com/404-not-found-error-explained-2622936\'>How to fix this?</a>'
    ),

    '405' => array(
        'code' => '405',
        'text' => 'Method Not Allowed',
        'help' => 'The request method is known by the server but is not supported. ' . $reload
    ),

    '406' => array(
        'code' => '406',
        'text' => 'Not Acceptable',
        'help' => $reload
    ),

    '407' => array(
        'code' => '407',
        'text' => 'Proxy Authentication Required',
        'help' => $malf
    ),

    '408' => array(
        'code' => '408',
        'text' => 'Request Timeout',
        'help' => 'Refresh the page'
    ),

    '409' => array(
        'code' => '409',
        'text' => 'Conflict',
        'help' => ''
    ),
);
