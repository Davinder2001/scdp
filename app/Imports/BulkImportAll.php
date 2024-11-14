<?php 
namespace App\Imports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BulkImportAll implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new bulk_import_all(),
            new bulk_import_all_second(),
            new bulk_import_all_third(),
        ];
    }
}
