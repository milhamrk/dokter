@extends('layout.master')

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-10">
                <div class="card-title">
                    <h4 class="mb-0">Pemeriksaan</h4>
                </div>
            </div>
            <div class="col-2">
                <select class=" form-select" id="anak" name="anak" data-width="100%">
                    <option value="clear">Pilih Anak</option>
                    @foreach($anak as $anak)

                    <option value="{{$anak->id}}">{{$anak->nama}}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <hr />
        <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-line-tab" data-bs-toggle="tab" href="#home" role="tab"
                    aria-controls="home" aria-selected="true">Fisik</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-line-tab" data-bs-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">Mata</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-line-tab" data-bs-toggle="tab" href="#contact" role="tab"
                    aria-controls="contact" aria-selected="false">Telinga</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="gigi-line-tab" data-bs-toggle="tab" href="#gigi" role="tab"
                    aria-controls="gigi" aria-selected="false">Disabled</a>
            </li>
        </ul>
        <div class="tab-content mt-3" id="lineTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-line-tab">
                <div class="">
                    <table id="table-fisik" class="table table-striped table-bordered " style="width:100%">
                        <thead>
                            <tr class="col-lg-12">
                                <th>id</th>
                                <th style="width: 1px;">no</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Hasil Pemeriksaan</th>

                            </tr>
                        </thead>
                        <tbody class="col-lg-12"></tbody>
                    </table>
                </div>

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-line-tab">
                <div class="">
                    <table id="table-mata" class="table table-striped table-bordered " style="width:100%">
                        <thead>
                            <tr class="col-lg-12">
                                <th>id</th>
                                <th style="width: 1px;">no</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Hasil Pemeriksaan</th>

                            </tr>
                        </thead>
                        <tbody class="col-lg-12"></tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-line-tab">
                <div class="">
                    <table id="table-telinga" class="table table-striped table-bordered " style="width:100%">
                        <thead>
                            <tr class="col-lg-12">
                                <th>id</th>
                                <th style="width: 1px;">no</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Hasil Pemeriksaan</th>

                            </tr>
                        </thead>
                        <tbody class="col-lg-12"></tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="gigi" role="tabpanel" aria-labelledby="disabled-line-tab">...</div>
        </div>
    </div>
</div>

@endsection

@push('after-script')

<script type="text/javascript">
    var tableData;
    var tableDataMata;
    var tableDataTelinga;
    let filter;

    $(document).ready(function () {

        $('#anak').select2({
            placeholder: 'Pilih anak',

        });
        if ($('#anak').val() == 'null') {
            $('#table-fisik').DataTable({
                "oLanguage": {
                    "sEmptyTable": "Silakan pilih anak terlebih dahulu",
                },
            }).clear();
            $('#table-mata').DataTable({
                "oLanguage": {
                    "sEmptyTable": "Silakan pilih anak terlebih dahulu",
                },
            }).clear();
            $('#table-telinga').DataTable({
                "oLanguage": {
                    "sEmptyTable": "Silakan pilih anak terlebih dahulu",
                },
            }).clear();


        } else {
            $('#table-fisik').DataTable({
                "oLanguage": {
                    "sEmptyTable": "Silakan pilih anak terlebih dahulu",
                },
            }).clear();
            $('#table-mata').DataTable({
                "oLanguage": {
                    "sEmptyTable": "Silakan pilih anak terlebih dahulu",
                },
            }).clear();
            $('#table-telinga').DataTable({
                "oLanguage": {
                    "sEmptyTable": "Silakan pilih anak terlebih dahulu",
                },
            }).clear();

        }


        function load_data(anak = '') {
            tableData = $('#table-fisik ').DataTable({
                "oLanguage": {
                    "sEmptyTable": "Silakan pilih anak terlebih dahulu",
                    "zeroRecords": "Data tidak ditemukan",
                },
                processing: true,
                serverSide: true,

                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari",
                    processing: `<div class="spinner-border text-primary" role="status">
                             <span class="visually-hidden">Loading...</span>
                            </div>`
                },
                "searching": true,
                "bPaginate": true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    url: "{{ url('admin/table/data-pemeriksaan-fisik') }}",
                    type: "GET",
                    data: {
                        anak: anak
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        visible: true
                    },

                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        visible: true
                    },
                    {
                        data: 'jam',
                        name: 'jam',
                        visible: true
                    },
                    {
                        data: 'imt',
                        name: 'imt',
                        visible: true
                    },




                ],

            });
            tableDataMata = $('#table-mata').DataTable({
                "oLanguage": {
                    "sEmptyTable": "Silakan pilih anak terlebih dahulu",
                    "zeroRecords": "Data tidak ditemukan",
                },
                processing: true,
                serverSide: true,

                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari",
                    processing: `<div class="spinner-border text-primary" role="status">
                             <span class="visually-hidden">Loading...</span>
                            </div>`
                },
                "searching": true,
                "bPaginate": true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    url: "{{ url('admin/table/data-pemeriksaan-mata') }}",
                    type: "GET",
                    data: {
                        anak: anak
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        visible: true
                    },

                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        visible: true
                    },
                    {
                        data: 'jam',
                        name: 'jam',
                        visible: true
                    },
                    {
                        data: 'soal3',
                        name: 'soal3',
                        visible: true
                    }


                ],

            });
            tableDataTelinga = $('#table-telinga').DataTable({
                "oLanguage": {
                    "sEmptyTable": "Silakan pilih anak terlebih dahulu",
                    "zeroRecords": "Data tidak ditemukan",
                },
                processing: true,
                serverSide: true,

                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari",
                    processing: `<div class="spinner-border text-primary" role="status">
                             <span class="visually-hidden">Loading...</span>
                            </div>`
                },
                "searching": true,
                "bPaginate": true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    url: "{{ url('admin/table/data-pemeriksaan-telinga') }}",
                    type: "GET",
                    data: {
                        anak: anak
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        visible: true
                    },

                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        visible: true
                    },
                    {
                        data: 'jam',
                        name: 'jam',
                        visible: true
                    },
                    {
                        data: 'soal3',
                        name: 'soal3',
                        visible: true
                    }


                ],

            });
        }

        $('#anak').change(function () {
            var anak = $(this).val();

            if (anak) {
                $('#table-fisik').DataTable().clear().destroy();
                $('#table-mata').DataTable().clear().destroy();
                $('#table-telinga').DataTable().clear().destroy();

                load_data(anak);
            } else {
                $('#table-fisik').DataTable().clear().destroy();
                $('#table-mata').DataTable().clear().destroy();
                $('#table-telinga').DataTable().clear().destroy();

            }
        });



    })

</script>
@endpush
