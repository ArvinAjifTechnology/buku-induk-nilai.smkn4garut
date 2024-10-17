<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GraduationYear;
use App\Http\Controllers\Controller;

class GraduationYearController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentYear = date('Y');
        $graduationYears = GraduationYear::where('year', '<=', $currentYear)
                                ->orderBy('year', 'desc')
                                ->get();


        return view('graduation-years.index', compact('graduationYears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('graduation-years.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:255',
        ]);

        GraduationYear::create($request->all());

        return redirect()->route('graduation-years.index')
                         ->with('success', 'Entry Year created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(GraduationYear $graduationYear)
    {
        return view('graduation-years.show', compact('graduationYear'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(GraduationYear $graduationYear)
    {
        return view('graduation-years.edit', compact('graduationYear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GraduationYear $graduationYear)
    {
        $request->validate([
            'year' => 'required|string|max:255',
        ]);

        $graduationYear->update($request->all());

        return redirect()->route('graduation-years.index')
                         ->with('success', 'Entry Year updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(GraduationYear $graduationYear)
    {
        $graduationYear->delete();

        return redirect()->route('graduation-years.index')
                         ->with('success', 'Entry Year deleted successfully.');
    }
}
