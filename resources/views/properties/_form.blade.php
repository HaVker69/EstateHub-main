@csrf

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Naziv oglasa</label>
        <input type="text" name="title" value="{{ old('title', $property->title ?? '') }}" class="form-control @error('title') is-invalid @enderror" required>
        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Tip nekretnine</label>
        <select name="property_type_id" class="form-select @error('property_type_id') is-invalid @enderror" required>
            <option value="">Izaberite tip</option>
            @foreach($propertyTypes as $type)
                <option value="{{ $type->id }}" @selected(old('property_type_id', $property->property_type_id ?? '') == $type->id)>{{ $type->name }}</option>
            @endforeach
        </select>
        @error('property_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Opis</label>
        <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $property->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Cena (&euro;)</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $property->price ?? '') }}" class="form-control @error('price') is-invalid @enderror" required>
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Kvadratura (m&sup2;)</label>
        <input type="number" step="0.01" name="area" value="{{ old('area', $property->area ?? '') }}" class="form-control @error('area') is-invalid @enderror" required>
        @error('area') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Broj soba</label>
        <input type="number" name="rooms" value="{{ old('rooms', $property->rooms ?? '') }}" class="form-control @error('rooms') is-invalid @enderror" required>
        @error('rooms') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Grad</label>
        <input type="text" name="city" value="{{ old('city', $property->city ?? '') }}" class="form-control @error('city') is-invalid @enderror" required>
        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Adresa</label>
        <input type="text" name="address" value="{{ old('address', $property->address ?? '') }}" class="form-control @error('address') is-invalid @enderror" required>
        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    @isset($property) @if($property->exists && $property->images->isNotEmpty())
        <div class="col-12">
            <label class="form-label">Postojeće slike</label>
            <div class="row g-2">
                @foreach($property->images as $image)
                    <div class="col-3 text-center">
                        <img src="{{ $image->url }}" class="img-fluid rounded mb-1" style="height:90px;object-fit:cover;width:100%;">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="remove_images[]" value="{{ $image->id }}" id="remove_image_{{ $image->id }}">
                            <label class="form-check-label small text-danger" for="remove_image_{{ $image->id }}">Ukloni</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif @endisset

    <div class="col-12">
        <label class="form-label">Dodaj slike</label>
        <input type="file" name="images[]" multiple accept="image/*" class="form-control @error('images.0') is-invalid @enderror">
        @error('images.0') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">Možete izabrati do 8 slika.</div>
    </div>
</div>
