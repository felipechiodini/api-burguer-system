<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreBanner;
use App\Table\Filter;
use App\Table\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{

    public function index(Request $request)
    {
        $builder = StoreBanner::query()
            ->orderBy('order')
            ->select('id', 'name', 'src');

        $table = Table::make()
            ->setEloquentBuilder($builder)
            ->addColumn('Nome')
            ->addColumn('Imagem')
            ->addFilter(new Filter('name', 'Nome'))
            ->addModifier('src', fn($value) => "https://d2sbwe6sqww2sr.cloudfront.net/$value")
            ->setPerPage($request->per_page)
            ->get();

        return response()
            ->json($table);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required'
        ]);

        $path = Storage::put('banners', $request->file('image'));

        StoreBanner::query()
            ->create([
                'name' => $request->name,
                'src' => $path,
                'order' => StoreBanner::query()->max('order') + 1
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
