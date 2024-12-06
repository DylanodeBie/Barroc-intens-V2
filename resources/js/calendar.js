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
    const customerSelect = document.getElementById('eventCustomer'); // Assuming customer select dropdown

    let selectedEvent = null;

    // FullCalendar-initialisatie
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        timeZone: 'UTC',
        events: '/api/events',
        editable: true,
        selectable: true,

        // Klik op een bestaand event om het te bewerken
        eventClick: function (info) {

            fetch('/api/customers')
                .then(response => response.json())
                .then(data => {

                    selectedEvent = info.event;
                    data.forEach(customer => {

                        const option = document.createElement('option');
                        option.value = customer.id;
                        option.text = customer.company_name;
                        // set selected 
                        if (customer.id === info.event.extendedProps.customer_id) {
                            option.selected = true;
                        }
                        customerSelect.appendChild(option);
                    });

                    // Dit zorgt ervoor dat selectedEvent niet leeg is in de volgende scope
                    openModal('Edit Event', {
                        title: info.event.title,
                        start: info.event.start.toISOString().slice(0, 16),
                        end: info.event.end ? info.event.end.toISOString().slice(0, 16) : '',
                        description: info.event.extendedProps.description || '',
                        customer_id: info.event.extendedProps.customer_id || '',
                    });


                })




        },

        // Klik op een datum om een nieuw event te maken
        dateClick: function (info) {
            openModal('Add Event', {
                title: '',
                start: info.dateStr + 'T00:00',
                end: '',
                description: '',
                customer_id: '',  // Customer field for new events
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
            customer_id: '',  // Zorg ervoor dat klantveld leeg is voor nieuwe evenementen
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
            description: document.getElementById('eventDescription').value.trim() || '',
            customer_id: document.getElementById('eventCustomer').value || null,
        };

        console.log('Event data:', eventData);  // Log de data die je naar de server stuurt

        if (selectedEvent) {
            // Update een bestaand event
            axios.put(`/events/${selectedEvent.id}`, eventData)
                .then((response) => {
                    console.log('Updating event:', selectedEvent);
                    updateEvent(response.data);
                })
                .catch((error) => {
                    console.error('Error updating event:', error);
                    alert('Er is een probleem opgetreden bij het bijwerken van het event.');
                });
        } else {
            // Maak een nieuw event aan
            axios.post('/events', eventData)
                .then((response) => {
                    console.log('Adding new event:', response.data);
                    addNewEvent(response.data);
                })
                .catch((error) => {
                    console.error('Error adding event:', error);
                    alert('Er is een probleem opgetreden bij het toevoegen van het event.');
                });
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

        const customerSelect = document.getElementById('eventCustomer');
        const options = customerSelect.options;
        // console.log(options);


        for (let i = 0; i < options.length; i++) {

            if (options[i].value === data.customer_id) {
                customerSelect.selectedIndex = i;
                console.log('Customer selected:', options[i].value);
                break; // Exit the loop once the option is found
            }
        }


        // Toon de modal
        eventModal.classList.remove('hidden');
    }


    // Sluit de modal
    function closeModalHandler() {
        // Je kunt dit behouden zoals het was, maar let op dat selectedEvent niet wordt gereset bij een modal sluitactie
        if (!selectedEvent) {
            // Als er geen geselecteerde gebeurtenis is, reset de form
            eventForm.reset();
        }

        // Sluit de modal
        eventModal.classList.add('hidden');
        // selectedEvent wordt niet gereset hier
    }

    // Voeg een nieuw event toe aan de kalender
    function addNewEvent(eventData) {
        calendar.addEvent({
            id: eventData.id,
            title: eventData.title,
            start: eventData.start,
            end: eventData.end,
            extendedProps: {
                description: eventData.description,
                customer_id: eventData.customer_id,
            },
        });
    }

    // Update een bestaand event in de kalender
    function updateEvent(eventData) {
        selectedEvent.setProp('title', eventData.title);
        selectedEvent.setStart(eventData.start);
        selectedEvent.setEnd(eventData.end);
        selectedEvent.setExtendedProp('description', eventData.description);
        selectedEvent.setExtendedProp('customer_id', eventData.customer_id);
    }
});