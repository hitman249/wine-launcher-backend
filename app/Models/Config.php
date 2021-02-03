<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int     $id
 * @property int     $user_id
 * @property int     $icon_id
 * @property int     $background_id
 * @property boolean $active
 * @property int     $sort
 * @property string  $name
 * @property string  $version
 * @property array   $config
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 *
 * @method Config ofName(string $name)
 *
 * Class Config
 * @package App\Models
 */
class Config extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configs';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'user_id'       => 'integer',
        'icon_id'       => 'integer',
        'background_id' => 'integer',
        'active'        => 'boolean',
        'sort'          => 'integer',
        'name'          => 'string',
        'version'       => 'string',
        'config'        => 'array',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'active',
        'sort',
        'name',
        'version',
        'config',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $name
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function scopeOfName($query, $name)
    {
        if (Auth::guest()) {
            throw new \Exception('User is not authorized');
        }

        $query->where('user_id', request()->user()->id);

        $query->where(function ($query) use ($name) {
            /** @var \Illuminate\Database\Eloquent\Builder $query */

            $search = implode('%', prepare_name($name));
            $query
                ->where('name', $name)
                ->orWhere('name', 'like', "%{$search}%");
        });
    }
}
