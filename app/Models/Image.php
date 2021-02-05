<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int    $id
 * @property int    $user_id
 * @property int    $parent_id
 * @property int    $likes
 * @property string $md5
 * @property string $mime
 * @property int    $size
 * @property int    $width
 * @property int    $height
 * @property string $raw
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Like[] $like
 *
 * Class Image
 * @package App\Models
 */
class Image extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'images';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file_storage';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'user_id'    => 'integer',
        'parent_id'  => 'integer',
        'likes'      => 'integer',
        'md5'        => 'string',
        'mime'       => 'string',
        'size'       => 'integer',
        'width'      => 'integer',
        'height'     => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'md5',
        'mime',
        'size',
        'width',
        'height',
        'raw',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'raw',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function like()
    {
        return $this->hasMany(Like::class, 'image_id', 'id');
    }

    /**
     * @return bool
     */
    public function updateLikes(): bool
    {
        $this->likes = $this->like()->count();

        return $this->save();
    }

    /**
     * @param string $path
     * @return Image
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function createFileByPath(string $path): Image
    {
        if (!file_exists($path)) {
            throw new \RuntimeException("File '$path' not found");
        }

        $createChild = static function (Image $model) {
            $child            = new self;
            $child->user_id   = request()->user()->id;
            $child->parent_id = $model->id;
            $child->width     = $model->width;
            $child->height    = $model->height;
            $child->md5       = $model->md5;
            $child->mime      = $model->mime;
            $child->size      = $model->size;
            $child->saveOrFail();

            return $child;
        };

        $md5 = md5_file($path);

        /** @var Image $existImage */
        $existImage = self::query()
            ->select(['id', 'parent_id', 'width', 'height', 'md5', 'size'])
            ->where('md5', $md5)
            ->where('parent_id', 0)
            ->first();

        if ($existImage) {
            return $createChild($existImage);
        }

        /** @var \Intervention\Image\Image $image */
        $image = app('image')->make($path);

        $model          = new self;
        $model->user_id = 1;
        $model->width   = $image->width();
        $model->height  = $image->height();
        $model->md5     = $md5;
        $model->mime    = $image->mime();
        $model->size    = $image->filesize();
        $model->raw     = file_get_contents($path);
        $model->saveOrFail();

        return $createChild($model);
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function deleteById(int $id): void
    {
        /** @var Image $existImage */
        $existImage = self::query()
            ->select(['id', 'parent_id'])
            ->where('id', $id)
            ->first();

        if ($existImage) {
            if ($existImage->parent_id &&
                self::query()->where('parent_id', $existImage->parent_id)->count() <= 1) {

                /** @var Image $parent */
                $parent = self::query()
                    ->select(['id', 'parent_id'])
                    ->where('id', $existImage->parent_id)
                    ->first();

                if ($parent) {
                    $parent->delete();
                }
            } elseif (!$existImage->parent_id) {
                /** @var Collection $childs */
                $childs = self::query()
                    ->select(['id', 'parent_id'])
                    ->where('parent_id', $existImage->id)
                    ->get();

                foreach ($childs as $child) {
                    /** @var Image $child */
                    $child->delete();
                }
            }
        }

        if ($existImage) {
            $existImage->delete();
        }
    }

    /**
     * @return string|null
     */
    public function getRaw()
    {
        if (!$this->parent_id) {
            return $this->raw;
        }

        /** @var Image $image */
        if ($image = self::query()->select(['raw'])->where('id', $this->parent_id)->first()) {
            return $image->raw;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getBase64(): string
    {
        $raw  = base64_encode($this->getRaw());
        $mime = $this->mime;

        return "data:{$mime};base64,{$raw}";
    }
}
