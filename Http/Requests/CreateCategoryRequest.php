<?php

namespace Modules\Idocs\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueSlugRule;

class CreateCategoryRequest extends BaseFormRequest
{
  public function rules()
  {
    return [];
  }

  public function translationRules()
  {
    return [
      'title' => 'required|min:2',
      'slug' => ['required', new UniqueSlugRule('idocs__category_translations', null, null,
        trans('idocs::categories.messages.sameSlug', ['slug' => $this->input(locale() . '.slug')])), 'min:1', "alpha_dash:ascii"],
    ];
  }

  public function authorize()
  {
    return true;
  }

  public function messages()
  {
    return [];
  }

  public function translationMessages()
  {
    return [
      'title.required' => trans('idocs::common.messages.title is required'),
      'title.min:2' => trans('idocs::common.messages.title min 2 '),
    ];
  }
}
