document.addEventListener('DOMContentLoaded', function() {
    const fontSizeSlider = document.getElementById('font-size');
    const body = document.body;

    let savedFontSize = localStorage.getItem('fontSize');
    if (!savedFontSize) {
        savedFontSize = '16';
        localStorage.setItem('fontSize', savedFontSize);
    }

    body.style.fontSize = `${savedFontSize}px`;

    if (fontSizeSlider) {
        fontSizeSlider.value = savedFontSize;

        fontSizeSlider.addEventListener('input', function() {
            const newFontSize = this.value;
            body.style.fontSize = `${newFontSize}px`;
            localStorage.setItem('fontSize', newFontSize);
        });
    }
});