@extends('layouts.layouts')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Setting Diskon</h4>
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
                    <th>Total Belanja</th>
                    <th>Diskon</th>
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
            <h5 class="modal-title" id="modal_tambah_label">Setting Diskon</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="ftambah" method="post">
            @csrf
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="total_belanja" class="col-form-label">Total Belanja</label>
                <input type="text" class="form-control" id="total_belanja" name="total_belanja">
            </div>
            <div class="form-group">
                <label for="diskon" class="col-form-label">Diskon</label>
                <input type="text" class="form-control" id="diskon" name="diskon">
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
            $.get('{{url("/diskon/detail")}}' + '/' + id).done(function(dt){
                if(dt.data){
                    if(dt.data.total_belanja) $("#total_belanja").val(dt.data.total_belanja);
                    if(dt.data.id) $("#id").val(dt.data.id);
                    if(dt.data.diskon) $("#diskon").val(dt.data.diskon);
                    $("#modal_tambah").modal('show')
                }else{
                    alert('Gagal bos')
                }
            })
            
        }

        function deleteRow(id){
            let c = confirm('Apakah kamu yakin untuk menghapus data ini?');
            if(c){
                $.get('{{url("/diskon/hapus")}}' + '/' + id).done(function(dt){
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
                ajax: "{{ route('diskon.list') }}",
                columns: [
                   
                    { data: 'id', name: 'id' },
                    { data: 'total_belanja', name: 'total_belanja' },
                    { data: 'diskon', name: 'diskon' },
                    
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
                let url = '{{route("diskon.tambah")}}';
                if(isEdit){
                    url = '{{route("diskon.update")}}'
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