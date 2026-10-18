<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatSpotting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
class CatSpottingModerationController extends Controller
{
    public function index(Request $request): JsonResponse
{
    $request->validate([
        'status' => ['sometimes', 'required', 'in:pending,approved,rejected'],
    ]);

    $query = CatSpotting::query()
        ->with('user:id,name,email')
        ->latest();

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    return response()->json($query->paginate(10));
}

    public function updateStatus(
        Request $request,
        CatSpotting $catSpotting
    ) {
        $data = $request->validate([
            'status' => ['required', Rule::in(['approved', 'rejected'])],
        ]);

        $catSpotting->update([
            'status' => $data['status'],
        ]);

        return response()->json([
            'message' => 'Status laporan berhasil diperbarui.',
            'data' => $catSpotting->fresh(),
        ]);
    }
}