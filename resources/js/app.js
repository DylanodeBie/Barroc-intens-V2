import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import './bootstrap'; // Als je Laravel Mix gebruikt
import { createBarChart, createPieChart } from './charts';

// Gebruik de functies om grafieken te maken
document.addEventListener('DOMContentLoaded', () => {
    // Voorbeelddata
    const labels = ['January', 'February', 'March', 'April'];
    const incomeData = [1200, 1900, 3000, 5000];

    // Maak een bar chart
    createBarChart('incomeChart', labels, incomeData, 'Inkomsten per maand');

    // Maak een pie chart (optioneel)
    const expenseData = [1000, 1500, 2000, 2500];
    createPieChart('expenseChart', labels, expenseData, 'Uitgaven');
});
