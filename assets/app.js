const $ = require('jquery');
global.$ = global.jQuery = $;
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('select2')

import 'select2/dist/css/select2.min.css'
import './styles/app.scss';

// You can specify which plugins you need
import { Tooltip, Toast, Popover, Modal, ScrollSpy, Alert,Tab, Button, Carousel, Collapse, Dropdown, Offcanvas } from 'bootstrap';

$('select').select2();
import './bootstrap';
