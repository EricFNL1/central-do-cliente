<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use Illuminate\Http\Request;

class AdminJourneyController extends Controller
{
    public function index()
    {
        $journeys = Journey::orderBy('order','asc')->get();
        return view('admin.journeys.index', compact('journeys'));
    }
    
    public function create()
    {
        return view('admin.journeys.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'link'        => 'nullable|url',
            'order'       => 'nullable|integer',
        ]);
    
        Journey::create($request->only(['title','description','link','order']));
    
        return redirect()->route('admin.journeys.index')
            ->with('status','Card criado com sucesso!');
    }
    
   
    

    public function edit(Journey $journey)
    {
        return view('admin.journeys.edit', compact('journey'));
    }

    public function update(Request $request, Journey $journey)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'link'        => 'nullable|url',
            'order'       => 'nullable|integer',
        ]);
    
        $journey->update($request->only(['title','description','link','order']));
    
        return redirect()->route('admin.journeys.index')
            ->with('status','Card atualizado com sucesso!');
    }

    public function destroy(Journey $journey)
    {
        $journey->delete();
        return redirect()->route('admin.journeys.index')
            ->with('status','Card excluído com sucesso!');
    }
}
