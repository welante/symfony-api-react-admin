import { ComponentType } from 'react';
import BookIcon from '@mui/icons-material/Book';
import PersonIcon from '@mui/icons-material/Person';

// Map backend "icon" string → actual React component
const icons: Record<string, ComponentType<any>> = {
    Book: BookIcon,
    User: PersonIcon,
};

export default icons;
