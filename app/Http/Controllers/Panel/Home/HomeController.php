<?php

namespace App\Http\Controllers\Panel\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\MObat;
use App\Models\MDosis;
use App\Http\Requests\ObatRequest;

class HomeController extends Controller
{
    public function __construct(
        private $viewsPath = 'panel.pages.home'
    )
    {}

    public function index()
    {
        try
        {
            return view("{$this->viewsPath}.index");
        }
        catch (\Throwable $th)
        {
            abort(500, $th->getMessage());
        }
    }

    public function create()
    {
        try
        {
            $dosis = MDosis::select('id', 'name')->get();

            return view("{$this->viewsPath}.create", [
                'dosis' => $dosis
            ]);
        }
        catch (\Throwable $th)
        {
            abort(500, $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try
        {
            $obat = MObat::create([
                'name'        => $request->input('namaObat'),
                'mg'          => $request->input('mg'),
                'company'     => $request->input('company'),
                'dosis_id'    => $request->input('dosisId'),
                'stock'       => $request->input('stock'),
                'stock_alert' => $request->input('stockAlert')
            ]);

            return redirect()->route('home.index');
        }
        catch (\Throwable $th)
        {
            dd($request->all());
        }
    }

    public function show($id)
    {
        try
        {
            $obat = MObat::with('dosis', 'trxObat')
                ->orderBy('id', 'desc')
            ->find($id);
            
            return view("{$this->viewsPath}._show", [
                'obat' => $obat
            ]);
        }
        catch (\Throwable $th)
        {
            abort(500, $th->getMessage());
        }
    }

    public function edit($id)
    {
        try
        {
            $obat = MObat::find($id);
            $dosis = MDosis::select('id', 'name')->get();

            return view("{$this->viewsPath}.edit", [
                'obat'  => $obat,
                'dosis' => $dosis
            ]);
        }
        catch (\Throwable $th)
        {
            abort(500, $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try
        {
            $obat = MObat::updateOrInsert(
                ['id' => $id],
                [
                    'name'     => $request->input('namaObat'),
                    'mg'       => $request->input('mg'),
                    'company'  => $request->input('company'),
                    'dosis_id' => $request->input('dosisId')
                ]
            );

            // $trxObat = TrxObat::create([
            //     'trx_date'   => $request->input('tanggal'),
            //     'obat_id'    => $id,
            //     'name'       => $request->input('namaObat'),
            //     'usage'      => 0,
            //     'last_stock' => $request->input('stock'),
            //     'new_stock'  => $request->input('stock'),
            //     'notes'      => 'Update Stok Barang',
            //     'created_at' => now()
            // ]);

            return redirect()->route('home.index');
        }
        catch (\Throwable $th)
        {
            dd($request->all());
        }
    }

    public function datatables(Request $request)
    {
        try
        {
            $obat = MObat::with('dosis')
                ->search($request->search)
                ->paginate(10)
                ->onEachSide(1)
            ->withQueryString();

            return response()->json([
                'status' => true,
                'data' => $obat,
                'pagination' => (string)$obat->links()
            ]);
        }
        catch (\Throwable $th)
        {
            dd($th->getMessage());
        }
    }
}
