function insertCurrentYear() {
    const elements = document.querySelectorAll('.current-year');
    const currentYear = new Date().getFullYear();
    elements.forEach(element => {
        element.textContent = currentYear;
    });
}

insertCurrentYear();