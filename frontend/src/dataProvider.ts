import { DataProvider, HttpError } from 'react-admin';
import { GetListParams } from 'ra-core';

const apiUrl = process.env.REACT_APP_API_URL || 'http://welante-admin-back/api';

const dataProvider: DataProvider = {
    getList: async (resource, params: GetListParams) => {
        const { page, perPage } = params.pagination ?? { page: 1, perPage: 10 };
        const { field, order } = params.sort ?? { field: 'id', order: 'ASC' };
        const filters = params.filter ?? {};

        const query = new URLSearchParams({
            page: String(page),
            perPage: String(perPage),
            sort: field,
            order,
            ...Object.fromEntries(Object.entries(filters).map(([k, v]) => [k, String(v)])),
        });

        const response = await fetch(`${apiUrl}/${resource}?${query}`);
        const result = await response.json();

        return {
            data: result.data,
            total: result.total,
        };
    },

    getOne: async (resource, params) => {
        const response = await fetch(`${apiUrl}/${resource}/${params.id}`);
        const data = await response.json();

        return { data: { id: params.id, ...data } };
    },

    create: async (resource, params) => {
        const response = await fetch(`${apiUrl}/${resource}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(params.data),
        });
        const data = await response.json();

        if (!response.ok) {
            if (response.status === 400 && data.errors) {
                throw new HttpError('Validation error', 400, { errors: data.errors });
            }
            throw new HttpError(data.message || 'Error creating resource', response.status, data);
        }

        return { data: { id: data.id, ...data } };
    },

    update: async (resource, params) => {
        const response = await fetch(`${apiUrl}/${resource}/${params.id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(params.data),
        });
        const data = await response.json();

        if (!response.ok) {
            if (response.status === 400 && data.errors) {
                throw new HttpError('Validation error', 400, { errors: data.errors });
            }
            throw new HttpError(data.message || 'Error updating resource', response.status, data);
        }

        return { data: { id: params.id, ...data } };
    },

    delete: async (resource, params) => {
        await fetch(`${apiUrl}/${resource}/${params.id}`, { method: 'DELETE' });
        return { data: { id: params.id } as any };
    },

    getMany: async (resource, params) => {
        const responses = await Promise.all(
            params.ids.map((id) => fetch(`${apiUrl}/${resource}/${id}`).then((res) => res.json()))
        );
        return { data: responses };
    },

    getManyReference: async () => {
        throw new Error('getManyReference not implemented');
    },

    updateMany: async (resource, params) => {
        const responses = await Promise.all(
            params.ids.map((id) =>
                fetch(`${apiUrl}/${resource}/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(params.data),
                }).then((res) => res.json())
            )
        );
        return { data: responses.map((r) => r.id) };
    },

    deleteMany: async (resource, params) => {
        await Promise.all(params.ids.map((id) => fetch(`${apiUrl}/${resource}/${id}`, { method: 'DELETE' })));
        return { data: params.ids };
    },
};

export default dataProvider;
