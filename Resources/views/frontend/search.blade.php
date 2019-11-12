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

        <!-- Blog Entries Column -->
        <div class="col-md-8">

          <h1 class="my-4">{{trans('idocs::common.title.idocs')}} - {{$searchphrase??''}}
          </h1>


          <div class="row">
            <div class="col-12">
              <div class="card my-4">
                <h5 class="card-header">Search</h5>
              <form id="doc-search-input" class="form-inline" method="GET" onsubmit="return docSearchForm('identification')">
                <div class="input-group col-12 mb-3 mt-3">
                  <input type="text" class="form-control" placeholder="{{trans('idocs::documents.form.document')}} " name="search" id ="identification" maxlength="64" required>
                  <span class="input-group-btn">
                        <button class="btn btn-secondary" type="submit"><span class="fa fa-search"></span></button>
                    </span>
                </div><!-- /input-group -->
              </form>
              </div>
            </div>
          </div>

        @if (count($documents))
          @foreach($documents as $document)
              <div class="card mb-4">
                {!!$document->present()->icon()!!}
                <div class="card-body">
                  <a href="{{$document->file->path}}"
                     class="btn btn-primary" target="_blank">{{$document->title}}</a>
                </div>
              </div>
          @endforeach

          <!-- Pagination -->
            <div class="pagination justify-content-center mb-4 pagination paginacion-blog row">
              <div class="pull-right">
                {{$documents->links('pagination::bootstrap-4')}}
              </div>
            </div>
          @endif

        </div>


      </div>
      <!-- /.row -->

    </div>
@stop

@section('scripts')
  @parent
      <script type="text/javascript">
          function docSearchForm(idsearch){
              rut = "{{route('idocs.document.search')}}";
              rut2 = rut+'?q='+document.getElementById(idsearch).value;
              location.href = rut2;
              return false;
          }
      </script>
@stop