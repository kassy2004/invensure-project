<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use DB;
class PCSIOutgingExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('pcsi_outgoing')
            ->get();
    }
    public function headings(): array
    {
        return ['ID', 'Transaction Date', 'Customer', 'CM Code', 'Item Code', 'Description', 'SKU Description', 'Primary Packaging', 'Secondary Packaging', 'CM Category', 'Prodct Category', 'Variant', 'Production', 'Quantity', 'Kilogram', 'Remarks', 'Approval Status', 'created at', ' updated at'];
    }
}
