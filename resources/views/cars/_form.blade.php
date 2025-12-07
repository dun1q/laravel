<div class="mb-3">
    <label for="title" class="form-label">Заголовок <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('title') is-invalid @enderror"
           id="title" name="title" value="{{ old('title', $car->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Описание</label>
    <textarea class="form-control @error('description') is-invalid @enderror"
              id="description" name="description" rows="3">{{ old('description', $car->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-12">
    <div class="mb-3">
        <label for="published_at" class="form-label">Дата публикации</label>
        @php
            $publishedValue = old('published_at');
            if (isset($car) && $car->published_at) {
                $publishedValue = $car->published_at->format('Y-m-d\TH:i');
            }
        @endphp
        <input 
            type="datetime-local"
            class="form-control @error('published_at') is-invalid @enderror"
            id="published_at"
            name="published_at"
            value="{{ $publishedValue }}"
        >
        @error('published_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">
            Оставьте пустым — объявление будет опубликовано сразу
        </small>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label for="year" class="form-label">Год выпуска <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('year') is-invalid @enderror"
                   id="year" name="year" min="1900" max="{{ date('Y') + 2 }}"
                   value="{{ old('year', $car->year ?? '') }}" required>
            @error('year')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="mileage_km" class="form-label">Пробег (км) <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('mileage_km') is-invalid @enderror"
                   id="mileage_km" name="mileage_km" min="0"
                   value="{{ old('mileage_km', $car->mileage_km ?? '') }}" required>
            @error('mileage_km')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="price" class="form-label">Цена (₽) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                   id="price" name="price" min="0"
                   value="{{ old('price', $car->price ?? '') }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="image" class="form-label">
        Изображение (JPEG/PNG, до 2 МБ) <span class="text-danger">*</span>
        @if(isset($car) && $car->image_path)
            <br><small class="text-muted">Оставьте пустым, чтобы не менять</small>
        @endif
    </label>
    <input type="file" class="form-control @error('image') is-invalid @enderror"
           id="image" name="image" {{ !isset($car) ? 'required' : '' }}>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($car) && $car->image_path)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $car->image_path) }}"
                 alt="Текущее изображение"
                 style="height: 80px; object-fit: cover; border-radius: 4px;">
        </div>
    @endif
</div>