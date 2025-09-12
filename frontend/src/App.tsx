import { useEffect, useState } from 'react';
import { Admin, Resource } from 'react-admin';
import dataProvider from './dataProvider';
import { DynamicCreate, DynamicEdit } from './components/DynamicForm';
import CustomLayout from './components/CustomLayout';
import icons from './icons';
import TabbedList from './components/TabbedList';
import DynamicList from './components/DynamicList';

type MenuItem = {
    name: string;
    label: string;
    icon?: string;
    type: 'resource' | 'parent';
    resource?: string;
    children?: MenuItem[];
    tabs?: { name: string; label: string; filters: Record<string, any> }[];
};

const App = () => {
    const [menuItems, setMenuItems] = useState<MenuItem[]>([]);

    useEffect(() => {
        fetch(`${process.env.REACT_APP_API_URL}/metadata/menu`)
            .then((res) => res.json())
            .then((data) => setMenuItems(data));
    }, []);

    const resources = menuItems
        .flatMap((item) => (item.type === 'parent' ? item.children || [] : [item]))
        .filter((item) => item.type === 'resource' && item.resource)
        .map((item) => {
            const IconComponent = item.icon ? icons[item.icon] : undefined;
            const ListComponent = item.tabs ? (
                <TabbedList resource={item.resource!} tabs={item.tabs} />
            ) : (
                <DynamicList />
            );

            return (
                <Resource
                    key={item.resource}
                    name={item.resource!}
                    list={ListComponent}
                    create={DynamicCreate}
                    edit={DynamicEdit}
                    options={{ label: item.label }}
                    icon={IconComponent}
                />
            );
        });

    return (
        <Admin dataProvider={dataProvider} layout={CustomLayout}>
            {resources}
        </Admin>
    );
};

export default App;
