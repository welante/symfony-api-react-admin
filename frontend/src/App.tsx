import { Admin, Resource } from 'react-admin';
import dataProvider from './dataProvider';
import DynamicList from './components/DynamicList';
import { DynamicCreate, DynamicEdit } from './components/DynamicForm';

const App = () => (
    <Admin dataProvider={dataProvider}>
        <Resource
            name="courses"
            list={DynamicList}
            create={DynamicCreate}
            edit={DynamicEdit}
        />
    </Admin>
);

export default App;
