<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kategori;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
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
        $kategoris = Kategori::paginate(10);

        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection($kategoris),
            'pagination' => [
                'total' => $kategoris->total(),
                'current_page' => $kategoris->currentPage(),
                'per_page' => $kategoris->perPage(),
                'last_page' => $kategoris->lastPage(),
                'next_page_url' => $kategoris->nextPageUrl(),
                'prev_page_url' => $kategoris->previousPageUrl(),
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

        $data = Kategori::create($validated);

        return new CategoryResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Kategori::findOrFail($id);

        return new CategoryResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string'
        ]);

        $data = $category->update($validated);

        return new CategoryResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Kategori::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus',
        ], 204);
    }
}
