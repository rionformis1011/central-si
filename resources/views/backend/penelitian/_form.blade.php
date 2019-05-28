<div class="form-group">
    <label for="judul">Judul</label>
    {{ Form::textarea('judul', null, ['class' => 'form-control', 'id' => 'judul', 'placeholder' => 'Judul Penelitian', 'rows' => 3]) }}
</div>

<div class="form-group">
    <label for="tahun">Tahun</label>
    {{ Form::text('tahun', null, ['class' => 'form-control', 'id' => 'tahun', 'placeholder' => 'Tahun Penelitian']) }}
</div>

<div class="form-group">
    <label for="lama_tahun">Jangka Waktu</label>
    {{ Form::text('lama_tahun', null, ['class' => 'form-control', 'id' => 'lama_tahun', 'placeholder' => 'Jangka waktu Penelitian (tahun)']) }}
</div>

<div class="form-group">
    <label for="total_dana">Total Dana</label>
    {{ Form::text('total_dana', null, ['class' => 'form-control', 'id' => 'total_dana', 'placeholder' => 'Total Dana Penelitian']) }}
</div>

<div class="form-group">
    <label for="skema_penelitian_id">Skema Penelitian</label>
    {{ Form::select('skema_penelitian_id', $skema_penelitian, null, ['class' => 'form-control', 'id' => 'skema_penelitian_id']) }}
</div>

<div class="form-group">
    <label for="sumber_dana_id">Sumber Dana</label>
    {{ Form::select('sumber_dana_id', $sumber_dana, null, ['class' => 'form-control', 'id' => 'sumber_dana_id']) }}
</div>

<div class="form-group">
    <label for="file_kontrak">File Kontrak (PDF)</label>
    {{ Form::file('file_kontrak', null, ['class' => 'form-control', 'id' => 'file_kontrak']) }}
</div>

<div class="form-group">
    <label for="file_laporan">File Laporan (PDF)</label>
    {{ Form::file('file_laporan', null, ['class' => 'form-control', 'id' => 'file_laporan', 'placeholder' => 'File Laporan Penelitian']) }}
</div>

