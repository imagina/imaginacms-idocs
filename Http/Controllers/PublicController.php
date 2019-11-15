<?php

namespace Modules\Idocs\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Idocs\Repositories\CategoryRepository;
use Modules\Idocs\Repositories\DocumentRepository;
use Route;

class PublicController extends BasePublicController
{
    private $category;
    private $document;

    public function __construct(DocumentRepository $docuement, CategoryRepository $category)
    {
        parent::__construct();
        $this->document = $docuement;
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
            $documents = $this->document->getItemsBy(json_decode(json_encode(['filter' => ['identification' => $searchphrase['identification'],'key'=>$searchphrase['key']], 'page' => $request->page ?? 1, 'take' => setting('idocs::docs-per-page'), 'include' => ['user']])));

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