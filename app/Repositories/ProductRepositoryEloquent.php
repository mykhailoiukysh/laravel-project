<?php

namespace DOLucasDelivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use DOLucasDelivery\Repositories\ProductRepository;
use DOLucasDelivery\Models\Product;
use DOLucasDelivery\Validators\ProductValidator;
use DOLucasDelivery\Presenters\ProductPresenter;

/**
 * Class ProductRepositoryEloquent
 * @package namespace DOLucasDelivery\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    
    protected $skipPresenter = true;
    
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getIdNamePrice()
    {
        return $this->model->get(['id', 'name', 'price']);
    }
    
    public function presenter()
    {
        return ProductPresenter::class;
    }
}
