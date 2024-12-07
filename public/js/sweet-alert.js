document.addEventListener('livewire:init', () => {
    // Listen for custom swal event from Livewire

    const swalEvents = ['swal:alert', 'swal:confirm'];

    swalEvents.forEach(eventName => {
        Livewire.on(eventName, (event) => {
            if (typeof Swal === 'undefined') {
                console.error('SweetAlert2 is not loaded');
                return;
            }

            const config = event.data;

            Swal.fire(config).then((result) => {
                if (result.isConfirmed && config.onConfirm) {
                    Livewire.dispatch(config.onConfirm);
                }
                if (result.isDenied && config.onDeny) {
                    Livewire.dispatch(config.onDeny);
                }
            });
        });
    });
});
