<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use DB;
class IncomingExport implements FromCollection, WithHeadings
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
        return DB::table('incoming')
        ->where('warehouse_id', $this->warehouseId)
            ->get();
    }
    public function headings(): array
    {
        return ['ID', 'Data Entry', 'Item Code', 'Item Group', 'Variant', 'Kilogram/Tray', 'Class', 'SKU', 'FG', 'Primary Packaging', 'Secondary Packaging', 'Prod. Date', 'Left', 'Expiry Date', 'Status', 'Storage Num', 'Inventory Head', 'Inventory Kilo', 'Received By', 'Issue Head', 'Issue Kilo', 'Balance Head', 'Balance Kilo', 'Created At', 'Updated At'];
    }
}
