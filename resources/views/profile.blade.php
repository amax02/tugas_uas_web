<!-- resources/views/datatable/index.blade.php -->

@extends('layouts.layouts')

@section('content')
<!-- setting-profile.blade.php -->

<form action="{{ route('profile.update') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $user->id }}">
    <label for="name">Nama:</label>
    <input type="text" id="name" name="name" value="{{ $user->name }}">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="{{ $user->email }}">
    <!-- Tambahkan input lainnya sesuai kebutuhan -->
    <button type="submit">Simpan Perubahan</button>
</form>


@endsection

@push('script')
<script>
    var isEdit = false;

    function editProfile() {
        isEdit = true;
        // Mendapatkan data profil pengguna dari server atau database sesuai kebutuhan
        // dan mengisi nilai-nilai dalam formulir
        $.get('{{ url("/user/detail") }}').done(function(response) {
            if (response.status === 200 && response.data) {
                $('#name').val(response.data.name);
                $('#email').val(response.data.email);
                // Mengisi data lainnya yang dibutuhkan pada form
                // Pastikan mengganti id elemen dan properti lainnya sesuai dengan formulir yang ada pada halaman "Setting Profile"
                $('#modal_tambah').modal('show');
            } else {
                alert('Gagal memuat profil');
            }
        });
    }

    $(document).ready(function() {
        $("#ftambah").on('submit', function(e) {
            e.preventDefault();
            let url = '{{ route("profile.update") }}';
            var formData = $(this).serialize();

            $.post(url, formData).done(function(data) {
                if (data.status == 200) {
                    $("#modal_tambah").modal('hide');
                    // Lakukan pembaruan tampilan profil atau halaman jika perlu
                    // Contoh: Menampilkan pesan sukses atau memperbarui informasi pada halaman profil
                }
            }).fail(function() {
                alert('Gagal memperbarui profil');
            });
        });
    });
</script>
@endpush