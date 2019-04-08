<?php

namespace App\Http\Controllers\Web;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Artist;
use App\Models\Service;
use App\Models\JobLine;
use App\Models\Expense;
use App\Models\ExpenseLine;
use App\Models\ExpenseCategory;
use App\Models\Payment;
use App\Models\ExpensePayment;
use App\Models\Account;
use App\Exports\JobsExport;
use App\Exports\ExpensesExport;
use App\Exports\AccountExport;

class ReportController extends Controller
{
    public function index()
    {
        $artists = Artist::all();
        $services = Service::all();
        $payment_statuses = Job::payment_statuses();
        $categories = ExpenseCategory::all();
        $accounts = Account::where('is_reward', '<>', 1)->get();
        return view('web.reports.index', compact('artists','services', 'payment_statuses', 'categories', 'accounts'));
    }

    public function sales(Request $request)
    {
        $request->validate([
            'date_from' => 'date|nullable',
            'date_until' => 'date|nullable',
            'artists' => 'nullable|array|min:1',
            'artists.*' => 'integer',
            'services' => 'nullable|array|min:1',
            'services.*' => 'integer',
            'payment_statuses' => 'nullable|array|min:1',
            'payment_statuses.*' => 'string',
        ]);

        $artists = $request->get('artists');
        $services = $request->get('services');
        $date_from = $request->get('date_from');
        $date_until = $request->get('date_until');
        $payment_statuses = $request->get('payment_statuses');

        $job_lines = JobLine::with('job', 'artist', 'service')
            ->when($date_from, function ($query, $date_from) {
                return $query->whereHas('job', function ($query) use ($date_from) {
                    $query->whereDate('date', '>=', $date_from);
                });
            })
            ->when($date_until, function ($query, $date_until) {
                return $query->whereHas('job', function ($query) use ($date_until) {
                    $query->whereDate('date', '<=', $date_until);
                });
            })
            ->when($payment_statuses, function ($query, $payment_statuses) {
                return $query->whereHas('job', function ($query) use ($payment_statuses) {
                    $query->whereIn('payment_status', $payment_statuses);
                });
            })
            ->when($artists, function ($query, $artists) {
                return $query->whereIn('artist_id', $artists);
            })
            ->when($services, function ($query, $services) {
                return $query->whereIn('service_id', $services);
            })
            ->orderBy('id', 'asc')->get();

        $customers = Customer::all();
        $amount_sum = $job_lines->pluck('amount')->sum();

        $request->flash();

        return view('web.reports.jobs', compact('job_lines', 'customers', 'date_from', 'date_until', 'amount_sum'));
    }

    public function salesExport(Request $request)
    {
        return (new JobsExport($request))->download('ventas.xlsx');
    }

    public function expenses(Request $request)
    {
        $request->validate([
            'date_from' => 'date|nullable',
            'date_until' => 'date|nullable',
            'categories' => 'nullable|array|min:1',
            'categories.*' => 'integer',
            'payment_statuses' => 'nullable|array|min:1',
            'payment_statuses.*' => 'string',
        ]);

        $categories = $request->get('categories');
        $date_from = $request->get('date_from');
        $date_until = $request->get('date_until');
        $payment_statuses = $request->get('payment_statuses');

        $expense_lines = ExpenseLine::with('expense', 'expense_category')
            ->when($date_from, function ($query, $date_from) {
                return $query->whereHas('expense', function ($query) use ($date_from) {
                    $query->whereDate('date', '>=', $date_from);
                });
            })
            ->when($date_until, function ($query, $date_until) {
                return $query->whereHas('expense', function ($query) use ($date_until) {
                    $query->whereDate('date', '<=', $date_until);
                });
            })
            ->when($payment_statuses, function ($query, $payment_statuses) {
                return $query->whereHas('expense', function ($query) use ($payment_statuses) {
                    $query->whereIn('payment_status', $payment_statuses);
                });
            })
            ->when($categories, function ($query, $categories) {
                return $query->whereIn('expense_category_id', $categories);
            })
            ->orderBy('id', 'asc')->get();

        $amount_sum = $expense_lines->pluck('amount')->sum();
        $request->flash();

        return view('web.reports.expenses', compact('expense_lines','date_from', 'date_until', 'amount_sum'));
    }

    public function expensesExport(Request $request)
    {
        return (new ExpensesExport($request))->download('gastos.xlsx');
    }

    public function accounts(Request $request)
    {
        $request->validate([
            'date_from' => 'date|nullable',
            'date_until' => 'date|nullable',
            'account_id' => 'required|integer'
        ]);

        $date_from = $request->get('date_from');
        $date_until = $request->get('date_until');
        $account = Account::where('id', $request->get('account_id'))->first();

        $payments = Payment::with('job', 'customer', 'transfer', 'expense')
            ->when($date_from, function ($query, $date_from) {
                return $query->whereDate('date', '>=', $date_from);
            })
            ->when($date_until, function ($query, $date_until) {
                return $query->whereDate('date', '<=', $date_until);
            })
            ->where('account_id', $account->id)->orderBy('date', 'desc')->get();

        $amount_sum = $payments->pluck('amount')->sum();

        $request->flash();

        return view('web.reports.accounts', compact('payments', 'date_from', 'date_until', 'amount_sum', 'account'));
    }

    public function accountsExport(Request $request)
    {
        return (new AccountExport($request))->download('cuenta.xlsx');
    }

}
