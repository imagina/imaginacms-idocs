<?php

namespace Modules\Idocs\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Idocs\Entities\DocumentUser;
use Modules\Idocs\Events\DocumentWasDownloaded;
use Modules\Idocs\Repositories\CategoryRepository;
use Modules\Idocs\Repositories\DocumentRepository;
use Route;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class PublicController extends BaseApiController
{
    private $category;
    private $document;

    public function __construct(DocumentRepository $document, CategoryRepository $category)
    {
        parent::__construct();
        $this->document = $document;
        $this->category = $category;
    }

    public function index()
    {

        $categories = $this->category->getItemsBy(json_decode(json_encode(['filter' => ['private' => 0], 'page' => $request->page ?? 1, 'take' => setting('idocs::docs-per-page'), 'include' => ['children']])));

        $tpl = "idocs::frontend.index";
        $ttpl = "idocs.index";

        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, compact('categories'));
    }
  
  
  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show(Request $request, $documentId)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $document = $this->document->getItem($documentId, $params);
      
      //Break if no found item
      if(!$document) throw new Exception('Item not found',404);
      
     
      
      $type = $document->file->mimeType;
      
      $privateDisk = config('filesystems.disks.privatemedia');
      $path = $privateDisk["root"]. $document->mediaFiles()->file->relativePath;
  
      event(new DocumentWasDownloaded($document));
      
      return response()->file($path, [
        'Content-Type' => $type,
      ]);
      
    } catch (\Exception $e) {
      return abort(404);
    }
  }
  
  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function showByKey(Request $request, $documentId, $key )
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $document = $this->document->getItem($documentId, $params);
   
      $documentUser = DocumentUser::where('key', $key)->where('document_id',$document->id ?? null)->first();
      //Break if no found item
      if(!$document || !$documentUser) throw new Exception('Item not found',404);
      
      $type = $document->file->mimeType;
      
      $privateDisk = config('filesystems.disks.privatemedia');
      $path = $privateDisk["root"]. $document->mediaFiles()->file->relativePath;
  
      event(new DocumentWasDownloaded($document,$key));
      
      return response()->file($path, [
        'Content-Type' => $type,
      ]);
      
    } catch (\Exception $e) {
      return abort(404);
    }
  }
      
    public function indexPrivate()
    {

        $categories = $this->category->getItemsBy(json_decode(json_encode(['filter' => ['private' => 0], 'page' => $request->page ?? 1, 'take' => setting('idocs::docs-per-page'), 'include' => ['children']])));

        $tpl = "idocs::frontend.index-private";
        $ttpl = "idocs.index-private";

        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, compact('categories'));
    }

    public function category($categorySlug)
    {
        $category = $this->category->findBySlug($categorySlug);

        if($category->private && !\Auth::user()) return redirect()->route('login');

        $documents = $this->document->whereCategory($category->id);
        $tpl = "idocs::frontend.categories";
        $ttpl = "idocs.categories";

        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, compact('documents', 'category'));
    }

    public function search(Request $request)
    {
        try {
            $searchphrase = $request->input('q');
            if (!$searchphrase) throw new \Exception('Item not found', 404);
            $documents = $this->document->getItemsBy(json_decode(json_encode(['filter' => ['identification' => $searchphrase['identification'],'key'=>$searchphrase['key']??'0','status'=>1], 'page' => $request->page ?? 1, 'take' => setting('idocs::docs-per-page'), 'include' => ['user']])));

        } catch (\Exception $e) {
            $searchphrase = null;
            $documents = null;
        }

        $tpl = "idocs::frontend.search";
        $ttpl = "idocs.search";

        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, compact('documents', 'searchphrase'));

    }

}