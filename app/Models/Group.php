<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    const NOMBRE_TABLA = 'groups';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'session_id',
        'user_id',
        'activo',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function methods(): BelongsToMany
    {
        return $this->belongsToMany(Method::class)->withTimestamps();
    }
}