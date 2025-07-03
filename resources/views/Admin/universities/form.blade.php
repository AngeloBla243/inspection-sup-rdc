<div class="form-group">
    <label for="name">Nom</label>
    <input type="text" name="name" id="name" value="{{ old('name', $university->name ?? '') }}"
        class="form-control" required>
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="type">Type</label>
    <select name="type" id="type" class="form-control" required>
        <option value="public" {{ old('type', $university->type ?? '') == 'public' ? 'selected' : '' }}>Public
        </option>
        <option value="privé" {{ old('type', $university->type ?? '') == 'privé' ? 'selected' : '' }}>Privé</option>
    </select>
    @error('type')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="location">Localisation</label>
    <input type="text" name="location" id="location" value="{{ old('location', $university->location ?? '') }}"
        class="form-control" required>
    @error('location')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="agreement">Agrément</label>
    <select name="agreement" id="agreement" class="form-control" required>
        <option value="1" {{ old('agreement', $university->agreement ?? '') == 1 ? 'selected' : '' }}>Oui
        </option>
        <option value="0" {{ old('agreement', $university->agreement ?? '') == 0 ? 'selected' : '' }}>Non
        </option>
    </select>
    @error('agreement')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="gps_latitude">Latitude GPS</label>
    <input type="text" name="gps_latitude" id="gps_latitude"
        value="{{ old('gps_latitude', $university->gps_latitude ?? '') }}" class="form-control">
    @error('gps_latitude')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="gps_longitude">Longitude GPS</label>
    <input type="text" name="gps_longitude" id="gps_longitude"
        value="{{ old('gps_longitude', $university->gps_longitude ?? '') }}" class="form-control">
    @error('gps_longitude')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inspection_status">Statut d'inspection</label>
    <select name="inspection_status" id="inspection_status" class="form-control" required>
        <option value="à jour"
            {{ old('inspection_status', $university->inspection_status ?? '') == 'à jour' ? 'selected' : '' }}>À jour
        </option>
        <option value="en attente"
            {{ old('inspection_status', $university->inspection_status ?? '') == 'en attente' ? 'selected' : '' }}>En
            attente</option>
    </select>
    @error('inspection_status')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
