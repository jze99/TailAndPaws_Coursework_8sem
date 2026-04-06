@extends('layouts.admin')

@section('title', 'Редактировать товар')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        @method('PUT')

        @php
        $variationCount = old('variations') !== null ? count(old('variations')) : $product->variations->count();
        $specCount = old('attributes') !== null ? count(old('attributes')) : $product->attributes->count();
        @endphp

        <input type="hidden" id="variationCount" value="{{ $variationCount }}">
        <input type="hidden" id="specCount" value="{{ $specCount ?: 1 }}">

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Основная информация</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Название <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $product->name) }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Бренд</label>
                                <select name="brand_id" class="form-select">
                                    <option value="">Выберите бренд</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Категория <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">Выберите категорию</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                        @for($i = 0; $i < $cat->level; $i++) — @endfor {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1"
                                        class="form-check-input" id="is_active"
                                        {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Активен</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Характеристики товара</h5>
                        <button type="button" class="btn btn-sm btn-dark-green" id="addSpec">
                            <i class="bi bi-plus-lg"></i> Добавить характеристику
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="specs-container">
                            @php
                            $productAttributes = old('attributes', $product->attributes->toArray());
                            $attrIndex = 0;
                            @endphp
                            @foreach($productAttributes as $key => $value)
                            <div class="row spec-item mb-2">
                                <div class="col-md-5">
                                    <input type="text" name="attributes[{{ $attrIndex }}][key]"
                                        class="form-control form-control-sm"
                                        value="{{ is_array($value) ? ($value['key'] ?? '') : $key }}" placeholder="Название">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="attributes[{{ $attrIndex }}][value]"
                                        class="form-control form-control-sm"
                                        value="{{ is_array($value) ? ($value['value'] ?? '') : $value }}" placeholder="Значение">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-danger remove-spec w-100">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @php $attrIndex++; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Вариации (размеры, вес, цвет)</h5>
                        <button type="button" class="btn btn-sm btn-dark-green" id="addVariation">
                            <i class="bi bi-plus-lg"></i> Добавить вариацию
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="variations-container">
                            @foreach(old('variations', $product->variations) as $index => $variation)
                            @include('admin.products.partials.variation-form', [
                            'index' => $index,
                            'variation' => $variation,
                            'product' => $product
                            ])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">SEO</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control"
                                value="{{ old('meta_title', $product->meta_title) }}">
                            <small class="text-muted">До 60 символов</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
                            <small class="text-muted">До 160 символов</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control"
                                value="{{ old('meta_keywords', $product->meta_keywords) }}">
                            <small class="text-muted">Ключевые слова через запятую</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <button type="submit" class="btn btn-dark-green">
                <i class="bi bi-save"></i> Сохранить
            </button>
            <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                Отмена
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    let variationIndex = parseInt(document.getElementById('variationCount').value);
    let specIndex = parseInt(document.getElementById('specCount').value);
    let errors = <?php echo json_encode($errors->getMessages()); ?>;
    let oldInput = <?php echo json_encode(old()); ?>;
    let deletedSkus = [];

    function escapeHtml(text) {
        if (!text) return '';
        return String(text).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    function showNotification(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : (type === 'warning' ? 'alert-warning' : 'alert-danger');
        const icon = type === 'success' ? 'bi-check-circle-fill' : (type === 'warning' ? 'bi-exclamation-triangle-fill' : 'bi-x-circle-fill');

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999; min-width: 350px;" role="alert">
                <i class="bi ${icon} me-2"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', alertHtml);

        setTimeout(() => {
            const alert = document.querySelector('.alert-dismissible');
            if (alert) alert.remove();
        }, 5000);
    }

    function handleDefaultVariation(clickedIndex) {
        const allCheckboxes = document.querySelectorAll('input[name$="[is_default]"]');
        allCheckboxes.forEach((checkbox, index) => {
            checkbox.checked = (index === clickedIndex);
        });
    }

    function initDefaultVariationHandlers() {
        document.querySelectorAll('input[name$="[is_default]"]').forEach((checkbox, index) => {
            const newCheckbox = checkbox.cloneNode(true);
            checkbox.parentNode.replaceChild(newCheckbox, checkbox);

            newCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    handleDefaultVariation(index);
                }
            });
        });
    }

    function checkSkuOnInput(input, variationIndex, variationId = null) {
        const sku = input.value.trim();
        if (!sku) {
            input.classList.remove('is-invalid');
            const errorDiv = input.parentElement.querySelector('.invalid-feedback');
            if (errorDiv) errorDiv.remove();
            return;
        }

        if (deletedSkus.includes(sku)) {
            input.classList.add('is-invalid');
            let errorDiv = input.parentElement.querySelector('.invalid-feedback');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                input.parentElement.appendChild(errorDiv);
            }
            errorDiv.textContent = 'Этот артикул будет удален после сохранения. Сохраните изменения и попробуйте снова.';
            return;
        }

        const checkUrl = document.querySelector('meta[name="sku-check-url"]').getAttribute('content');
        const productId = document.querySelector('meta[name="product-id"]')?.getAttribute('content') || null;

        fetch(checkUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    sku: sku,
                    variation_id: variationId,
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (input.value.trim() !== sku) return;

                if (!data.unique) {
                    input.classList.add('is-invalid');
                    let errorDiv = input.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        input.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = data.message;
                } else {
                    input.classList.remove('is-invalid');
                    const errorDiv = input.parentElement.querySelector('.invalid-feedback');
                    if (errorDiv) errorDiv.remove();
                }
            })
            .catch(error => {
                console.error('Error checking SKU:', error);
            });
    }

    function initSkuValidation() {
        document.querySelectorAll('input[name$="[sku]"]').forEach((input, index) => {
            const variationItem = input.closest('.variation-item');
            const variationIdInput = variationItem?.querySelector('input[name$="[id]"]');
            const variationId = variationIdInput ? variationIdInput.value : null;

            let timeout;
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    checkSkuOnInput(this, index, variationId);
                }, 500);
            });
        });
    }

    function validateAllSkus() {
        const skuInputs = document.querySelectorAll('input[name$="[sku]"]');
        let hasError = false;
        const skuValues = [];

        skuInputs.forEach((input) => {
            const sku = input.value.trim();
            if (sku) {
                if (skuValues.includes(sku)) {
                    input.classList.add('is-invalid');
                    let errorDiv = input.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        input.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = 'Артикул не может дублироваться в одной форме';
                    hasError = true;
                } else {
                    skuValues.push(sku);
                }
            }
        });

        skuInputs.forEach((input) => {
            const sku = input.value.trim();
            if (sku && deletedSkus.includes(sku)) {
                input.classList.add('is-invalid');
                let errorDiv = input.parentElement.querySelector('.invalid-feedback');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    input.parentElement.appendChild(errorDiv);
                }
                errorDiv.textContent = 'Этот артикул будет удален после сохранения. Сохраните изменения и попробуйте снова.';
                hasError = true;
            }
        });

        if (hasError) {
            showNotification('warning', 'Пожалуйста, исправьте ошибки в артикулах');
        }

        return !hasError;
    }

    function markVariationAsDeleted(item, sku) {
        item.style.opacity = '0.6';
        item.style.backgroundColor = '#f8d7da';

        let deleteMark = item.querySelector('.deletion-mark');
        if (!deleteMark) {
            deleteMark = document.createElement('div');
            deleteMark.className = 'deletion-mark text-danger small mt-2';
            deleteMark.innerHTML = '<i class="bi bi-trash"></i> Будет удалена после сохранения';
            item.appendChild(deleteMark);
        }

        const inputs = item.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.setAttribute('data-disabled', 'true');
            input.style.pointerEvents = 'none';
            input.style.opacity = '0.6';
        });

        showNotification('warning', `Артикул "${sku}" будет удален после сохранения. Не используйте его для новых вариаций до сохранения.`);
    }

    function updateVariationIndices() {
        const variationItems = document.querySelectorAll('.variation-item');
        variationItems.forEach((item, newIndex) => {
            item.setAttribute('data-variation-index', newIndex);

            const inputs = item.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/variations\[\d+\]/, `variations[${newIndex}]`);
                    if (newName !== name) {
                        input.setAttribute('name', newName);
                    }
                }
            });

            const elementsWithId = item.querySelectorAll('[id]');
            elementsWithId.forEach(el => {
                const oldId = el.id;
                if (oldId.includes('existing-images-') || oldId.includes('sortable-') || oldId.includes('default_')) {
                    const newId = oldId.replace(/\d+/, newIndex);
                    el.id = newId;
                }
            });

            const fileInputs = item.querySelectorAll('.variation-images-input');
            fileInputs.forEach(input => {
                input.setAttribute('data-index', newIndex);
            });
        });

        variationIndex = variationItems.length;
    }

    function getNewVariationTemplate(index) {
        return `
            <div class="variation-item border p-3 mb-3 rounded bg-light" data-variation-index="${index}">
                <input type="hidden" name="variations[${index}][id]" value="">
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Название вариации <span class="text-danger">*</span></label>
                        <input type="text" name="variations[${index}][name]" class="form-control form-control-sm" placeholder="Например: 250г, Красный, Мятный">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Артикул (SKU) <span class="text-danger">*</span></label>
                        <input type="text" name="variations[${index}][sku]" class="form-control form-control-sm" placeholder="Уникальный артикул">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Цена (₽) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="variations[${index}][price]" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Старая цена</label>
                        <input type="number" step="0.01" name="variations[${index}][old_price]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Количество <span class="text-danger">*</span></label>
                        <input type="number" name="variations[${index}][stock]" class="form-control form-control-sm" value="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Вес (кг)</label>
                        <input type="number" step="0.01" name="variations[${index}][attributes][weight]" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Фото для этой вариации</label>
                        <div id="existing-images-${index}" class="existing-images-container d-flex flex-wrap gap-2 mb-2"></div>
                        <div id="sortable-${index}" class="sortable-container d-flex flex-wrap gap-2 mb-2"></div>
                        <input type="file" name="variations[${index}][images][]" class="form-control form-control-sm variation-images-input" data-index="${index}" multiple accept="image/jpeg,image/png,image/webp">
                        <small class="text-muted">Можно выбрать несколько фото. Первое будет главным. Перетаскивайте для сортировки.</small>
                    </div>
                </div>
                <div class="row g-2 mt-3">
                    <div class="col-md-4">
                        <label class="form-label small">Вкус</label>
                        <input type="text" name="variations[${index}][attributes][flavor]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Цвет</label>
                        <input type="text" name="variations[${index}][attributes][color]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Размер</label>
                        <input type="text" name="variations[${index}][attributes][size]" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" name="variations[${index}][is_default]" class="form-check-input" value="1" id="default_${index}">
                            <label class="form-check-label small" for="default_${index}">Основная вариация</label>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-sm btn-danger remove-variation">
                        <i class="bi bi-trash"></i> Удалить вариацию
                    </button>
                </div>
            </div>
        `;
    }

    function getSpecTemplate(index) {
        return `
            <div class="row spec-item mb-2">
                <div class="col-md-5">
                    <input type="text" name="attributes[${index}][key]" class="form-control form-control-sm" placeholder="Название">
                </div>
                <div class="col-md-6">
                    <input type="text" name="attributes[${index}][value]" class="form-control form-control-sm" placeholder="Значение">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger remove-spec w-100">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }

    function initSortable(container, fileInput) {
        let filesArray = [];

        new Sortable(container, {
            onEnd: function() {
                const newOrder = [];
                container.querySelectorAll('.file-item').forEach(item => {
                    const idx = parseInt(item.dataset.index);
                    newOrder.push(filesArray[idx]);
                });
                filesArray = newOrder;
                updateFileInput(fileInput, filesArray);
                renderNewPreviews(container, filesArray);
            }
        });

        fileInput.addEventListener('change', function(e) {
            filesArray = Array.from(e.target.files);
            renderNewPreviews(container, filesArray);
            updateFileInput(fileInput, filesArray);
        });
    }

    function initExistingSortable(container) {
        if (!container || container.children.length === 0) return;

        new Sortable(container, {
            animation: 150,
            handle: '.existing-image-item',
            onEnd: function() {
                const newOrder = [];
                container.querySelectorAll('.existing-image-item').forEach(item => {
                    newOrder.push(item.dataset.image);
                });
                updateExistingImagesOrder(container.id, newOrder);
                updateMainBadge(container);
            }
        });
    }

    function renderNewPreviews(container, files) {
        if (!container) return;
        container.innerHTML = files.map((file, idx) => `
            <div class="file-item position-relative" data-index="${idx}" style="cursor: move;">
                <img src="${URL.createObjectURL(file)}" style="max-height: 60px; width: auto;" class="border rounded">
                <span class="badge bg-dark position-absolute top-0 start-0">${idx + 1}</span>
            </div>
        `).join('');
    }

    function updateFileInput(fileInput, files) {
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    function updateExistingImagesOrder(containerId, newOrder) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const parts = containerId.split('-');
        const variationIdx = parts[parts.length - 1];

        container.querySelectorAll('input[name$="[existing_images][]"]').forEach(input => input.remove());

        newOrder.forEach(imagePath => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `variations[${variationIdx}][existing_images][]`;
            input.value = imagePath;
            container.appendChild(input);
        });
    }

    function updateMainBadge(container) {
        const items = container.querySelectorAll('.existing-image-item');
        items.forEach((item, idx) => {
            const oldBadge = item.querySelector('.badge.bg-success');
            if (oldBadge) oldBadge.remove();
            if (idx === 0) {
                const badge = document.createElement('span');
                badge.className = 'badge bg-success position-absolute top-0 start-0';
                badge.style.fontSize = '10px';
                badge.textContent = 'Главное';
                item.style.position = 'relative';
                item.appendChild(badge);
            }
        });
    }

    window.removeVariationImage = function(button) {
        let variationIdx = parseInt(button.dataset.variationIndex);
        let imagePath = button.dataset.image;

        let removedContainer = document.getElementById(`removed-images-${variationIdx}`);
        if (!removedContainer) {
            removedContainer = document.createElement('div');
            removedContainer.id = `removed-images-${variationIdx}`;
            removedContainer.style.display = 'none';

            let existingContainer = document.getElementById(`existing-images-${variationIdx}`);
            if (existingContainer) {
                existingContainer.appendChild(removedContainer);
            }
        }

        let removedInput = document.createElement('input');
        removedInput.type = 'hidden';
        removedInput.name = `variations[${variationIdx}][removed_images][]`;
        removedInput.value = imagePath;
        removedContainer.appendChild(removedInput);

        let imageDiv = button.closest('.existing-image-item');
        if (imageDiv) {
            imageDiv.remove();
        }

        updateOrderAfterRemoval(variationIdx);
    }

    function updateOrderAfterRemoval(variationIdx) {
        const container = document.getElementById(`existing-images-${variationIdx}`);
        if (!container) return;

        const items = container.querySelectorAll('.existing-image-item');
        const newOrder = Array.from(items).map(item => item.dataset.image);
        updateExistingImagesOrder(container.id, newOrder);
        updateMainBadge(container);
    }

    function initDeleteVariationHandler() {
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-variation') || e.target.closest('.remove-variation')) {
                const btn = e.target.classList.contains('remove-variation') ? e.target : e.target.closest('.remove-variation');
                const item = btn.closest('.variation-item');

                if (item && confirm('Удалить эту вариацию?')) {
                    const skuInput = item.querySelector('input[name$="[sku]"]');
                    const sku = skuInput ? skuInput.value.trim() : null;

                    if (sku) {
                        deletedSkus.push(sku);
                        markVariationAsDeleted(item, sku);
                    }

                    item.remove();
                    updateVariationIndices();

                    if (sku) {
                        showNotification('warning', `Артикул "${sku}" будет удален после сохранения. Не используйте его для новых вариаций до сохранения.`);
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        deletedSkus = [];

        setTimeout(function() {
            document.querySelectorAll('.existing-images-container').forEach(container => {
                if (container.children.length > 0) {
                    initExistingSortable(container);
                }
            });

            document.querySelectorAll('.sortable-container').forEach(container => {
                const variationIdx = container.id.split('-')[1];
                const fileInput = document.querySelector(`.variation-images-input[data-index="${variationIdx}"]`);
                if (fileInput) {
                    initSortable(container, fileInput);
                }
            });
        }, 500);

        initSkuValidation();
        initDefaultVariationHandlers();
        initDeleteVariationHandler();

        document.getElementById('addVariation')?.addEventListener('click', function() {
            const container = document.getElementById('variations-container');
            container.insertAdjacentHTML('beforeend', getNewVariationTemplate(variationIndex));

            setTimeout(() => {
                updateVariationIndices();
                initSkuValidation();
                initDefaultVariationHandlers();

                document.querySelectorAll('.sortable-container').forEach(container => {
                    const variationIdx = container.id.split('-')[1];
                    const fileInput = document.querySelector(`.variation-images-input[data-index="${variationIdx}"]`);
                    if (fileInput && !container.hasAttribute('data-initialized')) {
                        initSortable(container, fileInput);
                        container.setAttribute('data-initialized', 'true');
                    }
                });
            }, 100);
        });

        document.getElementById('addSpec')?.addEventListener('click', function() {
            const container = document.getElementById('specs-container');
            container.insertAdjacentHTML('beforeend', getSpecTemplate(specIndex));
            specIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-spec') || e.target.closest('.remove-spec')) {
                const btn = e.target.classList.contains('remove-spec') ? e.target : e.target.closest('.remove-spec');
                const item = btn.closest('.spec-item');
                if (item) item.remove();
            }
        });

        const productForm = document.getElementById('productForm');
        if (productForm) {
            productForm.addEventListener('submit', function(e) {
                if (!validateAllSkus()) {
                    e.preventDefault();
                }
            });
        }
    });

    function displayValidationErrors() {
        for (let i = 0; i < variationIndex; i++) {
            if (errors[`variations.${i}.name`]) {
                const nameInput = document.querySelector(`input[name="variations[${i}][name]"]`);
                if (nameInput && !nameInput.classList.contains('is-invalid')) {
                    nameInput.classList.add('is-invalid');
                    let errorDiv = nameInput.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        nameInput.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = errors[`variations.${i}.name`][0];
                }
            }

            if (errors[`variations.${i}.sku`]) {
                const skuInput = document.querySelector(`input[name="variations[${i}][sku]"]`);
                if (skuInput && !skuInput.classList.contains('is-invalid')) {
                    skuInput.classList.add('is-invalid');
                    let errorDiv = skuInput.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        skuInput.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = errors[`variations.${i}.sku`][0];
                }
            }

            if (errors[`variations.${i}.price`]) {
                const priceInput = document.querySelector(`input[name="variations[${i}][price]"]`);
                if (priceInput && !priceInput.classList.contains('is-invalid')) {
                    priceInput.classList.add('is-invalid');
                    let errorDiv = priceInput.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        priceInput.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = errors[`variations.${i}.price`][0];
                }
            }

            if (errors[`variations.${i}.stock`]) {
                const stockInput = document.querySelector(`input[name="variations[${i}][stock]"]`);
                if (stockInput && !stockInput.classList.contains('is-invalid')) {
                    stockInput.classList.add('is-invalid');
                    let errorDiv = stockInput.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        stockInput.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = errors[`variations.${i}.stock`][0];
                }
            }

            const imageErrors = Object.keys(errors).filter(key => key.startsWith(`variations.${i}.images.`));
            if (imageErrors.length > 0) {
                const fileInput = document.querySelector(`.variation-images-input[data-index="${i}"]`);
                if (fileInput && !fileInput.classList.contains('is-invalid')) {
                    fileInput.classList.add('is-invalid');
                    let errorDiv = fileInput.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        fileInput.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = errors[imageErrors[0]][0];
                }
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(displayValidationErrors, 100);
    });

    const addVariationBtn = document.getElementById('addVariation');
    if (addVariationBtn) {
        addVariationBtn.addEventListener('click', function() {
            setTimeout(displayValidationErrors, 200);
        });
    }
</script>
@endsection