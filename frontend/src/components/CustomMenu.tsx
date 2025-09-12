import { useEffect, useState, ComponentType } from 'react';
import { Menu, MenuItemLink } from 'react-admin';
import SubMenu from './SubMenu';
import icons from '../icons';

type MenuItem = {
    name: string;
    label: string;
    icon?: string;
    type: 'resource' | 'parent';
    resource?: string;
    path?: string;
    children?: MenuItem[];
};

const CustomMenu = () => {
    const [menuItems, setMenuItems] = useState<MenuItem[]>([]);

    useEffect(() => {
        fetch(`${process.env.REACT_APP_API_URL}/metadata/menu`)
            .then((res) => res.json())
            .then((data) => setMenuItems(data));
    }, []);

    const renderItems = (items: MenuItem[]) =>
        items.map((item) => {
            const IconComponent: ComponentType<any> | undefined = item.icon ? icons[item.icon] : undefined;

            if (item.type === 'parent' && item.children) {
                return (
                    <SubMenu
                        key={item.name}
                        name={item.name}
                        label={item.label}
                        icon={IconComponent ? <IconComponent /> : undefined}
                    >
                        {renderItems(item.children)}
                    </SubMenu>
                );
            }

            if (item.type === 'resource' && item.resource) {
                return (
                    <MenuItemLink
                        key={item.name}
                        to={`/${item.resource}`}
                        primaryText={item.label}
                        leftIcon={IconComponent ? <IconComponent /> : undefined}
                    />
                );
            }

            return null;
        });

    return <Menu>{renderItems(menuItems)}</Menu>;
};

export default CustomMenu;
