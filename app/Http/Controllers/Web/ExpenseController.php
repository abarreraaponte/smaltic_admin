<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseLine;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use App\Models\ExpensePayment;
use App\Models\Account;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense_lines = ExpenseLine::orderBy('id', 'desc')->get();
        $expense_lines->load('expense');

        return view('web.expenses.index', compact('expense_lines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expense_categories = ExpenseCategory::active()->get();

        return view('web.expenses.create', compact('expense_categories'));
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
            'date' => 'required|date',
            'expense_category_id' => 'required|integer',
            'description' => 'required|string|max:255',
            'amount' => 'required|integer',
        ]);

        $expense = new Expense;
        $expense->date = $request->get('date');
        $expense->save();

        $el = new ExpenseLine;
        $el->expense_id = $expense->id;
        $el->expense_category_id = $request->get('expense_category_id');
        $el->description = $request->get('description');
        $el->amount = $request->get('amount');
        $el->save();

        return redirect('/web/expenses/' . $expense->getRouteKey())->with('success', 'El Gasto ha sido registrado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
