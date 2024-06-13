<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $category = Category::where('name', $row['category'])->first();
            $barcode = Product::where('barcode', $row['barcode'])->get();
            $buy_price = preg_replace('/\D/', '', $row['buy_price']);
            $sell_price = preg_replace('/\D/', '', $row['sell_price']);
            $stock = preg_replace('/\D/', '', $row['stock']);

            if ($category != null && $barcode->count() == 0) {
                Product::create([
                    'barcode' => $row['barcode'],
                    'name' => $row['name'],
                    'category_id' => $category->id,
                    'buy_price' => $buy_price,
                    'sell_price' => $sell_price,
                    'stock' => $stock
                ]);
            } 
        }
    }
}
