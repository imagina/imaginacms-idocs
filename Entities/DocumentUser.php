<?php

namespace Modules\Idocs\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Idocs\Presenters\DocumentPresenter;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Iprofile\Entities\Department;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;


class DocumentUser extends Model
{
    use  NamespacedEntity;

    protected $table = 'idocs__document_user';
    protected $fillable = [
      'document_id',
      'user_id',
      'key',
      'downloaded'
    ];




public function setKeyAttribute($value)
{
  $key = '';
  list($usec, $sec) = explode(' ', microtime());
  mt_srand((float) $sec + ((float) $usec * 100000));
  
  $inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));
  
  for($i=0; $i<$length; $i++)
  {
    $key .= $inputs{mt_rand(0,61)};
  }
  
  $this->attributes['key'] = $key;
}
}
