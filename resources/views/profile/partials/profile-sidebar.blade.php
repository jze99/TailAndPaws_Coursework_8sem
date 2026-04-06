<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card border-0 tw-bg-orange tw-text-light-gray">
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-person-circle fs-1"></i>
                </div>
                <h5>{{ $user->name }}</h5>
                <p class="small">{{ $user->email }}</p>
                <hr>
                <nav class="nav flex-column mt-2 mb-2">
                    <a href="{{ route('profile.index') }}" class="nav-link py-2 px-0 {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Обзор
                    </a>
                    <a href="{{ route('profile.edit') }}" class="nav-link py-2 px-0 {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="bi bi-gear me-2"></i> Настройки профиля
                    </a>
                    <hr class="my-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link py-2 px-0 text-start">
                            <i class="bi bi-box-arrow-right me-2"></i> Выйти
                        </button>
                    </form>
                </nav>
            </div>
        </div>
    </div>