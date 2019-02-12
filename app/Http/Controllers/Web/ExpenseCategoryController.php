<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense_categories = ExpenseCategory::active()->orderBy('created_at', 'desc')->get();

        return view('web.expense-categories.index', compact('expense_categories'));
    }


    public function inactives()
    {
        $expense_categories = ExpenseCategory::inactive()->orderBy('created_at', 'desc')->get();

        return view('web.expense-categories.inactives', compact('expense_categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.expense-categories.create');
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

        $expense_category = new ExpenseCategory;
        $expense_category->name = $request->get('name');
        $expense_category->save();

        return redirect('/web/expense-categories/' . $expense_category->getRouteKey())->with('success', __('La Categoria de gasto ha sido creada exitosamente'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseCategory $expense_category)
    {
        return view('web.expense-categories.view', compact('expense_category'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseCategory $expense_category)
    {

        return view('web.expense-categories.edit', compact('expense_category'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseCategory $expense_category)
    {
        $request->validate([
            'name' => 'string|required|max:100',
        ]);

        $expense_category->name = $request->get('name');
        $expense_category->save();

        return redirect('/web/expense-categories/' . $expense_category->getRouteKey())->with('success', __('La Categoria de gasto ha sido actualizada exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseCategory $expense_category)
    {
        if($expense_category->canBeDeleted() === true)
        {
            $expense_category->delete();
            return redirect('/web/expense-categories')->with('success', __('La Categoria de gasto ha sido eliminada exitosamente'));
        }

        else
        {
            return back()->with('errors', __('Esta categoria de gasto no puede ser eliminada, intente desactivarlo')); 
        }
    }

    public function inactivate(ExpenseCategory $expense_category)
    {
        $expense_category->inactivate();

        return redirect('/web/expense-categories')->with('success', __('La Categoria de gasto ha sido desactivada exitosamente'));
    }


    public function reactivate(ExpenseCategory $expense_category)
    {
        $expense_category->reactivate();

        return redirect('/web/expense-categories/' . $expense_category->getRouteKey())->with('success', __('La Categoria de gasto ha sido reactivada exitosamente'));
    }
}
