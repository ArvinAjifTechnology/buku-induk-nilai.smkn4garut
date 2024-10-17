<?php

namespace App\Http\Controllers;

use App\Models\EntryYear;
use Illuminate\Http\Request;

class EntryYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentYear = date('Y');
        $entryYears = EntryYear::orderBy('year', 'desc')
                                ->get();


        return view('entry-years.index', compact('entryYears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('entry-years.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:4|unique:entry_years,year',
        ]);

        EntryYear::create($request->all());

        return redirect()->route('entry-years.index')
                         ->with('success', 'Tahun Masuk Berhasil Di Tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(EntryYear $entryYear)
    {
        return view('entry-years.show', compact('entryYear'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(EntryYear $entryYear)
    {
        return view('entry-years.edit', compact('entryYear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EntryYear $entryYear)
    {
        $request->validate([
            'year' => 'required|string|max:4|unique:entry_years,year,'. $entryYear->id,
        ]);

        $entryYear->update($request->all());

        return redirect()->route('entry-years.index')
                         ->with('success', 'Tahun Masuk'.$request->year.'Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntryYear $entryYear)
    {
        $entryYear->delete();

        return redirect()->route('entry-years.index')
                         ->with('success', 'Tahun Masuk'.$entryYear->year.'Berhasil Dihapus');
    }
}
