<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $label
 * @property string $icon
 * @property int $created_user_id
 * @property int $updated_user_id
 * @property Collection $methods
 */
class Menu extends Model
{
    const NOMBRE_TABLA = 'menus';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'label',
        'icon',
        'activo',
        'created_user_id',
        'updated_user_id',

    ];

    public function methods(): HasMany
    {
        return $this->hasMany(Method::class)->orderBy('name','ASC');
    }
}