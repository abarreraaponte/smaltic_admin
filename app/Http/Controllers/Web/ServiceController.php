<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::active()->orderBy('created_at', 'desc')->get();

        return view('web.services.index', compact('services'));
    }

    public function inactives()
    {
        $services = Service::inactive()->orderBy('created_at', 'desc')->get();

        return view('web.services.inactives', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.services.create');
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
            'price' => 'integer|nullable',
        ]);

        $service = new Service;
        $service->name = $request->get('name');
        $service->price = $request->get('price');
        $service->save();

        return redirect('/web/services/' . $service->getRouteKey())->with('success', __('El servicio ha sido creado exitosamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('web.services.view', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('web.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'string|required|max:100',
            'price' => 'integer|nullable',
        ]);

        $service->name = $request->get('name');
        $service->price = $request->get('price');
        $service->save();

        return redirect('/web/services/' . $service->getRouteKey())->with('success', __('El servicio ha sido actualizado exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        if($service->canBeDeleted() === true)
        {
            $service->delete();
            return redirect('/web/services')->with('success', __('El servicio ha sido eliminado exitosamente'));
        }

        else 
        {
            return back()->with('errors', __('Este servicio no puede ser eliminado, intente desactivarlo'));
        }
    }

    public function inactivate(Service $service)
    {
        $service->inactivate();

        return redirect('/web/services')->with('success', __('El servicio ha sido desactivado exitosamente'));
    }


    public function reactivate(Service $service)
    {
        $service->reactivate();

        return redirect('/web/services/' . $service->getRouteKey())->with('success', __('El servicio ha sido reactivado exitosamente'));
    }
}
