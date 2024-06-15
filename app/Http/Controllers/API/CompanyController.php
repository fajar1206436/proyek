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
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        // Jika parameter id ada, cari perusahaan berdasarkan id
        if ($id) {
            $company = Company::with('users')->find($id);

            if ($company) {
                return ResponseFormatter::success($company, 'Company found');
            }

            return ResponseFormatter::error('Company not found', 404);
        }

        // Jika parameter name ada, filter perusahaan berdasarkan nama
        $query = Company::with('users');
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        // Paginasi dan kembalikan data perusahaan
        $companies = $query->paginate($limit);
        return ResponseFormatter::success($companies, 'Companies found');
    }
}