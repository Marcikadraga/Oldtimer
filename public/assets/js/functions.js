export const hFetch = (url, opts) => {
    let options = opts || {};
    options.headers = options.headers || {};
    options.headers = {
        'X-Requested-With': 'XMLHttpRequest'
    };
    return fetch(url, options);
}
