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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Level</th>
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
                                        <label for="name" class="col-sm-12 control-label">Nama Pengguna</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="col-sm-12 control-label">E-mail</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control" id="email" name="email" value=""
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-sm-12 control-label">Password</label>
                                        <div class="col-sm-12">
                                            <input type="password" class="form-control" id="password" name="password" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="level" class="col-sm-12 control-label">Level</label>
                                        <div class="col-sm-12">
                                            <select name="level" id="level" class="form-control required">
                                                <option value="">Level Pengguna</option>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
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
                        <p>Jika menghapus user, maka data user tersebut hilang selamanya, apakah anda yakin?</p>
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
        $('#modal-judul').html("Tambah User Baru");
        $('#tambah-edit-modal').modal('show');
    });

    // DATATABLE
    $(document).ready(function () {
        $('#table_inbox').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('data-user.index') }}",
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
                {data: 'name',name: 'name'},
                {data: 'email',name: 'email'},
                {data: 'level',name: 'level'},
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
                    data: $('#form-tambah-edit')
                        .serialize(), 
                    url: "{{ route('data-user.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
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
                    error: function (data) {
                        console.log('Error:', data);
                        $('#tombol-simpan').html('Simpan');
                    }
                });
            }
        })
    }

    // EDIT DATA
    $('body').on('click', '.edit-post', function () {
        var data_id = $(this).data('id');
        $.get('data-user/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit Post");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#level').val(data.level);
            $('#password').val(data.password);
        })
    });

    // TOMBOL DELETE
    $(document).on('click', '.delete', function () {
        dataId = $(this).attr('id');
        $('#konfirmasi-modal').modal('show');
    });

    $('#tombol-hapus').click(function () {
        $.ajax({

            url: "data-user/" + dataId,
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

</script>

<!-- JAVASCRIPT -->

@endsection
