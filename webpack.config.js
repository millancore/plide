const path = require('path');
const fs = require('fs');

const presentationsPath = path.resolve(__dirname, 'presentations');

let presentations = fs.readdirSync(presentationsPath, {
    withFileTypes: true,
}).filter(dirent => dirent.isDirectory())
    .map(dirent => dirent.name);


if (presentations.length === 0) {
    console.warn('No presentations found!');
    process.exit(1);
}


let configs = [];
presentations.forEach(presentation => {
    let config = {
        mode: 'development',
        entry: [
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