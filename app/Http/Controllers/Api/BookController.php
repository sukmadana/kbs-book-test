<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use App\Models\Buku;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bukus = Buku::orderBy('judul', $request->get('sort', 'asc'))
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => BookResource::collection($bukus),
            'pagination' => [
                'total' => $bukus->total(),
                'current_page' => $bukus->currentPage(),
                'per_page' => $bukus->perPage(),
                'last_page' => $bukus->lastPage(),
                'next_page_url' => $bukus->nextPageUrl(),
                'prev_page_url' => $bukus->previousPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|max:255',
            'tahun' => 'required|integer',
            'pengarang_id' => 'required|max:255',
        ]);

        $buku = Buku::create($validated);

        return new BookResource($buku);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);

        return new BookResource($buku);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|max:255',
            'tahun' => 'required|integer',
            'pengarang_id' => 'required|max:255',
        ]);

        $buku->update($validated);

        return new BookResource($buku);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus',
        ], 204);
    }
}
