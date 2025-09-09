import { useEffect, useState } from 'react';
import { Admin, Resource } from 'react-admin';
import dataProvider from './dataProvider';
import DynamicList from './components/DynamicList';
import { DynamicCreate, DynamicEdit } from './components/DynamicForm';
import CustomLayout from './components/CustomLayout';
import icons from './icons';

type MenuItem = {
    name: string;
    label: string;
    icon?: string;
    type: 'resource' | 'parent' ;
    resource?: string;
    path?: string;
    children?: MenuItem[];
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
            return (
                <Resource
                    key={item.resource}
                    name={item.resource!}
                    list={DynamicList}
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
