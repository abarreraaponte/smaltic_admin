<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Artist;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists = Artist::active()->orderBy('created_at', 'desc')->get();

        return view('web.artists.index', compact('artists'));
    }


    public function inactives()
    {
        $artists = Artist::inactive()->orderBy('created_at', 'desc')->get();

        return view('web.artists.inactives', compact('artists'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.artists.create');
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

        $artist = new Artist;
        $artist->name = $request->get('name');
        $artist->save();

        return redirect('/web/artists/' . $artist->getRouteKey())->with('success', __('El Artista ha sido creado exitosamente'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
        return view('web.artists.view', compact('artist'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Artist $artist)
    {

        return view('web.artists.edit', compact('artist'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artist $artist)
    {
        $request->validate([
            'name' => 'string|required|max:100',
        ]);

        $artist->name = $request->get('name');
        $artist->save();

        return redirect('/web/artists')->with('success', __('El Artista ha sido actualizado exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist)
    {
        if($artist->canBeDeleted() === true)
        {
            $artist->delete();
            return redirect('/web/artists')->with('success', __('El artista ha sido eliminado exitosamente'));
        }

        else
        {
            return back()->with('errors', __('Este artista no puede ser eliminado, intente desactivarlo')); 
        }
    }

    public function inactivate(Artist $artist)
    {
        $artist->inactivate();

        return redirect('/web/artists')->with('success', __('El artista ha sido desactivado exitosamente'));
    }


    public function reactivate(Artist $artist)
    {
        $artist->reactivate();

        return redirect('/web/artists/' . $artist->getRouteKey())->with('success', __('El artista ha sido reactivado exitosamente'));
    }
}
