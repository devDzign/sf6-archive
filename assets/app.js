const $ = require('jquery');
global.$ = global.jQuery = $;
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

import './styles/app.scss';

// You can specify which plugins you need
import { Tooltip, Toast, Popover, Modal, ScrollSpy, Alert,Tab, Button, Carousel, Collapse, Dropdown, Offcanvas } from 'bootstrap';

// import './js/test-jquery'
// import './js/form_collection'
// start the Stimulus application
import './bootstrap';
