document.addEventListener('livewire:init', () => {
    // Listen for custom swal event from Livewire

    Livewire.on('swal', (event) => {
        // Ensure SweetAlert2 is loaded
        if (typeof Swal !== 'undefined') {
            Swal.fire(event.data)
        } else {
            console.error('SweetAlert2 is not loaded');
        }
    });
});

const swalModal = (icon, title, text) => {
    Swal.fire({
        icon: icon,
        title: title,
        text: text
    })
}
