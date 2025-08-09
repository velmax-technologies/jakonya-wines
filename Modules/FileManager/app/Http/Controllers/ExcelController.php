<?php

namespace Modules\FileManager\Http\Controllers;

use Maatwebsite\Excel\Row;
use App\Imports\ItemImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
   
    public function import(Row $row) {
        Excel::import(new ItemImport, 'storage/uploads/items.xlsx') ;
    }

    /**
     * Show the specified resource.
     */
     

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
