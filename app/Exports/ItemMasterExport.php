<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use DB;
class ItemMasterExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('item_master')
            ->get();
    }
    public function headings(): array
    {
        return ['ID', 'Item', 'New MRP Code', 'Item Group', 'Abbrev', 'Category', 'Category 2', 'Primary Packaging', 'Secondary Packaging', 'Variant', 'Kilogram/Tray', 'Class', 'Expiration Stage', 'SKU', 'FG', 'FG Packaging' ,'Created At', 'Updated At'];
    }
}
