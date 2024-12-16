<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pengarang;
use App\Http\Resources\AuthorResource;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengarangs = Pengarang::paginate(10);

        return response()->json([
            'success' => true,
            'data' => AuthorResource::collection($pengarangs),
            'pagination' => [
                'total' => $pengarangs->total(),
                'current_page' => $pengarangs->currentPage(),
                'per_page' => $pengarangs->perPage(),
                'last_page' => $pengarangs->lastPage(),
                'next_page_url' => $pengarangs->nextPageUrl(),
                'prev_page_url' => $pengarangs->previousPageUrl(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:250'
        ]);

        $data = Pengarang::create($validated);

        return new AuthorResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Pengarang::findOrFail($id);

        return new AuthorResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $author = Pengarang::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string'
        ]);

        $data = $author->update($validated);

        return new AuthorResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Pengarang::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus',
        ], 204);
    }
}
