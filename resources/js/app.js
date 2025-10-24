import './bootstrap';
import Alpine from 'alpinejs';
import './notification-dropdown';

// Font Awesome
import '@fortawesome/fontawesome-free/css/all.min.css';

// Chart.js setup
import {
    Chart,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    ArcElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js';

Chart.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    ArcElement,
    Title,
    Tooltip,
    Legend
);

// FullCalendar setup
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

// Make Alpine.js, Chart.js, and Calendar available globally
window.Alpine = Alpine;
window.Chart = Chart;
window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.interactionPlugin = interactionPlugin;

// Initialize Alpine.js
Alpine.start();