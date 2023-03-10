@extends('panel.layouts.app')
@section('content')
    <div class="card">
        <div class="card-header bg-info d-flex flex-grow justify-content-between align-items-center pb-0">
            <h5 class="text-white">Daftar Obat</h5>
            <div class="demo-inline-spacing mb-3">
                <div class="input-group input-group-merge">
                    <span id="search2" class="input-group-text">
                        <i class="bx bx-search"></i>
                    </span>
                    <input
                        type="search"
                        class="form-control"
                        id="search"
                        name="search"
                        placeholder="Search"
                        aria-label="Search"
                        aria-describedby="search2"
                        data-uri="{{ route('home.json.datatables') }}"
                        onkeyup="handleSearchObat(event)"
                    />
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end my-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-menu"></i>&nbsp;Menu
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('home.create') }}" class="dropdown-item">
                                <i class="bx bx-plus-medical"></i>&nbsp;&nbsp;Tambah Obat
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('take-medicine.create') }}" class="dropdown-item" onclick="handleTakeMedicine(event)">
                                <i class="bx bx-layer-plus"></i>&nbsp;&nbsp;Pemakaian Obat
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pembelian-obat.create') }}" class="dropdown-item" onclick="handleUpdateStock(event)">
                                <i class="bx bx-cart"></i>&nbsp;&nbsp;Pembelian Obat
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-borderless" id="table-obat">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Mg (berat)</th>
                            <th>Pabrik</th>
                            <th>Pemakaian (Dosis) / Hari</th>
                            <th>Stok Perhari Ini</th>
                            <th>Minimal Stok</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td colspan="8" class="text-center">Fetching Data</td> 
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-3" id="pagination-obat">
            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', async event => {
            await handleNotification()
            handleObat(`{{ route('home.json.datatables') }}`)

            setInterval(() => {
                if (state.events.modal._element.id === 'modalNotificationObat' || !state.events.modal._isShown) {
                    location.reload()
                }
            }, 50000);
        })

        handleRefresher = async () => {
            await handleNotification()
            const elSearch = document.getElementById('search')
            const uri = `${elSearch.getAttribute('data-uri')}?search=${elSearch.value}`
            handleObat(uri)
        }

        handleObat = url => {
            sendRequest(`GET`, url, {}, true)
            .then(res => {
                if (res.status)
                {
                    const fromPage = res.data.from
                    const response = res.data.data
                    tableJson(`table-obat`, table => {
                        response.forEach((data, i) => {
                            table.insertRow().innerHTML = `
                                <tr class="text-nowrap">
                                    <td>${fromPage + i}</td>
                                    <td>${data.name}</td>
                                    <td>${data.mg}</td>
                                    <td>${data.company}</td>
                                    <td>${data.dosis.name}</td>
                                    <td>${parseFloat(data.stock)}</td>
                                    <td>${parseFloat(data.stock_alert)}</td>
                                    <td>
                                        ${data.stock === 0 
                                            ?  '<span class="badge bg-danger">Stock Habis</span>'
                                            : (`${parseFloat(data.stock) < parseFloat(data.stock_alert) ? '<span class="badge bg-warning">Stock Akan Habis</span>' : '<span class="badge bg-primary">Stock Tersedia</span>'}`)
                                        }
                                    </td>
                                    <td>
                                        <a href="{{ url('/home/${data.id}') }}" onclick="handleShowObat(event)">
                                            <i class="bx bx-show-alt me-1"></i>
                                        </a>
                                        <a href="{{ url('/home/${data.id}/edit') }}">
                                            <i class="bx bx-edit-alt me-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            `
                        })
                    })
                    pagination(`pagination-obat`, res.pagination, url => {
                        handleObat(url)
                    })
                }
            })
            .catch(err => {
                console.log(err.message)
            })
        }

        handleSearchObat = e => {
            const uri = `${e.target.getAttribute('data-uri')}?search=${e.target.value}`
            if (e.keyCode === 13) handleObat(uri)
            else return
        }

        handleShowObat = e => {
            e.preventDefault()
            sendRequest(`GET`, e.target.parentElement.href, {}, false)
            .then(res => {
                setInnerHtml(document.getElementById('app-manipulated-dom'), res)
                modal('modalShowObat')
            })
            .catch(err => {
                console.log(err)
            })
        }

        handleTakeMedicine = e => {
            e.preventDefault()
            sendRequest(`GET`, e.target.href, {}, false)
            .then(res => {
                setInnerHtml(document.getElementById('app-manipulated-dom'), res)
                modal('modalCreateTakeMedicine')
            })
            .catch(err => {
                console.log(err)
            })
        }

        handleUpdateStock = e => {
            e.preventDefault()
            sendRequest(`GET`, e.target.href, {}, false)
            .then(res => {
                setInnerHtml(document.getElementById('app-manipulated-dom'), res)
                modal('modalCreateTakeMedicine')
            })
            .catch(err => {
                console.log(err)
            })
        }

        handleNotification = () => {
            sendRequest(`GET`, `{{ route('notification.index') }}`, {}, true)
            .then(res => {
                if (res.status) {
                    setInnerHtml(document.getElementById('app-manipulated-dom'), res.view)
                    modal('modalNotificationObat')
                }
                else {
                    if (state.events.modal) {
                        modal('modalNotificationObat', 'hide')
                    }
                }
            })
            .catch(err => {
                console.log(err)
            })
        }
    </script>
@endsection