<?php

namespace App\Http\Controllers;

use App\Services\JsonRpc\UrlStatisticsMethods;

class ApiController extends Controller
{
    public function viewPage($params): array
    {
        return UrlStatisticsMethods::viewPage($params);
    }

    public function getStatistic($params): array
    {
        return UrlStatisticsMethods::getStatistic($params);
    }

    public function getDistributionPage($params): array
    {
        return UrlStatisticsMethods::getDistributionPage($params);
    }


}
