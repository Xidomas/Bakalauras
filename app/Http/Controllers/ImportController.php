<?php

namespace App\Http\Controllers;

use App\rentOffer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ImportController extends Controller
{

    public function importRentOffer()
    {
        return view('/vendor/voyager/importRentOffer');
    }

    public function handleImportRentOffer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }
        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = array_shift($rows);
        foreach ($rows as $row){
            $row = array_combine($header,$row);
            rentOffer::create([
                'name' => $row['name'],
                'slug' => $row['slug'],
                'year' => $row['year'],
                'category_id' => $row['category_id'],
                'details' => $row['details'],
                'price' => $row['price'],
                'description' => $row['description'],
                'town_id' => $row['town_id'],
                'featured' => $row['featured'],
                'quantity' => $row['quantity'],
                'vendor_id' => $row['vendor_id']
            ]);
        }
        return redirect()->back();
    }
}