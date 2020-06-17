<?php

namespace App;

use App\Models\Area;
use App\Models\Role;
use App\QueryFilter;
use App\Models\Profession;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class UserQuery extends QueryBuilder
{
    
    public function findByEmail($email)
    {
        return $this->where(compact('email'))->first();
    }

    public function WithLastLogin()
    {
        $subselect = Login::select('logins.created_at')
                ->whereColumn('logins.user_id', 'users.id')
                ->latest()
                ->limit(1);

        $this->addSelect(['last_login_at' => $subselect]);
        
        return $this;
    }
    public function withRole()
    {
        $subselect = Role::select('roles.name as role')
                            ->whereColumn('roles.id','users.rol_id');
        $this->addSelect(['role_name' => $subselect]);

        return $this;
    }
    public function withProfession()
    {
        $subselect = Profession::select('professions.name')
                            ->whereColumn('professions.id','users.profession_id');
        $this->addSelect(['profession_name' => $subselect]);

        return $this;
    }
    public function customUsersIf($value)
    {
        if ($value) {
            $this->onlyParents();
            $this->onlyAreas();
        }
        $this->whereNotNull('parent_id');

        return $this;
    }
    public function onlyParents()
    {

        $this->where('parent_id', auth()->user()->id);

        return $this;
    }

    public function onlyAreas()
    {

        $areas = $this->areas();

        $this->whereHas('areas', function($q) use($areas) {
            $q->whereIn('areas.id', $areas);
        });

        return $this;
    }

    protected function areas()
    {
        return DB::table('area_user as s')
                    ->select('s.user_id','s.area_id as id')
                    ->where('s.user_id', auth()->user()->id)
                    ->pluck('id')->toArray();
    }

    

}
