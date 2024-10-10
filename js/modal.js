const urlParams = new URLSearchParams(window.location.search);
const message = urlParams.get('message');
const type = urlParams.get('type');

if (message) {
    const modal = document.getElementById('modal');
    const modalHeader = document.getElementById('modal-header');
    const modalBody = document.getElementById('modal-body');

    modalHeader.textContent = (type === 'success') ? "Success" : "Error";
    modalBody.textContent = message;

    modal.style.display = 'flex'; 

    document.getElementById('close-modal').addEventListener('click', function() {
        modal.style.display = 'none';
        window.history.pushState({}, document.title, window.location.pathname); 
    });
}
