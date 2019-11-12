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

        $documents = $this->document->getItemsBy(json_decode(json_encode(['filter' => ['status' => 1], 'page' => $request->page ?? 1, 'take' => setting('idocg::docs-per-page'), 'include' => []])));

        $tpl = "idocs::frontend.index";
        $ttpl = "idocs.index";

        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, compact('documents'));
    }

    public function category($categorySlug)
    {

        $category = $this->category->findBySlug($categorySlug);
        $documents = $this->document->whereCategory($category->id);
        $tpl = "idocs::frontend.index";
        $ttpl = "idocs.index";

        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, compact('documents', 'category'));
    }

    public function search(Request $request)
    {
        try {
            $searchphrase = $request->input('q');

            $documents = $this->document->getItemsBy(json_decode(json_encode(['filter' => ['identification' => $searchphrase], 'page' => $request->page ?? 1, 'take' => setting('idocg::docs-per-page'), 'include' => ['user']])));

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