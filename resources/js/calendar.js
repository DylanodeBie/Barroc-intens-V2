import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const eventModal = document.getElementById('eventModal');
    const closeModal = document.getElementById('closeModal');
    const eventForm = document.getElementById('eventForm');
    const modalTitle = document.getElementById('modalTitle');
    const addEventButton = document.getElementById('addEventButton');
    const deleteEventButton = document.getElementById('deleteEventButton'); // Verwijderknop

    let selectedEvent = null;

    // FullCalendar-initialisatie
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        timeZone: 'UTC',
        events: window.events,
        editable: true,
        selectable: true,

        // Klik op een datum om een nieuw event te maken
        dateClick: function (info) {
            openModal('Add Event', {
                title: '',
                start: info.dateStr + 'T00:00',
                end: '',
                description: '',
            });
        },

        // Klik op een bestaand event om het te bewerken
        eventClick: function (info) {
            selectedEvent = info.event;
            openModal('Edit Event', {
                title: info.event.title,
                start: info.event.start.toISOString().slice(0, 16),
                end: info.event.end ? info.event.end.toISOString().slice(0, 16) : '',
                description: info.event.extendedProps.description || '',
            });
        },
    });

    calendar.render();

    // Voeg event listener toe aan de "Add Event" knop
    addEventButton.addEventListener('click', function () {
        selectedEvent = null;
        openModal('Add Event', {
            title: '',
            start: '',
            end: '',
            description: '',
        });
    });

    // Voeg event listener toe aan de "Delete" knop
    deleteEventButton.addEventListener('click', function () {
        if (selectedEvent) {
            // Toon een bevestigingsdialoog
            const confirmDelete = window.confirm("Weet je zeker dat je dit event wilt verwijderen?");
            if (confirmDelete) {
                // Verwijder het geselecteerde event uit de database
                axios.delete(`/events/${selectedEvent.id}`)
                    .then((response) => {
                        // Verwijder het event uit de kalender
                        selectedEvent.remove();
                        closeModalHandler();
                        alert('Event succesvol verwijderd.');
                    })
                    .catch((error) => {
                        console.error('Error deleting event:', error);
                        alert('Er is iets mis gegaan bij het verwijderen van het event.');
                    });
            }
        }
    });

    // Sluit modal
    closeModal.addEventListener('click', closeModalHandler);

    // Verwerk formulier voor het aanmaken/bewerken van een event
    eventForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const startTime = new Date(document.getElementById('eventStartTime').value);
        const endTime = new Date(document.getElementById('eventEndTime').value);

        if (!startTime || !endTime) {
            alert('Zorg ervoor dat zowel start- als eindtijd zijn ingevuld.');
            return;
        }

        if (endTime && endTime < startTime) {
            alert('Eindtijd kan niet voor de starttijd liggen.');
            return;
        }

        // Haal gegevens op uit het formulier
        const eventData = {
            title: document.getElementById('eventName').value,
            start: document.getElementById('eventStartTime').value,
            end: document.getElementById('eventEndTime').value || null,
            description: document.getElementById('eventDescription').value.trim() || '', // Voorkom lege beschrijving
        };


        if (selectedEvent) {
            // Update een bestaand event
            axios.put(`/events/${selectedEvent.id}`, eventData)
                .then((response) => {
                    updateEvent(response.data);
                })
                .catch((error) => console.error('Error updating event:', error));
        } else {
            // Maak een nieuw event aan
            axios.post('/events', eventData)
                .then((response) => {
                    addNewEvent(response.data);
                })
                .catch((error) => console.error('Error adding event:', error));
        }
        closeModalHandler();
    });

    // Functie om de modal te openen en gegevens in te vullen
    function openModal(title, data) {
        modalTitle.textContent = title;
        document.getElementById('eventName').value = data.title;
        document.getElementById('eventStartTime').value = data.start;
        document.getElementById('eventEndTime').value = data.end;
        document.getElementById('eventDescription').value = data.description;
        eventModal.classList.remove('hidden');
    }

    // Sluit de modal
    function closeModalHandler() {
        eventModal.classList.add('hidden');
        selectedEvent = null; // Reset selectedEvent na sluiten van de modal
    }

    // Voeg een nieuw event toe aan de kalender
    function addNewEvent(eventData) {
        calendar.addEvent({
            id: eventData.id,
            title: eventData.title,
            start: eventData.start,
            end: eventData.end,
            extendedProps: { description: eventData.description },
        });
    }

    // Update een bestaand event in de kalender
    function updateEvent(eventData) {
        selectedEvent.setProp('title', eventData.title);
        selectedEvent.setStart(eventData.start);
        selectedEvent.setEnd(eventData.end);
        selectedEvent.setExtendedProp('description', eventData.description);
    }
});