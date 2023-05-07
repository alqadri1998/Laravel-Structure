<?php

namespace App\Http\Controllers\Admin;

use App\Models\Catalog;
use App\Traits\GetAttributes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CataloguesController extends Controller
{

    use GetAttributes;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');

        $this->breadcrumbs[route('admin.home.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Catalogues'];
        $catalogues = Catalog::all();
        return view('admin.catalog.index', ['catalogs' => $catalogues]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Catalog' : 'Add Catalog');
        $this->breadcrumbs[route('admin.products.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Catalogues'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        $catalog = new Catalog();
        if ($id > 0) {
            $catalog = Catalog::where('id', $id)->first();
        }
        return view('admin.catalog.edit', [
            'catalogId' => $id,
            'catalog' => $catalog,
            'action' => route('admin.catalogues.update', $id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id == 0) {
            $this->validate($request, ['pdf_file' => 'required|mimes:pdf']);
        }
        $data = [];
        if ($request->has('image') && $request->image !== '') {
            $data['image'] = $request->image;
        }
        if ($request->hasFile('pdf_file')) {
            $fileName = explode('.', $request->file('pdf_file')->getClientOriginalName());
            $fileName = $fileName[0] . '-' . time() . '.' . $request->file('pdf_file')->getClientOriginalExtension();
            $request->file('pdf_file')->move(env('BASE_Catalog_PATH'), $fileName);
//           $request->file('pdf_file')->move(public_path('uploads'), $fileName);

            $data['pdf_name'] = 'uploads/' . $fileName;
        }
        if ($data !== '') {
            Catalog::updateOrCreate(['id' => $id], $data);
        }
        if ($id = 0) {
            return redirect()->route('admin.catalogues.index')->with('status', 'Catalog  Created Successfully');
        }
        return redirect()->route('admin.catalogues.index')->with('status', 'Catalog  Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Catalog::where('id', $id)->delete();
        return 'true';
    }
}
