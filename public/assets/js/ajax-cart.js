// Универсальный AJAX для добавления в корзину
document.addEventListener('DOMContentLoaded', function () {
    const cartForms = document.querySelectorAll('form[action*="cart/add"]');

    cartForms.forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            if (!submitBtn) return;

            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Добавление...';

            // Получаем данные формы
            const variationId = this.querySelector('input[name="variation_id"]')?.value;
            const quantity = this.querySelector('input[name="quantity"]')?.value || 1;

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        variation_id: variationId,
                        quantity: quantity
                    })
                });

                // Проверяем, что ответ JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Сервер вернул HTML вместо JSON');
                }

                const data = await response.json();

                if (data.success) {
                    // Обновляем счетчик корзины
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    cartCountElements.forEach(el => {
                        el.textContent = data.cart_count;
                        el.classList.add('cart-bump');
                        setTimeout(() => el.classList.remove('cart-bump'), 300);
                    });

                    submitBtn.textContent = '✓ Добавлено';
                    showNotification(data.message, 'success');

                    setTimeout(() => {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }, 1500);
                } else {
                    showNotification(data.message || 'Ошибка', 'error');
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Ошибка при добавлении в корзину', 'error');
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    });

    function showNotification(message, type = 'success') {
        const oldNotification = document.querySelector('.notification');
        if (oldNotification) oldNotification.remove();

        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#2c5e2e' : '#dc3545'};
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            z-index: 9999;
            animation: slideIn 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Добавляем CSS анимации
    if (!document.querySelector('#cart-animations')) {
        const style = document.createElement('style');
        style.id = 'cart-animations';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            @keyframes cartBump {
                0% { transform: scale(1); }
                50% { transform: scale(1.2); }
                100% { transform: scale(1); }
            }
            .cart-bump {
                animation: cartBump 0.3s ease;
                display: inline-block;
            }
        `;
        document.head.appendChild(style);
    }
});