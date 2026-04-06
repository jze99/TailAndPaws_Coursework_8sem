@extends('layouts.app')

@section('title', 'Политика обработки персональных данных')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">Главная</a>
            </li>
            <li class="breadcrumb-item active">Политика конфиденциальности</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <h1 class="h2 mb-4 text-center mt-4">Политика обработки персональных данных</h1>

            <div class="text-muted text-center mb-4">
                <small>Актуальная версия: 1.0 от 06.04.2026</small>
            </div>

            {{-- 1. Общие положения --}}
            <div class="policy-section mb-5">
                <h2 class="h4 mb-3">1. Общие положения</h2>
                <p>Настоящая политика обработки персональных данных составлена в соответствии с требованиями Федерального закона от 27.07.2006. № 152-ФЗ «О персональных данных» (далее — Закон о персональных данных) и определяет порядок обработки персональных данных и меры по обеспечению безопасности персональных данных, предпринимаемые «Хвостики и Лапки» (далее — Оператор).</p>
                <p class="mt-2">Оператор ставит своей важнейшей целью и условием осуществления своей деятельности соблюдение прав и свобод человека и гражданина при обработке его персональных данных, в том числе защиты прав на неприкосновенность частной жизни, личную и семейную тайну.</p>
                <p class="mt-2">Настоящая политика Оператора в отношении обработки персональных данных (далее — Политика) применяется ко всей информации, которую Оператор может получить о посетителях веб-сайта <a href="http://tailandpuws.ru/">http://tailandpuws.ru/</a>.</p>
            </div>

            {{-- 2. Основные понятия --}}
            <div class="policy-section mb-5">
                <h2 class="h4 mb-3">2. Основные понятия</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <strong>Автоматизированная обработка</strong>
                            <p class="mb-0 small text-muted">Обработка персональных данных с помощью средств вычислительной техники.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <strong>Блокирование персональных данных</strong>
                            <p class="mb-0 small text-muted">Временное прекращение обработки персональных данных.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <strong>Веб-сайт</strong>
                            <p class="mb-0 small text-muted">Совокупность графических и информационных материалов по адресу <a href="http://tailandpuws.ru/">http://tailandpuws.ru/</a>.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <strong>Персональные данные</strong>
                            <p class="mb-0 small text-muted">Любая информация, относящаяся прямо или косвенно к Пользователю.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Права и обязанности Оператора --}}
            <div class="policy-section mb-5">
                <h2 class="h4 mb-3">3. Права и обязанности Оператора</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="border-start border-success border-4 p-4 mb-3">
                            <h5 class="text-success mb-2">Оператор имеет право:</h5>
                            <ul class="small">
                                <li>Получать достоверные информацию и/или документы, содержащие персональные данные</li>
                                <li>Продолжить обработку персональных данных без согласия субъекта при наличии оснований</li>
                                <li>Самостоятельно определять состав мер для обеспечения безопасности персональных данных</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border-start border-primary border-4 p-4 mb-3">
                            <h5 class="text-primary mb-2">Оператор обязан:</h5>
                            <ul class="small">
                                <li>Предоставлять информацию о обработке персональных данных по запросу</li>
                                <li>Организовывать обработку в соответствии с законодательством РФ</li>
                                <li>Публиковать Политику в свободном доступе</li>
                                <li>Принимать меры для защиты персональных данных</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. Права субъектов персональных данных --}}
            <div class="policy-section mb-5">
                <h2 class="h4 mb-3">4. Права субъектов персональных данных</h2>
                <div class="bg-light p-3 rounded">
                    <p class="mb-2">Вы имеете право:</p>
                    <ul class="mb-0">
                        <li>Получать информацию, касающуюся обработки ваших персональных данных</li>
                        <li>Требовать уточнения, блокирования или уничтожения ваших персональных данных</li>
                        <li>Отозвать согласие на обработку персональных данных</li>
                        <li>Обжаловать неправомерные действия Оператора в уполномоченный орган или суд</li>
                    </ul>
                </div>
            </div>

            {{-- 5. Принципы обработки --}}
            <div class="policy-section mb-5">
                <h2 class="h4 mb-3">5. Принципы обработки персональных данных</h2>
                <div class="row g-2">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded h-100">
                            <i class="bi bi-shield-check fs-1 text-success"></i>
                            <p class="mt-2 mb-0 small">Законность и справедливость</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded h-100">
                            <i class="bi bi-bullseye fs-1 text-success"></i>
                            <p class="mt-2 mb-0 small">Ограничение целями обработки</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded h-100">
                            <i class="bi bi-database fs-1 text-success"></i>
                            <p class="mt-2 mb-0 small">Достоверность и достаточность</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 6. Цели обработки --}}
            <div class="policy-section mb-5">
                <h2 class="h4 mb-3">6. Цели обработки персональных данных</h2>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Цель обработки</th>
                            <th>Персональные данные</th>
                            <th>Правовые основания</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Предоставление доступа к сервисам, информации и материалам сайта</td>
                            <td>
                                <ul class="mb-0 small">
                                    <li>Фамилия, имя, отчество</li>
                                    <li>Электронный адрес</li>
                                    <li>Номера телефонов</li>
                                </ul>
                            </td>
                            <td>Федеральный закон № 149-ФЗ «Об информации, информационных технологиях и о защите информации»</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- 7. Условия обработки --}}
            <div class="policy-section mb-5">
                <h2 class="h4 mb-3">7. Условия обработки персональных данных</h2>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Обработка персональных данных осуществляется <strong>с согласия субъекта</strong> персональных данных.
                </div>
            </div>

            {{-- 8. Порядок сбора, хранения, передачи --}}
            <div class="policy-section mb-5">
                <h2 class="h4 mb-3">8. Порядок сбора, хранения, передачи</h2>
                <p>Оператор обеспечивает сохранность персональных данных и принимает все возможные меры, исключающие доступ к персональным данным неуполномоченных лиц.</p>

                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Важно:</strong> Персональные данные Пользователя никогда, ни при каких условиях не будут переданы третьим лицам, за исключением случаев, предусмотренных законодательством.
                </div>

                <p class="mt-3">Для актуализации или отзыва согласия на обработку персональных данных направьте уведомление на электронную почту: <a href="mailto:tailandpaws_info@gmail.com">tailandpaws_info@gmail.com</a>.</p>
            </div>

            {{-- 9. Конфиденциальность --}}
            <div class="policy-section mb-5">
                <h2 class="h4 mb-3">9. Конфиденциальность персональных данных</h2>
                <p>Оператор и иные лица, получившие доступ к персональным данным, обязаны не раскрывать третьим лицам и не распространять персональные данные без согласия субъекта персональных данных, если иное не предусмотрено федеральным законом.</p>
            </div>

            {{-- 10. Контактная информация --}}
            <div class="policy-section">
                <h2 class="h4 mb-3">10. Контактная информация</h2>
                <div class="bg-light p-4 rounded">
                    <p class="mb-2"><strong>По всем вопросам, касающимся обработки персональных данных, вы можете обратиться:</strong></p>
                    <ul class="mb-0">
                        <li>По электронной почте: <a href="mailto:tailandpaws_info@gmail.com">tailandpaws_info@gmail.com</a></li>
                        <li>По телефону: {{ $contacts->phone ?? '+7(985)-070-56-33' }}</li>
                        <li>По адресу: {{ $contacts->address ?? 'г. Челябинск, ул. Дружбы, д. 15' }}</li>
                    </ul>
                </div>
            </div>

            <hr class="my-4">

            <div class="text-center text-muted small">
                <p>Данная Политика действует бессрочно до замены ее новой версией.</p>
                <p>Актуальная версия Политики в свободном доступе расположена по адресу: <a href="{{ route('privacy-policy') }}">{{ route('privacy-policy') }}</a></p>
            </div>
        </div>
    </div>
</div>
@endsection