<div class="form-group">
    <label for="inspection_id">Inspection</label>
    <select name="inspection_id" id="inspection_id" class="form-control" required>
        <option value="">-- Sélectionnez une inspection --</option>
        @foreach ($inspections as $inspection)
            <option value="{{ $inspection->id }}"
                {{ old('inspection_id', $inspectionReport->inspection_id ?? '') == $inspection->id ? 'selected' : '' }}>
                {{ $inspection->university->name ?? '' }} - {{ $inspection->date->format('d/m/Y') ?? '' }}
            </option>
        @endforeach
    </select>
    @error('inspection_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inspector_id">Inspecteur</label>
    <select name="inspector_id" id="inspector_id" class="form-control" required>
        <option value="">-- Sélectionnez un inspecteur --</option>
        @foreach ($inspectors as $inspector)
            <option value="{{ $inspector->id }}"
                {{ old('inspector_id', $inspectionReport->inspector_id ?? '') == $inspector->id ? 'selected' : '' }}>
                {{ $inspector->name }}
            </option>
        @endforeach
    </select>
    @error('inspector_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="data">Données</label>
    <textarea name="data" id="data" class="form-control" rows="5" required>{{ old('data', $inspectionReport->data ?? '') }}</textarea>
    @error('data')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="gps_position">Position GPS</label>
    <input type="text" name="gps_position" id="gps_position" class="form-control"
        value="{{ old('gps_position', $inspectionReport->gps_position ?? '') }}">
    @error('gps_position')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="attachment">Pièce jointe (PDF, JPG, PNG)</label>
    <input type="file" name="attachment" id="attachment" class="form-control-file">
    @if (isset($inspectionReport) && $inspectionReport->attachment)
        <p>Fichier actuel : <a href="{{ asset('storage/' . $inspectionReport->attachment) }}" target="_blank">Voir</a>
        </p>
    @endif
    @error('attachment')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="electronic_signature">Signature électronique</label>
    <input type="text" name="electronic_signature" id="electronic_signature" class="form-control"
        value="{{ old('electronic_signature', $inspectionReport->electronic_signature ?? '') }}">
    @error('electronic_signature')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
