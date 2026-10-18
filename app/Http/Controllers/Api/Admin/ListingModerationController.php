<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingModerationController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::query();

        if ($request->filled('status')) {
            $data = $request->validate([
                'status' => ['required', Rule::in([
                    'pending', 'approved', 'rejected'
                ])],
            ]);

            $query->where('status', $data['status']);
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function updateStatus(Request $request, Listing $listing)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['approved', 'rejected'])],
        ]);

        $listing->update([
            'status' => $data['status'],
        ]);

        return response()->json([
            'message' => 'Status listing berhasil diperbarui.',
            'data' => $listing->fresh(),
        ]);
    }
}
