function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => {
        el.textContent = count;
        el.classList.add('cart-bump');
        setTimeout(() => el.classList.remove('cart-bump'), 300);
    });
}