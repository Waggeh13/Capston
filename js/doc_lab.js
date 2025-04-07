// Modal functionality
const labModal = document.getElementById("labModal");
const resultsModal = document.getElementById("resultsModal");
const newRequestBtn = document.getElementById("newRequestBtn");
const resultItems = document.querySelectorAll(".result-item");
const closeButtons = document.querySelectorAll(".close");

// Open lab request modal
newRequestBtn.onclick = function() {
    labModal.style.display = "block";
}

// Open results modal when clicking on a result item
resultItems.forEach(item => {
    item.addEventListener("click", function() {
        resultsModal.style.display = "block";
    });
});

// Close modals
closeButtons.forEach(button => {
    button.onclick = function() {
        labModal.style.display = "none";
        resultsModal.style.display = "none";
    }
});

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target == labModal) {
        labModal.style.display = "none";
    }
    if (event.target == resultsModal) {
        resultsModal.style.display = "none";
    }
}