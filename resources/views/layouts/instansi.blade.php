@extends('layouts.whole')
@section('title','Inbox')
@section('content')

<div class="row"> 
    <div class="col-sm-12 mt-2">
        <div class="card">            
            <div class="card-body">
                <!-- MULAI TABLE -->
                <table class="table table-striped table-bordered table-sm" id="table_instansi">
                    <thead>
                        <tr>
                        <th>Nama Aplikasi</th>
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
                                        <label class="control-label col-sm-12" for="tgl_surat">Nama Instansi</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" value="">
                                            <span class="text-danger" id="namainstansiErrorMsg"></span>
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

    // DATATABLE
    $(document).ready(function () {
        $('#table_instansi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('data-instansi.index') }}",
                type: 'GET'
            },
            language: {
                "infoFiltered":"",
                "processing": '<img src="{{ URL::asset('template/images/loading2.gif')}}" style="padding:0px; width: 30%;">',
                "searchPlaceholder": "",
            },
            columns: [ 
                {data: 'nama_instansi',name: 'nama_instansi'},
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
                    url: "{{ route('data-instansi.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#table_instansi').DataTable().ajax.reload(null, true);
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Simpan');
                        var oTable = $('#table_instansi').dataTable();
                        oTable.fnDraw(false);
                        iziToast.success({
                            title: 'Data Berhasil Diubah',
                            message: '{{ Session(' success ')}}',
                            position: 'bottomRight'
                        });
                    },
                    error: function(response) {
                        $('#namainstansiErrorMsg').text(response.responseJSON.errors.nama_instansi);
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
        $.get('data-instansi/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit Nama Instansi");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#nama_instansi').val(data.nama_instansi);
        })
    });

</script>

<!-- JAVASCRIPT -->

@endsection
