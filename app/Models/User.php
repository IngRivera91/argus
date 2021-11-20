<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    const NOMBRE_TABLA = 'users';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user',
        'password',
        'name',
        'last_name',
        'email',
        'group_id',
        'activo',
        'created_user_id',
        'updated_user_id',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }


}