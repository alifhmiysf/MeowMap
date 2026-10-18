<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Breed;
use Illuminate\Http\Request;


class BreedController extends Controller
{
    public function index(Request $request)
    {
        $query = Breed::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return response()->json(
            $query->orderBy('name')->paginate(15)
        );
    }

    public function show(Breed $breed)
    {
        return response()->json(['data' => $breed]);
    }
}