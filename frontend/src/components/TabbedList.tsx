import { useEffect, useState } from 'react';
import {
    List,
    Datagrid,
    TextField,
    BooleanField,
    NumberField,
    DateField,
    TextInput,
    BooleanInput,
    NumberInput,
    DateInput,
} from 'react-admin';
import { Tabs, Tab, Box } from '@mui/material';

type Schema = {
    columns: { name: string; label: string; type: string }[];
    filters: { name: string; label?: string; type: string }[];
    defaultSort: { field: string; order: 'ASC' | 'DESC' };
};

type TabConfig = {
    name: string;
    label: string;
    filters: Record<string, any>;
};

type Props = {
    resource: string;
    tabs?: TabConfig[];
};

const TabbedList = ({ resource, tabs = [] }: Props) => {
    const [schema, setSchema] = useState<Schema | null>(null);
    const [activeTab, setActiveTab] = useState(0);

    useEffect(() => {
        fetch(`${process.env.REACT_APP_API_URL}/metadata/${resource}/list`)
            .then((res) => res.json())
            .then((data) => setSchema(data));
    }, [resource]);

    if (!schema) return null;

    const currentFilters = tabs.length > 0 ? tabs[activeTab].filters : {};

    const renderFilters = () =>
        schema.filters.map((f) => {
            switch (f.type) {
                case 'string':
                    return <TextInput key={f.name} label={f.label || f.name} source={f.name} alwaysOn />;
                case 'boolean':
                    return <BooleanInput key={f.name} label={f.label || f.name} source={f.name} />;
                case 'number':
                    return <NumberInput key={f.name} label={f.label || f.name} source={f.name} />;
                case 'datetime':
                    return <DateInput key={f.name} label={f.label || f.name} source={f.name} />;
                default:
                    return <TextInput key={f.name} label={f.label || f.name} source={f.name} />;
            }
        });

    return (
        <Box>
            {tabs.length > 1 && (
                <Tabs value={activeTab} onChange={(e, v) => setActiveTab(v)}>
                    {tabs.map((tab, i) => (
                        <Tab key={i} label={tab.label} />
                    ))}
                </Tabs>
            )}
            <List
                key={activeTab}
                resource={resource}
                filters={renderFilters()}
                filter={currentFilters}
                sort={schema.defaultSort}
            >
                <Datagrid rowClick="edit">
                    {schema.columns.map((col) => {
                        switch (col.type) {
                            case 'string':
                                return <TextField key={col.name} source={col.name} label={col.label} />;
                            case 'boolean':
                                return <BooleanField key={col.name} source={col.name} label={col.label} />;
                            case 'number':
                                return <NumberField key={col.name} source={col.name} label={col.label} />;
                            case 'datetime':
                                return <DateField key={col.name} source={col.name} label={col.label} />;
                            default:
                                return <TextField key={col.name} source={col.name} label={col.label} />;
                        }
                    })}
                </Datagrid>
            </List>
        </Box>
    );
};

export default TabbedList;
