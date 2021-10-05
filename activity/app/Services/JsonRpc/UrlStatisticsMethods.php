<?php

namespace App\Services\JsonRpc;

use App\Models\ViewedPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UrlStatisticsMethods
{
    public static function viewPage(array $params): ?array
    {
        $validator = Validator::make($params, [
            'url' => 'required|url',
            'date' => 'required|integer',
        ]);

        if ($validator->fails() && ($errors = $validator->errors())) {
            return Response::error($errors);
        }

        /**
         * @var $model Model
         */
        $model = ViewedPage::create([
            'url' => $params['url'],
            'created_at' => $params['date'],
        ]);

        return [
            'id' => $model->getKey()
        ];
    }

    public static function getStatistic(array $params): array
    {
        $page = (int)$params['page'] ?? 1;
        $perPage = (int)$params['per_page'] ?? 5;

        $table = ViewedPage::getModel()->getTable();

        $query = DB::table($table)
            ->selectRaw(DB::raw('url, count(id) as count, max(created_at) as created_at'))
            ->groupBy('url');

        $total = DB::table(DB::raw("({$query->toSql()}) AS c"))->count();

        $pages = ceil($total / $perPage);
        $page = $page < 1 ? 1 : ($page > $pages ? $pages : $page);

        $offset = ($page - 1) * $perPage;

        $rows = $query
            ->limit($perPage)
            ->offset($offset)
            ->get();

        return compact('rows', 'total', 'perPage', 'page');
    }

    public static function getDistributionPage($params): array
    {
        $table = ViewedPage::getModel()->getTable();

        $sql = <<<SQL
WITH c AS (
    SELECT url, count(id) as count
    FROM {$table}
    GROUP BY url
)
SELECT
    url,
    100.0 * count / (SELECT sum(count) FROM c) AS percent
FROM c;
SQL;

        return DB::select($sql);
    }
}
