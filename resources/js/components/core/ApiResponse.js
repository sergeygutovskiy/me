export default class ApiResponse {
    async process(raw_response) {
        if (raw_response === null || raw_response === undefined) {
            throw new Error('No raw response');
        }
        
        const response = await raw_response.json();
    
        this._status = response.status;
        this._data = response.data;

        return this;
    }

    is_good() {
        return this._status === 1;
    }

    is_bad() {
        return this._status === 0;
    }

    data() {
        return this._data;
    }

    alert_problem() {
        alert('Сервер вернул ошибку, извините :(');
    }
} 