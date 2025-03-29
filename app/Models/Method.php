<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $label
 * @property string $icon
 * @property int $menu_id
 * @property bool $is_menu
 * @property bool $is_action
 * @property int $created_user_id
 * @property int $updated_user_id
 * @property Menu $menu
 * @property Collection $groups
 */

class Method extends Model
{
    const NOMBRE_TABLA = 'methods';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'label',
        'action',
        'icon',
        'menu_id',
        'is_menu',
        'is_action',
        'activo',
        'created_user_id',
        'updated_user_id',

    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class)->orderBy('name','ASC');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }
}