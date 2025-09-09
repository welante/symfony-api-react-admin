import { ComponentType } from 'react';
import Groups from '@mui/icons-material/Groups';
import Book from '@mui/icons-material/Book';
import EventNote from '@mui/icons-material/EventNote';
import CalendarToday from '@mui/icons-material/CalendarToday';
import Person from '@mui/icons-material/Person';

// Map backend "icon" string → actual React component
const icons: Record<string, ComponentType<any>> = {
    Group: Groups,
    Book: Book,
    Event: EventNote,
    CalendarToday: CalendarToday,
    Person: Person,
};

export default icons;
