<?php

if (!function_exists("buildRes")) {
    function buildRes($data = '', $msg = '',  $fail = false)
    {
        $response =  [
            'status'   => 200,
            'data' => $data,
            'fail' => $fail,
            'messages' => [
                'success' => $msg,
                'error' => ''
            ]
        ];
        if ($fail == true) {
            $response['messages'] = [
                'success' => '',
                'error' => $msg
            ];
        }
        return $response;
    }
}
