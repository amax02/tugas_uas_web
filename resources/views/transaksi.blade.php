<!-- resources/views/datatable/index.blade.php -->

@extends('layouts.layouts')

@section('content')
   <div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Data Transaksi</h4>
            <button class="btn btn-primary" onclick="tambahRow()">Tambah</button>
        </div>
    </div>
    <div class="card-body">
        <table id="db" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
                <!-- Define your table headers here -->
                <tr>
                    <th colspan="6" class="text-center">Daftar Transaksi</th>
                </tr>
                <tr>
                    <th>No Transaksi</th>
                    <th>Tanggal </th>
                    <th>Diskon </th>
                    <th>Total Bayar</th>
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
            <h5 class="modal-title" id="modal_tambah_label">Tambah Transaksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="ftambah" method="post">
            @csrf
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="no_transaksi" class="col-form-label">No Transaksi</label>
                <input type="number" class="form-control" id="no_transaksi" name="no_transaksi">
            </div>
            
            <div class="form-group">
                <label for="tgl_transaksi" class="col-form-label">Tanggal</label>
                <input class="form-control" type="datetime-local" id="tgl_transaksi" name="tgl_transaksi">
            </div>
            <div class="form-group">
                <label for="diskon" class="col-form-label">Diskon</label>
                <input class="form-control" type="text" id="diskon" name="diskon" placeholder="Enter discount percentage">
            </div>
            <div class="form-group">
                <label for="total_bayar" class="col-form-label">Total Bayar</label>
                <input class="form-control" type="number" id="total_bayar" name="total_bayar">
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
            $.get('{{url("/transaksi/detail")}}' + '/' + id).done(function(dt){
                if(dt.data){
                    if(dt.data.no_transaksi) $("#no_transaksi").val(dt.data.no_transaksi);
                    if(dt.data.tgl_transaksi) $("#tgl_transaksi").val(dt.data.tgl_transaksi);
                    if(dt.data.diskon) $("#diskon").val(dt.data.diskon);
                    if(dt.data.total_bayar) $("#total_bayar").val(dt.data.total_bayar);
                   
                    $("#modal_tambah").modal('show')
                }else{
                    alert('Gagal bos')
                }
            })
            
        }

        function deleteRow(id){
            let c = confirm('Apakah kamu yakin untuk menghapus data ini?');
            if(c){
                $.get('{{url("/transaksi/hapus")}}' + '/' + id).done(function(dt){
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
                ajax: "{{ route('transaksi.list') }}",
                columns: [
                    { data: 'no_transaksi', name: 'no_transaksi' },
                    { data: 'tgl_transaksi', name: 'tgl_transaksi' },
                    { data: 'diskon', name: 'diskon' },
                    { data: 'total_bayar', name: 'total_bayar' },
                    
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
                let url = '{{route("transaksi.tambah")}}';
                if(isEdit){
                    url = '{{route("transaksi.update")}}'
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
