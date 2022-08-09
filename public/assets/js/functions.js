export const hFetch = (url, opts) => {
    let options = opts || {};
    options.headers = options.headers || {};
    options.headers = {
        'X-Requested-With': 'XMLHttpRequest'
    };
    return fetch(url, options);
}

export const qs = (selector, parent = document) => {
    return parent.querySelector(selector);
}

export const qsa = (selector, parent = document) => {
    return [...parent.querySelectorAll(selector)];
}
