interface RequestOptions {
    method: string;
    headers?: HeadersInit;
    body?: string;
}

const BASE_URL = process.env.VUE_APP_BASE_URL;
const apiService = {
  async get<T>(endpoint: string, token?: string): Promise<T> {
    const options: RequestOptions = {
      method: 'GET',
      headers: {
        ...(token && { Authorization: `Bearer ${token}` }),
      },
    };

    const response = await fetch(`${BASE_URL}/${endpoint}`, options);
    return await response.json();
  },

  async post<T>(endpoint: string, data: any, token?: string): Promise<T> {
    const options: RequestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        ...(token && { Authorization: `Bearer ${token}` }),
      },
      body: JSON.stringify(data),
    };

    const response = await fetch(`${BASE_URL}/${endpoint}`, options);
    return await response.json();
  },

  async put<T>(endpoint: string, data: any, token?: string): Promise<T> {
    const options: RequestOptions = {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        ...(token && { Authorization: `Bearer ${token}` }),
      },
      body: JSON.stringify(data),
    };

    const response = await fetch(`${BASE_URL}/${endpoint}`, options);
    return await response.json();
  },

  async delete<T>(endpoint: string, token?: string): Promise<T> {
    const options: RequestOptions = {
      method: 'DELETE',
      headers: {
        ...(token && { Authorization: `Bearer ${token}` }),
      },
    };

    const response = await fetch(`${BASE_URL}/${endpoint}`, options);
    return await response.json();
  },

};

export default apiService;

