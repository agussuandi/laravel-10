<?php

namespace App\Http\Controllers\Panel\PembelianObat;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\MObat;
use App\Models\TrxObat;

class PembelianObatController extends Controller
{
    public function __construct(
        private $viewsPath = 'panel.pages.pembelian-obat'
    )
    {}

    public function create()
    {
        try
        {
            $obats = MObat::select('id', 'name')->get();

            return view("{$this->viewsPath}._create", [
                'obats' => $obats
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
            $newStock = $request->input('stock') + $request->input('qtyUsage');
            $obat = MObat::updateOrInsert(
                ['id' => $request->input('obatId')],
                [
                    'stock' => $newStock,
                ]
            );

            $trxObat = TrxObat::create([
                'trx_date'   => today(),
                'obat_id'    => $request->input('obatId'),
                'name'       => '-',
                'usage'      => $request->input('qtyUsage'),
                'last_stock' => $request->input('stock'),
                'new_stock'  => $newStock,
                'created_at' => now(),
                'notes'      => 'Pembelian obat'
            ]);

            return redirect()->route('home.index');
        }
        catch (\Throwable $th)
        {
            dd($request->all());
        }
    }
}
