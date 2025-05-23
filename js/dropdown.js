const dropdownTrigger = document.querySelector('.user-dropdown .dropdown-trigger');
const dropdownContent = document.querySelector('.user-dropdown .dropdown-content');

if (dropdownTrigger && dropdownContent) {
    dropdownTrigger.addEventListener('click', () => {
        dropdownContent.classList.toggle('show');
    });

    window.addEventListener('click', (event) => {
        if (!dropdownContent.contains(event.target) && !dropdownTrigger.contains(event.target)) {
            dropdownContent.classList.remove('show');
        }
    });
}
document.addEventListener('DOMContentLoaded', () => {
    const dropdowns = document.querySelectorAll('.navbar .dropdown');

    dropdowns.forEach((dropdown) => {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const content = dropdown.querySelector('.dropdown-content');

        if (trigger && content) {
            trigger.addEventListener('click', (event) => {
                event.preventDefault();
                content.classList.toggle('show');
            });

            window.addEventListener('click', (event) => {
                if (!dropdown.contains(event.target)) {
                    content.classList.remove('show');
                }
            });
        }
    });
});