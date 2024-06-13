<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.sale');
    }

    public function filterSale(Request $request)
    {
        return view('report.sale', [
            'startDate' => $request->start,
            'endDate' => $request->end,
            'transactions' => Transaction::whereDate('date', '>=', $request->start)->whereDate('date', '<=', $request->end)->get()
        ]);
    }

    public function export(Request $request)
    {
        return Excel::download(new ReportExport($request->startDate, $request->endDate), 'report-transactions-'. Carbon::now()->timestamp .'.xlsx');
    }
}
