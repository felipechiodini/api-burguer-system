<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{

    public function index(Request $request)
    {
        $page = StoreBanner::query()
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'start' => 'date',
            'end' => 'date'
        ]);

        $path = Storage::put('banners', $request->file('image'));

        StoreBanner::query()
            ->create([
                'name' => $request->name,
                'src' => $path
            ]);

        return response()
            ->json(['message' => 'Banner criado com sucesso!']);
    }

    public function destroy(StoreBanner $banner)
    {
        Storage::delete($banner->src);

        $banner->delete();

        return response()
            ->json(['message' => 'Banner deletado com sucesso!']);
    }
}
