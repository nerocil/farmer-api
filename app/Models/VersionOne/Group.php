<?php

namespace App\Models\VersionOne;

use App\Models\AttributesTraits;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Request;

class Group extends Model
{
    use HasFactory, SoftDeletes;
    /*
     * The AttributesTraits holds custom cast functions for columns
     * */
    use AttributesTraits;

    protected $guarded = [];

    public function groupMembers(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->select(['id','first_name','last_name','email']);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by')->select(['id','first_name','last_name','email']);
    }

    function profileIcon():Attribute{
        return Attribute::make(get: fn($value) => route('group.avatar',$value) );
    }

    public function scopeGroups(Builder $query, string $search=null): Builder
    {
        return $query->with(['createdBy','updatedBy'])
            ->when($search,function (Builder $query) use ($search){
            return $query->where('name', 'like', '%'. $search .'%');
        });
    }


}
