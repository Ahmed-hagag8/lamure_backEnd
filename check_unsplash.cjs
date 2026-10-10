const fs = require('fs');
const https = require('https');

const content = fs.readFileSync('database/seeders/DatabaseSeeder.php', 'utf-8');
const urls = [...new Set(content.match(/https:\/\/images\.unsplash\.com\/photo-[a-zA-Z0-9\-]+/g))];

async function checkUrl(url) {
    return new Promise((resolve) => {
        https.get(url, (res) => {
            if (res.statusCode >= 300 && res.statusCode < 400 && res.headers.location) {
                // follow redirect
                https.get(res.headers.location, (res2) => {
                    resolve(res2.statusCode);
                });
            } else {
                resolve(res.statusCode);
            }
        }).on('error', (e) => {
            resolve(e.message);
        });
    });
}

async function main() {
    for (const url of urls) {
        const status = await checkUrl(url);
        console.log(`${status} : ${url}`);
    }
}
main();
