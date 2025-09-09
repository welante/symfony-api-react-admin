import { ReactElement, ReactNode, useState } from 'react';
import { MenuItemLink } from 'react-admin';
import { Collapse, List } from '@mui/material';

type SubMenuProps = {
    name: string;
    label: string;
    icon?: ReactElement;
    children: ReactNode;
};

const SubMenu = ({ name, label, icon, children }: SubMenuProps) => {
    const [open, setOpen] = useState(false);

    const handleToggle = () => setOpen(!open);

    return (
        <>
            <MenuItemLink
                to={'#'}
                primaryText={label}
                leftIcon={icon}
                onClick={(e) => {
                    e.preventDefault();
                    handleToggle();
                }}
            />
            <Collapse in={open} timeout="auto" unmountOnExit>
                <List component="div" disablePadding sx={{ pl: 4 }}>
                    {children}
                </List>
            </Collapse>
        </>
    );
};

export default SubMenu;
