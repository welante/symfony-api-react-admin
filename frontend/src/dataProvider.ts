import { DataProvider } from 'react-admin';

const apiUrl = process.env.REACT_APP_API_URL || 'http://welante-admin-back/api';

const dataProvider: DataProvider = {
    getList: async (resource, params) => {
        if (resource === 'courses') {
            const response = await fetch(`${apiUrl}/courses`);
            const data = await response.json();

            return {
                data,
                total: data.length,
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
