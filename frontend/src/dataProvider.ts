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

            return { data };
        }
        throw new Error(`getOne not implemented for ${resource}`);
    },

    // ⚠️ Métodos que React Admin pide sí o sí
    create: async () => { throw new Error('create not implemented'); },
    update: async () => { throw new Error('update not implemented'); },
    delete: async () => { throw new Error('delete not implemented'); },
    getMany: async () => { throw new Error('getMany not implemented'); },
    getManyReference: async () => { throw new Error('getManyReference not implemented'); },
    updateMany: async () => { throw new Error('updateMany not implemented'); },
    deleteMany: async () => { throw new Error('deleteMany not implemented'); },
};

export default dataProvider;
