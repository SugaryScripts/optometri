

const sessionData = {
    pc_preset: document.body.getAttribute('data-pc-preset'),
    pc_sidebar_caption: document.body.getAttribute('data-pc-sidebar-caption') === 'true',
    pc_layout: document.body.getAttribute('data-pc-layout'),
    pc_direction: document.body.getAttribute('data-pc-direction'),
    pc_theme_contrast: document.body.getAttribute('data-pc-theme_contrast') === 'true',
    pc_theme: document.body.getAttribute('data-pc-theme'),
};

// Store data in localStorage if not already present
if (!localStorage.getItem('pc_config')) {
    localStorage.setItem('pc_config', JSON.stringify(sessionData));
}
