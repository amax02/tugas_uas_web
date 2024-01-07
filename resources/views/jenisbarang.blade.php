@extends('layouts.layouts')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Data Jenis Barang</h4>
            <button class="btn btn-primary" onclick="tambahRow()">Tambah</button>
        </div>
    </div>
    <div class="card-body">
        <table id="db" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
                <!-- Define your table headers here -->
                <tr>
                    <th colspan="6" class="text-center">Daftar Jenis Barang</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Nama Jenis</th>
                    <th>Aksi </th>
                    
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <!-- ... rest of your table content ... -->
        </table>

        <div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="modal_tambah_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_tambah_label">Tambah Jenis Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="ftambah" method="post">
            @csrf
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="nama_jenis" class="col-form-label">Nama Jenis Barang</label>
                <input type="text" class="form-control" id="nama_jenis" name="nama_jenis">
            </div>
            
            
        </div>
        <div class="modal-footer">
        <label for="aksi" class="col-form-label">Aksi</label>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
</div>
    </div>
    </div>
    </div>
</div>

    @endsection

    @push('script')
    <script>
        var table;
        let isEdit = false;

        function tambahRow(){
            isEdit = false
            $('#modal_tambah').modal('show')
        }

        function editRow(id){
            isEdit = true;
            $.get('{{url("/jenis/detail")}}' + '/' + id).done(function(dt){
                if(dt.data){
                    if(dt.data.nama_jenis) $("#nama_jenis").val(dt.data.nama_jenis);
                    if(dt.data.id) $("#id").val(dt.data.id);
                    $("#modal_tambah").modal('show')
                }else{
                    alert('Gagal bos')
                }
            })
            
        }

        function deleteRow(id){
            let c = confirm('Apakah kamu yakin untuk menghapus data ini?');
            if(c){
                $.get('{{url("/jenis/hapus")}}' + '/' + id).done(function(dt){
                    if(dt.status == 200){
                        table.draw();
                    }else{
                        alert('Gagal bos')
                    }
                })
            }

            
        }
        $(document).ready(function () {
            table = $('#db').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('jenis.list') }}",
                columns: [
                   
                    { data: 'id', name: 'id' },
                    { data: 'nama_jenis', name: 'nama_jenis' },
                    
                    { 
                        data: null,
                        render: function(data, type, row) {
                            var editButtonClass = data.someCondition ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm';
                            var deleteButtonClass = 'btn btn-danger btn-sm ml-1';

                            return '<button class="' + editButtonClass + '" onclick="editRow(' + data.id + ')">Edit</button>'
                                   + '<button class="' + deleteButtonClass + '" onclick="deleteRow(' + data.id + ')">Delete</button>';
                        },
                        orderable: false,
                        searchable: false
                    },
                    
                    // Add more columns as needed
                ]
            });

           

            $("#ftambah").on('submit', function(e){
                e.preventDefault();
                let url = '{{route("jenis.tambah")}}';
                if(isEdit){
                    url = '{{route("jenis.update")}}'
                }
                var dt = $(this).serialize();
                $.post(url, dt).done(function(data){
                    if(data.status == 200){
                        $("#modal_tambah").modal('hide');
                        table.draw();
                        $("#ftambah").trigger('reset')
                    }
                }).fail(function(){
                    alert('Gagal bos')
                })
            })
        });
    </script>
    @endpush