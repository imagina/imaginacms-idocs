<?php

namespace Modules\Idocs\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;

class Category extends Model
{
    use Translatable, MediaRelation, NamespacedEntity;

    protected $table = 'idocs__categories';
    public $translatedAttributes = ['title', 'description', 'slug', 'meta_title', 'meta_description', 'meta_keywords', 'translatable_options'];
    protected $fillable = ['parent_id', 'options','private'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
        'private'=>'boolean'
    ];


    /**
     * Relation with category parent
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relation with categories children
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Relation with documents
     * @return mixed
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'idocs__document_category');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * @return mixed
     */
    public function getSecondaryImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'secondaryimage')->first();
        if (!$thumbnail) {
            $image = [
                'mimeType' => 'image/jpeg',
                'path' => url('modules/idocs/img/default.jpg')
            ];
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string
            ];
        }
        return json_decode(json_encode($image));
    }

    /**
     * @return mixed
     */
    public function getMainImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'mainimage')->first();
        if (!$thumbnail) {
            $image = [
                'mimeType' => 'image/jpeg',
                'path' => url('modules/idocs/img/default.jpg')
            ];
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string
            ];
        }
        return json_decode(json_encode($image));

    }

    /**
     * @return mixed
     */
    public function getUrlAttribute()
    {

        return \URL::route(\LaravelLocalization::getCurrentLocale() . '.idocs.category', [$this->slug]);

    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /**
     * @param $query
     * @return mixed
     */
    public function scopeFirstLevelItems($query)
    {
        return $query->where('depth', '1')
            ->orWhere('depth', null)
            ->orderBy('lft', 'ASC');
    }
}
