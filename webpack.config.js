const path = require('path');
const fs = require('fs');

const presentationsPath = path.resolve(__dirname, 'presentations');

let presentations = fs.readdirSync(presentationsPath, {
    withFileTypes: true,
}).filter(dirent => dirent.isDirectory())
    .map(dirent => dirent.name);

let configs = [];
presentations.forEach(presentation => {
    let config = {
        mode: 'development',
        entry: [
            path.resolve(__dirname, 'resources/js/reveal.js'),
            path.resolve(presentationsPath, presentation, 'assets/main.js'),
        ],
        output: {
            path: path.resolve(presentationsPath, presentation, 'dist'),
            filename: 'bundle.js'
        },
        module: {
            rules: [
                {
                    test: /\.css$/i,
                    include: path.resolve(presentationsPath, presentation, 'assets'),
                    use: ['style-loader', 'css-loader', 'postcss-loader']
                }
            ]
        }
    }
    configs.push(config);
});

module.exports = configs;