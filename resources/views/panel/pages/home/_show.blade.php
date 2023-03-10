<div class="modal fade" id="modalShowObat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalShowObatTitle">Obat {{ $obat->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td class="w-24 fw-bold">Nama Obat</td>
                                <td class="w-2 fw-bold">:</td>
                                <td class="w-24">{{ $obat->name }}</td>
                                <td class="w-24 fw-bold">Stok</td>
                                <td class="w-2 fw-bold">:</td>
                                <td class="w-24">{{ (float)$obat->stock }}</td>
                            </tr>
                            <tr>
                                <td class="w-24 fw-bold">Pabrik</td>
                                <td class="w-2 fw-bold">:</td>
                                <td class="w-24">{{ $obat->company }}</td>
                                <td class="w-24 fw-bold">Pemakaian / Hari</td>
                                <td class="w-2 fw-bold">:</td>
                                <td class="w-24">{{ $obat->dosis->name }}</td>
                            </tr>
                            <tr>
                                <td class="w-24 fw-bold">Mg (berat)</td>
                                <td class="w-2 fw-bold">:</td>
                                <td class="w-24">{{ $obat->mg }}</td>
                                <td class="w-24 fw-bold">Minimal Stok</td>
                                <td class="w-2 fw-bold">:</td>
                                <td class="w-24">{{ (float)$obat->stock_alert }}</td>
                            </tr>
                            <tr>
                                <td class="w-24 fw-bold" valign="top">Status</td>
                                <td class="w-2 fw-bold" valign="top">:</td>
                                <td class="w-24" valign="top">
                                    {!! $obat->stock === 0
                                        ? '<span class="badge bg-danger">Stock Habis</span>'
                                        : ($obat->stock < $obat->stock_alert 
                                            ? '<span class="badge bg-warning">Stock Akan Habis</span>' 
                                            : '<span class="badge bg-primary">Stock Tersedia</span>'
                                          )
                                    !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h5 class="fw-bold">Riwayat</h5>
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Stok Terakhir</th>
                                <th>Pemakaian (Dosis) / Pembelian</th>
                                <th>Stok Terbaru</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obat->trxObat as $key => $trx)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $trx->created_at }}</td>
                                    <td>{{ (float)$trx->last_stock }}</td>
                                    <td>{{ (float)$trx->usage }}</td>
                                    <td>{{ (float)$trx->new_stock }}</td>
                                    <td>{{ $trx->notes }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>