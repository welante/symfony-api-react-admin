import HttpError from 'ra-core/dist/cjs/dataProvider/HttpError';
import { DataProvider, GetListParams, GetOneParams, CreateParams, UpdateParams, DeleteParams } from 'ra-core/dist/cjs/types';

const graphqlUrl =
  (process.env.REACT_APP_API_URL || 'http://welante-admin-back/api') + '/graphql/';

// Query/mutation constants

const COURSE_LIST_QUERY = `
  query CourseList($limit: Int, $offset: Int, $sort: String, $order: String, $filters: String) {
    courses(limit: $limit, offset: $offset, sort: $sort, order: $order, filters: $filters) {
      items {
        id code active persmax persmin isconfirmed start end cancelled createdAt updatedAt
      }
      totalCount
      hasNextPage
    }
  }
`;

const COURSE_GET_ONE_QUERY = `
  query CourseGetOne($id: Int!) {
    course(id: $id) {
      id code active persmax persmin isconfirmed start end cancelled createdAt updatedAt
    }
  }
`;

const COURSE_CREATE_MUTATION = `
  mutation CourseCreate($input: CourseInput!) {
    createCourse(input: $input) {
      id code active persmax persmin isconfirmed start end cancelled createdAt updatedAt
    }
  }
`;

const COURSE_UPDATE_MUTATION = `
  mutation CourseUpdate($id: Int!, $input: CourseInput!) {
    updateCourse(id: $id, input: $input) {
      id code active persmax persmin isconfirmed start end cancelled createdAt updatedAt
    }
  }
`;

const COURSE_DELETE_MUTATION = `
  mutation CourseDelete($id: Int!) {
    deleteCourse(id: $id)
  }
`;

// CourseInput allowed fields (strips id, createdAt, updatedAt)
const COURSE_INPUT_FIELDS = [
  'code',
  'active',
  'persmax',
  'persmin',
  'isconfirmed',
  'start',
  'end',
  'cancelled',
];

function stripToCourseInput(data: Record<string, unknown>): Record<string, unknown> {
  return Object.fromEntries(
    Object.entries(data).filter(([key]) => COURSE_INPUT_FIELDS.includes(key))
  );
}

function mapGraphQLError(error: {
  message?: string;
  extensions?: { category?: string; errors?: Record<string, string> };
}): HttpError {
  const category = error.extensions?.category;
  const message = error.message;

  if (category === 'validation') {
    return new HttpError('Validation error', 400, { errors: error.extensions?.errors ?? {} });
  }
  if (category === 'not_found') {
    return new HttpError(message || 'Not found', 404);
  }
  return new HttpError(message || 'Server error', 500);
}

async function gql(
  query: string,
  variables: Record<string, unknown>
): Promise<Record<string, unknown>> {
  let json: { data?: Record<string, unknown>; errors?: Array<{ message?: string; extensions?: { category?: string; errors?: Record<string, string> } }> };
  try {
    const response = await fetch(graphqlUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ query, variables }),
    });
    json = await response.json();
  } catch (_e) {
    throw new HttpError('Network error', 500);
  }

  if (json.errors && json.errors.length > 0) {
    throw mapGraphQLError(json.errors[0]);
  }

  return json.data ?? {};
}

const graphqlDataProvider: Pick<DataProvider, 'getList' | 'getOne' | 'create' | 'update' | 'delete'> = {
  getList: async (_resource: string, params: GetListParams) => {
    const { page, perPage } = params.pagination ?? { page: 1, perPage: 10 };
    const { field, order } = params.sort ?? { field: 'id', order: 'ASC' };
    const filters = params.filter ?? {};

    const data = await gql(COURSE_LIST_QUERY, {
      limit: perPage,
      offset: (page - 1) * perPage,
      sort: field,
      order,
      filters: JSON.stringify(filters),
    });

    const connection = data.courses as { items: unknown[]; totalCount: number };
    return {
      data: connection.items as any[],
      total: connection.totalCount,
    };
  },

  getOne: async (_resource: string, params: GetOneParams) => {
    const data = await gql(COURSE_GET_ONE_QUERY, { id: Number(params.id) });
    return { data: data.course as any };
  },

  create: async (_resource: string, params: CreateParams) => {
    const input = stripToCourseInput(params.data as Record<string, unknown>);
    const data = await gql(COURSE_CREATE_MUTATION, { input });
    return { data: data.createCourse as any };
  },

  update: async (_resource: string, params: UpdateParams) => {
    const input = stripToCourseInput(params.data as Record<string, unknown>);
    const data = await gql(COURSE_UPDATE_MUTATION, { id: Number(params.id), input });
    return { data: data.updateCourse as any };
  },

  delete: async (_resource: string, params: DeleteParams) => {
    await gql(COURSE_DELETE_MUTATION, { id: Number(params.id) });
    return { data: { id: params.id } as any };
  },
};

export default graphqlDataProvider;
