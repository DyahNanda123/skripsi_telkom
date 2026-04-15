<form action="{{ url('/strategi-target/target/'.$target->id.'/update_ajax') }}" method="POST" id="form-edit-target">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close" style="font-size: 28px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body px-5 pb-5 pt-2 bg-light" style="border-radius: 12px;">
                <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                    <div class="card-body p-4">
                        <h6 class="font-weight-bold mb-4" style="color: #333;">
                            <i class="fas fa-bullseye text-danger mr-2"></i> Edit Target Sales
                        </h6>
                        
                        <div class="row align-items-end">
                            <div class="col-md-5 mb-3">
                                <label class="small font-weight-bold text-muted mb-1">NAMA SALES</label>
                                <select name="user_id" class="form-control" style="border-radius: 8px; background-color: #f8f9fa;">
                                    <option value="">- Pilih Sales -</option>
                                    @foreach($sales as $s)
                                        <option value="{{ $s->id }}" {{ $target->user_id == $s->id ? 'selected' : '' }}>{{ $s->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                                <small class="error-text user_id-error text-danger"></small>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-muted mb-1">PERIODE (BULAN & TAHUN)</label>
                                @php
                                    $bulanFormat = str_pad($target->bulan, 2, '0', STR_PAD_LEFT);
                                    $periodeValue = $target->tahun . '-' . $bulanFormat;
                                @endphp
                                <input type="month" name="periode" class="form-control" value="{{ $periodeValue }}" style="border-radius: 8px; background-color: #f8f9fa;">
                                <small class="error-text periode-error text-danger"></small>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="small font-weight-bold text-muted mb-1">TARGET (PS)</label>
                                <input type="number" name="jumlah_target" class="form-control" value="{{ $target->jumlah_target }}" style="border-radius: 8px;">
                                <small class="error-text jumlah_target-error text-danger"></small>
                            </div>
                        </div>
                        
                        <div class="row mt-4 border-top pt-3">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-light font-weight-bold mr-2" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                                <button type="submit" class="btn btn-danger font-weight-bold text-white" style="border-radius: 8px;">
                                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#form-edit-target').on('submit', function(e) {
            e.preventDefault();
            $('.error-text').text(''); 
            
            var form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST', 
                data: form.serialize(), // Pakai serialize() karena form target gak ada upload file
                success: function(response) {
                    if(response.status) {
                        $('#myModal').modal('hide'); 
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                      
                        $('.card-body.bg-light.mt-3').load(window.location.href + ' .card-body.bg-light.mt-3 > *');
                    } else {
                        $.each(response.msgField, function(prefix, val) {
                            $('.'+prefix+'-error').text(val[0]);
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Terjadi kesalahan sistem!', 'error');
                }
            });
        });
    });
</script>