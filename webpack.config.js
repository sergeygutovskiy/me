const path = require("path");
const sass = require("sass");
const minicss = require("mini-css-extract-plugin");
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
    mode: "development",
    
    entry: {
        app: './resources/js/app.js',
        admin: './resources/js/admin.js',
    },
    optimization: {
        splitChunks: {
            cacheGroups: {
                app: {
                    name: 'app',
                    test: /app\.s?css$/,
                    chunks: 'all',
                    enforce: true,
                },
            },
        },
    },
	output: {
		path: path.resolve(__dirname, 'public'),
		filename: 'js/[name].js',
	},
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test:/\.(s*)css$/,
                use: [
                    minicss.loader,
                    {
                        loader: 'css-loader',
                        options: { url: false }
                    },
                    {
                        loader: "sass-loader",
                        options: {
                            implementation: sass,
                        }
                    },
                ],
            },
        ],
    },

    plugins: [
        new minicss({
            // filename: 'css/[name].css',
            filename: ({ chunk }) => `css/${chunk.name.replace('/js/', '/css/')}.css`,
        }),
        new VueLoaderPlugin(),
    ]
}