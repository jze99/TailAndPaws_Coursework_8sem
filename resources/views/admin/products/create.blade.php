@extends('layouts.admin')

@section('title', 'Добавить товар')

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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf

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
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
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
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                            <label class="form-label">Полное описание</label>
                            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1"
                                        class="form-check-input" id="is_active"
                                        {{ old('is_active', true) ? 'checked' : '' }}>
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
                            <div class="row spec-item mb-2">
                                <div class="col-md-5">
                                    <input type="text" name="attributes[0][key]" class="form-control form-control-sm"
                                        placeholder="Название (например, Состав)">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="attributes[0][value]" class="form-control form-control-sm"
                                        placeholder="Значение (например, индейка 30%)">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-danger remove-spec w-100">
                                        <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Удалить" width="20" height="20" class="mx-auto">
                                    </button>
                                </div>
                            </div>
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
                                value="{{ old('meta_title') }}">
                            <small class="text-muted">До 60 символов</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                            <small class="text-muted">До 160 символов</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control"
                                value="{{ old('meta_keywords') }}">
                            <small class="text-muted">Ключевые слова через запятую</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <input type="hidden" id="variationCount" value="{{ old('variations') ? count(old('variations')) : 0 }}">
            <input type="hidden" id="specCount" value="{{ old('attributes') ? count(old('attributes')) : 1 }}">
            <button type="submit" class="btn btn-dark-green p-2 d-flex gap-1 align-items-center justify-content-center" title="Добавить товар">
                <img src="{{ asset('assets/images/icons/add-folder-svgrepo-com.svg') }}" alt="Добавить" width="20" height="20">
            </button>
            <a href="{{ route('admin.products') }}" class="btn btn-orange p-2 d-flex gap-1 align-items-center">
                <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Отмена" width="20" height="20">
                Отмена
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    let errors = <?php echo json_encode($errors->getMessages()); ?>;
    let oldInput = <?php echo json_encode(old()); ?>;

    let variationIndex = parseInt(document.getElementById('variationCount').value);
    let specIndex = parseInt(document.getElementById('specCount').value);

    function escapeHtml(text) {
        if (!text) return '';
        return String(text).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    function getVariationTemplate(index) {
        let nameError = errors[`variations.${index}.name`] ? errors[`variations.${index}.name`][0] : null;
        let skuError = errors[`variations.${index}.sku`] ? errors[`variations.${index}.sku`][0] : null;
        let priceError = errors[`variations.${index}.price`] ? errors[`variations.${index}.price`][0] : null;
        let stockError = errors[`variations.${index}.stock`] ? errors[`variations.${index}.stock`][0] : null;

        let nameOld = oldInput.variations?.[index]?.name || '';
        let skuOld = oldInput.variations?.[index]?.sku || '';
        let priceOld = oldInput.variations?.[index]?.price || '';
        let stockOld = oldInput.variations?.[index]?.stock || 0;
        let oldPriceOld = oldInput.variations?.[index]?.old_price || '';
        let weightOld = oldInput.variations?.[index]?.attributes?.weight || '';

        const isDefaultChecked = (oldInput.variations?.[index]?.is_default !== undefined) ?
            oldInput.variations?.[index]?.is_default :
            (index === 0);

        return `
        <div class="variation-item border p-3 mb-3 rounded bg-light">
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Название вариации <span class="text-danger">*</span></label>
                    <input type="text" name="variations[${index}][name]" 
                           class="form-control form-control-sm ${nameError ? 'is-invalid' : ''}" 
                           value="${escapeHtml(nameOld)}">
                    ${nameError ? `<div class="invalid-feedback">${escapeHtml(nameError)}</div>` : ''}
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Артикул (SKU) <span class="text-danger">*</span></label>
                    <input type="text" name="variations[${index}][sku]" 
                           class="form-control form-control-sm ${skuError ? 'is-invalid' : ''}" 
                           value="${escapeHtml(skuOld)}">
                    ${skuError ? `<div class="invalid-feedback">${escapeHtml(skuError)}</div>` : ''}
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Цена (₽) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="variations[${index}][price]" 
                           class="form-control form-control-sm ${priceError ? 'is-invalid' : ''}" 
                           value="${priceOld}">
                    ${priceError ? `<div class="invalid-feedback">${escapeHtml(priceError)}</div>` : ''}
                </div>
            </div>

            <div class="row g-2 mt-2">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Старая цена</label>
                    <input type="number" step="0.01" name="variations[${index}][old_price]" 
                           class="form-control form-control-sm" 
                           value="${oldPriceOld}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Количество <span class="text-danger">*</span></label>
                    <input type="number" name="variations[${index}][stock]" 
                           class="form-control form-control-sm ${stockError ? 'is-invalid' : ''}" 
                           value="${stockOld}">
                    ${stockError ? `<div class="invalid-feedback">${escapeHtml(stockError)}</div>` : ''}
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Вес (кг)</label>
                    <input type="number" step="0.01" name="variations[${index}][attributes][weight]" 
                           class="form-control form-control-sm" 
                           value="${weightOld}">
                </div>
            </div>
            
            <div class="row g-2 mt-2">
                <div class="col-12">
                    <label class="form-label small fw-bold">Фото для этой вариации</label>
                    <div id="sortable-${index}" class="sortable-container d-flex flex-wrap gap-2 mb-2"></div>
                    <input type="file" name="variations[${index}][images][]" 
                           class="form-control form-control-sm variation-images-input" 
                           data-index="${index}"
                           multiple accept="image/*">
                    <small class="text-muted">Можно выбрать несколько фото. Первое будет главным. Перетаскивайте для сортировки. Максимальный размер 2 МБ.</small>
                </div>
            </div>

            <div class="row g-2 mt-2">
                <div class="col-md-4">
                    <label class="form-label small">Вкус</label>
                    <input type="text" name="variations[${index}][attributes][flavor]" 
                           class="form-control form-control-sm" 
                           value="${escapeHtml(oldInput.variations?.[index]?.attributes?.flavor || '')}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Цвет</label>
                    <input type="text" name="variations[${index}][attributes][color]" 
                           class="form-control form-control-sm" 
                           value="${escapeHtml(oldInput.variations?.[index]?.attributes?.color || '')}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Размер</label>
                    <input type="text" name="variations[${index}][attributes][size]" 
                           class="form-control form-control-sm" 
                           value="${escapeHtml(oldInput.variations?.[index]?.attributes?.size || '')}">
                </div>
            </div>

            <div class="col-12">
                <div class="form-check mt-3">
                    <input type="checkbox" name="variations[${index}][is_default]" class="form-check-input" value="1" id="default_${index}" 
                           ${isDefaultChecked ? 'checked' : ''}>
                    <label class="form-check-label small" for="default_${index}">
                        Основная вариация
                    </label>
                </div>
            </div>
            
            <div class="mt-3">
                <button type="button" class="btn btn-sm btn-danger remove-variation d-flex gap-1 align-items-center justify-content-center">
                    <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Удалить" width="20" height="20"> Удалить
                </button>
            </div>
        </div>
        `;
    }

    function getSpecTemplate(index) {
        return `
        <div class="row spec-item mb-2">
            <div class="col-md-5">
                <input type="text" name="attributes[${index}][key]" class="form-control form-control-sm" 
                       placeholder="Название характеристики">
            </div>
            <div class="col-md-6">
                <input type="text" name="attributes[${index}][value]" class="form-control form-control-sm" 
                       placeholder="Значение">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-danger remove-spec w-100">
                    <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Удалить" width="20" height="20" class="mx-auto">
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
                renderPreviews(container, filesArray);
            }
        });

        fileInput.addEventListener('change', function(e) {
            filesArray = Array.from(e.target.files);
            renderPreviews(container, filesArray);
            updateFileInput(fileInput, filesArray);
        });
    }

    function renderPreviews(container, files) {
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

    // ========== УПРАВЛЕНИЕ ОСНОВНОЙ ВАРИАЦИЕЙ ==========
    function initDefaultVariation() {
        const defaultCheckboxes = document.querySelectorAll('input[name$="[is_default]"]');

        defaultCheckboxes.forEach((checkbox, index) => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    defaultCheckboxes.forEach((cb, i) => {
                        if (i !== index) {
                            cb.checked = false;
                        }
                    });
                }
            });
        });
    }

    // ========== ПРОВЕРКА SKU ==========
    function checkSkuOnInput(input, variationIndex) {
        const sku = input.value.trim();
        if (!sku) return;

        const checkUrl = document.querySelector('meta[name="sku-check-url"]').getAttribute('content');

        fetch(checkUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    sku: sku,
                    variation_id: null,
                    product_id: null
                })
            })
            .then(response => response.json())
            .then(data => {
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
            });
    }

    function initSkuValidation() {
        document.querySelectorAll('input[name$="[sku]"]').forEach((input, index) => {
            let timeout;
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    checkSkuOnInput(this, index);
                }, 500);
            });
        });
    }

    // ========== ОТОБРАЖЕНИЕ ОШИБОК ==========
    function displayValidationErrors() {
        for (let i = 0; i < variationIndex; i++) {
            if (errors[`variations.${i}.name`]) {
                const input = document.querySelector(`input[name="variations[${i}][name]"]`);
                if (input && !input.classList.contains('is-invalid')) {
                    input.classList.add('is-invalid');
                    let errorDiv = input.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        input.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = errors[`variations.${i}.name`][0];
                }
            }

            if (errors[`variations.${i}.sku`]) {
                const input = document.querySelector(`input[name="variations[${i}][sku]"]`);
                if (input && !input.classList.contains('is-invalid')) {
                    input.classList.add('is-invalid');
                    let errorDiv = input.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        input.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = errors[`variations.${i}.sku`][0];
                }
            }

            if (errors[`variations.${i}.price`]) {
                const input = document.querySelector(`input[name="variations[${i}][price]"]`);
                if (input && !input.classList.contains('is-invalid')) {
                    input.classList.add('is-invalid');
                    let errorDiv = input.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        input.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = errors[`variations.${i}.price`][0];
                }
            }

            if (errors[`variations.${i}.stock`]) {
                const input = document.querySelector(`input[name="variations[${i}][stock]"]`);
                if (input && !input.classList.contains('is-invalid')) {
                    input.classList.add('is-invalid');
                    let errorDiv = input.parentElement.querySelector('.invalid-feedback');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        input.parentElement.appendChild(errorDiv);
                    }
                    errorDiv.textContent = errors[`variations.${i}.stock`][0];
                }
            }
        }
    }

    // ========== ПРОВЕРКА ВСЕХ SKU ПЕРЕД ОТПРАВКОЙ ==========
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

        if (hasError) {
            alert('Пожалуйста, исправьте ошибки в артикулах');
        }

        return !hasError;
    }

    // ========== ИНИЦИАЛИЗАЦИЯ ==========
    document.addEventListener('DOMContentLoaded', function() {
        const variationsContainer = document.getElementById('variations-container');
        const addVariationBtn = document.getElementById('addVariation');
        const specsContainer = document.getElementById('specs-container');
        const addSpecBtn = document.getElementById('addSpec');

        // Заполняем вариации
        if (oldInput.variations && Object.keys(oldInput.variations).length > 0) {
            variationsContainer.innerHTML = '';
            for (let i = 0; i < Object.keys(oldInput.variations).length; i++) {
                variationsContainer.insertAdjacentHTML('beforeend', getVariationTemplate(i));
                if (i >= variationIndex) variationIndex = i + 1;
            }
        } else if (variationIndex === 0) {
            variationsContainer.insertAdjacentHTML('beforeend', getVariationTemplate(0));
            variationIndex = 1;
        } else {
            for (let i = 0; i < variationIndex; i++) {
                variationsContainer.insertAdjacentHTML('beforeend', getVariationTemplate(i));
            }
        }

        // Инициализация Sortable для всех вариаций
        setTimeout(() => {
            document.querySelectorAll('.sortable-container').forEach(container => {
                const variationIdx = container.id.split('-')[1];
                const fileInput = document.querySelector(`.variation-images-input[data-index="${variationIdx}"]`);
                if (fileInput) {
                    initSortable(container, fileInput);
                }
            });
        }, 100);

        // Добавление вариации
        if (addVariationBtn) {
            addVariationBtn.addEventListener('click', function() {
                const newIndex = variationIndex; // Сохраняем текущий индекс
                variationsContainer.insertAdjacentHTML('beforeend', getVariationTemplate(newIndex));

                // Увеличиваем индекс ПОСЛЕ вставки HTML
                variationIndex++;

                setTimeout(() => {
                    const newContainer = document.getElementById(`sortable-${newIndex}`);
                    const newFileInput = document.querySelector(`.variation-images-input[data-index="${newIndex}"]`);
                    console.log('Adding new variation:', newIndex, newContainer, newFileInput);
                    if (newContainer && newFileInput) {
                        initSortable(newContainer, newFileInput);
                    }
                    initDefaultVariation();
                    initSkuValidation();
                }, 100);
            });
        }

        // Удаление вариаций и характеристик
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-variation') ||
                e.target.parentElement?.classList.contains('remove-variation')) {
                const btn = e.target.classList.contains('remove-variation') ? e.target : e.target.parentElement;
                const item = btn.closest('.variation-item');
                if (item) item.remove();
            }

            if (e.target.classList.contains('remove-spec') ||
                e.target.parentElement?.classList.contains('remove-spec')) {
                const btn = e.target.classList.contains('remove-spec') ? e.target : e.target.parentElement;
                const item = btn.closest('.spec-item');
                if (item) item.remove();
            }
        });

        // Заполняем характеристики
        if (oldInput.attributes && Object.keys(oldInput.attributes).length > 0) {
            specsContainer.innerHTML = '';
            for (let i = 0; i < Object.keys(oldInput.attributes).length; i++) {
                const attr = oldInput.attributes[i];
                const specHtml = `
                <div class="row spec-item mb-2">
                    <div class="col-md-5">
                        <input type="text" name="attributes[${i}][key]" class="form-control form-control-sm" 
                               placeholder="Название характеристики" value="${escapeHtml(attr.key || '')}">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="attributes[${i}][value]" class="form-control form-control-sm" 
                               placeholder="Значение" value="${escapeHtml(attr.value || '')}">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-danger remove-spec w-100">
                            <img src="{{ asset('assets/images/icons/delete-svgrepo-com.svg') }}" alt="Удалить" width="20" height="20" class="mx-auto">
                        </button>
                    </div>
                </div>
                `;
                specsContainer.insertAdjacentHTML('beforeend', specHtml);
                if (i >= specIndex) specIndex = i + 1;
            }
        }

        // Добавление характеристики
        if (addSpecBtn) {
            addSpecBtn.addEventListener('click', function() {
                specsContainer.insertAdjacentHTML('beforeend', getSpecTemplate(specIndex));
                specIndex++;
            });
        }

        // Инициализация всех обработчиков
        initDefaultVariation();
        initSkuValidation();
        displayValidationErrors();

        // Блокировка отправки формы при ошибках
        const productForm = document.getElementById('productForm');
        if (productForm) {
            productForm.addEventListener('submit', function(e) {
                if (!validateAllSkus()) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
@endsection