<?php

namespace Modules\User\Repositories\Dashboard;

use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\RepositorySetterAndGetter;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class UserRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }


    public function modelCreated($model, $request, $is_created = true): void
    {
        if ($request['roles'] != null) {
            $this->saveRoles($model, $request);
        }
    }

    public function modelUpdated($model, $request): void
    {
        if ($request['roles'] != null) {
            $this->saveRoles($model, $request);
        }
    }
    public function saveRoles($user, $request)
    {
        $user->syncRoles($request['roles']);
        return true;
    }


    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        $user = $this->model->withDeleted()->find($id);

        return $user;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $user = $this->model->where('email', $email)->first();

        return $user;
    }
    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = $this->model->whereHas('roles.permissions',function ($q){
                $q->where('name','seller_access');
            })->where('id', '!=', auth()->id())->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }
}
