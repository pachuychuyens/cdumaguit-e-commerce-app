import './bootstrap';
import 'preline';
import '../css/app.css';
 
// import.meta.glob(['../images/**']);

document.addEventListener('livewire:navigated', () =>{
    window.HSStaticMethods.autoInit();
})
