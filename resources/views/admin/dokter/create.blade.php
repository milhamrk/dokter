@extends('layout.master')

@section('content')
@if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Tambah Dokter</h6>
                <form action="{{ route('dokter.store') }}" class="forms-sample" id="dokter-store" method="post" nctype="multipart/form-data" files=true >
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="userPassword" autocomplete="current-password" placeholder="Password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">
                          Show Password
                        </label>
                      </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" autocomplete="off"
                            placeholder="NIK">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" autocomplete="off"
                            placeholder="Nama">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wilayah</label>
                        <select class="js-example-basic-single form-select" name="kecamatan" data-width="100%">
                            <option selected disabled class="mb-2" value=" ">Pilih Kecamatan</option>
                            @foreach(\App\Models\Kecamatan::get() as $value => $key)
                            <option class="mb-2" value="{{$key->id}}">{{$key->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="col-md-12 mb-2"> Jenis Kelamin </label>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" value="laki-laki" name="jenis_kelamin"
                                id="radioInline">
                            <label class="form-check-label" for="radioInline">
                                Laki-Laki
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" value="perempuan" class="form-check-input" name="jenis_kelamin"
                                id="radioInline1">
                            <label class="form-check-label" for="radioInline1">
                                Perempuan
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" autocomplete="off"
                            placeholder="Tempat Lahir">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal_lahir" autocomplete="off"
                            placeholder="Tempat Lahir">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">No Hp</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" autocomplete="off"
                            placeholder="Tempat Lahir">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">No Str</label>
                        <input type="text" class="form-control" id="no_str" name="no_str" autocomplete="off"
                            placeholder="no_str">
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#exampleCheck1').click(function(){
			if($(this).is(':checked')){
				$('#userPassword').attr('type','text');
			}else{
				$('#userPassword').attr('type','password');
			}
		});
	});
      
   

</script>
@endpush
