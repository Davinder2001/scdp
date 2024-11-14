<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\bulk_import_all;

class bulkImport_Controller extends Controller
{
    public function bulk_import_all_show(){

        return view("Bulk-import.bulk_import_page");
    }
 
    public function bulkimport(Request $request)
    {
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    
                    $res = Excel::import(new bulk_import_all, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Soe budget allocation imported successfully.');
                } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                    $failures = $e->failures();
                    return redirect()->back()->with('import_errors', $failures);
                }
            }
            else{
                return back()->with('error', 'The excel file must be a file of type:xlsx');
            }            
        }
    }
}
