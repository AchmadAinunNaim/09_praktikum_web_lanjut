<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        $posts = Mahasiswa::query()
            ->where('Nama', 'LIKE', "%$search%")
            ->paginate(5);

        return view('mahasiswas.index', compact('posts'));        
    }
}
