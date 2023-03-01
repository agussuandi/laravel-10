<div class="modal fade" id="modalCreateTakeMedicine" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateTakeMedicineTitle">Pemakaian Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('take-medicine.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="obatId" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" readonly value="{{ date('Y-m-d') }}" />
                    </div>
                    <div class="mb-3">
                        <label for="obatId" class="form-label">Obat</label>
                        <select name="obatId" id="obatId" class="form-select" onchange="handleObat(this)" required>
                            <option value="" disabled selected>-- Pilih Obat --</option>
                            @foreach ($obats as $key => $obat)
                                <option value="{{ $obat->id }}" data-uri="{{ route('take-medicine.obat', $obat->id) }}">{{ $obat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mg" class="form-label">Mg (berat)</label>
                        <input type="text" class="form-control" id="mg" name="mg" placeholder="Masukan berat obat" required autocomplete="off" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')" readonly />
                    </div>
                    <div class="mb-3">
                        <label for="company" class="form-label">Pabrik</label>
                        <input type="text" class="form-control" id="company" placeholder="Masukan pabrik pembuat obat" required autocomplete="off" maxlength="220" readonly />
                    </div>
                    <div class="mb-3">
                        <label for="dosisId" class="form-label">Pemakaian (Dosis) Perhari</label>
                        <input type="text" class="form-control" id="dosisId" placeholder="Masukan perhari" required autocomplete="off" maxlength="220" readonly />
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="text" class="form-control" id="stock" name="stock" placeholder="Masukan stok obat" required autocomplete="off" maxlength="5" readonly oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')" />
                    </div>
                    <div class="mb-3">
                        <label for="stockAlert" class="form-label">Minimal Stok</label>
                        <input type="text" class="form-control" id="stockAlert" name="stockAlert" placeholder="Masukan stok peringatan" required autocomplete="off" maxlength="5" readonly oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')" />
                        <div id="floatingInputHelp" class="form-text text-black">Column ini digunakan untuk mengirimkan notifikasi jika Stok Obat sudah melawati Minimal Stok.</div>  
                    </div>
                    <hr />
                    <div class="mb-3">
                        <label for="qtyUsage" class="form-label">Jumlah Pemakaian</label>
                        <input type="text" class="form-control" id="qtyUsage" name="qtyUsage" placeholder="Masukan jumlah pemakaian" required autocomplete="off" maxlength="5" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')" onkeyup="handleJumlahPemakaian(this)" />
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    handleObat = obj => {
        sendRequest(`GET`, obj.options[obj.selectedIndex].getAttribute('data-uri'), {}, true)
        .then(res => {
            const elMg         = document.getElementById('mg')
            const elCompany    = document.getElementById('company')
            const elStock      = document.getElementById('stock')
            const elStockAlert = document.getElementById('stockAlert')
            const elDosis      = document.getElementById('dosisId')

            elMg.value         = res.data.mg
            elCompany.value    = res.data.company
            elStock.value      = res.data.stock
            elStockAlert.value = res.data.stock_alert
            elDosis.value      = res.data.dosis.name
        })
        .catch(err => {
            console.log(err)
        })
    }

    handleJumlahPemakaian = obj => {
        const elStock = document.getElementById('stock')

        if (parseInt(obj.value) > parseInt(elStock.value)) {
            alert(`Jumlah pemakaian melebih batas stok`)
            obj.value = ''
        }
    }
</script>