const defaultConfig = require('@wordpress/scripts/config/webpack.config');
module.exports = {
    ...defaultConfig,
    entry: {
        ...defaultConfig.entry,
        'admin/app': './src/admin/app.js',
        ...blocksEntries,
    },
};
