<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseRepositoryInterface
{
    // model property on class instances
	protected $model;
    // Constructor to bind model to repo
	public function __construct(Model $model)
	{
		$this->model = $model;
	}
    // Get all instances of model
	public function all()
	{
		return $this->model->all();
	}

     /**
     * @param array $data
     * @return mixed
     */
     public function insert(array $data)
     {
     	return $this->model->insert($data);
     }

     /**
     * @param array $data
     * @return mixed
     */
     public function create(array $data)
     {
     	return $this->model->create($data);
     }

     /**
     * @param array $data
     * @return mixed
     */
     public function update(array $data, $id)
     {
     	$record = $this->model->find($id);
     	return $record->update($data);
     }

     /**
     * @param array $id
     * @return mixed
     */
     public function delete($id)
     {
     	return $this->model->destroy($id);
     }

     /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
     public function findById($id, $columns = ['*'], $with = [])
     {

     	return $this->model->with($with)->findOrFail($id, $columns);
     }

     /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
     public function findByColumn($attribute, $value, $columns = ['*'])
     {
     	return $this->model->where($attribute, '=', $value)->first($columns);
     }

     /**
     * @param array $id
     * @return mixed
     */
     public function show($id)
     {
     	return $this->model->findOrFail($id);
     }

     // Get the associated model
     public function getModel()
     {
     	return $this->model;
     }
    // Set the associated model
     public function setModel($model)
     {
     	$this->model = $model;
     	return $this;
     }
    // Eager load database relationships
     public function with($relations)
     {
     	return $this->model->with($relations);
     }

     public function bulk_update(array $data, $field_name, array $ids)
     {
          $record = $this->model->whereIn($field_name, $ids);
          return $record->update($data);
     }
 }
