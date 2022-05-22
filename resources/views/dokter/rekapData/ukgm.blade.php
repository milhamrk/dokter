@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Rekap Data Pasien</a></li>
            <li class="breadcrumb-item active" aria-current="page">UKGM</li>
        </ol>
    </nav>
<div class="card">
    <div class="card-body">
        <h6 class="card-title">REKAP DATA PER WILAYAH</h6>
        <p class="text-muted mb-3">Masukkan wilayah yang ingin ditampilkan datanya</p>
        <form class="forms-sample">
        <div class="row">
            <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Wilayah Kelurahan</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="option-data-kelurahan">
                                <option selected disabled>Pilih Kelurahan</option>
                                <option>12-18</option>
                                <option>18-22</option>
                                <option>22-30</option>
                                <option>30-60</option>
                                <option>Above 60</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Posyandu</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="option-data-posyandu">
                                <option selected disabled>Pilih Posyandu</option>
                                <option>Seruni</option>
                                <option>18-22</option>
                                <option>22-30</option>
                                <option>30-60</option>
                                <option>Above 60</option>
                            </select>
                        </div>
                    </div>
                
            </div>
            </form>
            <div class="col-md-6" id="nama-posyandu" style="display: none;">
                <div class="card border-primary">
                    <div class="card-body">
                    Seruni
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <p class="text-muted mb-3" id="text-tabel-pasien">Berikut merupakan tabel seluruh pasien gigi</p>
        <div class="table-responsive">
            <table id="dataTableExample" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Nama Posyandu</th>
                        <th>Usia</th>
                        <th>Status Skrining</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Abdi</td>
                        <td>Laki-laki</td>
                        <td>Seruni</td>
                        <td>7 bulan</td>
                        <td>Sudah <span class="text-muted">(19/02/2022)</i></td>
                        <td><a href="{{route('dokter.rekapDetailUKGM')}}" class="btn btn-primary btn-icon-text btn-xs" role="button">Lihat Rekap<i class="btn-icon-append" data-feather="book-open"></i></a> <a class="btn btn-info btn-icon btn-xs text-white" id="serun" href="#" role="button"><i class="mdi mdi-tooth"></i></a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Alzio</td>
                        <td>Laki-laki</td>
                        <td>Seruni</td>
                        <td>2 tahun 1 bulan</td>
                        <td>Sudah <span class="text-muted">(03/02/2022)</i></td>
                        <td><a href="{{route('dokter.rekapDetailUKGM')}}" class="btn btn-primary btn-icon-text btn-xs" role="button">Lihat Rekap<i class="btn-icon-append" data-feather="book-open"></i></a> <a class="btn btn-info btn-icon btn-xs text-white" id="serun" href="#" role="button"><i class="mdi mdi-tooth"></i></a></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Adisty Sahida</td>
                        <td>Perempuan</td>
                        <td>Seruni</td>
                        <td>1 tahun 6 bulan</td>
                        <td>Sudah <span class="text-muted">(02/03/2022)</i></td>
                        <td><a href="{{route('dokter.rekapDetailUKGM')}}" class="btn btn-primary btn-icon-text btn-xs" role="button">Lihat Rekap<i class="btn-icon-append" data-feather="book-open"></i></a> <a class="btn btn-info btn-icon btn-xs text-white" id="serun" href="#" role="button"><i class="mdi mdi-tooth"></i></a></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Asraf</td>
                        <td>Laki-laki</td>
                        <td>Melati</td>
                        <td>8 bulan</td>
                        <td>Sudah <span class="text-muted">(02/02/2022)</i></td>
                        <td><a href="{{route('dokter.rekapDetailUKGM')}}" class="btn btn-primary btn-icon-text btn-xs" role="button">Lihat Rekap<i class="btn-icon-append" data-feather="book-open"></i></a> <a class="btn btn-info btn-icon btn-xs text-white" id="serun" href="#" role="button"><i class="mdi mdi-tooth"></i></a></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Shafnaz</td>
                        <td>Perempuan</td>
                        <td>Seruni</td>
                        <td>3 tahun</td>
                        <td>Sudah <span class="text-muted">(22/02/2022)</i></td>
                        <td><a href="{{route('dokter.rekapDetailUKGM')}}" class="btn btn-primary btn-icon-text btn-xs" role="button">Lihat Rekap<i class="btn-icon-append" data-feather="book-open"></i></a> <a class="btn btn-info btn-icon btn-xs text-white" id="serun" href="#" role="button"><i class="mdi mdi-tooth"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection

@push('after-script')

<script  type="text/javascript"> 
var tableData;

$(document).ready(function () {
        tableData = $('#table-dokter').DataTable({
            processing: true,
			serverSide: true,
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari"
            },
			"searching": true,
            "bPaginate": true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ url('admin/table/data-dokter') }}",
                type: "GET",
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    visible: false
                },
				{
					data: 'DT_RowIndex', name:'DT_RowIndex', visible:true
				},

                {
                    data: 'nik',
                    name: 'nik',
                    visible: true
                },
                {
                    data: 'nama',
                    name: 'nama',
                    visible: true
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin',
                    visible: true
                },
                 { data: 'action', name:'action', visible:true},

            ],

        });
        $('#table-dokter tbody').on( 'click', '#btn-delete', function () {
        var data = tableData.row( $(this).parents('tr') ).data();
       Swal.fire({
            title: 'Harap Konfirmasi',
            text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjutkan'
        }).then((willDelete) => {
          if (willDelete.isConfirmed) {
            $.ajax({
              url: "{{ url('delete/dokter') }}"+"/"+data['id'],
              method: 'get',
              success: function(result){
                tableData.ajax.reload();
                Swal.fire(
                'Hapus',
                  'Data Berhasil di hapus.',
                 'success'
                 )
              }

            });
          }
        });
      });


})
$("#option-data-kelurahan").change(function() {
    var id = $(this).children(":selected").attr("id");
    $('#text-tabel-pasien').text("Berikut merupakan tabel seluruh pasien gigi di Kelurahan ");
});

$("#option-data-posyandu").change(function() {
    //var id = $(this).children(":selected").attr("id");
    $('#nama-posyandu').show();
    $('#text-tabel-pasien').text("Berikut merupakan tabel seluruh pasien gigi di Kelurahan-Posyandu");
});
</script>

@endpush