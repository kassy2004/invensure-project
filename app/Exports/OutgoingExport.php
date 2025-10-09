<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use DB;
class OutgoingExport implements FromCollection, WithHeadings
{
    protected $warehouseId;

    public function __construct($warehouseId)
    {
        $this->warehouseId = $warehouseId;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('outgoing')
            ->where('warehouse_id', $this->warehouseId)
            ->get();
    }
    public function headings(): array
    {
        return ['ID', 'Transaction Date', 'Customer', 'CM Code', 'Item Code', 'Description', 'SKU Description', 'Primary Packaging', 'Secondary Packaging', 'CM Category', 'Prodct Category', 'Variant', 'Production', 'Quantity', 'Kilogram', 'Remarks', 'Approval Status', 'created at', ' updated at'];
    }
}
