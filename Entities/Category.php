<?php

namespace Modules\Idocs\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Isite\Traits\RevisionableTrait;
use Modules\Core\Icrud\Traits\HasCacheClearable;

use Modules\Core\Support\Traits\AuditTrait;

class Category extends Model
{
  use Translatable, MediaRelation, NamespacedEntity, NodeTrait, AuditTrait, RevisionableTrait, HasCacheClearable;

  public $transformer = 'Modules\Idocs\Transformers\CategoryTransformer';
  public $entity = 'Modules\Idocs\Entities\Category';
  public $repository = 'Modules\Idocs\Repositories\CategoryRepository';

  protected $table = 'idocs__categories';

  public $translatedAttributes = [
    'title',
    'description',
    'slug',
    'meta_title',
    'meta_description',
    'meta_keywords',
    'translatable_options'
  ];
  protected $fillable = [
    'parent_id',
    'options',
    'private'
  ];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
    'options' => 'array',
    'private' => 'boolean'
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
  public function getUrlAttribute()
  {
    if ($this->private)
      return \URL::route(\LaravelLocalization::getCurrentLocale() . '.idocs.index.private.category', [$this->slug]);
    else
      return \URL::route(\LaravelLocalization::getCurrentLocale() . '.idocs.index.public.category', [$this->slug]);

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

  public function getLftName()
  {
    return 'lft';
  }

  public function getRgtName()
  {
    return 'rgt';
  }

  public function getDepthName()
  {
    return 'depth';
  }

  public function getParentIdName()
  {
    return 'parent_id';
  }

  // Specify parent id attribute mutator
  public function setParentAttribute($value)
  {
    $this->setParentIdAttribute($value);
  }

  public function getCacheClearableData()
  {
    $baseUrls = [config("app.url")];

    if (!$this->wasRecentlyCreated) {
      $baseUrls[] = $this->url;
    }
    $urls = ['urls' => $baseUrls];

    return $urls;
  }

}
