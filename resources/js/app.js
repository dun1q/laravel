import './bootstrap';
import 'bootstrap';
import 'jquery';
import '@popperjs/core';

// Подключим стили (через JS — для HMR и сборки)
import '../sass/app.scss';

// Глобальные переменные для Bootstrap 5 (если нужны в шаблонах)
window.$ = window.jQuery = require('jquery');