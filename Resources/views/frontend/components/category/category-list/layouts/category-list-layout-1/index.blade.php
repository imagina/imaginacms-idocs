<section id="idocsCategoryList1" class="idocs-category-list">
        <div id="idocsDocumentsAccordion">
          <div class="card card-documents rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between" id="headingOne">
              <h5 class="card-title font-weight-bold mb-0">Mandato Registro de Facturas - ORF</h5>
              <button class="btn btn-collapse px-2 py-0" data-toggle="collapse" data-target="#collapseOne"
                      aria-expanded="true" aria-controls="collapseOne" type="button">
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </button>
            </div>
        
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#documentsAccordion">
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-documents mb-0">
                    <thead>
                    <tr>
                      <th scope="col" class="text-right">#</th>
                      <th scope="col">Título</th>
                      <th scope="col">Tamaño</th>
                      <th scope="col">Visitas</th>
                      <th scope="col">Descargar</th>
                      <th scope="col" class="dropdown-docs text-right pr-4">
                        <button class="btn dropdown-toggle p-0" type="button" id="docOptions"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cog" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu border-0 rounded-0" aria-labelledby="docOptions">
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1">#</label>
                          </div>
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch2">
                            <label class="custom-control-label" for="customSwitch2">Tamaño</label>
                          </div>
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch3">
                            <label class="custom-control-label" for="customSwitch3">Visitas</label>
                          </div>
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch4">
                            <label class="custom-control-label" for="customSwitch4">Descargar</label>
                          </div>
                        </div>
                      </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td class="text-right">
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                      </td>
                      <td class="table-documents__title">Ver Mandato</td>
                      <td>1,37 mb</td>
                      <td>122</td>
                      <td>
                        <a class="ml-3" href="#" download>
                          <i class="fa fa-cloud-download" aria-hidden="true"></i>
                        </a>
                      </td>
                      <td>
                        <button class="btn btn-preview d-flex align-items-center flex-column p-0" type="button">
                          <i class="fa fa-eye text-gray-200" aria-hidden="true"></i>
                          Vista Previa
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right">
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                      </td>
                      <td class="table-documents__title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aspernatur autem delectus dignissimos, distinctio eligendi explicabo fugiat labore magnam nihil odit omnis repudiandae similique sit veritatis. Delectus eius inventore saepe!</td>
                      <td>1,37 mb</td>
                      <td>122</td>
                      <td>
                        <a class="ml-3" href="#" download>
                          <i class="fa fa-cloud-download" aria-hidden="true"></i>
                        </a>
                      </td>
                      <td>
                        <button class="btn btn-preview d-flex align-items-center flex-column p-0" type="button">
                          <i class="fa fa-eye text-gray-200" aria-hidden="true"></i>
                          Vista Previa
                        </button>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
 
</section>


@section('scripts-owl')
  @parent
  
  <script type="text/javascript">
    $(document).ready(function () {
      var $dropdownDocs = $('.dropdown-docs');
      
      $dropdownDocs.on({
        "click": function(event) {
          if ($(event.target).closest('.dropdown-toggle').length) {
            $(this).data('closable', true);
          } else {
            $(this).data('closable', false);
          }
        },
        "hide.bs.dropdown": function(event) {
          hide = $(this).data('closable');
          $(this).data('closable', true);
          return hide;
        }
      });
    });
  </script>

@stop