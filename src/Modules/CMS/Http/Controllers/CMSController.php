<?php

namespace dvplex\Phantom\Modules\CMS\Http\Controllers;

use App\Support\Collection;
use dvplex\Phantom\Classes\PhantomCollectionSearch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CMSController extends Controller {
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {

        return view('cms::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */

    public function search(Request $request) {
        $cms_theme = config('phantom.cms_theme');
        $dir = app_path("/CMS/Themes/{$cms_theme}/views/layouts");
        $lays = parse_ini_file($dir . '/layouts.ini', true);
        $layouts = [];
        $n = 0;

        foreach ($lays as $name => $data) {
            $path = $dir . '/' . $name . '.blade.php';
            @$layouts[$n]->id = $n;
            @$layouts[$n]->file_name = $name . '.blade.php';
            @$layouts[$n]->path = $path;
            @$layouts[$n]->description = $data['description'];
            $lt = file_get_contents($path);

            @$layouts[$n]->hasAceContents = $lt;
            $layouts[$n]=collect($layouts[$n]);
            $n++;
        }
        $layouts = new Collection($layouts);
        $ll = new PhantomCollectionSearch();
        $ll->searchInit($layouts,$request,'layoutsSearch');
        $ll->searchFields(['file_name','description']);
        $layouts = $ll->search(5);
        return view('cms::cms-content', compact('layouts'));
    }
    public function create() {
        return view('cms::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('cms::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        return view('cms::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        return 'layoutsSearch';
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
}
