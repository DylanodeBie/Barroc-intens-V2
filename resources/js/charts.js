import Chart from 'chart.js/auto';

// Functie om een bar chart te maken
function createBarChart(chartId, labels, data, title) {
    const ctx = document.getElementById(chartId).getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels, // Bijvoorbeeld: ['January', 'February']
            datasets: [{
                label: title,
                data: data, // Dynamische data
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                title: { display: true, text: title },
            },
        },
    });
}

// Functie om een pie chart te maken (optioneel)
function createPieChart(chartId, labels, data, title) {
    const ctx = document.getElementById(chartId).getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'], // Kleuren
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                title: { display: true, text: title },
            },
        },
    });
}

// Exporteer de functies
export { createBarChart, createPieChart };
