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
        $table = Table::make()
            ->setQuery(StoreCustomer::query())
            ->addColumn('name', 'Nome', fn($value) => (new TypesName($value))->__toString())
            ->addColumn('document', 'Documento', fn($value) => (new TypesDocument($value))->getFormated())
            ->addColumn('cellphone', 'Telefone', fn($value) => (new TypesCellphone($value))->getFormated())
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
