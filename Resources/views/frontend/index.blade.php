@extends('layouts.master')

@section('meta')
    @include('idocs::frontend.partials.category.metas')
@stop
@section('title')
    {{trans('idocs::common.title.idocs')}} | @parent
@stop
@section('content')
    <div class="docs-category-all">
        <div class="container">

            <div class="row">
                <div class="col-md-8">

                    <h1 class="my-4">{{trans('idocs::common.title.idocs')}}
                    </h1>

                @if (count($categories))
                    <div class="row">
                    @foreach($categories as $category)
                            <div class="card col-sm-6 mb-4">
                                <img class="card-img-top"
                                     src="{{--str_replace('.jpg','_mediumThumb.jpg',$category->mainimage->path)--}}{{$category->mainimage->path}}"
                                     alt="{{$category->title}}">
                                <div class="card-body">
                                    <h2 class="card-title">{{$category->title}}</h2>
                                    <a href="{{$category->url}}"
                                       class="btn btn-primary">{{trans('idocs::common.button.view more')}} &rarr;</a>
                                </div>
                            </div>
                    @endforeach
                    </div>
                <!-- Pagination -->
                    <div class="pagination justify-content-center mb-4 pagination paginacion-blog row">
                        <div class="pull-right">
                            {{$categories->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                    @else
                        <div class="col-xs-12 con-sm-12">
                            <div class="white-box">
                                <h3>Ups... :(</h3>
                                <h1>404 documentos no encontrado</h1>
                                <hr>
                                <p style="text-align: center;">No hemos podido encontrar el Contenido que estás
                                    buscando.</p>
                            </div>
                            @endif

                        </div>

                        <!-- Sidebar Widgets Column -->
                        <div class="col-md-4">

                            <!-- Search Widget -->
                            <div class="card my-4">
                                <h5 class="card-header">Search</h5>
                                <div class="card-body">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <!-- /.row -->

            </div>
@stop