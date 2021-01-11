<?php

namespace App\Services;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FilterService
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filter($query)
    {
        $this->readQuery();

        $query = QueryBuilder::for($query);

        $realties = $query
            ->allowedFilters(
                AllowedFilter::scope('price_between'),
                AllowedFilter::scope('realty.area_between'),
                AllowedFilter::exact('loai-tin-dang', 'realty_posts.type'),
                AllowedFilter::exact('loai-bds', 'realty.type'),
                AllowedFilter::exact('huong', 'realty.direction'),
                AllowedFilter::exact('tinh', 'realty.province_code'),
                AllowedFilter::exact('huyen', 'realty.district_code'),
                AllowedFilter::exact('xa', 'realty.commune_code'),
                AllowedFilter::exact('du-an', 'realty.project_id'),
                AllowedFilter::exact('us', 'created_by'),
                'realty.full_address',
            )
            ->allowedSorts('price', 'area', 'rank');

        return $realties;
    }

    public function readQuery()
    {
        $result = [];
        $query = $this->request->all();
        if (!$this->request->has('filter')) {
            $this->request->filter = [];
        }
        foreach ($this->request->all() as $key => $value) {
            switch ($key) {
                case 'dien-tich':
                    $result['realty.area_between'] = $value;
                    break;
                case 'loai-tin-dang':
                    $result['loai-tin-dang'] = $value;
                    break;
                case 'gia':
                    $result['price_between'] = $value;
                    break;
                case 'loai-bds':
                    $result['loai-bds'] = $value;
                    break;
                case 'huong':
                    $result['huong'] = $value;
                    break;
                case 'tinh':
                    $result['tinh'] = $value;
                    break;
                case 'huyen':
                    $result['huyen'] = $value;
                    break;
                case 'xa':
                    $result['xa'] = $value;
                    break;
                case 'us':
                    $result['us'] = $value;
                    break;
                case 'dia-chi':
                    $result['realty.full_address'] = $value;
                    break;
                default:
                    break;
            }
        }

        $this->request->request->set('filter', array_merge($this->request->filter, $result));
    }

}