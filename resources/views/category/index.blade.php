@extends('layouts.whole')
@section('title','Category')
@section('content')

<div class="row"> 
    <div class="col-sm-12 mt-2">
        <div class="card">            
            <div class="card-body">
                <!-- MULAI TOMBOL TAMBAH -->
                <a href="javascript:void(0)" class="btn btn-outline-info btn-sm" id="tombol-tambah"><i class="fa fa-plus"></i> Add Category</a>
                <button class="btn btn-sm btn-danger d-none" id="deleteAll"> Hapus Semua</button>
                <br><br>
                <!-- AKHIR TOMBOL -->
                <!-- MULAI TABLE -->
                <table class="table table-striped table-bordered table-sm" id="table_kategori">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="main_checkbox"><label></label></th>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
                <!-- AKHIR TABLE -->
            </div>
        </div>

        <!-- MULAI MODAL FORM TAMBAH/EDIT-->
        <div class="modal fade" id="tambah-edit-modal" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-judul"></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                            <div class="row">
                                <div class="col-sm-12">

                                    <input type="hidden" name="id" id="id">

                                    <div class="form-group">
                                        <label for="name" class="col-sm-12 control-label">Nama Kategori</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="" required>
                                            @error('nama_kategori')
                                                <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-offset-2 col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan"
                                        value="create">Simpan
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <!-- AKHIR MODAL -->

        <!-- MULAI MODAL KONFIRMASI DELETE-->
        <div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi-modal" data-backdrop="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color: red";>PERHATIAN!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jika menghapus data ini, maka data tersebut hilang selamanya, apakah anda yakin?</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" name="tombol-hapus" id="tombol-hapus">Ya, hapus</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- AKHIR MODAL KONFIRMASI DELETE-->

    </div>  
</div>

@endsection

@section('script')

<!-- JAVASCRIPT -->
<script>
    //CSRF TOKEN PADA HEADER
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    //TOMBOL TAMBAH DATA
    $('#tombol-tambah').click(function () {
        $('#button-simpan').val("create-post");
        $('#id').val('');
        $('#form-tambah-edit').trigger("reset");
        $('#modal-judul').html("Tambah Kategori Baru");
        $('#tambah-edit-modal').modal('show');
    });

    // DATATABLE
    $(document).ready(function () {
        $('#table_kategori').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('data-kategori.index') }}",
                type: 'GET'
            },
            language: {
                "infoFiltered":"",
                "processing": '<img src="{{ URL::asset('template/images/loading2.gif')}}" style="padding:0px; width: 30%;">',
                "searchPlaceholder": "",
            },
            columns: [
                {data: 'checkbox',name: 'checkbox', orderable:false, searchable:false},
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },                
                {data: 'nama_kategori',name: 'nama_kategori'},
                {data: 'action',name: 'action', orderable:false, searchable:false},
            ],
            order: [
                [0, 'asc']
            ]
        });
    });

    // TOMBOL TAMBAH
    if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan').val();
                $('#tombol-simpan').html('Sending..');

                $.ajax({
                    data: $('#form-tambah-edit').serialize(), 
                    url: "{{ route('data-kategori.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Simpan');
                        var oTable = $('#table_kategori').dataTable();
                        oTable.fnDraw(false);
                        iziToast.success({
                            title: 'Data Berhasil Disimpan',
                            message: '{{ Session(' success ')}}',
                            position: 'bottomRight'
                        });
                    },
                    error: function (data) {
                        $('#tambah-edit-modal').modal('hide');
                        iziToast.error({
                            title: 'Data Gagal Disimpan',
                            message: '{{ Session(' message ')}}',
                            position: 'bottomRight'
                        });
                    }
                });
            }
        })
    }

    // EDIT DATA
    $('body').on('click', '.edit-post', function () {
        var data_id = $(this).data('id');
        $.get('data-kategori/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit Post");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#nama_kategori').val(data.nama_kategori);
        })
    });

    // TOMBOL DELETE
    $(document).on('click', '.delete', function () {
        dataId = $(this).attr('id');
        $('#konfirmasi-modal').modal('show');
    });

    $('#tombol-hapus').click(function () {
        $.ajax({

            url: "data-kategori/" + dataId,
            type: 'delete',
            beforeSend: function () {
                $('#tombol-hapus').text('Hapus Data');
            },
            success: function (data) {
                setTimeout(function () {
                    $('#konfirmasi-modal').modal('hide');
                    var oTable = $('#table_kategori').dataTable();
                    oTable.fnDraw(false);
                });
                iziToast.warning({
                    title: 'Data Berhasil Dihapus',
                    message: '{{ Session('delete')}}',
                    position: 'bottomRight'
                });
            },
            error: function (data) {
                $('#konfirmasi-modal').modal('hide');
                iziToast.error({
                    title: 'Data Gagal Dihapus',
                    message: '{{ Session('delete')}}',
                    position: 'bottomRight'
                });
            }
        })
    });

    $(document).on('click','input[name="main_checkbox"]', function(){
        if(this.checked){
            $('input[name="kategori_checkbox"]').each(function(){
                this.checked = true;
            });
        }else{
            $('input[name="kategori_checkbox"]').each(function(){
                this.checked = false;
            });
        }
        toggledeleteAll();
    });

    $(document).on('change','input[name="kategori_checkbox"]', function(){
        if($('input[name="kategori_checkbox"]').length == $('input[name="kategori_checkbox"]:checked').length){
            $('input[name="main_checkbox"]').prop('checked', true);
        }else{
            $('input[name="main_checkbox"]').prop('checked', false);
        }
        toggledeleteAll();
    });

    function toggledeleteAll(){
        if($('input[name="kategori_checkbox"]:checked').length > 0){
            $('button#deleteAll').text('Delete ('+$('input[name="kategori_checkbox"]:checked').length+')').removeClass('d-none');
        }else{
            $('button#deleteAll').addClass('d-none');
        }
    }

    $(document).on('click','button#deleteAll', function(){
        var checkedKategori = [];
        $('input[name="kategori_checkbox"]:checked').each(function(){
            checkedKategori.push($(this).data('id'));
        });
        var url = '{{ route("deleteSelectedKategori") }}';
        if(checkedKategori.length > 0){
            swal({
                title: 'Are you sure?',
                html: 'You want to delete <b>('+checkedKategori.length+')</b> kategori',
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#556ee6',
                cancelButtonColor: '#d33',
                width: 500,
                allowOutsideClick:false
            }).then(function(result){
                // alert(checkedKategori)
                if(checkedKategori != null){
                    $.post(url,{id:checkedKategori}, function(data){
                    }).done(function(data) {
                        $('#table_kategori').DataTable().ajax.reload(null, true);
                        $('button#deleteAll').addClass('d-none');
                        switch (data.msg) {
                        case "berhasil":
                            iziToast.success({
                                title: 'Data Kategori Berhasil Dihapus',
                                position: 'bottomRight'
                            });
                            break;
                        case "gagal":
                            iziToast.error({
                                title: 'Gagal! Data ini masih digunakan!',
                                position: 'bottomRight'
                            });
                            break;
                        case "info":
                            iziToast.warning({
                                title: 'Warning! Beberapa data tidak berhasil dihapus karena masih digunakan!',
                                position: 'bottomRight'
                            });
                            break;
                        }
                    });
                }
            })
        }
    });

</script>

<!-- JAVASCRIPT -->

@endsection
