<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::active()->orderBy('created_at', 'desc')->get();

        return view('web.accounts.index', compact('accounts'));
    }

    public function inactives()
    {
        $accounts = Account::inactive()->orderBy('created_at', 'desc')->get();

        return view('web.accounts.inactives', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.accounts.create');
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

        $account = new Account;
        $account->name = $request->get('name');
        $account->save();

        return redirect('/web/accounts/' . $account->getRouteKey())->with('success', __('La Cuenta ha sido creada exitosamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return view('web.accounts.view', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        return view('web.accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $request->validate([
            'name' => 'string|required|max:100',
        ]);

        $account->name = $request->get('name');
        $account->save();

        return redirect('/web/accounts/' . $account->getRouteKey())->with('success', __('La Cuenta ha sido actualizada exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        if($account->canBeDeleted() === true)
        {
            $account->delete();
            return redirect('/web/accounts')->with('success', __('La cuenta ha sido eliminada exitosamente'));
        }

        else 
        {
            return back()->with('errors', __('Esta cuenta no puede ser eliminada, intente desactivarla'));
        }
    }

    public function inactivate(Account $account)
    {
        $account->inactivate();

        return redirect('/web/accounts')->with('success', __('La cuenta ha sido desactivada exitosamente'));
    }


    public function reactivate(Account $account)
    {
        $account->reactivate();

        return redirect('/web/accounts/' . $account->getRouteKey())->with('success', __('La Cuenta ha sido reactivada  exitosamente'));
    }
}
