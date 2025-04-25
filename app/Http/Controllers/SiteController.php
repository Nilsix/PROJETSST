<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::all();
        return view('site.index', ["sites" => $sites]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('site.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "nomSite" => ['required',Rule::unique('sites','nomSite')]]);
            Site::create($data);
            return view('site.index', ["sites" => Site::all()])->with('success', 'Site créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        return view('site.edit', ["site" => $site]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $data = $request->validate([
            "nomSite" => ['required',Rule::unique('sites','nomSite')]]);
            $site->update($data);
            return view('site.index', ["sites" => Site::all()])->with('success', 'Site modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        $site->delete();
        return view('site.index', ["sites" => Site::all()])->with('success', 'Site supprimé avec succès');
    }
}
