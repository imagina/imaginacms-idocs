@extends('layouts.master')

@section('meta')
  @if(isset($category->id))
    @include('idocs::frontend.partials.category.metas')
  @endif
@stop
@section('title')
  {{trans('idocs::frontend.publicDocuments')}} | @parent
@stop
@section('content')
  <div id="publicDocumentsAll">
    <div class="breadcrumb-section">
      <div class="content overflow-hidden">
        <div class="row justify-content-center align-items-center">
          <div class="col-12 ">
            <div class="breadcrumb-content position-relative overlay-hidden  order-0 ">
              <div class="breadcrumb-info mx-3 mx-lg-5 breadcrumb-overlay">
                <div class="h-100 container ">
                  <div class="h-100 row align-items-center">
                    <div class="col-auto">
                      <div class="title-section  text-white ">
                        {{trans("idocs::common.title.idocs")}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="b-image">
                @if(isset($category) && $category->mediaFiles() && $category->mediaFiles()->mainimage && !Str::contains($category->mediaFiles()->mainimage->path, 'default'))
                  <x-media::single-image
                    imgClasses=""
                    :mediaFiles="$category->mediaFiles()"
                    :isMedia="true"
                    :alt="$category->title"
                  />
                @else
                  <x-media::single-image
                    imgClasses=""
                    setting="icustom::breadcrumbDocuments"
                    alt="img-media-breadcrumb"/>
                @endif
              </div>
              @if(isset($category))
                <div class=" breadcrumb-content h3 text-center py-3">{{$category->title}}</div>
              @endif
            </div>
            <div class="breadcrumb-tree order-1">
              <x-isite::breadcrumb>
                <li class="breadcrumb-item active"
                    aria-current="page"> {{trans('idocs::frontend.publicDocuments')}}</li>
              </x-isite::breadcrumb>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="documents-section">
      <div class="container">
        <div class="row">
          <div class="col-12">
            @if(!isset($category))
              <div Id="TitleDocument" class="mb-4 mb-lg-5">
                @php
                  $settingTitleDocument = sjson_decode(etting("icustom::titleDocument"));
                  $settingDescriptionDocument = json_decode(setting("icustom::descriptionDocument"));
                  $titleDocument = $settingTitleDocument['$titleDocument'] ?? trans('idocs::common.title.idocs');
                  $descriptionDocument = $settingDescriptionDocument['$descriptionDocument'] ?? trans('idocs::common.description.idocs');
                @endphp
                <h1 class="title text-primary text-center">
                  {!! $titleDocument ?? '' !!}
                </h1>
                <div class="subtitle text-primary text-center mx-auto">
                  {!! $descriptionDocument ?? '' !!}
                </div>
              </div>
            @endif
            <div id="contentListDocumentsAll" class="container">
              <div class="row">
                @if(isset($category))
                  <div class="col-12">
                    @if(isset($category->id))
                      <livewire:isite::items-list
                        moduleName="Idocs"
                        entityName="Document"
                        itemComponentNamespace="Modules\Idocs\View\Components\DocumentListItem"
                        :params="[
                          'filter' => ['categoryId' => $category->id, 'private' => false],
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
                        {{  trans('idocs::frontend.emptyCategoryPublic')  }}
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
                          'filter' => ['private' => false, 'parentId' => $category->id ?? null],
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
        </div>
      </div>
    </div>
  </div>
@stop
