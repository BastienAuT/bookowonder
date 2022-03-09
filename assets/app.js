/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
const menuResponsive = document.querySelector('.toggle-menu');
const iconeToggle = document.querySelector('.icone-toggle');

iconeToggle.addEventListener('click', () => {
    menuResponsive.classList.toggle('hidden');
});

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
