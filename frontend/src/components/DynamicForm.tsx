import { useEffect, useState } from 'react';
import {
    SimpleForm,
    TextInput,
    NumberInput,
    BooleanInput,
    Create,
    Edit,
} from 'react-admin';

type Field = {
    name: string;
    label: string;
    type: string;
    required?: boolean;
};

type Schema = {
    fields: Field[];
};

const apiUrl = process.env.REACT_APP_API_URL;

function renderField(field: Field) {
    switch (field.type) {
        case 'string':
            return <TextInput key={field.name} source={field.name} label={field.label} required={field.required} />;
        case 'text':
            return <TextInput key={field.name} source={field.name} label={field.label} multiline />;
        case 'number':
            return <NumberInput key={field.name} source={field.name} label={field.label} />;
        case 'boolean':
            return <BooleanInput key={field.name} source={field.name} label={field.label} />;
        default:
            return <TextInput key={field.name} source={field.name} label={field.label} />;
    }
}

export const DynamicCreate = () => {
    const [schema, setSchema] = useState<Schema | null>(null);

    useEffect(() => {
        fetch(`${apiUrl}/metadata/courses/form`)
            .then((res) => res.json())
            .then((data) => setSchema(data as Schema));
    }, []);


    if (!schema) return null;

    return (
        <Create>
            <SimpleForm>
                {schema.fields.map((field) => renderField(field))}
            </SimpleForm>
        </Create>
    );
};

export const DynamicEdit = () => {
    const [schema, setSchema] = useState<Schema | null>(null);

    useEffect(() => {
        fetch(`${apiUrl}/metadata/courses/form`)
            .then((res) => res.json())
            .then((data) => setSchema(data as Schema));
    }, []);

    if (!schema) return null;

    return (
        <Edit>
            <SimpleForm>
                {schema.fields.map((field) => renderField(field))}
            </SimpleForm>
        </Edit>
    );
};
