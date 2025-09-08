import { DataProvider, HttpError } from 'react-admin';
import { GetListParams } from 'ra-core';

const apiUrl = process.env.REACT_APP_API_URL || 'http://welante-admin-back/api';

const dataProvider: DataProvider = {
    getList: async (resource, params: GetListParams) => {
        if (resource === 'courses') {
            const { page, perPage } = params.pagination ?? { page: 1, perPage: 10 };
            const { field, order } = params.sort ?? { field: 'id', order: 'ASC' };
            const filters = params.filter ?? {};

            const query = new URLSearchParams({
                page: String(page),
                perPage: String(perPage),
                sort: field,
                order,
                ...Object.fromEntries(Object.entries(filters).map(([k, v]) => [k, String(v)]))
            });

            const response = await fetch(`${apiUrl}/courses?${query}`);
            const result = await response.json();

            return {
                data: result.data,
                total: result.total,
            };
        }
        throw new Error(`getList not implemented for ${resource}`);
    },

    getOne: async (resource, params) => {
        if (resource === 'courses') {
            const response = await fetch(`${apiUrl}/courses/${params.id}`);
            const data = await response.json();

            return { data: { id: params.id, ...data } };
        }
        throw new Error(`getOne not implemented for ${resource}`);
    },

    create: async (resource, params) => {
        if (resource === 'courses') {
            const response = await fetch(`${apiUrl}/courses`, {
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
        }
        throw new Error(`create not implemented for ${resource}`);
    },

    update: async (resource, params) => {
        if (resource === 'courses') {
            const response = await fetch(`${apiUrl}/courses/${params.id}`, {
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
        }
        throw new Error(`update not implemented for ${resource}`);
    },

    delete: async (resource, params) => {
        if (resource === 'courses') {
            await fetch(`${apiUrl}/courses/${params.id}`, { method: 'DELETE' });
            return { data: { id: params.id } as any };
        }
        throw new Error(`delete not implemented for ${resource}`);
    },

    getMany: async () => { throw new Error('getMany not implemented'); },
    getManyReference: async () => { throw new Error('getManyReference not implemented'); },
    updateMany: async () => { throw new Error('updateMany not implemented'); },

    deleteMany: async (resource, params) => {
        if (resource === 'courses') {
            await Promise.all(
                params.ids.map((id) =>
                    fetch(`${apiUrl}/courses/${id}`, { method: 'DELETE' })
                )
            );
            return { data: params.ids };
        }
        throw new Error(`deleteMany not implemented for ${resource}`);
    },
};

export default dataProvider;
