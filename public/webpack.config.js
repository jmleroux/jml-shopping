module.exports = {
    entry: './src/index.js',
    output: {
        path: './js/dist/',
        filename: 'bundle.js'
    },
    target: 'web',
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                options: { presets: [ 'es2015', 'react' ] }
            }
        ]
    }
};
