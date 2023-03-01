<div class="modal fade" id="modalNotificationObat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNotificationObatTitle">Notifikasi Stok Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Mg (berat)</th>
                                <th>Pabrik</th>
                                <th>Pemakaian (Dosis) / Hari</th>
                                <th>Stok Perhari Ini</th>
                                <th>Minimal Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obats as $key => $obat)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $obat->name }}</td>
                                    <td>{{ $obat->mg }}</td>
                                    <td>{{ $obat->company }}</td>
                                    <td>{{ $obat->dosis->name }}</td>
                                    <td>{{ $obat->stock }}</td>
                                    <td>{{ $obat->stock_alert }}</td>
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
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Data Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>