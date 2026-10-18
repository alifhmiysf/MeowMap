<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Validation\Rule;
class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::where('status', 'approved');

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('cat_name', 'like', "%{$search}%")
                  ->orWhere('breed', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' .
                $request->input('location') . '%');
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        return response()->json(
            $query->latest()->paginate(15)
        );
    }

    public function show(Listing $listing)
    {
        abort_unless($listing->status === 'approved', 404);

        return response()->json([
            'data' => $listing->load('user:id,name'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'cat_name' => ['nullable', 'string', 'max:100'],
            'breed' => ['nullable', 'string', 'max:100'],
            'age_months' => ['nullable', 'integer', 'min:0', 'max:360'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'unknown'])],
            'location' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:9999999999'],
        ]);

        $listing = $request->user()->listings()->create($data);

        return response()->json([
            'message' => 'Listing berhasil dibuat dan menunggu moderasi.',
            'data' => $listing,
        ], 201);
    }

    public function update(Request $request, Listing $listing)
    {
        abort_unless($listing->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string', 'max:5000'],
            'cat_name' => ['sometimes', 'nullable', 'string', 'max:100'],
            'breed' => ['sometimes', 'nullable', 'string', 'max:100'],
            'age_months' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:360'],
            'gender' => ['sometimes', 'nullable', Rule::in(['male', 'female', 'unknown'])],
            'location' => ['sometimes', 'required', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric', 'min:0', 'max:9999999999'],
        ]);

        $data['status'] = 'pending';
        $listing->update($data);

        return response()->json([
            'message' => 'Listing diperbarui dan dikirim kembali untuk moderasi.',
            'data' => $listing->fresh(),
        ]);
    }

    public function destroy(Request $request, Listing $listing)
    {
        abort_unless($listing->user_id === $request->user()->id, 403);

        $listing->delete();

        return response()->json([
            'message' => 'Listing berhasil dihapus.',
        ]);
    }
}