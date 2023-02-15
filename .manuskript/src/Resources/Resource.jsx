export async function fetchResources(url) {
    const response = await fetch(url);
    const {rows, columns, meta, links} = await response.json();

    return {
        rows,
        columns,
        pagination: {
            ...meta,
            ...links,
        },
    };
}
