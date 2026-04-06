document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('input_search');
    let searchTimeout;

    if (searchInput) {
        let suggestionsContainer = document.createElement('div');
        suggestionsContainer.className = 'search-suggestions';
        suggestionsContainer.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        `;
        searchInput.parentNode.style.position = 'relative';
        searchInput.parentNode.appendChild(suggestionsContainer);

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                suggestionsContainer.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`/search/ajax?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.products.length > 0 || data.brands.length > 0) {
                            let html = '';

                            if (data.brands.length > 0) {
                                html += '<div class="p-2 bg-light fw-semibold">Бренды</div>';
                                data.brands.forEach(brand => {
                                    html += `
                                        <a href="/brands/${brand.slug}" class="d-block p-2 text-decoration-none text-dark hover-bg-light">
                                            <i class="bi bi-building me-2"></i> ${brand.name}
                                        </a>
                                    `;
                                });
                            }

                            if (data.products.length > 0) {
                                html += '<div class="p-2 bg-light fw-semibold">Товары</div>';
                                data.products.forEach(product => {
                                    html += `
                                        <a href="/product/${product.slug}" class="d-block p-2 text-decoration-none text-dark hover-bg-light">
                                            <i class="bi bi-box me-2"></i> ${product.name}
                                        </a>
                                    `;
                                });
                            }

                            suggestionsContainer.innerHTML = html;
                            suggestionsContainer.style.display = 'block';
                        } else {
                            suggestionsContainer.style.display = 'none';
                        }
                    });
            }, 300);
        });

        document.addEventListener('click', function (e) {
            if (!searchInput.parentNode.contains(e.target)) {
                suggestionsContainer.style.display = 'none';
            }
        });
    }
});
