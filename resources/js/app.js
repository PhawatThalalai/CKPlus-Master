import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import Swal from 'sweetalert2';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min.js';
// import * as bootstrap from 'bootstrap';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.plugin(focus);

Alpine.start();
