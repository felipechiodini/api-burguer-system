<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreCustomer;
use App\Rules\Cellphone;
use App\Rules\Document;
use App\Rules\Name;
use App\Table\Table;
use App\Types\Cellphone as TypesCellphone;
use App\Types\Document as TypesDocument;
use App\Types\Name as TypesName;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $builder = StoreCustomer::query()
            ->select('id', 'name', 'cellphone', 'document');

        $table = Table::make()
            ->setEloquentBuilder($builder)
            ->addColumn('Nome')
            ->addColumn('Documento')
            ->addColumn('Celular')
            ->addModifier('document', fn($value) => TypesDocument::format($value))
            ->addModifier('cellphone', fn($value) => TypesCellphone::format($value))
            ->setPerPage($request->per_page)
            ->get();

        return response()
            ->json($table);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', new Name],
            'document' => ['string', new Document],
            'cellphone' => ['required', new Cellphone],
        ]);

        $customer = StoreCustomer::query()
            ->create([
                'name' => new TypesName($request->name),
                'document' => new TypesDocument($request->document),
                'cellphone' => new TypesCellphone($request->cellphone)
            ]);

        return response()
            ->json([
                'message' => 'Cliente cadastrado com sucesso',
                'customer' => $customer
            ]);
    }

    public function destroy()
    {
        //
    }
}
