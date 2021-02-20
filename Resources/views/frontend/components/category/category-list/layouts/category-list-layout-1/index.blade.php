@if($documents->count())
<section id="idocsCategoryList1" class="idocs-category-list mb-3">
        <div id="idocsDocumentsAccordion" class="accordion">
          <div class="card card-documents rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between" id="headingOne">
            
              <button class="btn btn-link px-2 py-0 w-100 text-left" data-toggle="collapse" data-target="#collapseOne"
                      aria-expanded="true" aria-controls="collapseOne" type="button">
                <h5 class="card-title font-weight-bold mb-0">
                {{$item->title}}
                </h5>
              </button>
  
                <button class="btn btn-collapse px-2 py-0 float-right" data-toggle="collapse" data-target="#collapseOne"
                        aria-expanded="true" aria-controls="documentsAccordion" type="button">
                  <i class="fa fa-angle-down" aria-hidden="true"></i>
                </button>
           
            </div>
        
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#idocsDocumentsAccordion">
              <div class="card-body p-0">
          
                    <div class="row head d-none d-md-flex">
                      <div class="col-12 col-md-6 title-description">
                        <span>{{trans('idocs::documents.form.title')}}</span>
                      </div>
                      <div class="col-12 col-md-2 size">
                        <span> {{trans('idocs::documents.form.size')}}</span>
                      </div>
    
                      <div class="col-12 col-md-2 downloaded">
                        <span> {{trans('idocs::documents.form.downloads')}}</span>
                      </div>
                      <div class="col-12 col-md-2 download">
                        <span> {{trans('idocs::documents.form.download')}}</span>
                      </div>
                    </div>
  
                    <livewire:isite::item-list
                      moduleName="Idocs"
                      entityName="Document"
                      :params="[
                    'filter' => ['categoryId' => $item->id],
                    'include' => [],
                    'take' => 12
                  ]"
                      :showTitle="false"
                      itemListLayout="one"
                      itemComponentName="idocs::document-list-item"
                      :responsiveTopContent="['mobile' => false, 'desktop' => false]"
                    />

               
              </div>
            </div>
          </div>
        </div>
 
</section>
@endif