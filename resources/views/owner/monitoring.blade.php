@extends('layouts.admin-layout')

@section('title', 'Monitoring Details')

@section('content')
<div class="card shadow">
    <div class="card-header text-center bg-danger text-white py-4">
        <h3 class="fw-bold">Monitoring Calendar</h3>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="eventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6><strong>Event:</strong></h6>
                <p id="eventTitle" class="text-muted"></p>
                <h6><strong>Description:</strong></h6>
                <p id="eventDetails" class="text-muted"></p>
                <h6><strong>Date:</strong></h6>
                <p id="eventDate" class="text-muted"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        if (!calendarEl) {
            console.error('Calendar container not found.');
            return;
        }

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap', // Customize calendar theme to match Bootstrap
            events: [
                {
                    title: 'Inspection Due: Fire Safety',
                    start: '2025-01-10',
                    description: 'Fire safety inspection for Dormitory A.',
                },
                {
                    title: 'Plumbing Maintenance',
                    start: '2025-01-15',
                    description: 'Scheduled plumbing maintenance for Dormitory B.',
                },
                {
                    title: 'General Cleaning',
                    start: '2025-01-20',
                    description: 'Routine general cleaning for all dormitories.',
                },
            ],
            eventClick: function (info) {
                const modal = new bootstrap.Modal(document.getElementById('eventModal'));
                document.getElementById('eventTitle').textContent = info.event.title;
                document.getElementById('eventDetails').textContent = info.event.extendedProps.description;
                document.getElementById('eventDate').textContent = info.event.start.toLocaleDateString();
                modal.show();
            },
            height: 'auto', // Adjust calendar height dynamically
            contentHeight: 600, // Fix content height
            selectable: true,
            dayMaxEvents: true, // Display "more" link when too many events
            views: {
                dayGridMonth: {
                    dayMaxEventRows: 3, // Limit number of events per day in month view
                },
            },
        });

        calendar.render();
    });
</script>

<style>
    /* Customize calendar styles */
    #calendar {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    .fc-toolbar-title {
        font-weight: bold;
        font-size: 1.5rem;
        color: #dc3545; /* Primary theme color */
    }
    .fc-button {
        background-color: #dc3545 !important;
        color: #ffffff !important;
        border: none !important;
    }
    .fc-button:hover {
        background-color: #b02a37 !important;
    }
    .fc-daygrid-event {
        background-color: #dc3545 !important;
        color: #ffffff !important;
        border: none !important;
    }
</style>
@endsection
