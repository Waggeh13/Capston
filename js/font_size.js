document.addEventListener('DOMContentLoaded', function() {
    const fontSizeSlider = document.getElementById('font-size');
    const body = document.body;

    // Load saved font size from localStorage, default to 16 if not set
    let savedFontSize = localStorage.getItem('fontSize');
    if (!savedFontSize) {
        savedFontSize = '16'; // Default font size in pixels
        localStorage.setItem('fontSize', savedFontSize);
    }

    // Apply the saved font size to the body
    body.style.fontSize = `${savedFontSize}px`;

    // Update the slider value to match the saved font size (if slider exists)
    if (fontSizeSlider) {
        fontSizeSlider.value = savedFontSize;

        // Listen for changes to the slider
        fontSizeSlider.addEventListener('input', function() {
            const newFontSize = this.value;
            body.style.fontSize = `${newFontSize}px`;
            localStorage.setItem('fontSize', newFontSize);
        });
    }
});