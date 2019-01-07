<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Source;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sources = Source::active()->orderBy('created_at', 'desc')->get();

        return view('web.sources.index', compact('sources'));
    }


    public function inactives()
    {
        $sources = Source::inactive()->orderBy('created_at', 'desc')->get();

        return view('web.sources.inactives', compact('sources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.sources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required|max:100',
        ]);

        $source = new Source;
        $source->name = $request->get('name');
        $source->save();

        return redirect('/web/sources/' . $source->getRouteKey())->with('success', __('El como nos conoce ha sido creado exitosamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source)
    {
        return view('web.sources.view', compact('source'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Source $source)
    {
        return view('web.sources.edit', compact('source'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Source $source)
    {
        $request->validate([
            'name' => 'string|required|max:100',
        ]);

        $source->name = $request->get('name');
        $source->save();

        return redirect('/web/sources/' . $source->getRouteKey())->with('success', __('El como nos conoce ha sido actualizado exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        if($source->canBeDeleted() === true)
        {
            $source->delete();

            return redirect('/web/sources')->with('success', __('El como nos conoce fue eliminado exitosamente'));
        }

        else 
        {
            return back()->with('warning', __('El como nos conoce no puede ser eliminado, por favor desactívelo'));
        }
    }


    public function inactivate(Source $source)
    {
        $source->inactivate();

        return redirect('/web/sources')->with('success', __('El como nos conoce ha sido desactivado exitosamente'));
    }


    public function reactivate(Source $source)
    {
        $source->reactivate();

        return redirect('/web/sources/' . $source->getRouteKey())->with('success', __('El como nos conoce ha sido reactivado exitosamente'));
    }
}
