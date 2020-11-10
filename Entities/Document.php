<?php

namespace Modules\Idocs\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Idocs\Presenters\DocumentPresenter;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;


class Document extends Model
{
    use Translatable, MediaRelation, NamespacedEntity, PresentableTrait;

    protected $table = 'idocs__documents';
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['user_identification','key','email','options', 'category_id', 'user_id', 'role_id', 'status'];
    protected $presenter = DocumentPresenter::class;

    protected $casts = [
        'options' => 'array'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'idocs__document_category');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsToMany("Modules\\User\\Entities\\{$driver}\\User", 'idocs__document_user', 'document_id', 'user_id')->withTimestamps();
    }

    public function user()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    /**
     * @return mixed
     */
    public function getFileAttribute()
    {

        $thumbnail = $this->files()->where('zone', 'file')->first();
        if (!$thumbnail) {
           return null;
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string,
                'size'=>$thumbnail->filesize
            ];
        }
        return json_decode(json_encode($image));

    }

    /**
     * @return mixed
     */
    public function getIconImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'iconimage')->first();
        if (!$thumbnail) {
            return null;
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string
            ];
        }
        return json_decode(json_encode($image));

    }

}
