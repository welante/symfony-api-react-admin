import { useEffect, useState } from 'react';
import { Admin, Resource } from 'react-admin';
import dataProvider from './dataProvider';
import DynamicList from './components/DynamicList';
import { DynamicCreate, DynamicEdit } from './components/DynamicForm';
import icons from './icons';

type MenuItem = {
    name: string;
    label: string;
    icon?: string;
};

const App = () => {
    const [menuItems, setMenuItems] = useState<MenuItem[]>([]);

    useEffect(() => {
        fetch(`${process.env.REACT_APP_API_URL}/metadata/menu`)
            .then((res) => res.json())
            .then((data) => setMenuItems(data));
    }, []);

    return (
        <Admin dataProvider={dataProvider}>
            {menuItems.map((item) => {
                const IconComponent = item.icon ? icons[item.icon] : undefined;

                return (
                    <Resource
                        key={item.name}
                        name={item.name}
                        list={DynamicList}
                        create={DynamicCreate}
                        edit={DynamicEdit}
                        options={{ label: item.label }}
                        icon={IconComponent}
                    />
                );
            })}
        </Admin>
    );
};

export default App;
