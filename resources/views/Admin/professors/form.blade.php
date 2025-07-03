<div class="form-group">
    <label for="matricule">Matricule</label>
    <input type="text" name="matricule" id="matricule" value="{{ old('matricule', $professor->matricule ?? '') }}"
        class="form-control" required>
    @error('matricule')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="name">Nom</label>
    <input type="text" name="name" id="name" value="{{ old('name', $professor->name ?? '') }}"
        class="form-control" required>
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="status">Statut</label>
    <select name="status" id="status" class="form-control" required>
        @php
            $statuses = ['Prof ordinaire', 'associé', 'chef de travaux', 'ouvrier'];
        @endphp
        @foreach ($statuses as $status)
            <option value="{{ $status }}"
                {{ old('status', $professor->status ?? '') == $status ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>
    @error('status')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="universities">Affectations (universités)</label>
    <select name="universities[]" id="universities" class="form-control" multiple>
        @foreach ($universities as $university)
            <option value="{{ $university->id }}"
                {{ collect(old('universities', $professor->universities->pluck('id')->toArray() ?? []))->contains($university->id) ? 'selected' : '' }}>
                {{ $university->name }}
            </option>
        @endforeach
    </select>
    @error('universities')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
