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
    const deleteEventButton = document.getElementById('deleteEventButton');
    const customerSelect = document.getElementById('eventCustomer');

    let selectedEvent = null;

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        timeZone: 'UTC',
        events: '/api/events',
        editable: true,
        selectable: true,

        eventClick: function (info) {
            selectedEvent = info.event;

            fetchCustomers().then(() => {
                openModal('Edit Event', {
                    title: info.event.title,
                    start: info.event.start.toISOString().slice(0, 16),
                    end: info.event.end ? info.event.end.toISOString().slice(0, 16) : '',
                    description: info.event.extendedProps.description || '',
                    customer_id: info.event.extendedProps.customer_id || '',
                });
            });
        },

        dateClick: function (info) {
            selectedEvent = null;
            fetchCustomers().then(() => {
                openModal('Add Event', {
                    title: '',
                    start: info.dateStr + 'T00:00',
                    end: '',
                    description: '',
                    customer_id: '',
                });
            });
        },
    });

    calendar.render();

    addEventButton.addEventListener('click', function () {
        selectedEvent = null;
        fetchCustomers().then(() => {
            openModal('Add Event', {
                title: '',
                start: '',
                end: '',
                description: '',
                customer_id: '',
            });
        });
    });

    deleteEventButton.addEventListener('click', function () {
        if (selectedEvent) {
            const confirmDelete = window.confirm("Are you sure you want to delete this event?");
            if (confirmDelete) {
                axios.delete(`/events/${selectedEvent.id}`)
                    .then(() => {
                        selectedEvent.remove();
                        closeModalHandler();
                        alert('Event successfully deleted.');
                    })
                    .catch((error) => {
                        console.error('Error deleting event:', error);
                        alert('Failed to delete the event.');
                    });
            }
        }
    });

    closeModal.addEventListener('click', closeModalHandler);

    eventForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const eventData = {
            title: document.getElementById('eventName').value,
            start: document.getElementById('eventStartTime').value,
            end: document.getElementById('eventEndTime').value || null,
            description: document.getElementById('eventDescription').value.trim(),
            customer_id: document.getElementById('eventCustomer').value,
        };

        if (selectedEvent) {
            axios.put(`/events/${selectedEvent.id}`, eventData)
                .then((response) => {
                    updateEvent(response.data);
                    closeModalHandler();
                })
                .catch((error) => {
                    console.error('Error updating event:', error);
                    alert('Failed to update the event.');
                });
        } else {
            axios.post('/events', eventData)
                .then((response) => {
                    addNewEvent(response.data);
                    closeModalHandler();
                })
                .catch((error) => {
                    console.error('Error creating event:', error);
                    alert('Failed to create the event.');
                });
        }
    });

    function openModal(title, data) {
        modalTitle.textContent = title;
        document.getElementById('eventName').value = data.title;
        document.getElementById('eventStartTime').value = data.start;
        document.getElementById('eventEndTime').value = data.end;
        document.getElementById('eventDescription').value = data.description;
        if (data.customer_id) {
            customerSelect.value = data.customer_id;
        }
        eventModal.classList.remove('hidden');
    }

    function closeModalHandler() {
        eventForm.reset();
        eventModal.classList.add('hidden');
    }

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

    function updateEvent(eventData) {
        selectedEvent.setProp('title', eventData.title);
        selectedEvent.setStart(eventData.start);
        selectedEvent.setEnd(eventData.end);
        selectedEvent.setExtendedProp('description', eventData.description);
        selectedEvent.setExtendedProp('customer_id', eventData.customer_id);
    }

    async function fetchCustomers() {
        try {
            const response = await axios.get('/api/customers');
            const customers = response.data;
            customerSelect.innerHTML = '<option value="" disabled selected>Kies een klant</option>';
            customers.forEach((customer) => {
                const option = document.createElement('option');
                option.value = customer.id;
                option.textContent = customer.company_name;
                customerSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching customers:', error);
            alert('Failed to load customers.');
        }
    }
});