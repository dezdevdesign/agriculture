/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
require('./template');

import helpers from './utilities/helpers';
import Home from './modules/Home';
import Farmer from './modules/Farmer';
import Crop from './modules/Crop';
import User from './modules/User';

// Global Helper...
window.helpers = new helpers();

let current = window.location.pathname;

if(current == '/') {
	$(document).on('keydown', function (e) {
        if((e.ctrlKey) && ( String.fromCharCode(e.which).toLowerCase() === 'm') ) {
            $('#modal-login').modal('show');
        }
    });
}

if(current.includes('/home')) {
	$(document).ready(function(e) {
		window.Home = new Home();
	});
}

if(current.includes('/farmers')) {
	$(document).ready(function(e) {
		window.Farmer = new Farmer();
	});
}

if(current.includes('/crops')) {
	$(document).ready(function() {
		window.Crop = new Crop();
	});
}

if(current.includes('/users')) {
	$(document).ready(function() {
		window.User = new User();
	});
}



require('./modules/Cropping');
require('./modules/Map');

require('./modules/CroppingList');
require('./modules/HarvestList');


