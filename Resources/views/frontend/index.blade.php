@extends('layouts.master')

@section('meta')
    @include('idocs::frontend.partials.category.metas')
@stop
@section('title')
    {{trans('idocs::frontend.publicDocuments')}} | @parent
@stop
@section('content')
    
    <x-isite::breadcrumb>
        <li class="breadcrumb-item active" aria-current="page"> {{trans('idocs::frontend.publicDocuments')}}</li>
    </x-isite::breadcrumb>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <livewire:isite::items-list
                  moduleName="Idocs"
                  itemComponentName="idocs::category-list-item"
                  itemComponentNamespace="Modules\Idocs\View\Components\CategoryListItem"
                  entityName="Category"
                  :params="[
						'filter' => ['private' => false],
						'include' => [],
						'take' => 12
					]"
                  :showTitle="false"
                  itemListLayout="one"
                  :responsiveTopContent="['mobile' => false, 'desktop' => false]"
                />
            </div>
            
        </div>
        
    </div>
   
@stop