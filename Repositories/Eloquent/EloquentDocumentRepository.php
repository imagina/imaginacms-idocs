<?php

namespace Modules\Idocs\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Idocs\Events\DocumentWasCreated;
use Modules\Idocs\Events\DocumentWasDeleted;
use Modules\Idocs\Events\DocumentWasUpdated;
use Modules\Idocs\Repositories\DocumentRepository;

class EloquentDocumentRepository extends EloquentBaseRepository implements DocumentRepository
{
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;//Short filter

            if (isset($filter->identification)) {

                $query->where('user_identification',$filter->identification);
            }


            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
            }

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false;//Take
            return $query->get();
        }
    }

    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Filter by specific field
                $field = $filter->field;
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
    }

    /**
     * @param $param
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($keys)
    {
        $query = $this->model->query();
        $criterion = $keys;
        $query->whereHas('translations', function (Builder $q) use ($criterion) {
            $q->where('title', 'like', "%{$criterion}%");
        });
        $query->orWhere('id', $criterion);

        return $query->orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * Standard Api Method
     * Create a iblog post
     * @param  array $data
     * @return Post
     */
    public function create($data)
    {
        $documnet = $this->model->create($data);
        $documnet->categories()->sync(array_get($data, 'categories', []));
        $documnet->users()->sync(array_get($data, 'users', []));
        event(new DocumentWasCreated($documnet, $data));

        return $documnet;
    }

    /**
     * Update a resource
     * @param $documnet
     * @param  array $data
     * @return mixed
     */
    public function update($documnet, $data)
    {
        $documnet->update($data);

        $documnet->categories()->sync(array_get($data, 'categories', []));

        event(new DocumentWasUpdated($documnet, $data));


        return $documnet;
    }


    public function destroy($model)
    {

        event(new DocumentWasDeleted($model->id, get_class($model)));

        return $model->delete();
    }

}
