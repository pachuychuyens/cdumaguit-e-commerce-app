import './bootstrap';
import 'preline';
import '../css/app.css';
import { HSDropdown, HSCollapse } from 'preline';

// Init on page load
document.addEventListener('DOMContentLoaded', () => {
    HSDropdown.autoInit();
    HSCollapse.autoInit();
});

// Re-init after Livewire navigation
document.addEventListener('livewire:navigated', () => {
    HSDropdown.autoInit();
    HSCollapse.autoInit();
});
