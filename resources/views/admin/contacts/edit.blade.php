@extends('layouts.admin')

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

    <div class="card">
        <div class="card-header">
            <h5>Редактирование данных сайта</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contacts.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <ul class="nav nav-tabs mb-4" id="contactTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                            Основные данные
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab">
                            Логотип и фавикон
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab">
                            Контакты
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab">
                            Социальные сети
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab">
                            SEO
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="contactTabsContent">
                    {{-- Основные данные --}}
                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label">Название сайта <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                value="{{ old('name', $contact->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Описание сайта</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                name="description"
                                rows="3">{{ old('description', $contact->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Режим работы</label>
                            <input type="text"
                                class="form-control @error('work_hours') is-invalid @enderror"
                                name="work_hours"
                                value="{{ old('work_hours', $contact->work_hours) }}"
                                placeholder="Например: Пн-Пт: 10:00 - 18:00, Сб-Вс: выходной">
                            @error('work_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Логотип и фавикон --}}
                    <div class="tab-pane fade" id="images" role="tabpanel">
                        <div class="mb-4">
                            <label class="form-label">Логотип</label>
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <input type="file"
                                        class="form-control @error('logo') is-invalid @enderror"
                                        name="logo"
                                        id="logo-input"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp">
                                    @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Рекомендуемый размер: 200x200px. Максимум 2MB</small>
                                </div>
                                <div class="col-md-6">
                                    @if($contact->logo)
                                    <div class="current-image">
                                        <p class="mb-2">Текущий логотип:</p>
                                        <img src="{{ asset('assets/images/logo/' . $contact->logo) }}"
                                            alt="Логотип"
                                            id="logo-preview"
                                            style="max-height: 100px; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                                    </div>
                                    @else
                                    <div class="current-image">
                                        <p class="mb-2 text-muted">Логотип не загружен</p>
                                        <img src=""
                                            id="logo-preview"
                                            style="max-height: 100px; display: none;">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Фавикон (иконка вкладки браузера)</label>
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <input type="file"
                                        class="form-control @error('favicon') is-invalid @enderror"
                                        name="favicon"
                                        id="favicon-input"
                                        accept="image/x-icon,image/png,image/svg+xml">
                                    @error('favicon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Рекомендуемый размер: 16x16px или 32x32px. Максимум 1MB</small>
                                </div>
                                <div class="col-md-6">
                                    @if($contact->favicon)
                                    <div class="current-image">
                                        <p class="mb-2">Текущий фавикон:</p>
                                        <img src="{{ asset('assets/images/logo/' . $contact->favicon) }}"
                                            alt="Фавикон"
                                            id="favicon-preview"
                                            style="max-height: 32px; border: 1px solid #ddd; padding: 2px; border-radius: 4px;">
                                    </div>
                                    @else
                                    <div class="current-image">
                                        <p class="mb-2 text-muted">Фавикон не загружен</p>
                                        <img src=""
                                            id="favicon-preview"
                                            style="max-height: 32px; display: none;">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Контакты --}}
                    <div class="tab-pane fade" id="contacts" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label">Телефон</label>
                            <input type="text"
                                class="form-control @error('phone') is-invalid @enderror"
                                name="phone"
                                value="{{ old('phone', $contact->phone) }}"
                                placeholder="+7(000)-000-00-00">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email', $contact->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Адрес</label>
                            <input type="text"
                                class="form-control @error('address') is-invalid @enderror"
                                name="address"
                                value="{{ old('address', $contact->address) }}">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Социальные сети --}}
                    <div class="tab-pane fade" id="social" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label">Telegram</label>
                            <div class="input-group">
                                <span class="input-group-text">t.me/</span>
                                <input type="text"
                                    class="form-control @error('telegram') is-invalid @enderror"
                                    name="telegram"
                                    value="{{ old('telegram', $contact->telegram) }}"
                                    placeholder="username">
                            </div>
                            @error('telegram')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text">wa.me/</span>
                                <input type="text"
                                    class="form-control @error('whatsapp') is-invalid @enderror"
                                    name="whatsapp"
                                    value="{{ old('whatsapp', $contact->whatsapp) }}"
                                    placeholder="79991234567">
                            </div>
                            @error('whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ВКонтакте</label>
                            <div class="input-group">
                                <span class="input-group-text">vk.com/</span>
                                <input type="text"
                                    class="form-control @error('vkontakte') is-invalid @enderror"
                                    name="vkontakte"
                                    value="{{ old('vkontakte', $contact->vkontakte) }}"
                                    placeholder="club00000000">
                            </div>
                            @error('vkontakte')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="tab-pane fade" id="seo" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label">Meta Title (заголовок страницы)</label>
                            <input type="text"
                                class="form-control @error('meta_title') is-invalid @enderror"
                                name="meta_title"
                                value="{{ old('meta_title', $contact->meta_title) }}">
                            <small class="text-muted">Рекомендуемая длина: 50-60 символов</small>
                            @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description (описание страницы)</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                name="meta_description"
                                rows="3">{{ old('meta_description', $contact->meta_description) }}</textarea>
                            <small class="text-muted">Рекомендуемая длина: 150-160 символов</small>
                            @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords (ключевые слова)</label>
                            <input type="text"
                                class="form-control @error('meta_keywords') is-invalid @enderror"
                                name="meta_keywords"
                                value="{{ old('meta_keywords', $contact->meta_keywords) }}"
                                placeholder="магазин, зоотовары, корм, игрушки">
                            <small class="text-muted">Ключевые слова через запятую</small>
                            @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-dark-green p-2 d-flex gap-1 align-items-center justify-content-center">
                        <img src="{{ asset('assets/images/icons/edit-svgrepo-com.svg') }}" alt="Сохранить" width="20" height="20">
                        Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoInput = document.getElementById('logo-input');
        const logoPreview = document.getElementById('logo-preview');

        if (logoInput) {
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        logoPreview.src = event.target.result;
                        logoPreview.style.display = 'block';
                        if (logoPreview.closest('.current-image')) {
                            logoPreview.closest('.current-image').querySelector('.text-muted')?.remove();
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        const faviconInput = document.getElementById('favicon-input');
        const faviconPreview = document.getElementById('favicon-preview');

        if (faviconInput) {
            faviconInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        faviconPreview.src = event.target.result;
                        faviconPreview.style.display = 'block';
                        if (faviconPreview.closest('.current-image')) {
                            faviconPreview.closest('.current-image').querySelector('.text-muted')?.remove();
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endsection