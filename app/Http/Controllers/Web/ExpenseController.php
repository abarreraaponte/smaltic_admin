<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseLine;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use App\Models\Payment;
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
        $expense_line = $expense->expense_lines->first();
        $expense_payments = $expense->payments;
        $payment_methods = PaymentMethod::active()->get();
        $accounts = Account::active()->where('is_reward', '<>', '1')->get();

        return view('web.expenses.view', compact('expense', 'expense_line', 'expense_payments', 'payment_methods', 'accounts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $expense_line = $expense->expense_lines->first();
        $expense_categories = ExpenseCategory::active()->get();

        return view('web.expenses.edit', compact('expense', 'expense_line', 'expense_categories'));
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
        $request->validate([
            'date' => 'required|date',
            'expense_category_id' => 'required|integer',
            'description' => 'required|string|max:255',
            'amount' => 'required|integer',
        ]);

        $expense->date = $request->get('date');
        $expense->save();

        $el = $expense->expense_lines->first();
        $el->expense_category_id = $request->get('expense_category_id');
        $el->description = $request->get('description');
        $el->amount = $request->get('amount');
        $el->save();

        $expense->updatePaymentStatus();

        return redirect('/web/expenses/' . $expense->getRouteKey())->with('success', 'El Gasto ha sido actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        if($expense->canBeDeleted() === true)
        {

            foreach($expense->expense_lines as $expense_line)
            {
                $expense_line->delete();
            }

            $expense->delete();

            return redirect('/web/expenses')->with('success', __('La cita ha sido eliminada exitosamente'));
        }

        else
        {
            return back()->with('errors', __('Esta cita no puede ser eliminado, intente eliminar los pagos primero')); 
        }
    }
}
