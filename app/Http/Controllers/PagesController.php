<?php

namespace App\Http\Controllers;

use App\Page;
use App\PageContent;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class PagesController extends Controller
{

    protected $auth;

    /**
     * Create a new Pages controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'guest']);
    }

    /**
     * Show all pages.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pages = Page::all();
        return view('dashboard.pages.index', compact('pages'));
    }


    /**
     * Shows the page to edit a page.
     *
     * @param $pageId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($pageId)
    {
        $page = Page::find($pageId);
        $content = $page->content;
        return view('dashboard.pages.edit', compact('page', 'content'));
    }

    /**
     * Creates a new page.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Redirect
     */
    public function create(Request $request)
    {
        $newPage = Page::create([
            'title' => $request->get('title')
        ]);

        $newPage->save();

        if($request->ajax()){
            return response()->json(['status' => 'ok', 'msg' => 'En ny sida har nu skapats.']);
        }

        return redirect('pages');
    }

    /**
     *
     * Deletes a page.
     *
     * @param $pageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($pageId)
    {
        $page = Page::find($pageId);
        $page->delete();
        return redirect()->route('pages');
    }

    /**
     *
     * Saves a block.
     *
     * @param $pageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveBlock($blockId, Request $request)
    {
        $block = PageContent::find($blockId);
        $block->content = $request->get('content');
        $block->title = $request->get('title');
        $block->save();

        if($request->ajax()){
            $response = array(
                'status' => 'success',
                'blockId' => $blockId,
            );
            return response()->json($response);
        }

        return 'Uppdaterat.';
    }

}
