<!-- resources/views/datatable/index.blade.php -->

@extends('layouts.layouts')

@section('content')
   <div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Data Barang</h4>
            <button class="btn btn-primary" onclick="tambahRow()">Tambah</button>
        </div>
    </div>
    <div class="card-body">
        <table id="db" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
                <!-- Define your table headers here -->
                <tr>
                    <th colspan="6" class="text-center">Daftar Barang</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <!-- ... rest of your table content ... -->
        </table>

        <div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="modal_tambah_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_tambah_label">Tambah Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="ftambah" method="post">
            @csrf
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="nama_barang" class="col-form-label">Nama</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang">
            </div>
            <div class="form-group">
                <label for="id_jenis" class="col-form-label">Jenis</label>
                <select class="form-control" id="id_jenis" name="id_jenis">
                    <option value="">-- pilih jenis --</option>
                    @isset($jenis)
                        @foreach($jenis as $j)
                            <option value="{{$j['id']}}">{{$j['nama_jenis']}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="form-group">
                <label for="harga" class="col-form-label">Harga</label>
                <input class="form-control" type="number" id="harga" name="harga">
            </div>
            <div class="form-group">
                <label for="stok" class="col-form-label">Stok</label>
                <input class="form-control" type="number" id="stok" name="stok">
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
            $.get('{{url("/barang/detail")}}' + '/' + id).done(function(dt){
                if(dt.data){
                    if(dt.data.nama_barang) $("#nama_barang").val(dt.data.nama_barang);
                    if(dt.data.id_jenis) $("#id_jenis").val(dt.data.id_jenis);
                    if(dt.data.harga) $("#harga").val(dt.data.harga);
                    if(dt.data.stok) $("#stok").val(dt.data.stok);
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
                $.get('{{url("/barang/hapus")}}' + '/' + id).done(function(dt){
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
                ajax: "{{ route('barang.list') }}",
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'jenis', name: 'jenis' },
                    { data: 'nama_barang', name: 'nama_barang' },
                    { data: 'harga', name: 'harga' },
                    { data: 'stok', name: 'stok' },
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
                let url = '{{route("barang.tambah")}}';
                if(isEdit){
                    url = '{{route("barang.update")}}'
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
