<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Helpers\ResponseFormatter;

class CompanyController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $name =$request->input('name');
        $limit = $request->input('limit', 10);

        
        if ($id) {     
            $company = Company::with(['users'])->find($id);

            if ($company)
            {
                return ResponFormatter::succes($company, 'Company found');
            }

            return ResponFormatter::error('Company not found', 404);
        }

        $companies = Company::with(['users']);

        if ($name) {
            $companies->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success(
            $companies->paginate($limit),
            'Companies found'
        );
    }
}
