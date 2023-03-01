<?php

namespace App\Http\Controllers\Panel\TakeMedicine;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\MObat;
use App\Models\TrxObat;

class TakeMedicineController extends Controller
{
    public function __construct(
        private $viewsPath = 'panel.pages.take-medicine'
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
            DB::transaction(function() use($request)
            {
                $newStock = $request->input('stock') - $request->input('qtyUsage');
                $trxObat = TrxObat::create([
                    'trx_date'   => $request->input('tanggal'),
                    'obat_id'    => $request->input('obatId'),
                    'name'       => '-',
                    'usage'      => $request->input('qtyUsage'),
                    'last_stock' => $request->input('stock'),
                    'new_stock'  => $newStock,
                    'created_at' => now(),
                    'notes'      => 'Penggunaan Obat'
                ]);

                $obat = MObat::updateOrInsert(
                    ['id' => $request->input('obatId')],
                    [
                        'stock' => $newStock,
                    ]
                );
            });

            return redirect()->route('home.index');
        }
        catch (\Throwable $th)
        {
            dd($th->getMessage());
        }
    }

    public function jsonObat($id)
    {
        try
        {
            $obats = MObat::with('dosis')->find($id);

            return response()->json([
                'status' => true,
                'data'   => $obats
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
