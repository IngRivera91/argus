<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MethodBase extends Model
{
    const NOMBRE_TABLA = 'methods_base';
    protected $table = 'methods_base';


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
        'is_menu',
        'is_action',
        'activo',
        'created_user_id',
        'updated_user_id',

    ];

}