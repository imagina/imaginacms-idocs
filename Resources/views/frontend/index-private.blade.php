@extends('iprofile::frontend.layouts.master')

@section('meta')
  @include('idocs::frontend.partials.category.metas')
@stop
@section('title')
  {{trans('idocs::frontend.myDocuments')}} | @parent
@stop
@section('profileTitle')
  {{trans('idocs::frontend.myDocuments')}}
@stop

@section('profileBreadcrumb')
  <x-isite::breadcrumb>
    <li class="breadcrumb-item active" aria-current="page"> {{trans('idocs::frontend.myDocuments')}}</li>
  </x-isite::breadcrumb>
@endsection

@section('content')
  <div id="privateDocumentsAll">
    <x-isite::breadcrumb>
      <li class="breadcrumb-item active" aria-current="page"> {{trans('idocs::frontend.privateDocuments')}}</li>
    </x-isite::breadcrumb>

    <div class="container">
      <div class="row">
        <div class="col-12">
          <!--Translation  Title _ idocs::common.idocs.title -->
          <h1 class="docs-title h3">{{isset($category->id)
                         ? $category->title
                         : trans("idocs::common.title.idocs")}}
          </h1>

          <!-- Translation Description _ idocs::common.idocs.description -->
          <p class="docs-description">{!! isset($category->id)
                       ? $category->description
                        : trans("idocs::common.description.idocs") !!}
          </p>
        </div>
        @if(isset($category))
          <div class="col-12">
            @if(isset($category->id))
              <livewire:isite::items-list
                moduleName="Idocs"
                entityName="Document"
                itemComponentNamespace="Modules\Idocs\View\Components\DocumentListItem"
                :params="[
                    'filter' => ['categoryId' => $category->id],
                    'include' => [],
                    'take' => 12
                  ]"
                :showTitle="false"
                itemListLayout="one"
                itemComponentName="idocs::document-list-item"
                :responsiveTopContent="['mobile' => false, 'desktop' => false]"
              />
            @else
              <p class="category-empty-message">
                {{  trans('idocs::frontend.emptyCategoryPrivate')  }}
              </p>
            @endif
          </div>
        @else
          <div class="col-12">
            <livewire:isite::items-list
              moduleName="Idocs"
              itemComponentName="idocs::category-list-item"
              itemComponentNamespace="Modules\Idocs\View\Components\CategoryListItem"
              entityName="Category"
              :params="[
                          'filter' => ['private' => true],
                          'include' => [],
                          'take' => 12
                        ]"
              :showTitle="false"
              itemListLayout="one"
              :responsiveTopContent="['mobile' => false, 'desktop' => false]"
            />
          </div>
        @endif
      </div>
    </div>
  </div>
@stop
