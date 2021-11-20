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
        'name',
        'activo',
        'created_user_id',
        'updated_user_id',

    ];

    public static function obtenerMetodosAgrupadosPorMenu(int $groupId) {

        $menus = Menu::query()
            ->with('methods')
            ->orderBy('label','ASC')
            ->get();

        $methodsIds = self::query()->find($groupId)->methods;

        $ids = [];

        foreach ($methodsIds as $methodsId) {
            $ids[] = $methodsId->id;
        }

        $metodosAgrupadosPorMenu = [];

        foreach ($menus as $menu) {

            foreach ($menu->methods as $key => $method) {
                $activo = 0;
                if (in_array($method->id, $ids)) {
                    $activo = 1;
                }
                $metodosAgrupadosPorMenu[strtolower($menu->label)][$key] = [
                    'id' => $method->id,
                    'metodo' => $method->name,
                    'activo' => $activo,
                ];
            }

        }

        return $metodosAgrupadosPorMenu;
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function methods(): BelongsToMany
    {
        return $this->belongsToMany(Method::class)->withTimestamps()->orderBy('name','ASC');
    }
}