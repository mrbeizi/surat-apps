@extends('layouts.whole')
@section('title','Inbox')
@section('content')

<div class="row"> 
    <div class="col-sm-12 mt-2">
        <div class="card">            
            <div class="card-body">
                <!-- MULAI TOMBOL TAMBAH -->
                <a href="javascript:void(0)" class="btn btn-outline-info btn-sm" id="tombol-tambah"><i class="fa fa-plus"></i> Tambah Surat</a>
                <br><br>
                <!-- AKHIR TOMBOL -->
                <!-- MULAI TABLE -->
                <table class="table table-striped table-bordered table-sm" id="table_inbox">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>TGL Surat</th>
                        <th>Judul</th>
                        <th>No Surat</th>
                        <th>Kategori</th>
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
                                        <label class="control-label col-sm-12" for="tgl_surat">Tanggal Surat</label>
                                        <div class="col-sm-12">
                                            <input class="form-control form-control-sm tanggal" data-date-format="yyyy-mm-dd" name="tgl_surat" placeholder="yyyy-mm-dd" type="text"/>
                                            <span class="text-danger" id="tglsuratErrorMsg"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="col-sm-12 control-label">Judul Surat</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="title" name="title" value="">
                                            <span class="text-danger" id="titleErrorMsg"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="col-sm-12 control-label">No Surat</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="no_surat" name="no_surat" value="">
                                            <span class="text-danger" id="nosuratErrorMsg"></span>
                                        </div>
                                    </div>
                                    

                                    <div class="form-group">
                                        <label for="id_kategori" class="col-sm-12 control-label">Kategori</label>
                                        <div class="col-sm-12">
                                            <select name="id_kategori" id="id_kategori" class="form-control">
                                                <option value="" readonly>- Pilih-</option>                                   
                                                @foreach($datas as $item)                                 
                                                <option value="{{$item->id}}">{{$item->nama_kategori}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="kategoriErrorMsg"></span>
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
        $('#modal-judul').html("Tambah Surat");
        $('#tambah-edit-modal').modal('show');
    });

    // DATATABLE
    $(document).ready(function () {
        $('#table_inbox').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('data-inbox.index') }}",
                type: 'GET'
            },
            language: {
                "infoFiltered":"",
                "processing": '<img src="{{ URL::asset('template/images/loading2.gif')}}" style="padding:0px; width: 30%;">',
                "searchPlaceholder": "",
            },
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'tgl_surat',name: 'tgl_surat'},
                {data: 'title',name: 'title'},
                {data: 'no_surat',name: 'no_surat'},
                {data: 'nama_kategori',name: 'nama_kategori'},
                {data: 'action',name: 'action'},
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
                    url: "{{ route('data-inbox.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#table_inbox').DataTable().ajax.reload(null, true);
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Simpan');
                        var oTable = $('#table_inbox').dataTable();
                        oTable.fnDraw(false);
                        iziToast.success({
                            title: 'Data Berhasil Disimpan',
                            message: '{{ Session(' success ')}}',
                            position: 'bottomRight'
                        });
                    },
                    error: function(response) {
                        $('#tglsuratErrorMsg').text(response.responseJSON.errors.tgl_surat);
                        $('#titleErrorMsg').text(response.responseJSON.errors.title);
                        $('#nosuratErrorMsg').text(response.responseJSON.errors.no_surat);
                        $('#kategoriErrorMsg').text(response.responseJSON.errors.id_kategori);
                        iziToast.error({
                            title: 'Data Gagal disimpan',
                            message: '{{ Session('error')}}',
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
        $.get('data-inbox/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit Surat Masuk");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#tgl_surat').val(data.tgl_surat);
            $('#title').val(data.title);
            $('#no_surat').val(data.no_surat);
            $('#id_kategori').val(data.id_kategori);
        })
    });

    // TOMBOL DELETE
    $(document).on('click', '.delete', function () {
        dataId = $(this).attr('id');
        $('#konfirmasi-modal').modal('show');
    });

    $('#tombol-hapus').click(function () {
        $.ajax({

            url: "data-inbox/" + dataId,
            type: 'delete',
            beforeSend: function () {
                $('#tombol-hapus').text('Hapus Data');
            },
            success: function (data) {
                setTimeout(function () {
                    $('#konfirmasi-modal').modal('hide');
                    var oTable = $('#table_inbox').dataTable();
                    oTable.fnDraw(false);
                });
                iziToast.warning({
                    title: 'Data Berhasil Dihapus',
                    message: '{{ Session('
                    delete ')}}',
                    position: 'bottomRight'
                });
            }
        })
    });

    // FORMAT TANGGAL
    jQuery(document).ready(function($) { 
        $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        startDate: new Date(),
        todayHighlight: true,
        autoclose:true
        });   
    });

</script>

<!-- JAVASCRIPT -->

@endsection
