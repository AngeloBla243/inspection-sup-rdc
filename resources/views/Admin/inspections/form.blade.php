<div class="form-group">
    <label for="university_id">Université</label>
    <select name="university_id" id="university_id" class="form-control" required>
        <option value="">-- Sélectionnez une université --</option>
        @foreach ($universities as $university)
            <option value="{{ $university->id }}"
                {{ old('university_id', $inspection->university_id ?? '') == $university->id ? 'selected' : '' }}>
                {{ $university->name }}
            </option>
        @endforeach
    </select>
    @error('university_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inspector_id">Inspecteur</label>
    <select name="inspector_id" id="inspector_id" class="form-control" required>
        <option value="">-- Sélectionnez un inspecteur --</option>
        @foreach ($inspectors as $inspector)
            <option value="{{ $inspector->id }}"
                {{ old('inspector_id', $inspection->inspector_id ?? '') == $inspector->id ? 'selected' : '' }}>
                {{ $inspector->name }}
            </option>
        @endforeach
    </select>
    @error('inspector_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="date">Date</label>
    <input type="date" name="date" id="date" class="form-control"
        value="{{ old('date', isset($inspection) ? $inspection->date->format('Y-m-d') : '') }}" required>
    @error('date')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="objective">Objectif</label>
    <input type="text" name="objective" id="objective" class="form-control"
        value="{{ old('objective', $inspection->objective ?? '') }}" required>
    @error('objective')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="status">Statut</label>
    <select name="status" id="status" class="form-control" required>
        <option value="à venir" {{ old('status', $inspection->status ?? '') == 'à venir' ? 'selected' : '' }}>À venir
        </option>
        <option value="en cours" {{ old('status', $inspection->status ?? '') == 'en cours' ? 'selected' : '' }}>En
            cours</option>
        <option value="terminée" {{ old('status', $inspection->status ?? '') == 'terminée' ? 'selected' : '' }}>
            Terminée</option>
    </select>
    @error('status')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="active">Activée</label>
    <select name="active" id="active" class="form-control" required>
        <option value="1" {{ old('active', $inspection->active ?? '') == 1 ? 'selected' : '' }}>Oui</option>
        <option value="0" {{ old('active', $inspection->active ?? '') == 0 ? 'selected' : '' }}>Non</option>
    </select>
    @error('active')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
