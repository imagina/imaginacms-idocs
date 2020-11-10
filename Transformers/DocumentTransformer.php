<?php

namespace Modules\Idocs\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Idocs\Transformers\CategoryTransformer;

class DocumentTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'title' => $this->when($this->title, $this->title),
      'description' => $this->description ?? '',
      'options' => $this->when($this->options, $this->options),
      'status' => $this->when($this->status, intval($this->status)),
      'parentId' => $this->parent_id,
      'categoryId' => $this->category_id,
      'category' => new CategoryTransformer($this->whenLoaded('category')),
      'categories' => CategoryTransformer::collection($this->whenLoaded('categories')),
      'mediaFiles' => $this->mediaFiles(),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at)
    ];

    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['title'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['description'] ?? '' : '';
      }
    }

    return $data;
  }
}
