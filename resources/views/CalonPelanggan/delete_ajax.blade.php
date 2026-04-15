<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 20px; padding: 15px;">
        <form action="{{ url('/calon_pelanggan/' . $CalonPelanggan->id . '/destroy_ajax') }}" method="POST" id="form-delete">
            @csrf
            @method('DELETE')
            
            <div class="modal-body text-center pt-4 pb-0">
                <i class="fas fa-exclamation-circle text-danger" style="font-size: 70px; margin-bottom: 20px;"></i>
                
                <h4 style="font-weight: 600; color: #333;">Konfirmasi Hapus</h4>
                <p class="text-muted mb-4" style="font-size: 15px;">
                    Apakah kamu yakin ingin menghapus prospek/pelanggan <br>
                    <strong class="text-dark">{{ $CalonPelanggan->nama_pelanggan }}</strong>?
                </p>
            </div>

            <div class="modal-footer border-0 justify-content-center pt-0 pb-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal" style="border-radius: 25px; min-width: 120px;">Batal</button>
                <button type="submit" class="btn btn-danger px-4" style="border-radius: 25px; min-width: 120px;">Ya, Hapus!</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#form-delete").on('submit', function(e) {
            e.preventDefault(); 
            
            let form = $(this);
            let url = form.attr('action');
            let btn = form.find('button[type="submit"]');
            let btnAsli = btn.html();
           
            btn.html('<i class="fas fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
            
            $.ajax({
                url: url,
                type: "POST",
                data: form.serialize(),
                success: function(response) {
                    btn.html(btnAsli).prop('disabled', false); 
                    
                    if(response.status) {
                        $('#myModal').modal('hide');
                        $('.modal-backdrop').remove(); 
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '');

                        // Notifikasi sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'BERHASIL',
                            text: response.message,
                            confirmButtonColor: '#28a745',
                            customClass: { title: 'font-weight-bold' }
                        });
                    
                        if (typeof tableCalonPelanggan !== 'undefined') {
                            tableCalonPelanggan.ajax.reload(null, false);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    btn.html(btnAsli).prop('disabled', false); // Kembalikan bentuk tombol
                    console.log("Detail Error:", xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Server',
                        text: 'Terjadi kesalahan sistem saat mencoba menghapus data.'
                    });
                }
            });
        });
    });
</script>