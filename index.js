// Import necessary modules
const express = require('express');
const bodyParser = require('body-parser');
const pg = require('pg');
const path = require('path');

const app = express();
const port = process.env.PORT || 3000;

// PostgreSQL configuration
const config = {
    user: 'root',
    host: 'dpg-cqb74iuehbks73dkm78g-a.oregon-postgres.render.com',
    database: 'lovepotion_db',
    password: 'LjmX4r6w3FM21BZlOyCUmXUZuDiIaZbN',
    port: 5432,
    ssl: true
};

// Create a pool
const pool = new pg.Pool(config);

// Middleware setup
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Set the view engine to EJS
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Define routes
app.get('/', (req, res) => {
    // Example route to fetch data from PostgreSQL
    pool.connect((err, client, done) => {
        if (err) {
            return console.error('Error fetching client from pool', err);
        }
        client.query('SELECT * FROM promotions ORDER BY promotion_id ASC', (err, result) => {
            done();
            if (err) {
                return console.error('Error running query', err);
            }
            res.render('index', { promotions: result.rows }); // Render index.ejs with promotions data
        });
    });
});

// Static files setup (optional)
app.use(express.static(path.join(__dirname, 'public')));

// Start server
app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});
