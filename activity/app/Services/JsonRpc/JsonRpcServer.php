<?php

namespace App\Services\JsonRpc;

use App\Exceptions\JsonRpcException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JsonRpcServer
{
    public function handle(Request $request, Controller $controller)
    {
        $content = \json_decode($request->getContent(), true);

        if (empty($content)) {
            throw new JsonRpcException('Parse error', JsonRpcException::PARSE_ERROR);
        }
        try {
            $result = $controller->{$content['method']}(...[$content['params']]);
            return Response::success($result, $content['id']);
        } catch (\Exception $e) {
            return Response::error($e->getMessage());
        }
    }
}
