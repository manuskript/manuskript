module.exports = theme => ({
    DEFAULT: {
        css: {
            th: {
                position: "relative",
                backgroundColor: theme("colors.slate.50"),
                padding: theme("spacing.1"),
                p: {
                    margin: theme("spacing.0"),
                },
            },
            td: {
                position: "relative",
                padding: theme("spacing.1"),
                p: {
                    margin: theme("spacing.0"),
                },
            },
            ".selectedCell": {
                borderColor: theme("colors.blue.500"),
            },
        },
    },
});
