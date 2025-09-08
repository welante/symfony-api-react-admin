import { useEffect, useState } from 'react';
import {
    SimpleForm,
    TextInput,
    NumberInput,
    BooleanInput,
    DateTimeInput,
    Create,
    Edit,
} from 'react-admin';

type Field = {
    name: string;
    label: string;
    type: string;
    required?: boolean;
    readonly?: boolean;
};

type Schema = {
    fields: Field[];
};

const apiUrl = process.env.REACT_APP_API_URL;

function renderField(field: Field) {
    switch (field.type) {
        case 'string':
            return <TextInput key={field.name} source={field.name} label={field.label} required={field.required} disabled={field.readonly} />;
        case 'text':
            return <TextInput key={field.name} source={field.name} label={field.label} multiline disabled={field.readonly} />;
        case 'number':
            return <NumberInput key={field.name} source={field.name} label={field.label} disabled={field.readonly} />;
        case 'boolean':
            return <BooleanInput key={field.name} source={field.name} label={field.label} disabled={field.readonly} />;
        case 'datetime':
            return <DateTimeInput key={field.name} source={field.name} label={field.label} disabled={field.readonly} />;
        default:
            return <TextInput key={field.name} source={field.name} label={field.label} disabled={field.readonly} />;
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
        <Edit mutationMode="pessimistic">
            <SimpleForm>
                {schema.fields.map((field) => renderField(field))}
            </SimpleForm>
        </Edit>
    );
};
