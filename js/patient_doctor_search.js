document.getElementById('patientSearch')?.addEventListener('input', function() {
    const query = this.value.trim();
    console.log('Search query:', query);
    const resultsDiv = document.getElementById('searchResults');
    resultsDiv.innerHTML = '';
    resultsDiv.style.display = 'none';

    if (!query) return;

    const searchUrl = '../actions/patient_search_doctor_action.php';
    console.log('Sending search request:', { query, url: searchUrl });
    fetch(searchUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: query })
    })
    .then(response => {
        console.log('Search response status:', response.status);
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.status} ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Search response:', data);
        resultsDiv.innerHTML = '';
        if (data.success && data.doctors && Array.isArray(data.doctors) && data.doctors.length > 0) {
            data.doctors.forEach(doctor => {
                const div = document.createElement('div');
                div.className = 'search-result-item';
                div.innerHTML = `<div class="chat-item-info">
                    <div class="chat-item-name">${doctor.name || 'Unknown'}</div>
                    <div class="chat-item-last-message">Start new chat</div>
                </div>`;
                div.onclick = () => window.location.href = `patient_message.php?doctor_id=${doctor.id}`;
                resultsDiv.appendChild(div);
            });
            resultsDiv.style.display = 'block';
        } else {
            resultsDiv.innerHTML = `<div class="search-result-item">${data.error || 'No doctors found'}</div>`;
            resultsDiv.style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Search error:', error);
        resultsDiv.innerHTML = `<div class="search-result-item">Error searching doctors: ${error.message}</div>`;
        resultsDiv.style.display = 'block';
    });
});