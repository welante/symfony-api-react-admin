import { useEffect, useState } from 'react';
import {
    Datagrid,
    List,
    TextField,
    NumberField,
    BooleanField,
} from 'react-admin';

type Column = {
    name: string;
    label: string;
    type: string;
};

type Schema = {
    columns: Column[];
};

const apiUrl = process.env.REACT_APP_API_URL;

function renderColumn(column: Column) {
    switch (column.type) {
        case 'string':
            return <TextField key={column.name} source={column.name} label={column.label} />;
        case 'number':
            return <NumberField key={column.name} source={column.name} label={column.label} />;
        case 'boolean':
            return <BooleanField key={column.name} source={column.name} label={column.label} />;
        case 'datetime':
            return <DateField key={column.name} source={column.name} label={column.label} />;
        default:
            return <TextField key={column.name} source={column.name} label={column.label} />;
    }
}

const DynamicList = () => {
    const [schema, setSchema] = useState<Schema | null>(null);

    useEffect(() => {
        fetch(`${apiUrl}/metadata/courses/list`)
            .then((res) => res.json())
            .then((data) => setSchema(data as Schema));
    }, []);


    if (!schema) return null;

    return (
        <List>
            <Datagrid rowClick="edit">
                {schema.columns.map((col) => renderColumn(col))}
            </Datagrid>
        </List>
    );
};

export default DynamicList;
