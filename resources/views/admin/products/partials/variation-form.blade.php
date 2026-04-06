<div class="variation-item border p-3 mb-3 rounded bg-light" data-variation-index="{{ $index }}">
    <input type="hidden" name="variations[{{ $index }}][id]" value="{{ is_array($variation) ? ($variation['id'] ?? '') : ($variation->id ?? '') }}">

    <div class="row g-2">
        <div class="col-md-4">
            <label class="form-label small fw-bold">Название вариации <span class="text-danger">*</span></label>
            <input type="text" name="variations[{{ $index }}][name]"
                class="form-control form-control-sm @error(" variations.$index.name") is-invalid @enderror"
                value="{{ old("variations.$index.name", is_array($variation) ? ($variation['name'] ?? '') : ($variation->name ?? '')) }}">
            @error("variations.$index.name")
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-bold">Артикул (SKU) <span class="text-danger">*</span></label>
            <input type="text" name="variations[{{ $index }}][sku]"
                class="form-control form-control-sm @error(" variations.$index.sku") is-invalid @enderror"
                value="{{ old("variations.$index.sku", is_array($variation) ? ($variation['sku'] ?? '') : ($variation->sku ?? '')) }}">
            @error("variations.$index.sku")
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-bold">Цена (₽) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="variations[{{ $index }}][price]"
                class="form-control form-control-sm @error(" variations.$index.price") is-invalid @enderror"
                value="{{ old("variations.$index.price", is_array($variation) ? ($variation['price'] ?? '') : ($variation->price ?? '')) }}">
            @error("variations.$index.price")
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-md-4">
            <label class="form-label small fw-bold">Старая цена</label>
            <input type="number" step="0.01" name="variations[{{ $index }}][old_price]"
                class="form-control form-control-sm"
                value="{{ old("variations.$index.old_price", is_array($variation) ? ($variation['old_price'] ?? '') : ($variation->old_price ?? '')) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-bold">Количество <span class="text-danger">*</span></label>
            <input type="number" name="variations[{{ $index }}][stock]"
                class="form-control form-control-sm @error(" variations.$index.stock") is-invalid @enderror"
                value="{{ old("variations.$index.stock", is_array($variation) ? ($variation['stock'] ?? 0) : ($variation->stock ?? 0)) }}">
            @error("variations.$index.stock")
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-bold">Вес (кг)</label>
            @php
            $weightValue = '';
            if (is_array($variation)) {
            $weightValue = $variation['attributes']['weight'] ?? '';
            } else {
            $weightValue = $variation->attributes->where('key', 'weight')->first()?->value ?? '';
            }
            @endphp
            <input type="number" step="0.01" name="variations[{{ $index }}][attributes][weight]"
                class="form-control form-control-sm"
                value="{{ old("variations.$index.attributes.weight", $weightValue) }}">
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-12">
            <label class="form-label small fw-bold">Фото для этой вариации</label>

            <div id="existing-images-{{ $index }}" class="existing-images-container d-flex flex-wrap gap-2 mb-2">
                @php
                $imagesArray = [];

                if (!is_array($variation)) {
                $imagesArray = $variation->images->pluck('path')->toArray();
                } else {
                $variationId = $variation['id'] ?? null;
                if ($variationId && isset($product) && $product->variations) {
                $originalVariation = $product->variations->where('id', $variationId)->first();
                if ($originalVariation) {
                $imagesArray = $originalVariation->images->pluck('path')->toArray();
                }
                }
                }
                @endphp

                @foreach($imagesArray as $idx => $imagePath)
                <div class="existing-image-item position-relative" data-image="{{ $imagePath }}" data-index="{{ $idx }}" style="cursor: move;">
                    <img src="{{ asset($imagePath) }}" style="max-height: 60px; width: auto;" class="border rounded">
                    @if($idx === 0)
                    <span class="badge bg-success position-absolute top-0 start-0" style="font-size: 10px;">Главное</span>
                    @endif
                    <button type="button"
                        class="btn btn-sm btn-danger position-absolute top-0 end-0 p-0"
                        style="font-size: 14px; line-height: 1; width: 20px; height: 20px; border-radius: 50%;"
                        data-variation-index="{{ $index }}"
                        data-image="{{ $imagePath }}"
                        onclick="removeVariationImage(this)">
                        ✕
                    </button>
                </div>
                @endforeach
            </div>

            <div id="sortable-{{ $index }}" class="sortable-container d-flex flex-wrap gap-2 mb-2"></div>

            <input type="file" name="variations[{{ $index }}][images][]"
                class="form-control form-control-sm variation-images-input @error(" variations.{$index}.images.*") is-invalid @enderror"
                data-index="{{ $index }}"
                multiple accept="image/*">

            @error("variations.{$index}.images.*")
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="text-muted">Можно выбрать несколько фото. Первое будет главным. Перетаскивайте для сортировки.</small>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-md-4">
            <label class="form-label small">Вкус</label>
            @php
            $flavorValue = '';
            if (is_array($variation)) {
            $flavorValue = $variation['attributes']['flavor'] ?? '';
            } else {
            $flavorValue = $variation->attributes->where('key', 'flavor')->first()?->value ?? '';
            }
            @endphp
            <input type="text" name="variations[{{ $index }}][attributes][flavor]"
                class="form-control form-control-sm"
                value="{{ old("variations.$index.attributes.flavor", $flavorValue) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label small">Цвет</label>
            @php
            $colorValue = '';
            if (is_array($variation)) {
            $colorValue = $variation['attributes']['color'] ?? '';
            } else {
            $colorValue = $variation->attributes->where('key', 'color')->first()?->value ?? '';
            }
            @endphp
            <input type="text" name="variations[{{ $index }}][attributes][color]"
                class="form-control form-control-sm"
                value="{{ old("variations.$index.attributes.color", $colorValue) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label small">Размер</label>
            @php
            $sizeValue = '';
            if (is_array($variation)) {
            $sizeValue = $variation['attributes']['size'] ?? '';
            } else {
            $sizeValue = $variation->attributes->where('key', 'size')->first()?->value ?? '';
            }
            @endphp
            <input type="text" name="variations[{{ $index }}][attributes][size]"
                class="form-control form-control-sm"
                value="{{ old("variations.$index.attributes.size", $sizeValue) }}">
        </div>
    </div>

    <div class="col-12">
        <div class="form-check mt-3">
            <input type="checkbox" name="variations[{{ $index }}][is_default]"
                class="form-check-input" value="1" id="default_{{ $index }}"
                {{ old("variations.$index.is_default", is_array($variation) ? ($variation['is_default'] ?? false) : ($variation->is_default ?? false)) ? 'checked' : '' }}>
            <label class="form-check-label small" for="default_{{ $index }}">
                Основная вариация
            </label>
        </div>
    </div>

    <div class="mt-3">
        <button type="button" class="btn btn-sm btn-danger remove-variation">
            <i class="bi bi-trash"></i> Удалить вариацию
        </button>
    </div>
</div>