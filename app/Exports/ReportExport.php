<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromQuery, WithMapping, WithHeadings
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($startDate, $endDate)
    {
    	$this->startDate = $startDate;
    	$this->endDate = $endDate;
    }

    public function query()
    {
        return Transaction::query()->whereDate('date', '>=', $this->startDate)->whereDate('date', '<=', $this->endDate);
    }

    public function map($transaction): array
    {
    	$customer = $transaction->customer_id !== null ? $transaction->customer->name : 'Umum';
    	$total = "Rp.". number_format($transaction->total);
    	$profit = "Rp.". number_format($transaction->profit);
    	return [
    		$transaction->invoice,
    		$transaction->date,
    		$customer,
    		$transaction->user->name,
    		$total,
    		$profit
    	];
    }

    public function headings(): array
    {
    	return ['Invoice', 'Date', 'Customer', 'Cashier', 'Total', 'Profit'];
    }
}
