<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use DB;
class AuditExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('audits')
            ->get();
    }
    public function headings(): array
    {
        return ['ID', 'User Type', 'User ID', 'Event', 'Auditable Type', 'Auditable ID', 'Old Values', 'New Values', 'URL', 'IP Address', 'User Agent', 'Tags', 'Created At', 'Updated At'];
    }
}
