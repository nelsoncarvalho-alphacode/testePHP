<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        "name",
        "surname",
        "email",
        "cpf"
    ];

    public function getById(string $id)
    {
        return $this->find($id)->first();
    }

    public function getAll()
    {
        return $this->all();
    }

    public function getByName(string $name)
    {
        return $this->where('name', 'like', "%{$name}%")->orWhere('surname', 'like', "%{$name}%")->first();
    }

    public function create(array $data)
    {
        $this->fill($data)->save();
        return;
    }

    public function updateData(int $id, array $data)
    {
        $this->where('id', $id)->update($data);
        return;
    }

    public function remove(int $id)
    {
        $this->where("id", $id)->delete();
        return;
    }

    public function getPaginatedSortedAndFiltered(int $offset=0, int $limit=20, string $sortByColumn='id', string $sortByType='ASC', string $filterByValue='')
    {
        if(strlen($filterByValue) > 0){
            $cpfFilter = preg_replace('/\D/', '', $filterByValue);

            $collection = $this
                    ->where('name', 'like', "%{$filterByValue}%")
                    ->orWhere('surname', 'like', "%{$filterByValue}%")
                    ->orWhere('email', 'like', "%{$filterByValue}%");

            if(strlen($cpfFilter) > 0)
                $collection = $collection
                    ->orWhere('cpf', 'like', "%".$cpfFilter."%");

            if(strtoupper($sortByType) === 'ASC')
                $collection = $collection->orderBy($sortByColumn);
            else
                $collection = $collection->orderByDesc($sortByColumn);

            $count = $collection->count();
            $data = [
                "total" => $count,
                "items" => $collection
                    ->offset($offset)
                    ->limit($limit)
                    ->get()
            ];

            return $data;
        }else{
            $collection = strtoupper($sortByType) === 'ASC' ? $this->orderBy($sortByColumn) : $this->orderByDesc($sortByColumn);

            $count = $collection->count();
            $data = [
                "total" => $count,
                "items" => $collection
                    ->offset($offset)
                    ->limit($limit)
                    ->get()
            ];

            return $data;
        }
    }

    public function removeMany(array $ids)
    {
        if(count($ids) > 0)
            $this->whereIn("id", $ids)->delete();

        return;
    }
}
